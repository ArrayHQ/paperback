/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Live-update changed settings in real time in the Customizer preview
	var $style = $( '#paperback-color-scheme-css' ),
		api = wp.customize;

	if ( ! $style.length ) {
		$style = $( 'head' ).append( '<style type="text/css" id="paperback-color-scheme-css" />' )
		                    .find( '#paperback-color-scheme-css' );
	}

	// Color Scheme CSS
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			$style.html( css );
		} );
	} );

	// Site title and description
	wp.customize('blogname',function(value){
		value.bind(function(to){
			$('.site-title').text(to);
		});
	});


	wp.customize('blogdescription',function(value){
		value.bind(function(to){
			$('.site-description').text(to);
		});
	});


	wp.customize('paperback_accent_color',function(value){
		value.bind(function(to){
			$('.entry-content a').css('border-color',to);

			$('.hero-cats a,.page-numbers.current,.page-numbers:hover,.drawer .tax-widget a:hover,#page #infinite-handle button:hover').css('background-color',to);
		});
	});


	wp.customize('paperback_button_color',function(value){
		value.bind(function(to){
			$('button,input[type="button"],input[type="reset"],input[type="submit"],.button,.comment-navigation a').css('background-color',to);
		});
	});


	wp.customize('paperback_footer_text',function(value){
		value.bind(function(to){
			$('.site-info').text(to);
		});
	});

	// Hero background opacity
	wp.customize( 'paperback_hero_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.hero-post .background-effect' ).css( 'opacity', to );
		} );
	} );


	// Header height
	wp.customize( 'paperback_header_height', function( value ) {
		value.bind( function( to ) {
			$( '.site-identity' ).css( 'padding', to + '% 0' );
		} );
	} );


	// Hero height
	wp.customize( 'paperback_hero_height', function( value ) {
		value.bind( function( to ) {
			$( '.single .hero-posts .hero-post' ).css( 'padding-top', to + '%' );
		} );
	} );


	// Footer background image opacity
	wp.customize( 'paperback_footer_image_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer .background-effect' ).css( 'opacity', to );
		} );
	} );

})(jQuery);
