<?php
/**
 * The main template file.
 *
 * @package Paperback
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main blocks-page" role="main">
			<?php if ( have_posts() ) : ?>

				<div id="post-wrapper">
					<div class="grid-wrapper">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();

							if ( 'one-column' === get_option( 'paperback_layout_style', 'one-column' ) ) {
								get_template_part( 'template-parts/content' );
							} else {
								get_template_part( 'template-parts/content-grid-item' );
							}

						endwhile;
					?>
					</div><!-- .grid-wrapper -->

					<?php paperback_page_navs(); ?>
				</div><!-- #post-wrapper -->

				<?php else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
