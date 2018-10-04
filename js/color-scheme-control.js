/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'paperback-color-scheme' ),
		colorSchemeKeys = [
			'top_nav_background_color',
			'top_nav_text_color',
			'header_background_color',
			'header_text_color',
			'accent_color',
			'footer_background_color',
			'footer_text_color',
		],
		colorSettings = [
			'top_nav_background_color',
			'top_nav_text_color',
			'header_background_color',
			'header_text_color',
			'accent_color',
			'footer_background_color',
			'footer_text_color',
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					// Update Top Navigation Background Color
					api( 'top_nav_background_color' ).set( colorScheme[value].colors[0] );
					api.control( 'top_nav_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[0] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[0] );

					// Update Top Navigation Text Color
					api( 'top_nav_text_color' ).set( colorScheme[value].colors[1] );
					api.control( 'top_nav_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[1] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[1] );

					// Update Header Background Color
					api( 'header_background_color' ).set( colorScheme[value].colors[2] );
					api.control( 'header_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[2] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[2] );

					// Update Header Text Color
					api( 'header_text_color' ).set( colorScheme[value].colors[3] );
					api.control( 'header_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					// Update Accent Color
					api( 'accent_color' ).set( colorScheme[value].colors[4] );
					api.control( 'accent_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[4] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[4] );

					// Update Footer Background Color
					api( 'footer_background_color' ).set( colorScheme[value].colors[5] );
					api.control( 'footer_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[5] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[5] );

					// Update Footer Text Color
					api( 'footer_text_color' ).set( colorScheme[value].colors[6] );
					api.control( 'footer_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[6] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[6] );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(), css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( setting )();
		});

		// Add additional colors.
		colors.footer_text_color_secondary = Color( colors.footer_text_color ).toCSS( 'rgba', 0.8 );
		colors.footer_border_color = Color( colors.footer_text_color ).toCSS( 'rgba', 0.3 );

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
