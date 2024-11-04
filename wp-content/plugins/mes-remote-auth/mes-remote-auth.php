<?php
/*
Plugin Name: RemoteAuth
Plugin URI: http://myesys.elance.com
Description: Authenticates user remotely using web service. On success, creates local user with same credentials if not already exists else conditionally updates local user. On failure, displays customized error message on login page.
Author: MyESys
Version: 1.0
Author URI: https://www.myesys.elance.com/
*/
// Block direct requests
if(!defined('ABSPATH')) {
    die("Don't call this file directly.");
}

/**
 * plugin class  - MesRemoteAuth
 */
class MesRemoteAuth{
    /*
     * Stores error message for auth failure and local user update
     */
    private $loginErrorMsg = '';

    /*
     * Stores plugin option name
     */
    const SETTING_NAME = 'mes_remoteauth_settings';

    /**
     * Registers actions
     * Adds filters
     */
    public function __construct() {
        register_activation_hook(__FILE__, array( $this, 'on_activation'));
        register_deactivation_hook(__FILE__, array( $this, 'on_deactivation'));

		add_action( 'admin_menu', array($this, 'my_admin_menu'));
        add_action( 'admin_init', array($this,'my_admin_init'));
        add_filter( 'authenticate', array($this, 'my_authenticate'), 500, 3);
    }

    /*
     * Captures user input and delegates to other functions for remote auth and local user update
     *
     * @param $user WP_Error or WP_User or null
     * @param $username string
     * @param $password strng
     *
     * @return WP_Error or WP_User
     */

    function my_authenticate($user, $username, $password ) {
        if (empty($username) || empty($password)) return $user;
        $remoteUserInfo = $this->authenticate_user($username, $password);
        if ($remoteUserInfo === FALSE){
            $this->loginErrorMsg = 'Remote Auth failed. ' . $this->loginErrorMsg;
            return new WP_Error('RemoteAuth', $this->get_login_error_msg());
        }
        else {
            return $this->update_user($remoteUserInfo,$username,$password);
        }
    }

    /*
     * Returns formatted error message
     *
     * @return string
     */
    function get_login_error_msg(){
        return "<strong>ERROR:</strong> $this->loginErrorMsg";
    }

    /*
     * Verifies plugin settings
     *
     * @param $settings plugin option saved in db
     *
     * @return bool
     */
    function verify_plugin_settings($settings){
        if ($settings === false || !is_array($settings) ||
            !isset($settings['webservice']) || empty($settings['webservice']) ||
            !isset($settings['client_id']) || empty($settings['client_id']) ||
            !isset($settings['client_secret']) || empty($settings['client_secret'])
        ){
            return false;
        }
        return true;
    }

    /*
     * Verifies web service response correctness
     *
     * @param @remoteUserInfo array
     *
     * @return bool
     */
    function verfiy_webservice_response($remoteUserInfo){
        if (!isset($remoteUserInfo['result']) ||
            empty($remoteUserInfo['result'])
            ){
            return false;
        }

        if ($remoteUserInfo['result'] == 'success' && (
            !isset($remoteUserInfo['UserID']) ||
            !isset($remoteUserInfo['Email']) ||
            empty($remoteUserInfo['UserID']) ||
            empty($remoteUserInfo['FlightStatus']) ||
            empty($remoteUserInfo['Email'])
            )){
            return false;
        }
        if ($remoteUserInfo['result'] == 'failure' && (
                !isset($remoteUserInfo['error'])

            )){
            return false;
        }
        return true;
    }

