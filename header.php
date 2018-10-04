<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Paperback
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="masthead" class="site-header" role="banner">

		<div class="top-navigation">
			<div class="container">

				<nav id="secondary-navigation" class="main-navigation secondary-navigation" role="navigation">
					<?php if ( has_nav_menu( 'secondary' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'secondary'
						) );
					} ?>
				</nav><!-- .secondary-navigation -->

				<div class="top-navigation-right">
					<?php if ( has_nav_menu( 'social' ) ) { ?>
						<nav class="social-navigation" role="navigation">
							<?php wp_nav_menu( array(
								'theme_location' => 'social',
								'depth'          => 1,
								'fallback_cb'    => false
							) );?>
						</nav><!-- .social-navigation -->
					<?php } ?>

					<div class="overlay-toggle drawer-toggle drawer-open-toggle">
						<span class="toggle-visible">
							<i class="fa fa-search"></i>
							<?php esc_html_e( 'Explore', 'paperback' ); ?>
						</span>
						<span>
							<i class="fa fa-times"></i>
							<?php esc_html_e( 'Close', 'paperback' ); ?>
						</span>
					</div><!-- .overlay-toggle-->

					<div class="overlay-toggle drawer-toggle drawer-menu-toggle">
						<span class="toggle-visible">
							<i class="fa fa-bars"></i>
							<?php esc_html_e( 'Menu', 'paperback' ); ?>
						</span>
						<span>
							<i class="fa fa-times"></i>
							<?php esc_html_e( 'Close', 'paperback' ); ?>
						</span>
					</div><!-- .overlay-toggle-->
				</div><!-- .top-navigation-right -->
			</div><!-- .container -->
		</div><!-- .top-navigation -->

		<div class="drawer-wrap">
			<?php
				// Get the explore drawer (template-parts/content-drawer.php)
				get_template_part( 'template-parts/content-drawer' );

				// Get the explore drawer (template-parts/content-menu-drawer.php)
				get_template_part( 'template-parts/content-menu-drawer' );
			?>
		</div><!-- .drawer-wrap -->

		<div class="site-identity clear">
			<div class="container">
				<!-- Site title and logo -->
				<?php
					paperback_title_logo();

					$mega_menu = get_theme_mod( 'paperback_category_menu', 'disabled' );
				?>

				<!-- Main navigation -->
				<nav id="site-navigation" class="main-navigation <?php echo esc_attr( $mega_menu ); ?>" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'primary'
					) );?>
				</nav><!-- .main-navigation -->

			</div><!-- .container -->
		</div><!-- .site-identity-->

		<?php
		if ( 'enabled' == $mega_menu ) { ?>
			<div class="featured-posts-wrap clear">
				<div class="featured-posts clear">
					<div class="featured-header">
						<span class="featured-header-category"></span>
						<span class="featured-header-close"><i class="fa fa-times"></i> <?php esc_html_e( 'Close', 'paperback' ); ?></span>
					</div>

					<div class="post-container clear"></div>
				</div>
			</div>
		<?php } // If mega menu enabled ?>
</header><!-- .site-header -->

<?php
	// Get the fixed nav bar for EDD
	if ( function_exists( 'EDD' ) && get_option( 'paperback_hero_header_edd' ) ) {
		get_template_part( 'inc/edd/content-fixed-bar-edd' );
	} else {
		// Get the standard fixed bar
		get_template_part( 'template-parts/content-fixed-bar' );
	}

	// Get the hero header for EDD
	if ( function_exists( 'EDD' ) && get_option( 'paperback_featured_option', 'post' ) == 'download' ) {
		get_template_part( 'inc/edd/content-hero-header-edd' );
	} else {
		// Get the standard hero header
		get_template_part( 'template-parts/content-hero-header' );
	}
?>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content">
