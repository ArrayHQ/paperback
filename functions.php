<?php
/**
 * Paperback functions and definitions
 *
 * @package Paperback
 */


if ( ! function_exists( 'paperback_setup' ) ) :
/**
 * Sets up Paperback's defaults and registers support for various WordPress features
 */
function paperback_setup() {

	/**
	 * Load Getting Started page and initialize theme update class
	 */
	require_once get_template_directory() . '/inc/admin/updater/theme-updater.php';

	/**
	 * TGM activation class
	 */
	require_once get_template_directory() . '/inc/admin/tgm/tgm-activation.php';

	/**
	 * Load the Typekit class
	 */
	require_once get_template_directory() . '/inc/typekit/typekit.php';

	/**
	 * Easy Digital Downloads functions
	 */
	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		require_once( get_template_directory() . '/inc/edd/edd.php' );
	}

	/**
	 * Add styles to post editor (editor-style.css)
	 */
	add_editor_style( array( 'editor-style.css', paperback_fonts_url() ) );

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'paperback', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add video metabox
	 */
	add_theme_support( 'array_themes_video_support' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	// Large post image
	add_image_size( 'paperback-full-width', 2000 );

	// Grid thumbnail
	add_image_size( 'paperback-grid-thumb', 450, 300, true );

	// Post navigation thumbnail
	add_image_size( 'paperback-nav-thumb', 800, 280, true );

	// Mega menu thumbnail
	add_image_size( 'paperback-mega-thumb', 235, 160, true );

	// Fixed nav thumbnail
	add_image_size( 'paperback-fixed-thumb', 65, 65, true );

	// Hero image
	add_image_size( 'paperback-hero', 1300 );

	// Hero pager thumb
	add_image_size( 'paperback-hero-thumb', 50, 50, true );

	// Logo size
	add_image_size( 'paperback-logo', 300 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'paperback' ),
		'secondary' => esc_html__( 'Secondary Menu', 'paperback' ),
		'social'    => esc_html__( 'Social Icon Menu', 'paperback' ),
		'footer'    => esc_html__( 'Footer Menu', 'paperback' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'site-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'size'        => 'paperback-logo',
	) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'gallery',
	) );
}
endif; // paperback_setup
add_action( 'after_setup_theme', 'paperback_setup' );


/**
 * Removes certain page templates from the page template
 * dropdown if certain plugins aren't activated.
 *
 * @since Paperback 1.2.2
 */
function paperback_filter_page_templates( $page_templates, $wp_theme, $post ) {

	if( ! class_exists( 'Easy_Digital_Downloads' ) ) :
		unset( $page_templates['inc/edd/home-downloads.php'] );
	endif;

	return $page_templates;
}
add_filter( 'theme_page_templates', 'paperback_filter_page_templates', 10, 3 );


/**
 * Set the content width based on the theme's design and stylesheet
 */
function paperback_content_width() {
	global $content_width;
	if ( is_page_template( 'full-width.php' ) ) {
		$GLOBALS['content_width'] = apply_filters( 'paperback_content_width', 1500 );
	} else {
		$GLOBALS['content_width'] = apply_filters( 'paperback_content_width', 900 );
	}
}
add_action( 'after_setup_theme', 'paperback_content_width', 0 );


/**
 * Register widget area
 */
