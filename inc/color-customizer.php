<?php
/**
 * Paperback Customizer functionality
 *
 * @package WordPress
 * @subpackage Paperback
 * @since Paperback 1.0
 *
 * Based on the color customization options found in TwentyFifteen
 */

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Paperback 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function paperback_color_customize_register( $wp_customize ) {
	$color_scheme = paperback_get_color_scheme();

	/**
	 * Add color scheme setting and control.
	 */
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'paperback_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => esc_html__( 'Base Color Scheme', 'paperback' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => paperback_get_color_scheme_choices(),
		'priority' => 1,
	) );


	/**
	 * Remove the core header textcolor control
	 */
	$wp_customize->remove_control( 'header_textcolor' );


	/**
	 * Top Navigation Background Color
	 */
	$wp_customize->add_setting( 'top_nav_background_color', array(
		'default'           => $color_scheme[0],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_nav_background_color', array(
		'label'       => esc_html__( 'Top Navigation Background Color', 'paperback' ),
		'description' => esc_html__( 'Applied to the top navigation background.', 'paperback' ),
		'section'     => 'colors',
	) ) );


	/**
	 * Top Navigation Text Color
	 */
	$wp_customize->add_setting( 'top_nav_text_color', array(
		'default'           => $color_scheme[1],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_nav_text_color', array(
		'label'       => esc_html__( 'Top Navigation Text Color', 'paperback' ),
		'description' => esc_html__( 'Applied to the top navigation text and links.', 'paperback' ),
		'section'     => 'colors',
	) ) );


	/**
	 * Header Background Color
	 */
	$wp_customize->add_setting( 'header_background_color', array(
		'default'           => $color_scheme[2],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background_color', array(
		'label'       => esc_html__( 'Header Background Color', 'paperback' ),
		'description' => esc_html__( 'Applied to the header that contains the logo and main navigation.', 'paperback' ),
		'section'     => 'colors',
	) ) );


	/**
	 * Header Text Color
	 */
	$wp_customize->add_setting( 'header_text_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_text_color', array(
		'label'       => esc_html__( 'Header Text Color', 'paperback' ),
		'description' => esc_html__( 'Applied to text and links in the header.', 'paperback' ),
		'section'     => 'colors',
	) ) );


	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'accent_color', array(
		'default'           => $color_scheme[4],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label'       => esc_html__( 'Accent Color', 'paperback' ),
		'description' => esc_html__( 'Applied to some elements as an accent color.', 'paperback' ),
		'section'     => 'colors',
	) ) );


	/**
	 * Footer Background Color
	 */
	$wp_customize->add_setting( 'footer_background_color', array(
		'default'           => $color_scheme[5],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color', array(
		'label'       => esc_html__( 'Footer Background Color', 'paperback' ),
		'description' => esc_html__( 'Applied to the background of the footer widget area.', 'paperback' ),
		'section'     => 'colors',
	) ) );


	/**
	 * Footer Text Color
	 */
	$wp_customize->add_setting( 'footer_text_color', array(
		'default'           => $color_scheme[6],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color', array(
		'label'       => esc_html__( 'Footer Text Color', 'paperback' ),
		'description' => esc_html__( 'Applied to the text in the footer widget area.', 'paperback' ),
		'section'     => 'colors',
	) ) );

}
add_action( 'customize_register', 'paperback_color_customize_register', 11 );



/**
 * Register color schemes for Paperback.
 *
 * Can be filtered with {@see 'paperback_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Top Navigation Background Color
 * 2. Top Navigation Text Color
 * 3. Header Background Color
 * 4. Header Text Color
 * 5. Accent Color
 * 6. Footer Background Color
 * 7. Footer Text Color
 *
 * @since Paperback 1.0
 *
 * @return array An associative array of color scheme options.
 */
