<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Paperback
 */


/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function paperback_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrapper',
		'footer'         => 'page',
		'footer_widgets' => array( 'footer' ),
		'render'         => 'paperback_render_infinite_posts',
		'wrapper'        => 'new-infinite-posts',
	) );
}
add_action( 'after_setup_theme', 'paperback_jetpack_setup' );


/* Render infinite posts by using template parts */
function paperback_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		if ( 'one-column' === get_option( 'paperback_layout_style', 'one-column' ) ) {
			get_template_part( 'template-parts/content' );
		} else {
			get_template_part( 'template-parts/content-grid-item' );
		}
	}
}


/**
 * Changes the text of the "Older posts" button in infinite scroll
 */
function paperback_infinite_scroll_button_text( $js_settings ) {

	$js_settings['text'] = esc_html__( 'Load more', 'paperback' );

	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'paperback_infinite_scroll_button_text' );


/**
 * Move Related Posts
 */
function paperback_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'post_flair', $callback, 40 );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'paperback_remove_rp', 20 );