    /*
     * Invokes web service authentication method
     *
     * @param $settings array plugin settings
     * @param $username string
     * @param password string
     *
     * @return false or json
     */
    function invoke_remote_method($settings, $username, $password){
        $webservice = $settings['webservice'];
        $clientId = $settings['client_id'];
        $clientSecret = $settings['client_secret'];

        $response = wp_remote_post( esc_url_raw($webservice), array(
                'timeout' => 300,
                'body' => array( 'username' => $username, 'password' => $password, 'clientid'=>$clientId, 'secret'=>$clientSecret),
                'sslverify'=> false
            )
        );
        if (is_wp_error($response)) {
            $this->loginErrorMsg = $response->get_error_message();
            return false;
        }
        $response_code = wp_remote_retrieve_response_code( $response );
        $response_message = wp_remote_retrieve_response_message( $response );
        if ( 200 != $response_code){
            $this->loginErrorMsg =  "Http response error. Code($response_code) - Msg($response_message).";
            return false;
        }
        return wp_remote_retrieve_body( $response );
    }

    /*
     * Authenticates input username and password. Converts json to php array
     *
     * @param $username string
     * @param $password strng
     *
     * @return array
     */
    function authenticate_user($username, $password){
        $this->loginErrorMsg='';
        $settings = get_option(self::SETTING_NAME);
        if (!$this->verify_plugin_settings($settings)){
            $this->loginErrorMsg = 'Invalid/Incomplete settings for RemoteAuth plugin.';
            return false;
        }
        $json = $this->invoke_remote_method($settings, $username, $password);
        if ($json === false){
            return false;
        }
        $remoteUserInfo = json_decode($json, true);
        if ($remoteUserInfo === NULL){
            $this->loginErrorMsg = 'Invalid web service response.';
            return false;
        }
        if ($this->verfiy_webservice_response($remoteUserInfo)===false){
            $this->loginErrorMsg = 'Incomplete web service response.';
            return false;
        }
        if ($remoteUserInfo['result'] == 'failure'){
            $this->loginErrorMsg = $remoteUserInfo['error'];
            return false;
        }

        if (!isset($remoteUserInfo['FirstName'])) $remoteUserInfo['FirstName'] = '';
        if (!isset($remoteUserInfo['LastName'])) $remoteUserInfo['LastName'] = '';
        return $remoteUserInfo;
    }

    /*
     * Updates local user
     *
     * @param $remoteUserInfo array user info received from web service
     * @param $username string
     * @param $password string
     *
     * @return WP_User
     */
    function update_user($remoteUserInfo, $username, $password){
        $userarray['user_login'] = $username;
        $userarray['user_pass'] = $password;
        $userarray['first_name'] = sanitize_text_field($remoteUserInfo['FirstName']);
        $userarray['last_name'] = sanitize_text_field($remoteUserInfo['LastName']);
        $userarray['flight_status'] = sanitize_text_field($remoteUserInfo['FlightStatus']);
        $userarray['user_email'] = sanitize_email($remoteUserInfo['Email']);
        $userarray['display_name'] = $userarray['first_name'] ." ".$userarray['last_name'];
        $userarray['description'] = 'Remotely autheticated user';
        if ($userarray['display_name'] == " ") $userarray['display_name'] = $username;

        $user_id = username_exists($username);
        $user = null;
        if ($user_id) {
            $user = get_userdata($user_id);
            if (strcasecmp($user->first_name,$userarray['first_name'])!=0 ||
                strcasecmp($user->last_name,$userarray['last_name'])!=0 ||
                strcasecmp($user->user_email,$userarray['user_email'])!=0 ||
                !wp_check_password( $userarray['user_pass'], $user->data->user_pass, $user_id)
            ){
                $userarray['ID'] = $user_id;
                $user_id = wp_update_user($userarray);

            }
            $user_state = 'old';
        }
        else {
            $user_id = wp_insert_user($userarray);
            $user_state = 'new';
        }
        if (is_wp_error($user_id)) {
            $wpErrorMsg = $user_id->get_error_message();
            if ($user_state == 'new')
                $errorMsg = 'Failed to create user account.';
            else
                $errorMsg = 'Failed to update user account.';
            $errorMsg .= (empty($wpErrorMsg) ? "" : " $wpErrorMsg");
            $errorMsg .= $username;
            $this->loginErrorMsg = $errorMsg;
            return new WP_Error('RemoteAuth', $this->get_login_error_msg());
        }
        else{
            if ($user_state == 'new'){
                wp_new_user_notification($user_id, $userarray['user_pass']);
            }
            $user = get_userdata($user_id);
            // save a user meta field with the flight status
            update_user_meta($user_id, 'vpoids-training_flight_status', $userarray['flight_status']);
            return $user;
        }
    }