function paperback_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'paperback' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of posts and pages.', 'paperback' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'paperback' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Widgets added here will appear in the footer.', 'paperback' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'paperback_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
if ( ! function_exists( 'paperback_fonts_url' ) ) :
function paperback_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = esc_html_x( 'on', 'Lato font: on or off', 'paperback' );

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$open_sans = esc_html_x( 'on', 'Open Sans font: on or off', 'paperback' );

	if ( 'off' !== $lato || 'off' !== $open_sans ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:400,700,400italic,700italic';

		if ( 'off' !== $open_sans )
			$font_families[] = 'Open+Sans:400,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles
 */
function paperback_scripts() {

	wp_enqueue_style( 'paperback-style', get_stylesheet_uri() );

	/**
	* Load Open Sans and Lato from Google
	*/
	wp_enqueue_style( 'paperback-fonts', paperback_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.4.0', 'screen' );

	/**
	 * Load Paperback's javascript
	 */
	wp_enqueue_script( 'paperback-js', get_template_directory_uri() . '/js/paperback.js', array( 'jquery' ), '1.0', true );

	/**
	 * Localizes the paperback-js file
	 */
	if( 'enabled' == get_theme_mod( 'paperback_fixed_bar', 'enabled' ) ) {
		$load_fixed = 'true';

		/**
		 * Load headroom core javascript
		 */
		wp_enqueue_script( 'headroom', get_template_directory_uri() . '/js/headroom.js', array(), '0.7.0', true );

		/**
		 * Load headroom for jQuery
		 */
		wp_enqueue_script( 'headroom-jquery', get_template_directory_uri() . '/js/jQuery.headroom.js', array( 'headroom' ), '0.7.0', true );
		
	} else { $load_fixed = 'false'; }
	wp_localize_script( 'paperback-js', 'paperback_js_vars', array(
		'ajaxurl'    => admin_url( 'admin-ajax.php' ),
		'load_fixed' => $load_fixed,
	) );

	/**
	 * Load fitvids
	 */
	wp_enqueue_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.6.6', true );

	/**
	 * Load matchHeight
	 */
	wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load responsiveSlides javascript
	 */
	wp_enqueue_script( 'responsive-slides', get_template_directory_uri() . '/js/responsiveslides.js', array(), '1.54', true );

	/**
	 * Load touchSwipe javascript
	 */
	wp_enqueue_script( 'touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.js', array(), '1.6.6', true );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'paperback_scripts' );


/**
 * Custom template tags for Paperback
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Color customizer theme options
 */
require get_template_directory() . '/inc/color-customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Redirect to Getting Started page on theme activation
 */
function paperback_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "themes.php?page=paperback-license" ) );

	}
}
add_action( 'admin_init', 'paperback_redirect_on_activation' );


/**
 * Add button class to next/previous post links
 */
function paperback_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'paperback_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'paperback_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function paperback_layout_class( $classes ) {
	$layout_style = get_option( 'paperback_layout_style', 'one-column' );

	// Add a sidebar class
	if ( 'three-column' != get_option( 'paperback_layout_style', 'one-column' ) || is_single() || is_page() ) {
		$classes[] = ( is_active_sidebar( 'sidebar' ) ) ? 'has-sidebar' : 'no-sidebar';
	}

	// Add a layout class
	if ( $layout_style ) {
		$classes[] = $layout_style;
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'paperback_layout_class' );


/**
 * Adjust excerpt length based on customizer setting
 */
function paperback_extend_excerpt_length( $length ) {
	return get_theme_mod( 'paperback_grid_excerpt_length', '40' );
}
add_filter( 'excerpt_length', 'paperback_extend_excerpt_length', 999 );


/**
 * Adds a data-object-id attribute to nav links for category mega menu
 *
 * @return array $atts The HTML attributes applied to the menu item's <a> element
 */
function paperback_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	if ( 'post' === get_option( 'paperback_category_menu_edd', 'post' ) && 'category' === $item->object ) {
		$atts['data-object-id'] = $item->object_id;
	}

	if ( 'download' === get_option( 'paperback_category_menu_edd', 'post' ) && 'download_category' === $item->object ) {
		$atts['data-object-id'] = $item->object_id;
	}

	return $atts;
}


/**
 * Filters the current menu item to add another class.
 * Used to restore the active state when using the mega menu.
 */
function paperback_nav_menu_css_class( $item, $args, $depth ) {
	if ( in_array( 'current-menu-item', $item ) ) {
		$item[] = 'current-menu-item-original';
	}
	return $item;
}


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function paperback_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'paperback_page_menu_args' );


