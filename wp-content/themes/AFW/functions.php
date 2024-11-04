<?php
/**
 * Twenty Thirteen child functions load before parent. http://codex.wordpress.org/Child_Themes#Using_functions.php
 * Remove sidebar class from body tag
 */
function twentythirteenchild_body_class( $classes ) {
	if ( is_page_template('page-templates/full-width.php') )
	foreach($classes as $key => $value) {
      if ($value == 'sidebar') unset($classes[$key]);
      }
	return $classes;
}
add_filter( 'body_class', 'twentythirteenchild_body_class', 20 );
/*
secondary menu in child theme
*/
function register_my_menus() {
  register_nav_menus(
    array(
      'primary' => __( 'Navigation Menu' ),
      'extra-menu' => __( 'Extra Menu' ),
      'about-menu' => __( 'About Menu' ),
      'passengers-menu' => __( 'Passengers Menu' ),
      'members-menu' => __( 'Members Menu' ),
      'footer_1' => __( 'Footer 1' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );
/*
Attempt at segmenting pilot posts from everything else
*/
function exclude_category( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-35' );
    }
}
add_action( 'pre_get_posts', 'exclude_category' );
/*
http://css-tricks.com/snippets/wordpress/if-page-is-parent-or-child/
*/
function is_tree($pid) {      // $pid = The ID of the page we're looking for pages underneath
	global $post;         // load details about this page
	if(is_page()&&($post->post_parent==$pid||is_page($pid))) 
        return true;   // we're at the page or at a sub page
	else 
        return false;  // we're elsewhere
}
function cycle_scripts() {
	wp_register_script( 'cycle2', get_stylesheet_directory_uri().'/js/jquery.cycle2.0.2.min.js');
    wp_enqueue_script( 'cycle2' );
    
    wp_register_script( 'cycle2-carousel', get_stylesheet_directory_uri().'/js/jquery.cycle2.carousel.min.js');
    wp_enqueue_script( 'cycle2-carousel' );
    
    wp_register_script( 'cycle2-swipe', get_stylesheet_directory_uri().'/js/jquery.cycle2.swipe.min.js');
    wp_enqueue_script( 'cycle2-swipe' );
}    
add_action('wp_enqueue_scripts', 'cycle_scripts');

function fancybox_scripts() {
	wp_enqueue_style( 'fancybox-css', get_stylesheet_directory_uri().'/js/jquery.fancybox.css');
	wp_register_script( 'fancybox', get_stylesheet_directory_uri().'/js/jquery.fancybox.pack.js');
    wp_enqueue_script( 'fancybox' );
}    
add_action('wp_enqueue_scripts', 'fancybox_scripts');

function custom_excerpt_more( $more ) {
  return '';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

function has_parent($post, $post_id) {
  if ($post->ID == $post_id) return true;
  else if ($post->post_parent == 0) return false;
  else return has_parent(get_post($post->post_parent),$post_id);
}

add_filter('widget_text', 'do_shortcode');

// handle the creation of an assignment, which means a file was uploaded
function learndash_assignment_uploaded($post_id) {
	// If this is just a revision, don't send the email.
	//echo "<p>Post ID: ".$post_id;
	//echo "<p>Post Type: ".get_post_type($post_id);
	//exit;
	if (wp_is_post_revision($post_id)) return;

  $post_type = get_post_type($post_id);
  if ($post_type == "sfwd-assignment") {
	  $post_title = get_the_title($post_id);
	  $post_url = get_permalink($post_id);
    $current_user = wp_get_current_user();
    if ($post->ID == '') $pid = $post_id; else $pid = $post->ID;
    $file_name = get_post_meta($pid,'file_name', true); 
    $file_link = get_post_meta($pid,'file_link', true); 
    $user_name = get_post_meta($pid,'user_name', true); 
    $lesson_id = get_post_meta($pid,'lesson_id', true);     
    $course_id = get_post_meta($pid,'course_id', true); 
    
    $response = wp_remote_post( esc_url_raw("https://missions.vitalflight.org/api/memberDocReceived"),
      array(
        'timeout' => 300,
        'body' => array(
          'post_id' => $post_id,
          'user_username' => $current_user->user_login,
          'post_title' => $post_title,
          'post_url' => $post_url,
          'file_name' => $file_name,
          'file_link' => $file_link,
          'post_user_name' => $user_name,
          'lesson_id' => $lesson_id,
          'course_id' => $course_id
        ),
        'sslverify'=> false
      )
    );	  
  }
}
add_action( 'save_post', 'learndash_assignment_uploaded',11);

// handle the creation of an assignment, which means a file was uploaded
function learndash_assignment_uploaded_meta($post_id) {
	// Check to see if this is a revision
	if (wp_is_post_revision($post_id)) return;

  $post_type = get_post_type($post_id);
  if ($post_type == "sfwd-assignment") {
    update_post_meta($post_id,'vpoids_check',1);
  }
}

add_action('save_post','learndash_assignment_uploaded_meta',10,2);

/* the previous method will work better
function redirect_assignment_upload()
{
  // if something posted on a page
  if (isset($_POST) && !empty($_POST)) {
    // if not in a dashboard
    if (!is_admin()) {
      // if LD file upload form is submitted
      if (isset($_POST['uploadfile']) && isset($_POST['post'])) {
        $file = $_FILES['uploadfiles'];
        $name = $file['name']; // uploaded file name
        // if upload is not empty
        if (!empty($file['name'][0])) {
        	$current_user = wp_get_current_user();
          $response = wp_remote_post( esc_url_raw("https://missions.vitalflight.org/api/memberDocReceived"),
            array(
              'timeout' => 300,
              'body' => array(
                'post_id' => $_POST["post"],
                'user_username' => $current_user->user_login
              ),
              'sslverify'=> false
            )
          );
        }
      }
    }
  }
}

add_action('parse_request', 'redirect_assignment_upload', 10);
*/

// change what happens after a course is completed
add_filter("learndash_course_completion_url", function($link, $course_id) {
  if ($course_id == 1) $link = "/ground-orientation-complete/"; /* ground orientation course */
  if ($course_id == 2) $link = "/command-pilot-orientation-complete/"; /* command pilot orientation course */
  return $link;
}, 5, 2);

// make a call to the organization's VPOIDS server when a course is completed
add_action("learndash_course_completed", function($data) {
  // $data = array( 'user' => $current_user, 'course' => get_post($course_id), 'progress' => $course_progress)
  // $course_id = $data["course"]->ID;
  // $user_id = $data["user"]->ID;
  $response = wp_remote_post( esc_url_raw("https://missions.vitalflight.org/api/orientationCourseCompleted"),
    array(
      'timeout' => 300,
      'body' => array('user_username' => $data["user"]->user_login,'course_id' => $data["course"]),
      'sslverify'=> false
    )
  );
}, 5, 1);

/* shortcodes to replace organization specific terminology */
function org_name_text() {
  return "Angel Flight West";
}
function ground_volunteer_term_text() {
  return "Earth Angel";
}
function vpoids_url_text() {
  return "https://afids.angelflightwest.org";
}
function coordination_email_text() {
  return "coordination@angelflightwest.org";
}
function volunteer_email_text() {
  return "memberinfo@angelflightwest.org";
}

add_shortcode('organization_name', 'org_name_text');
add_shortcode('ground_volunteer_term', 'ground_volunteer_term_text');
add_shortcode('vpoids_url', 'vpoids_url_text');
add_shortcode('coordination_email', 'coordination_email_text');
add_shortcode('volunteer_email', 'volunteer_email_text');

