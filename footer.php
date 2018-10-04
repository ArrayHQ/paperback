<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Paperback
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php
	// Get the post navigations for single posts
	if ( is_single() ) {
		paperback_post_navigation();
	} ?>

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">

		<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<div class="footer-widgets">
				<?php do_action( 'paperback_above_footer_widgets' );
				dynamic_sidebar( 'footer' );
				do_action( 'paperback_below_footer_widgets' ); ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<?php if ( has_nav_menu( 'footer' ) ) { ?>
				<nav class="footer-navigation" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .footer-navigation -->
			<?php } ?>

			<div class="footer-tagline">
				<div class="site-info">
					<?php echo paperback_filter_footer_text(); ?>
				</div>
			</div><!-- .footer-tagline -->
		</div><!-- .footer-bottom -->
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
