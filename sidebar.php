<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Paperback
 */

// Get layout style
$homepage_layout = get_option( 'paperback_layout_style', 'one-column' );

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar' ) ) {
	if ( $homepage_layout === 'one-column' || $homepage_layout === 'two-column' || is_single() || is_page() ) {
	?>
	<div id="secondary" class="widget-area">
		<?php do_action( 'paperback_above_sidebar' );

		dynamic_sidebar( 'sidebar' );

		do_action( 'paperback_below_sidebar' ); ?>
	</div><!-- #secondary .widget-area -->
<?php } } ?>