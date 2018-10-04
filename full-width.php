<?php
/**
 * Template Name: Full Width
 * Template Post Type: post, page
 *
 * @package Paperback
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				// Move Jetpack share links below author box
				if ( function_exists( 'sharing_display' ) ) {
					remove_filter( 'the_content', 'sharing_display', 19 );
					remove_filter( 'the_excerpt', 'sharing_display', 19 );
				}

				// Page content template
				get_template_part( 'template-parts/content-page' );

				// Comments template
				comments_template();

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
