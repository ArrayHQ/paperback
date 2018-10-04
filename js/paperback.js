(function($) {

	$(document).ready(function() {

		// Setup variables
		var body              = $(document.body);
		var fpGrid            = $('.featured-posts .grid-thumb');
		var drawerOpenToggle  = $('.drawer-open-toggle');
		var drawerMenuToggle  = $('.drawer-menu-toggle');
		var drawerMenuExplore = $('.drawer-menu-explore');
		var drawerExplore     = $('.drawer-explore');
		var drawerOpenDrawer  = $('.drawer-open .drawer');


		function equalHeight() {
            // Equalize column heights
            $('.grid-thumb').matchHeight();
        }
        equalHeight();


        function fitVids() {
            // Fitvids
	        $('.post iframe').not('.fitvid iframe').wrap('<div class="fitvid"/>');
			$('.fitvid').fitVids();
        }
        fitVids();


		// Comments toggle
		$('.comments-toggle').click(function(e) {
			$('#comments,#disqus_thread').fadeToggle(400);
			$('.comments-toggle span').toggle();
			return false;
		});


		// Scroll to comment on direct link
		if ( document.location.href.indexOf('#comment') > -1 ) {
			// Show comments on click
			$('#comments').show();
			$('.comments-toggle span').toggle();

			// Grab the comment ID from the url
			var commentID = window.location.hash.substr(1);

			// Scroll to comment ID
			$('html,body').animate({
		    scrollTop: $('#'+commentID).offset().top - 25
		}, 600);
		}


		// Explore drawer
		drawerOpenToggle.click(function(e) {
			// Hide the menu drawer if open
			drawerMenuExplore.removeClass('show-drawer');

			// Reset the toggle button
			drawerMenuToggle.removeClass('drawer-toggle-switch');

			// Show the explore drawer
			drawerExplore.toggleClass('show-drawer');

			// Add a class to the body
			body.toggleClass('drawer-open');

			// Toggle the button state
			$(this).toggleClass('drawer-toggle-switch');

			return false;
		});


		// Mobile menu drawer
		drawerMenuToggle.click(function(e) {
			// Hide the explore drawer if open
			drawerExplore.removeClass('show-drawer');

			// Reset the toggle button
			drawerOpenToggle.removeClass('drawer-toggle-switch');

			// Show the explore drawer
			drawerMenuExplore.toggleClass('show-drawer');

			// Add a class to the body
			body.toggleClass('drawer-open');

			// Toggle the button state
			drawerMenuToggle.toggleClass('drawer-toggle-switch');

			return false;
		});


		// When drawer is open, allow click on body to close
		$('html').click(function() {
			drawerOpenDrawer.slideUp(200);
			$('body.drawer-open').removeClass('drawer-open');
			$('.drawer').removeClass('show-drawer');
			$('.drawer-toggle').removeClass('drawer-toggle-switch');
		});


		// Escape key closes drawer
		$(document).keyup(function(e) {
		    if (e.keyCode == 27) {
			// Hide any drawers that are open
			drawerOpenDrawer.slideUp(200);
					$('body.drawer-open').removeClass('drawer-open');
					$('.drawer-toggle').removeClass('drawer-toggle-switch');
					$('.drawer').removeClass('show-drawer');

					// Hide featured post drawer
					$('.featured-posts .grid-thumb').removeClass('fadeInUp').hide();
					$('.featured-posts').removeClass('show');
					$('#site-navigation .current-menu-item').removeClass('current-menu-item');
					$('.current-menu-item-original').addClass('current-menu-item');
		    }
		});


		// Allow clicking in the drawer when it's open
		$('.drawer').click(function(event){
		    event.stopPropagation();
		});


		// Scroll to explore panel when clicked on fixed nav bar
		$('.mini-bar .drawer-open-toggle').click(function(e) {
			$('html,body').animate({
			    scrollTop: 0
			}, 400);

			$('.drawer-open-toggle').toggleClass('drawer-toggle-switch');
			return false;
		});


		// Headroom fixed nav bar
		if ( ( paperback_js_vars.load_fixed ) == 'true') {
			$('.mini-bar').headroom({
			    offset : 200,
			    tolerance : 10
			});
		}


		// Back to top
		$('.back-to-top a').click(function(e) {
			e.preventDefault();

			$('html,body').animate({
			    scrollTop: 0
			}, 700);

			return false;
		} );


		// Open mobile menu via fixed menu button
		$('.back-to-menu a').click(function(e) {
			e.preventDefault();

			$('html,body').animate({
		    scrollTop: 0
		}, 700);

		$('.drawer-menu-toggle').trigger('click');

			return false;
		} );


		// Initialize responsive slides
		var $slides = $('.hero-posts');
		$slides.responsiveSlides({
		    auto: false,
		    speed: 200,
		    nav: true,
		    navContainer: ".pager-navs",
		    manualControls: '#hero-pager'
		});


		// Add touch support to responsive slides
		$('.home .hero-wrapper .rslides').each(function() {
		    $(this).swipe({
			swipeLeft: function() {
			    $(this).parent().find('.rslides_nav.prev').click();
			},
			swipeRight: function() {
			    $(this).parent().find('.rslides_nav.next').click();
			}
		    });
		});


		// Remove fancy link underline from linked images
		$('.entry-content img').each(function() {
			$(this).parent().addClass('no-underline');
		});


		// Standardize drop menu types
		$('.main-navigation .children').addClass('sub-menu');
		$('.main-navigation .page_item_has_children').addClass('menu-item-has-children');


		// Navigation
		$(window).on("resize load", function() {

			var current_width = $(window).width();
			var post_navs = $('.single .post-navigation');

			// If width is below ipad landscape
			if (current_width > 1024) {
				// Explore drawer
				drawerOpenToggle.click(function(e) {
					$('#big-search').focus();
					return false;
				});
			}

		    // If width is below iPad size
		    if (current_width < 769) {

				// Move the post navs above the sidebar
				$(post_navs).insertAfter('#comments');

		    } else {

				// Reset drawers on resize
				$('.site-identity .toggle-sub').remove();

				// Return the post navs
				$(post_navs).insertAfter('#page');

				// Adjust column height on resize
				equalHeight();
		    }
		});


		/**
		 * Mobile menu functionality
		 */

		// Append a clickable icon to mobile drop menus
		var item = $('<button class="toggle-sub" aria-expanded="false"><i class="fa fa-plus-square"></i></button>');

		// Append clickable icon for mobile drop menu
		if ($('.drawer .menu-item-has-children .toggle-sub').length == 0) {
			$('.drawer .menu-item-has-children,.drawer .page_item_has_children').append(item);
		}

		// Show sub menu when toggle is clicked
		$('.drawer .menu-item-has-children .toggle-sub').click(function(e) {
			$(this).each(function() {
				e.preventDefault();

				// Change aria expanded value
				$(this).attr('aria-expanded', ($(this).attr('aria-expanded')=='false') ? 'true':'false');

				// Open the drop menu
				$(this).closest('.menu-item-has-children').toggleClass('drop-open');
				$(this).prev('.sub-menu').toggleClass('drop-active');

				// Change the toggle icon
				$(this).find('i').toggleClass('fa-plus-square').toggleClass('fa-minus-square');
			});
		});


		// Fade in the featured posts as they load
		function fade_images() {
			$('.featured-posts .post').each(function(i) {
				var row = $(this);
				setTimeout(function() {
					row.addClass('fadeInUp');
				}, 30*i)
			});
		}


		// Fade out the featured post container while loading
		$('.site-identity .main-navigation a').click(function(e) {
			$('.post-container').addClass('post-loading');
		});

		// Fetch ajax posts for category menu
		var megaNavLink = $('#site-navigation a');

		megaNavLink.click(function (event) {

			var catLink = $(this).attr('data-object-id');

			if (typeof catLink !== typeof undefined && catLink !== false) {

				event.preventDefault();

				var id = $(this).attr('data-object-id');

				var container = $('.post-container');

				var catHeader = $( '.featured-header-category' );

				var data = {
					action: 'paperback_category',
					id: id
				}

				$.ajax({
					data: data,
					type: "POST",
					dataType: "json",
					url: paperback_js_vars.ajaxurl,
					success: function(response) {
						container.html(response.html);
						catHeader.html(response.term_html);
						$('.post-container').removeClass('post-loading');

						// Reset the post container if empty
						$('.featured-posts').removeClass('hide');
						if ($('.show .post-container').is(':empty')){
							$('.featured-posts').addClass('hide');
						}

						fade_images();
					},
					error: function(response) {
						container.html(response.html);
					}
				});

				$(this).parent().siblings().removeClass('current-menu-item');
				$(this).parent().addClass('current-menu-item');

				// Hide the sub menu when clicking drop menu links
				$('.sub-menu').addClass('hide-sub');

				// Show the featured posts
				$('.featured-posts').addClass('show');

				container.show();
			}
		});

		// Remove the hide-sub class from the drop menu
		$('.menu-item-has-children').on('mouseover', function () {
		    $('.sub-menu').removeClass('hide-sub');
		});

		// Close the mega menu
		$('.featured-header-close').click(function(e) {
			$('.featured-posts .grid-thumb').removeClass('fadeInUp').hide();
			$('.featured-posts').removeClass('show');
			$('#site-navigation .current-menu-item').removeClass('current-menu-item');
			$('.current-menu-item-original').addClass('current-menu-item');
			return false;
		});


		$( document.body ).on( "post-load", function () {
			var $container = $('.grid-wrapper');
			var $newItems = $('.new-infinite-posts').not('.is--replaced');
			var $elements = $newItems.find('.post');

			// Remove the empty elements that break the grid
			$('.new-infinite-posts,.infinite-loader').remove();

			// Append IS posts
			$container.append($elements);

			fitVids();
		});

	});

})(jQuery);