function paperback_get_color_schemes() {
	return apply_filters( 'paperback_color_schemes', array(
		'default' => array(
			'label'  => esc_html__( 'Default', 'paperback' ),
			'colors' => array(
				'#343e47',
				'#ffffff',
				'#ecf1f7',
				'#383f49',
				'#f35245',
				'#343e47',
				'#ffffff',
			),
		),
		'blue-color'  => array(
			'label'  => esc_html__( 'Blue', 'paperback' ),
			'colors' => array(
				'#1796c6',
				'#ffffff',
				'#ecf1f7',
				'#343e47',
				'#1796c6',
				'#343e47',
				'#ffffff',
			),
		),
		'green-color'    => array(
			'label'  => esc_html__( 'Green', 'paperback' ),
			'colors' => array(
				'#53b584',
				'#ffffff',
				'#ecf1f7',
				'#343e47',
				'#53b584',
				'#343e47',
				'#ffffff',
			),
		),
		'purple-color'  => array(
			'label'  => esc_html__( 'Purple', 'paperback' ),
			'colors' => array(
				'#9b59b6',
				'#ffffff',
				'#ecf1f7',
				'#343e47',
				'#9b59b6',
				'#343e47',
				'#ffffff',
			),
		),
		'red-color'  => array(
			'label'  => esc_html__( 'Red', 'paperback' ),
			'colors' => array(
				'#e05a50',
				'#ffffff',
				'#ecf1f7',
				'#343e47',
				'#e05a50',
				'#343e47',
				'#ffffff',
			),
		),
		'orange-color'  => array(
			'label'  => esc_html__( 'Orange', 'paperback' ),
			'colors' => array(
				'#e8804c',
				'#ffffff',
				'#ecf1f7',
				'#343e47',
				'#e8804c',
				'#343e47',
				'#ffffff',
			),
		),
	) );
}


if ( ! function_exists( 'paperback_get_color_scheme' ) ) :
/**
 * Get the current Paperback color scheme.
 *
 * @since Paperback 1.0
 *
 * @return array An associative array of either the current or default color scheme hex values.
 */
function paperback_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = paperback_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif; // paperback_get_color_scheme



if ( ! function_exists( 'paperback_get_color_scheme_choices' ) ) :
/**
 * Returns an array of color scheme choices registered for Paperback.
 *
 * @since Paperback 1.0
 *
 * @return array Array of color schemes.
 */
function paperback_get_color_scheme_choices() {
	$color_schemes                = paperback_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif; // paperback_get_color_scheme_choices



/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Paperback 1.0
 *
 * @see wp_add_inline_style()
 */
function paperback_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = paperback_get_color_scheme();

	// Convert color to rgba
	$footer_text_color_rgb = paperback_hex2rgb( $color_scheme[6] );

	$colors = array(
		'top_nav_background_color'    => $color_scheme[0],
		'top_nav_text_color'          => $color_scheme[1],
		'header_background_color'     => $color_scheme[2],
		'header_text_color'           => $color_scheme[3],
		'accent_color'                => $color_scheme[4],
		'footer_background_color'     => $color_scheme[5],
		'footer_text_color'           => $color_scheme[6],
		'footer_text_color_secondary' => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.8)', $footer_text_color_rgb ),
		'footer_border_color'         => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.3)', $footer_text_color_rgb ),
	);

	$color_scheme_css = paperback_get_color_scheme_css( $colors );

	wp_add_inline_style( 'paperback-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'paperback_color_scheme_css' );


/**
 * Returns CSS for the color schemes.
 *
 * @since Paperback 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function paperback_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'top_nav_background_color'    => '',
		'top_nav_text_color'          => '',
		'header_background_color'     => '',
		'header_text_color'           => '',
		'accent_color'                => '',
		'footer_background_color'     => '',
		'footer_text_color'           => '',
		'footer_text_color_secondary' => '',
		'footer_border_color'         => '',
	) );

	$css = <<<CSS
	/* Color Scheme */

	/* Top Navigation Background Color */
	.top-navigation,
	.secondary-navigation ul.sub-menu {
		background-color: {$colors['top_nav_background_color']};
	}

	.top-navigation,
	.top-navigation nav a,
	.top-navigation li ul li a,
	.drawer-toggle {
		color: {$colors['top_nav_text_color']};
	}

	.main-navigation a,
	.site-title a,
	.site-description {
		color: {$colors['header_text_color']};
	}

	.main-navigation:not(.secondary-navigation) ul.menu > li.current-menu-item > a {
		border-color: {$colors['accent_color']};
	}

	.site-identity {
		background-color: {$colors['header_background_color']};
	}

	.hero-cats a,
	.post-navigation .nav-label,
	.entry-cats a {
		background-color: {$colors['accent_color']};
	}

	.page-numbers.current,
	.page-numbers:hover,
	#page #infinite-handle button:hover {
		background-color: {$colors['accent_color']};
	}

	.main-navigation:not(.secondary-navigation) ul > li.current-menu-item > a {
		border-bottom-color: {$colors['accent_color']};
	}

	.site-footer {
		background-color: {$colors['footer_background_color']};
	}

	.site-footer,
	.site-footer a {
		color: {$colors['footer_text_color_secondary']};
	}

	.site-footer .widget-title,
	.site-footer a:hover {
		color: {$colors['footer_text_color']};
	}

	.footer-widgets ul li,
	.footer-widgets + .footer-bottom {
		border-color: {$colors['footer_border_color']};
	}

CSS;

	return $css;
}



