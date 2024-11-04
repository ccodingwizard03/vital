=== RemoteAuth ===
Authenticates user remotely using web service. On success, creates local user with same credentials if not already exists else conditionally updates local user.

== Description ==
Captures inputted username and password from login page and authenticates the user from web service. On successful authentication, new user account in wordpress is created if it doesn't already exist. On each login, local user is updated if remote user email, first name, last name or password is changed. On authentication failure, customized error message is shown on login page.

== Installation ==
As easy, as 1-2-3 -
1. Upload 'mes_remote_auth' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Start using the 'xmailer'

= Plugin Activation = 
Adds an option page under setting menu. Web service url, client id, client secret can be configured on option page.

= Plugin Deactivation = 
Deletes plugin settings, removes plugin's menu and its corresponding page.

= Requirements = 
Requires oWordpress 3.5 or later.

== Notes ==
1. Wordpress core sanitizes username and trims password on new user registration. So, I shall be sending sanitized username and trimmed password to web service. Otherwise, username and password of wordpress will not be same as on remote server. (Sanitization removes tags, octets, entities and returns only  alphanumeric characters, underscore, space, dot, dash, asterik, and @)

2. After web service authentication, if user already exist in wordpress, user will be updated if firstname, lastname,email or password is different than stored in wordpress. This way, local and remote user properties will be kept in sync.

3. I am sending POST HTTP request to web service.

4. On authentication failure from web service, login will be failed even if user credentials are correct for wordpress.

== Support ==
Please feel free to reach me at 'myesys@gmail.com'
