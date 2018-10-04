<?php
/**
 * Specify recommended plugins with TGM activation class
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Paperback
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/admin/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'paperback_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function paperback_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'WPForms Lite',
			'slug'      => 'wpforms-lite',
			'required'  => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'paperback',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
	);

	tgmpa( $plugins, $config );
}

/**
 * Add WPForms sharesale ID
 *
 * If the constant is not already defined, define it not.
 */
if ( ! defined( 'WPFORMS_SHAREASALE_ID' ) ) {
	define( 'WPFORMS_SHAREASALE_ID', '1307854' );
}

/**
 * Filter the WPForms Shareasale ID and ensure that it is persistent.
 */
add_filter( 'wpforms_shareasale_id', 'paperback_wpforms_shareasale_id' );

function paperback_wpforms_shareasale_id( $shareasale_id ) {
	// Check for Shareasale ID
	if ( ! empty( $shareasale_id ) ) {
		return $shareasale_id;
	}

	// Define the default Shareasale ID
	$default_shareasale_id = '1307854';

	// Set default Shareasale ID
	update_option( 'wpforms_shareasale_id', $default_shareasale_id );

	// Return the default Shareasale ID.
	return $default_shareasale_id;
}
