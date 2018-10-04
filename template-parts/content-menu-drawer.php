<?php
/**
 * This template adds the menu drawer
 *
 * @package Paperback
 * @since Paperback 1.0
 */
?>

<div class="drawer drawer-menu-explore">
	<div class="container">
		<?php if ( has_nav_menu( 'primary' ) ) { ?>
			<nav id="drawer-navigation" class="main-navigation drawer-navigation" role="navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'primary'
				) );?>
			</nav><!-- #site-navigation -->
		<?php } ?>

		<?php if ( has_nav_menu( 'secondary' ) ) { ?>
			<nav id="secondary-navigation" class="main-navigation secondary-navigation" role="navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'secondary'
				) );?>
			</nav><!-- .secondary-navigation -->
		<?php } ?>

		<?php if ( has_nav_menu( 'social' ) ) { ?>
			<nav class="social-navigation" role="navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'social',
					'depth'          => 1,
					'fallback_cb'    => false
				) );?>
			</nav><!-- .footer-navigation -->
		<?php } ?>
	</div><!-- .container -->
</div><!-- .drawer -->