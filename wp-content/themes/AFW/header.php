<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!-- header.php -->
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png?<?php echo date('H:i:s')?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body <?php body_class(); ?> data-section="<?php echo get_post_meta($post->ID, 'section', true); ?>">
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
	<div id="page" class="hfeed site">
	
	<!--<div class="site-top-banner">
		<div class="site-top-banner-inner"><span id="top-phone" style="color:#ffc600">888-4-AN-ANGEL (888-426-2643)</span> <div class="social" style="float:right;"><a href="//plus.google.com/105851682686270627305?prsrc=3" rel="publisher" target="_top" style="text-decoration:none;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/google_32.png" alt="Google+" style="border:0; width:24px; height:24px; margin-left:5px; vertical-align:-40%;"/></a><a href="https://www.facebook.com/AngelFlightWest" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook_32.png" style="width:24px; height:24px; margin-left:5px; vertical-align:-40%;" /></a><a href="https://twitter.com/AngelFlightWest" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/twitter_32.png" style="width:24px; height:24px; margin-left:5px; vertical-align:-40%;" /></a><a href="http://www.youtube.com/user/angelflightwest" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/youtube_32.png" style="width:24px; height:24px; margin-left:5px; vertical-align:-40%;" /></a><a href="http://www.amazon.com/?tag=afw-homepage-20" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/amazon_32.png" style="width:24px; height:24px; margin-left:5px; vertical-align:-40%;" /></a><a style="margin-left:15px;" href="/about-us/">About</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/blog/">News</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/regional-wings/">Wings</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/pilot-page/calendar-of-events/">Events</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="http://www.endeavorawards.org" target="_blank">Endeavor Awards</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/about-us/contact-us/">Contact</a>&nbsp;&nbsp;&nbsp;<a class="header-button" href="https://afids.angelflightwest.org/">Member Login</a></div></div>
	</div>
	<div>
		<div class="site-top-main-tabs-inner clear" style="padding:10px 0 0 0;">
			<a href="/"><h1 class="ir logo">Angel Flight West</h1></a>
			<div class="top-tabs">
			<a href="https://afids.angelflightwest.org/flight-request" class="main-nav request-tab" style="width:255px;">
				<span style="font-size:1.4em;"><span style="font-weight:900;">Request</span> a Flight</span>
				<div style="">See if you qualify for free medical and compassion flights</div>
			</a>
			<a href="/pilot-page/" class="main-nav pilots-tab" style="width:330px;">
				<span style="font-size:1.4em;"><span style="font-weight:900;">Join</span> Angel Flight West</span>
				<div style="">Find out what it takes and why it's so rewarding to be an Angel Flight West pilot</div>
			</a>
			<a href="/donate/" class="main-nav donate-tab" style="width:245px;">
				<span style="font-size:1.4em;"><span style="font-weight:900;">Donate</span> to AFW</span>
				<div style="">Explore the many ways you can help Angel Flight West</div>
			</a>
			</div>
		</div>    
    </div> 
    <div class="site-top-main-tabs-stripe"></div>-->
    <!-- / end tabs -->
    <?php
    if( is_home() ) { ?>
<!-- is_page = blog!! -->
					<header id="masthead" class="site-header" role="banner" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/header-image-<?php print rand(1, 7); ?>.jpg) no-repeat top center; ">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<!-- fixed position over header -->
			<div class="content-wrap clearfix" style="width:1050px;">
				<div class="slider-static-block" style="margin-left:0; text-align:center; width:1052px;">
<img src="/wp-content/themes/AFW/images/vital-flight-training.png" style="width:190px; height:auto; vertical-align:middle;" />
				<span style="margin-top:0; padding-top:0; font-size:38px; color:#fff">Vital Flight U</span>
				<div style="font-size:18px; line-height:140%; color:#fff;">Online learning for new Vital Flight volunteers that will set you up for success.</div>
				</div>
			</div> 
			</a>
			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
					<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</header><!-- #masthead -->
<!-- / is_page = blog -->
<?php } else { ?>
<!-- default masthead -->
			<header id="masthead" class="site-header" role="banner" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/header-image-<?php print rand(1, 7); ?>.jpg) no-repeat top center; ">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<!-- fixed position over header -->
			<div class="content-wrap clearfix" style="width:1050px;">
				<div class="slider-static-block" style="margin-left:0; text-align:center; width:1052px;">
<img src="/wp-content/themes/AFW/images/vital-flight-training.png" style="width:190px; height:auto; vertical-align:middle;" />
				<span style="margin-top:0; padding-top:0; font-size:38px; color:#fff">Vital Flight U</span>
				<div style="font-size:18px; line-height:140%; color:#fff;">Online learning for new Vital Flight volunteers that will set you up for success.</div>
				</div>
			</div> 
			</a>
			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
					<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</header><!-- #masthead -->
<!-- / default masthead -->
	<?php } ?>		

	<div id="main" class="site-main">
<!-- / header.php -->