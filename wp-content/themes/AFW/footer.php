<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>
			<div style="background:#c8d5e8; padding:25px 0;" class="clear">
				<div style="max-width:1040px; margin:0 auto;" class="clear">
				
				
					<?php wp_nav_menu( array( 'theme_location' => 'footer_1', 'container_class' => 'footer_1 clear' ) ); ?>
				</div>
			</div>
			<div class="site-info">
				<div class="legal" style="">&copy;<?php print date('Y'); ?> Angel Flight West. All Rights Reserved.</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
	
	<script type="text/javascript"> 
    jQuery(document).ready(function() { 
    	// add a helper class to body highlight correct header tab, also see header relies on WP custom fields on each page. 
		if (jQuery('body').data('section') == 'pilots') {
			jQuery('body').addClass('pilots');
			}
    }); 
	</script>

</body>
</html>