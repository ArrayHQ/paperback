<?php
/**
 * Template Name: Downloads
 *
 * @package Paperback
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

					<?php
						if ( get_query_var( 'paged' ) ) :
							$paged = get_query_var( 'paged' );
						elseif ( get_query_var( 'page' ) ) :
							$paged = get_query_var( 'page' );
						else :
							$paged = 1;
						endif;

						$args = array(
							'post_type'      => 'download',
							'posts_per_page' => apply_filters( 'paperback_download_num', 12 ),
							'paged'          => $paged,
						);
						$download_query = new WP_Query ( $args );

						if ( $download_query -> have_posts() ) :
					?>

					<div id="post-wrapper">
						<div id="grid-wrapper" class="grid-wrapper">

							<?php while ( $download_query->have_posts() ) : $download_query->the_post();

								if ( 'one-column' === get_option( 'paperback_layout_style', 'one-column' ) ) {
									get_template_part( 'template-parts/content' );
								} else {
									get_template_part( 'template-parts/content-grid-item' );
								}

							endwhile; ?>
						</div><!-- .grid-wrapper -->

						<?php paperback_page_navs(); ?>
					</div><!-- #post-wrapper -->

					<?php else :

					get_template_part( 'template-parts/content-none' );

				endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
