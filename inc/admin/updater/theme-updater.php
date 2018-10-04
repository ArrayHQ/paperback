<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'Array_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// The theme version to use in the updater
define( 'paperback_SL_THEME_VERSION', wp_get_theme( 'paperback' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://arraythemes.com', // Site where EDD is hosted
		'item_name'      => 'Paperback WordPress Theme', // Name of theme
		'theme_slug'     => 'paperback', // Theme slug
		'version'        => paperback_SL_THEME_VERSION, // The current version of this theme
		'author'         => 'Array', // The author of this theme
		'download_id'    => '97963', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => esc_html__( 'Getting Started', 'paperback' ),
		'enter-key'                 => esc_html__( 'Enter your theme license key.', 'paperback' ),
		'license-key'               => esc_html__( 'Enter your license key', 'paperback' ),
		'license-action'            => esc_html__( 'License Action', 'paperback' ),
		'deactivate-license'        => esc_html__( 'Deactivate License', 'paperback' ),
		'activate-license'          => esc_html__( 'Activate License', 'paperback' ),
		'save-license'              => esc_html__( 'Save License', 'paperback' ),
		'status-unknown'            => esc_html__( 'License status is unknown.', 'paperback' ),
		'renew'                     => esc_html__( 'Renew?', 'paperback' ),
		'unlimited'                 => esc_html__( 'unlimited', 'paperback' ),
		'license-key-is-active'     => esc_html__( 'Typekit fonts and in-dash theme updates have been enabled. You will receive a notice in your dashboard when a theme update is available.', 'paperback' ),
		'expires%s'                 => esc_html__( 'Your license for Paperback expires %s.', 'paperback' ),
		'%1$s/%2$-sites'            => esc_html__( 'You have %1$s / %2$s sites activated.', 'paperback' ),
		'license-key-expired-%s'    => esc_html__( 'License key expired %s.', 'paperback' ),
		'license-key-expired'       => esc_html__( 'License key has expired.', 'paperback' ),
		'license-keys-do-not-match' => esc_html__( 'License keys do not match.', 'paperback' ),
		'license-is-inactive'       => esc_html__( 'License is inactive.', 'paperback' ),
		'license-key-is-disabled'   => esc_html__( 'License key is disabled.', 'paperback' ),
		'site-is-inactive'          => esc_html__( 'Site is inactive.', 'paperback' ),
		'license-status-unknown'    => esc_html__( 'License status is unknown.', 'paperback' ),
		'update-notice'             => esc_html__( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'paperback' ),
		'update-available'          => esc_html__('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'paperback' )
	)

);