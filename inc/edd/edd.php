<?php
/**
 * Easy Digital Downloads functions
 *
 * @package Paperback
 */

/**
 * Add comment support to downloads
 */
function paperback_modify_edd_download_supports( $supports ) {
	return array_merge( $supports, array( 'comments' ) );
}
add_filter( 'edd_download_supports', 'paperback_modify_edd_download_supports' );


/**
 * Output a list of EDD's terms (with links) from the 'download_category' taxonomy
 */
function paperback_list_edd_terms( $type ='grid' ) {
	global $post;

	// Get the download categories
	$terms = get_the_terms( $post->ID, 'download_category' );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		// Output the list of download categories
		echo '<div class=" '. $type . '-cats">';
			foreach( ( $terms ) as $term ) {
				echo '<a href="' . esc_attr( get_term_link( $term, 'download_category' ) ) . '">' . $term->name . '</a>';
				if ( ++$i == 3 ) {
					break;
				}
			}
		echo '</div>';
	}
}


/**
 * EDD category select
 */
function paperback_edd_cats_select() {

	$results = array(
		'' => esc_html__( 'Disable Featured Header', 'paperback' )
	);

	$edd_cats = get_terms( 'download_category', array( 'hide_empty' => false ) );

	if ( ! empty( $edd_cats ) && ! is_wp_error( $edd_cats ) ) {
		foreach( $edd_cats as $key => $value ) {
			$results[$value->slug] = $value->name;
		}
	}
	return $results;
}


/**
 * Sanitizes the EDD category select
 */
function paperback_sanitize_edd_category( $input ) {
	$args = array(
		'hide_empty' => false,
		'slug'       => $input
	);
	$valid = get_terms( 'download_category', $args );

	if( ! empty( $valid ) && ! is_wp_error( $valid ) ) {
		return $input;
	} else {
		return '';
	}
}


/**
 * Sanitize option for Menu Menu Content dropdown
 */
function paperback_featured_option_select( $edd_select ) {

	if ( ! in_array( $edd_select, array( 'post', 'download' ) ) ) {
		$edd_select = 'post';
	}
	return $edd_select;
}

/**
 * Callback to show download categories in featured header
 */
function paperback_post_download_callback( $control ) {
    if ( $control->manager->get_setting('paperback_featured_option')->value() === 'download' ) {
        return true;
    } else {
        return false;
    }
}


/**
 * Callback to show download categories in mega menu
 */
function paperback_post_download_mega_callback( $control ) {
    if ( $control->manager->get_setting('paperback_category_menu')->value() === 'enabled' ) {
        return true;
    } else {
        return false;
    }
}


/**
 * EDD related customizer settings
 *
 * @param WP_Customize_Manager $wp_customize
 */
function paperback_customizer_edd_register( $wp_customize ) {

	/**
	 * EDD Download/Post Select
	 */
	$wp_customize->add_setting( 'paperback_featured_option', array(
		'default'           => 'posts',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'paperback_featured_option_select',
	));

	$wp_customize->add_control( 'paperback_featured_option_select', array(
		'settings'    => 'paperback_featured_option',
		'label'       => esc_html__( 'Featured Post Content', 'paperback' ),
		'description' => sprintf( esc_html__( 'Do you want to show standard posts or EDD %s in the Featured Post Header?', 'paperback' ), edd_get_label_plural() ),
		'section'     => 'paperback_hero_settings',
		'type'        => 'select',
		'choices'  => array(
			'post'     => esc_html__( 'Posts', 'paperback' ),
			'download' => edd_get_label_plural(),
		),
		'priority' => 1
	) );

	/**
	 * EDD Featured Category Select
	 */
	$wp_customize->add_setting( 'paperback_hero_header_edd', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'paperback_sanitize_edd_category',
	) );

	$wp_customize->add_control( 'paperback_edd_category_select', array(
		'settings'          => 'paperback_hero_header_edd',
		'label'             => esc_html__( 'Featured Download Category', 'paperback' ),
		'description'       => esc_html__( 'Select a category to populate the hero header.' ),
		'section'           => 'paperback_hero_settings',
		'type'              => 'select',
		'active_callback' 	=> 'paperback_post_download_callback',
		'choices'           => paperback_edd_cats_select(),
		'priority'          => 1,
	) );

	/**
	 * EDD Mega Download/Post Select
	 */
	$wp_customize->add_setting( 'paperback_category_menu_edd', array(
		'default'           => 'posts',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'paperback_featured_option_select',
	));

	$wp_customize->add_control( 'paperback_category_menu_edd_select', array(
		'settings'        => 'paperback_category_menu_edd',
		'label'           => esc_html__( 'Mega Menu Content', 'paperback' ),
		'description'     => sprintf( esc_html__( 'Do you want to show standard posts or EDD %s in the Category Mega Menu?', 'paperback' ), edd_get_label_plural() ),
		'section'         => 'paperback_general_settings',
		'type'            => 'select',
		'active_callback' => 'paperback_post_download_mega_callback',
		'choices'         => array(
			'post'     => esc_html__( 'Posts', 'paperback' ),
			'download' => edd_get_label_plural(),
		),
		'priority' => 4
	) );

}
add_action( 'customize_register', 'paperback_customizer_edd_register' );