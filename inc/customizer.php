<?php
/**
 * Paperback Theme Customizer
 *
 * Customizer color options can be found in inc/wporg.php.
 *
 * @package Paperback
 */

add_action( 'customize_register', 'paperback_customizer_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}

if ( is_customize_preview() ) :

/**
 * Hero category select
 */
class Paperback_Customize_Category_Control extends WP_Customize_Control {
    private $cats = false;

    public function __construct( $manager, $id, $args = array(), $options = array() ) {
        $this->cats = get_categories( $options );

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content() {

        if( !empty( $this->cats ) ) {
        ?>

            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html__( 'Select a category to populate the hero header.', 'paperback' ); ?></span>
                <select <?php $this->link(); ?>>
                    <?php
                        // Add an empty default option
                        printf( '<option value="0">' . esc_html( 'Disable Featured Header', 'paperback' ) . '</option>' );
                        printf( '<option value="0">--</option>' );

                        foreach ( $this->cats as $cat ) {
                            printf( '<option value="%s" %s>%s</option>', $cat->term_id, selected( $this->value(), $cat->term_id, false ), $cat->name );
                        }
                    ?>
            </select>
            </label>

        <?php }
    }
}
endif;

/**
 * Sanitizes the hero category select
 */
function paperback_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}


/**
 * Sanitize range slider
 */
function paperback_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize gallery select option
 */
function paperback_sanitize_layout_select( $layout ) {

	if ( ! in_array( $layout, array( 'three-column', 'two-column', 'one-column' ) ) ) {
		$layout = 'one-column';
	}
	return $layout;
}


/**
 * Sanitize mega menu select option
 */
function paperback_sanitize_mega_select( $mega_menu ) {

	if ( ! in_array( $mega_menu, array( 'disabled', 'enabled' ) ) ) {
		$mega_menu = 'disabled';
	}
	return $mega_menu;
}


/**
 * Sanitize comment style select option
 */
function paperback_sanitize_comment_select( $comment_style ) {

	if ( ! in_array( $comment_style, array( 'click', 'show' ) ) ) {
		$comment_style = 'click';
	}
	return $comment_style;
}


/**
 * Sanitize text
 */
function paperback_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize textarea output
 */
function paperback_sanitize_textarea( $text ) {
    return esc_textarea( $text );
}


/**
 * Sanitize checkboux
 */
function paperback_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}


function paperback_homepage_full_callback( $control ) {
    if ( $control->manager->get_setting('paperback_layout_style')->value() == 'one-column' ) {
        return true;
    } else {
        return false;
    }
}


function paperback_homepage_grid_callback( $control ) {
    if ( $control->manager->get_setting('paperback_layout_style')->value() == 'two-column' ) {
        return true;
    } else {
        return false;
    }
}


function paperback_excerpt_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('paperback_layout_style')->value();
    $control_id = $control->id;

    if ( $control_id == 'paperback_grid_excerpt_length'  && $excerpt_setting == 'two-column' ) return true;
    if ( $control_id == 'paperback_grid_excerpt_length'  && $excerpt_setting == 'three-column' ) return true;

    return false;
}


function paperback_auto_excerpt_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('paperback_layout_style')->value();
    $control_id = $control->id;

    if ( $excerpt_setting == 'one-column' ) return true;

    return false;
}


/**
 * EDD featured post callback
 */
