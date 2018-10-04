<?php

if( ! class_exists( 'Array_Typekit_Library' ) ) :
/**
 * The Array Typekit class.
 *
 * Loads the Typekit fonts saved in the options table during theme license activation.
 */
class Array_Typekit_Library {

	// Holds the current theme slug
	protected $theme_slug = null;

	public function __construct() {

		$this->theme_slug = get_template();

		add_action( 'customize_register', array( $this, 'customize_register' ) );

		add_action( 'wp_head', array( $this, 'load_typekit' ), 0 );
	}


	/**
	 * Enqueues Typekit fonts.
	 */
	public function load_typekit() {

		// Check for a saved Typekit Kit ID
		$id = $this->get_typekit_id();

		// If we have a kit ID and a valid license, load Typekit
		if ( '' !== $id
		&& 'valid' == get_option( $this->theme_slug . '_license_key_status' )
		&& '' == get_option( $this->theme_slug . '_disable_typekit', '' ) ) : ?>
	<script type="text/javascript" src="//use.typekit.net/<?php echo $this->sanitize_typekit_id( $id ); ?>.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		<?php endif;
	}


	/**
	 * Returns the Typekit ID if there is one.
	 *
	 * @return string
	 */
	public function get_typekit_id() {

		return get_option( 'array_typekit_id', '' );
	}


	/**
	 * Makes sure Typekit IDs are [0-9a-z].
	 */
	function sanitize_typekit_id( $id ) {

		return preg_replace( '/[^0-9a-z]+/', '', $id );
	}


	/**
	 * Returns true if the license is valid and active.
	 */
	function active_license() {
		if( 'valid' == get_option( $this->theme_slug . '_license_key_status' ) ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Sanitizes checkbox inputs
	 */
	function sanitize_checkbox( $input ) {
		if( 1 == $input ) {
			return 1;
		} else {
			return '';
		}
	}


	/**
	 * Customizer options
	 */
	function customize_register( $wp_customize ) {

		$wp_customize->add_section( 'typekit', array(
			'title'           =>  esc_html__( 'Typekit', 'paperback' ),
			'priority'        => 1,
		) );

		$wp_customize->add_setting( $this->theme_slug . '_disable_typekit', array(
			'default'           => 0,
			'type'              => 'option',
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'         => 'postMessage',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'disable_typekit', array(
			'type'            => 'checkbox',
			'label'           =>  esc_html__( 'Disable Typekit', 'paperback' ),
			'description'     =>  esc_html__( 'Check to disable the Typekit fonts included with this theme if you would like to use your own fonts.', 'paperback' ),
			'section'         => 'typekit',
			'settings'        => $this->theme_slug . '_disable_typekit',
			'priority'        => 1,
			'active_callback' => array( $this, 'active_license' ),
		) );
	}


}
endif;

$array_typekit_library = new Array_Typekit_Library();