/**
 * Fetches the posts for the mega menu posts
 */
function paperback_menu_category_query() {

	$post_type = get_option( 'paperback_category_menu_edd', 'post' );
	$term_html = '';
	$output    = '';
	$id        = ( ! empty( $_REQUEST['id' ] ) ) ? $_REQUEST['id'] : '';

	if ( class_exists( 'Easy_Digital_Downloads' ) && 'download' === $post_type ) {
		$taxonomy = 'download_category';
	} else {
		$taxonomy = 'category';
	}

	if ( ! empty( $id ) ) {
		$term = get_term( (int) $id, $taxonomy );
	}

	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {

		$args = apply_filters( 'paperback_mega_menu_query_args', array(
			'posts_per_page' => '6',
			'post_type'      => (array) $post_type,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => (int) $id
				)
			)
		) );

		$posts = new WP_Query( $args );

		if ( $posts->have_posts() ) {
			ob_start();
			while( $posts->have_posts() ) {
				$posts->the_post();
				include( 'template-parts/content-mini-grid-item.php' );
			}
			$output = ob_get_clean();

			// Get category title and link
			$term_html = sprintf( esc_html__( 'Category: %s', 'paperback' ), $term->name ) . sprintf( wp_kses( __( '<a class="view-all" href="%s">View All</a>', 'paperback' ), array( 'a' => array( 'href' => array(), 'class' => 'view-all' ) ) ), esc_url( get_term_link( $term->term_id, $taxonomy ) ) );
		} else {
			$term_html = esc_html__( 'No articles were found.', 'paperback' );
		}
	}

	wp_send_json( array(
		'html'      => $output,
		'term_html' => $term_html
	) );

}
add_action( 'wp_ajax_paperback_category', 'paperback_menu_category_query' );
add_action( 'wp_ajax_nopriv_paperback_category', 'paperback_menu_category_query' );

/**
 * Adds the menu item filters when the mega menu option is enabled
 */
function paperback_mega_menu_check() {

	if ( 'enabled' === get_theme_mod( 'paperback_category_menu', 'disabled' ) ) {
		add_filter( 'nav_menu_css_class', 'paperback_nav_menu_css_class', 10, 3 );
		add_filter( 'nav_menu_link_attributes', 'paperback_nav_menu_link_attributes', 10, 4 );
	}
}
add_action( 'template_redirect', 'paperback_mega_menu_check' );


/**
 * Auto generate excerpt on single column layout
 */
function paperback_auto_excerpt( $content = false ) {

	global $post;
	$content = $post->post_excerpt;

	// If an excerpt is set in the Excerpt box
	if( $content ) {

		$content = apply_filters( 'the_excerpt', $content );

	} else {
		// No excerpt, get the first 55 words from post content
		$content = wpautop( wp_trim_words( $post->post_content, 55 ) );

	}

	// Read more link
	return $content . '<a class="more-link" href="' . get_permalink() . '">' . esc_html__( 'Read More', 'paperback' ) . '</a>';

}

/**
 * Auto generate excerpt if option is selected
 */
function paperback_excerpt_check() {
	// If is the home page, an archive, or search results
	if ( 'enabled' === get_theme_mod( 'paperback_auto_excerpt', 'disabled' ) && ( is_home() || is_archive() || is_search() ) ) {
		add_filter( 'the_content', 'paperback_auto_excerpt' );
	}
}
add_action( 'template_redirect', 'paperback_excerpt_check' );


/**
 * Exclude featured posts from main loop
 */
function paperback_exclude_featured_posts($query) {
	$hero_category = get_theme_mod( 'paperback_hero_header' );

	if ( 1 === get_theme_mod( 'paperback_hero_header_exclude', 0 ) && $query->is_home() && $query->is_main_query() ) {
		$query->set( 'cat', '-' . $hero_category );
	}
}
add_action( 'pre_get_posts', 'paperback_exclude_featured_posts' );