function paperback_edd_callback( $control ) {
	if ( class_exists( 'Easy_Digital_Downloads' ) && $control->manager->get_setting('paperback_featured_option')->value() == 'download' ) {
		return false;
	} else {
		return true;
	}
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function paperback_customizer_register( $wp_customize ) {


	/**
	 * Add a setting to hide header text if logo is used
	 */
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		$wp_customize->add_setting( 'paperback_logo_text', array(
			'default'           => 1,
			'sanitize_callback' => 'paperback_sanitize_checkbox',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'site_logo_header_text', array(
			'label'    => esc_html__( 'Display Header Text', 'paperback' ),
			'section'  => 'title_tagline',
			'settings' => 'paperback_logo_text',
			'type'     => 'checkbox',
		) ) );
	}


	/**
	 * Logo and header text options - only show if Site Logos is not supported
	 */
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		$wp_customize->add_setting( 'paperback_customizer_logo', array(
			'sanitize_callback' => 'paperback_sanitize_text'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'paperback_customizer_logo', array(
			'label'    => esc_html__( 'Logo Upload', 'paperback' ),
			'section'  => 'title_tagline',
			'settings' => 'paperback_customizer_logo',
		) ) );
	}


	/**
	 * Header Height
	 */
	$wp_customize->add_setting( 'paperback_header_height', array(
		'default'           => '5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'paperback_sanitize_range',
	) );

	$wp_customize->add_control( 'paperback_header_height', array(
		'type'        => 'range',
		'priority'    => 15,
		'section'  => 'title_tagline',
		'label'       => esc_html__( 'Header Height', 'paperback' ),
		'description' => esc_html__( 'Adjust the height of the site identity header.', 'paperback' ),
		'input_attrs' => array(
			'min'   => 2,
			'max'   => 5,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Footer tagline
	 */
	$wp_customize->add_setting( 'paperback_footer_text', array(
		'sanitize_callback' => 'paperback_sanitize_text',
	) );

	$wp_customize->add_control( 'paperback_footer_text', array(
			'label'    => esc_html__( 'Footer Tagline', 'paperback' ),
			'section'  => 'paperback_general_settings',
			'settings' => 'paperback_footer_text',
			'type'     => 'text',
			'priority' => 20
		)
	);


	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_panel( 'paperback_hero_panel', array(
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Theme Options', 'paperback' ),
	) );


	/**
	 * General Settings Panel
	 */
	$wp_customize->add_section( 'paperback_general_settings', array(
		'title'    => esc_html__( 'General Settings', 'paperback' ),
		'priority' => 1,
		'panel'    => 'paperback_hero_panel',
	) );


	/**
	 * Post Layout
	 */
	$wp_customize->add_setting( 'paperback_layout_style', array(
		'default'           => 'one-column',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'paperback_sanitize_layout_select',
	));

	$wp_customize->add_control( 'paperback_layout_style_select', array(
		'settings' => 'paperback_layout_style',
		'label'    => esc_html__( 'Post Layout', 'paperback' ),
		'description' => esc_html__( 'Choose a layout for posts on your homepage and archive pages.', 'paperback' ),
		'section'  => 'paperback_general_settings',
		'type'     => 'select',
		'choices'  => array(
			'one-column'   => esc_html__( '1 column + sidebar', 'paperback' ),
			'two-column'   => esc_html__( '2 column grid + sidebar', 'paperback' ),
			'three-column' => esc_html__( '3 column grid no sidebar', 'paperback' ),
		),
		'priority' => 1
	) );


	/**
	 * Grid excerpt length
	 */
	$wp_customize->add_setting( 'paperback_grid_excerpt_length', array(
		'default'           => '40',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'paperback_sanitize_range',
	) );

	$wp_customize->add_control( 'paperback_grid_excerpt_length', array(
		'type'        => 'number',
		'priority'    => 2,
		'section'     => 'paperback_general_settings',
		'label'       => esc_html__( 'Grid View Excerpt Length', 'paperback' ),
		'description' => esc_html__( 'Change the size of the excerpt on grid views.', 'paperback' ),
		'active_callback'   => 'paperback_excerpt_callback',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),
	) );


	/**
	 * Single column auto excerpt
	 */
	$wp_customize->add_setting( 'paperback_auto_excerpt', array(
		'default'           => 'disabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'paperback_sanitize_mega_select',

	));

	$wp_customize->add_control( 'paperback_auto_excerpt_select', array(
		'settings'    => 'paperback_auto_excerpt',
		'label'       => esc_html__( 'Auto Generate Excerpt', 'paperback' ),
		'description' => esc_html__( 'Auto generate an excerpt for blog posts on the homepage, archive and search.', 'paperback' ),
		'section'     => 'paperback_general_settings',
		'type'        => 'select',
		'active_callback'   => 'paperback_auto_excerpt_callback',
		'choices'  	  => array(
			'disabled' => esc_html__( 'Disabled', 'paperback' ),
			'enabled'  => esc_html__( 'Enabled', 'paperback' ),
		),
		'priority' => 3
	) );


	/**
	 * Category Mega Menu
	 */
	$wp_customize->add_setting( 'paperback_category_menu', array(
		'default'           => 'disabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'paperback_sanitize_mega_select',

	));

	$wp_customize->add_control( 'paperback_category_menu_select', array(
		'settings'    => 'paperback_category_menu',
		'label'       => esc_html__( 'Category Mega Menu', 'paperback' ),
		'description' => esc_html__( 'Replace the main navigation menu with a category mega menu.', 'paperback' ),
		'section'     => 'paperback_general_settings',
		'type'        => 'select',
		'choices'  	  => array(
			'disabled' => esc_html__( 'Disabled', 'paperback' ),
			'enabled'  => esc_html__( 'Enabled', 'paperback' ),
		),
		'priority' => 3
	) );


	/**
	 * Fixed Scroll Bar
	 */
	$wp_customize->add_setting( 'paperback_fixed_bar', array(
		'default'           => 'enabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'paperback_sanitize_mega_select',

	));

	$wp_customize->add_control( 'paperback_fixed_bar_select', array(
		'settings'    => 'paperback_fixed_bar',
		'label'       => esc_html__( 'Fixed Scroll Bar', 'paperback' ),
		'description' => esc_html__( 'Show a fixed scroll bar when scrolling back to the top of your site.', 'paperback' ),
		'section'     => 'paperback_general_settings',
		'type'        => 'select',
		'choices'  	  => array(
			'disabled' => esc_html__( 'Disabled', 'paperback' ),
			'enabled'  => esc_html__( 'Enabled', 'paperback' ),
		),
		'priority' => 5
	) );


	/**
	 * Comment Style
	 */
	$wp_customize->add_setting( 'paperback_comment_style', array(
		'default'           => 'click',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'paperback_sanitize_comment_select',
	));

	$wp_customize->add_control( 'paperback_comment_style_select', array(
		'settings'    => 'paperback_comment_style',
		'label'       => esc_html__( 'Comment Section Style', 'paperback' ),
		'description' => esc_html__( 'Choose to hide the comment section by default or always show the comment section.', 'paperback' ),
		'section'     => 'paperback_general_settings',
		'type'        => 'select',
		'choices'     => array(
			'click' => esc_html__( 'Click to show', 'paperback' ),
			'show'  => esc_html__( 'Always show', 'paperback' ),
		),
		'priority' => 6
	) );


	/**
	 * Homepage Hero Settings Panel
	 */
	$wp_customize->add_section( 'paperback_hero_settings', array(
		'title'    => esc_html__( 'Featured Posts Header', 'paperback' ),
		'priority' => 3,
		'panel'    => 'paperback_hero_panel',
	) );


	/**
	 * Homepage Hero Header
	 */
	$wp_customize->add_setting( 'paperback_hero_header', array(
		'sanitize_callback' => 'paperback_sanitize_integer',
	) );

	$wp_customize->add_control( new Paperback_Customize_Category_Control( $wp_customize, 'paperback_hero_header_select', array(
			'label'           => esc_html__( 'Featured Post Category', 'paperback' ),
			'section'         => 'paperback_hero_settings',
			'settings'        => 'paperback_hero_header',
			'priority'        => 2,
			'active_callback' => 'paperback_edd_callback',
    	) ) );


    	$wp_customize->add_setting( 'paperback_hero_header_exclude', array(
		'default'           => 0,
		'sanitize_callback' => 'paperback_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'paperback_hero_header_exclude', array(
		'label'    => esc_html__( 'Exclude Featured Posts', 'paperback' ),
		'description' => esc_html__( 'Check this box if you only want your featured posts to appear in the header, not the post loop.', 'paperback' ),
		'section'  => 'paperback_hero_settings',
		'settings' => 'paperback_hero_header_exclude',
		'priority' => 3,
		'type'     => 'checkbox',
	) ) );


	/**
	 * Homepage Hero Opacity
	 */
	$wp_customize->add_setting( 'paperback_hero_opacity', array(
		'default'           => '.5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'paperback_sanitize_range',
	) );

	$wp_customize->add_control( 'paperback_hero_opacity', array(
		'type'        => 'range',
		'priority'    => 3,
		'section'     => 'paperback_hero_settings',
		'label'       => esc_html__( 'Featured Post Opacity', 'paperback' ),
		'description' => esc_html__( 'Change the opacity of your hero images.', 'paperback' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => .1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Hero Height
	 */
	$wp_customize->add_setting( 'paperback_hero_height', array(
		'default'           => '26',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'paperback_sanitize_range',
	) );

	$wp_customize->add_control( 'paperback_hero_height', array(
		'type'        => 'range',
		'priority'    => 4,
		'section'     => 'paperback_hero_settings',
		'label'       => esc_html__( 'Featured Image Height', 'paperback' ),
		'description' => esc_html__( 'Adjust the height of your header on single post pages.', 'paperback' ),
		'input_attrs' => array(
			'min'   => 4,
			'max'   => 26,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Custom CSS Output
	 */
	$wp_customize->add_setting( 'paperback_custom_css',
		array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'paperback_sanitize_textarea',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control( 'paperback_custom_css_control', array(
			'label'     => esc_html__( 'Custom CSS', 'paperback' ),
			'section'   => 'colors',
			'settings'  => 'paperback_custom_css',
			'type'      => 'textarea',
			'description' => esc_html__( 'Use this setting to add minor CSS edits. Further CSS edits should be made in a child theme to ensure your edits are safely stored.', 'paperback' ),
			'priority'  => 30
		)
	);

}


/**
 * Add Customizer CSS To Header
 */
function paperback_custom_css() {
	$css_header_height = get_theme_mod( 'paperback_header_height' );
	$css_hero_height   = get_theme_mod( 'paperback_hero_height' );
	$css_custom_output = get_theme_mod( 'paperback_custom_css' );
	$site_logo_text    = get_theme_mod( 'paperback_logo_text', 1 );

	if ( $css_header_height || $css_hero_height || $css_custom_output || $site_logo_text ) {
	?>
	<style type="text/css">
		<?php if ( $css_header_height ) { ?>
			.site-identity {
				padding: <?php echo $css_header_height; ?>% 0;
			}
		<?php } ?>

		<?php if ( $css_hero_height ) { ?>
			.single .hero-posts .with-featured-image {
				padding-top: <?php echo $css_hero_height; ?>%;
			}
		<?php } ?>

		<?php if ( $css_custom_output ) {
			echo get_theme_mod( 'paperback_custom_css' );
		} ?>

		<?php if ( ! function_exists( 'jetpack_the_site_logo' ) && $site_logo_text == 0 ) { ?>
			.titles-wrap {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php } ?>
	</style>
<?php
} }
add_action( 'wp_head', 'paperback_custom_css' );


/**
 * Replaces the footer tagline text
 */
function paperback_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'paperback_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'paperback' ), 'Paperback', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'paperback_footer_text', 'paperback_filter_footer_text' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function paperback_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'paperback_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function paperback_customize_preview_js() {
	wp_enqueue_script( 'paperback_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150735', true );
}
add_action( 'customize_preview_init', 'paperback_customize_preview_js' );