/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer
 * preview.
 *
 * @since Paperback 1.0
 */
function paperback_color_scheme_css_template() {
	$colors = array(
		'top_nav_background_color'    => '{{ data.top_nav_background_color }}',
		'top_nav_text_color'          => '{{ data.top_nav_text_color }}',
		'header_background_color'     => '{{ data.header_background_color }}',
		'header_text_color'           => '{{ data.header_text_color }}',
		'accent_color'                => '{{ data.accent_color }}',
		'footer_background_color'     => '{{ data.footer_background_color }}',
		'footer_text_color'           => '{{ data.footer_text_color }}',
		'footer_text_color_secondary' => '{{ data.footer_text_color_secondary }}',
		'footer_border_color'         => '{{ data.footer_border_color }}',
	);
	?>
	<script type="text/html" id="tmpl-paperback-color-scheme">
		<?php echo paperback_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'paperback_color_scheme_css_template' );



/**
 * Enqueues front-end CSS for the custom colors.
 *
 * @since Paperback 1.0
 *
 * @see wp_add_inline_style()
 */
function paperback_header_background_color_css() {
	$default_color = get_theme_mod( 'color_scheme', 'default' );
	$color_scheme  = paperback_get_color_scheme();

	$top_nav_background_color = get_theme_mod( 'top_nav_background_color', $color_scheme[0] );
	$top_nav_text_color       = get_theme_mod( 'top_nav_text_color', $color_scheme[1] );
	$header_background_color  = get_theme_mod( 'header_background_color', $color_scheme[2] );
	$header_text_color        = get_theme_mod( 'header_text_color', $color_scheme[3] );
	$accent_color             = get_theme_mod( 'accent_color', $color_scheme[4] );
	$footer_background_color  = get_theme_mod( 'footer_background_color', $color_scheme[5] );
	$footer_text_color        = get_theme_mod( 'footer_text_color', $color_scheme[6] );

	// Convert color to rgba
	$footer_text_color_rgb   = paperback_hex2rgb( $footer_text_color );
	$footer_text_color_secondary = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.8)', $footer_text_color_rgb );
	$footer_border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.3)', $footer_text_color_rgb );

	$css = '
		/* Top Nav Background Color */
		.top-navigation,
		.secondary-navigation ul.sub-menu {
			background-color: %1$s;
		}

		/* Top Nav Text Color */
		.top-navigation,
		.top-navigation nav a,
		.top-navigation li ul li a,
		.drawer-toggle {
			color: %2$s;
		}

		.main-navigation:not(.secondary-navigation) ul.menu > li.current-menu-item > a {
			border-color: %5$s;
		}

		/* Header Background Color */
		.site-identity {
			background-color: %3$s;
		}

		/* Header Text Color */
		.main-navigation a,
		.site-title a,
		.site-description {
			color: %4$s;
		}

		/* Accent Color */
		.hero-cats a,
		.post-navigation .nav-label,
		.entry-cats a {
			background-color: %5$s;
		}

		.page-numbers.current,
		.page-numbers:hover,
		#page #infinite-handle button:hover {
			background-color: %5$s;
		}

		/* Footer Background Color */
		.site-footer {
			background-color: %6$s;
		}

		/* Footer Text Color */
		.site-footer .widget-title,
		.site-footer a:hover {
			color: %7$s;
		}

		.site-footer,
		.site-footer a {
			color: %8$s;
		}

		/* Footer Border Color */
		.footer-widgets ul li,
		.footer-widgets + .footer-bottom {
			border-color: %9$s;
		}
	';

	wp_add_inline_style( 'paperback-style', sprintf(
		$css,
		$top_nav_background_color,
		$top_nav_text_color,
		$header_background_color,
		$header_text_color,
		$accent_color,
		$footer_background_color,
		$footer_text_color,
		$footer_text_color_secondary,
		$footer_border_color ) );
}
add_action( 'wp_enqueue_scripts', 'paperback_header_background_color_css', 11 );



if ( ! function_exists( 'paperback_sanitize_color_scheme' ) ) :
/**
 * Sanitization callback for color schemes.
 *
 * @since Paperback 1.0
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function paperback_sanitize_color_scheme( $value ) {
	$color_schemes = paperback_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default';
	}

	return $value;
}
endif; // paperback_sanitize_color_scheme



/**
 * Convert HEX to RGB.
 *
 * @since Paperback 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function paperback_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) == 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) == 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}



/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since Paperback 1.0
 */
function paperback_color_customize_control_js() {
	wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20141219', true );
	wp_localize_script( 'color-scheme-control', 'colorScheme', paperback_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'paperback_color_customize_control_js' );