	 /**
     * Activation hook function
     */
    function on_activation() {
        $this->on_activation_helper();
    }
	
	/**
     * helper function for activation
     */
    function on_activation_helper(){
        if ( ! current_user_can( 'activate_plugins' ) )
            wp_die( 'Insufficient permissions' );
		
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "activate-plugin_{$plugin}" );

        global $wp_version;
        if (version_compare($wp_version,"3.5","<")){
            deactivate_plugins(basename(__FILE__));
            wp_die("This plugin requires Wordpress version 3.5 or higher");
        }
    }

	/**
     * Deactivation hook function
     */
    function on_deactivation() {
        $this->on_deactivation_helper();
    }
	
	/**
     * helper function for deactivation
     */
    function on_deactivation_helper(){
        if ( ! current_user_can( 'activate_plugins' ) )
            wp_die( 'Insufficient permissions' );
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "deactivate-plugin_{$plugin}" );
		delete_option('mes_remoteauth_settings');
    }

    /**
     * Adds menu on admin
     */

    function my_admin_menu() {
        $this->main_page_hook_suffix = add_options_page('RemoteAuth Plugin Settings', 'RemoteAuth', 'manage_options', __FILE__, array($this, 'my_options_page') );
    }

    /*
     * Registers plugin settings
     */
    function my_admin_init() {
        //register our settings
        register_setting( 'mes_remoteauth_settings_group', 'mes_remoteauth_settings' );
    }
    /**
     * Displays plugin settings
     */
    function my_options_page() {
        $email = $email_subject = $email_message = $files = false;
        if (isset($this->form_data) && !empty($this->form_data)){
            $clientId = $this->form_data['client_id'];
            $clientSecret = $this->form_data['client_secret'];
        }
        $webservice=$clientId=$clientSecret='';
        $settings = get_option(self::SETTING_NAME);
        if ($settings !== FALSE){
            $webservice = $settings['webservice'];
            $clientId = $settings['client_id'];
            $clientSecret = $settings['client_secret'];
        }

?>
        <div class="wrap">
        <h2>RemoteAuth Plugin Settings</h2>
        <form action="options.php" method="post" name="mes_remoteauth_form" id="mes_remoteauth_form" class="validate">
<?php
settings_fields( 'mes_remoteauth_settings_group');
?>
        <table class="form-table" id="mes_remoteauth_table">
            <tbody>
                <tr class="form-field">
                    <th scope="row"><label for="cf_webservice">Web Service</label></th>
                    <td><input type="text" id="cf_webservice" name="mes_remoteauth_settings[webservice]" aria-required="true" value="<?php echo esc_attr($webservice);?>">
                    <p class="description">for example, https://dev.vpoids.org/api/memberValidate</p></td>

                </tr>
                <tr class="form-field">
                    <th scope="row"><label for="cf_client_id">Client ID </label></th>
                    <td><input type="text" id="cf_client_id" name="mes_remoteauth_settings[client_id]" aria-required="true" value="<?php echo esc_attr($clientId);?>"></td>
                    
                </tr>
                <tr class="form-field">
                    <th scope="row"><label for="cf_client_secret">Client Secret </label></th>
                    <td><input type="text" id="cf_client_secret" name="mes_remoteauth_settings[client_secret]" value="<?php echo esc_attr($clientSecret);?>"></td>
                </tr>
            </tbody>
        </table>
            <?php submit_button(); ?></form>
    </div>
<?php
    }
function is_gpc_on(){
    return (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) || ini_get('magic_quotes_sybase');
}
function process_gpc($value){
    if ($this->is_gpc_on())
        return stripslashes( $value );
    return $value;
}
}//end class
//plugin object
$mes_remoteauth_plugin = new MesRemoteAuth();
?>