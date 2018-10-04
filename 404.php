<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Paperback
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="entry-header archive-header">
				<h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'paperback' ); ?></h1>

				<div class="entry-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Please use the search box or the sitemap to locate the content you were looking for.', 'paperback' ); ?></p>

					<?php get_search_form(); ?>

					<div class="archive-box">
						<h4><?php esc_html_e( 'Sitemap', 'paperback' ); ?></h4>
						<ul>
							<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
						</ul>
					</div>
				</div><!-- .entry-content -->
			</header><!-- .entry-header -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar();

get_footer(); ?>
