=== Insert or Embed Articulate Content into Wordpress ====
Contributors: Brian Batt
Donate link: http://www.articulatefreak.com/presenter/insert-or-embed-articulate-content-into-wordpress-plugin/
Tags: articulate, presenter, quizmaker, engage, storyline, insert, embed, iframe, studio
Requires at least: 2.0.2
Tested up to: 4.1
Stable tag: 4.5
Quickly embed or insert Articulate content into a post or page.

== Description ==

This plugin will add a new toolbar icon (the letter 'a') next to the 'Add Media' button on the Edit Post and Edit Page pages.  Upon clicking this toolbar icon, you will have the ability to upload your published Articulate content as a ZIP file.  Once uploaded, the plugin will automatically extract the content, find the approriate .html file, and add code to your post or page that will display your Articulate content as an iframe or a lightbox.

== Installation ==

1. Upload the 'insert-or-embed-articulate-into-wordpress' folder to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

== How to Use ==

Check out the screencast in the link below to learn how to use this plugin: https://www.youtube.com/watch?v=AwcIsxpkvM4

== Frequently Asked Questions ==

= How do I use this to embed Articulate content? =

Check out this screencast:  https://www.youtube.com/watch?v=AwcIsxpkvM4

= Does this work with Articulate Storyline content? =

Yes, it works with all versions of Articulate Storyline.

= Why does the upload never finish or I get a -1 error message? =

In order to resolve this issue, you need to update your php.ini file in your wp-admin folder to reflect the following: 

post_max_size = 50M

max_execution_time = 60

max_input_time = 60

upload_max_filesize = 50M


(These settings will vary depending upon your server and content.  You may need to contact your hosting company to make these changes.) 

= If I delete the plugin, what happens to the content that I've uploaded? =

The uploaded content is saved into the wp-content / uploads / articulate_uploads folder on your site.  Thus, your uploaded content will not be removed if you delete this plugin.

== Changelog ==

= 4.5 =

Added multi-site or network support

= 4.0 =

Added support for custom lightbox sizing
Added support for custom launch buttons
Added themes
Added the ability to disable scroll bars when you launch with a lightbox
Added support for custom transitions in the default lightbox
Added support for the Nivo lightbox
Added support for custom transitions in the Nivo lightbox
Added a Dashboard that displays on the left side of the Admin panel in Wordpress
Crushed bugs

= 3.2 =

Added support for Articulate Studio '13 including Presenter '13, Engage '13, and Quizmaker '13

= 2.00 =

Added lightbox support via Colorbox
Added the ability to launch the content with a link or a Launch Presentation button

= 1.04 =

Fixed short tag created when adding Storyline content (story.html) (Thanks to David Burton)
Added additional information in the readme.txt on handling the -1 error and other upload errors

= 1.03 =

Fixed call to quiz.png for all users

= 1.02 =

Fixed call to quiz.png for some browsers

= 1.01 =

Fixed call to jquery

= 1.0 =

Initial version.

== Upgrade Notice ==

Added multi-site or network support