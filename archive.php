<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Paperback
 */
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main blocks-page" role="main">
			<?php if ( have_posts() ) : ?>
				<header class="entry-header archive-header">
				<?php
					// Grab author profile box
					if ( is_author() ) {
						paperback_author_box();
					} else {
						the_archive_title( '<h1 class="entry-title">', '</h1>' );
						the_archive_description( '<div class="entry-content"><div class="taxonomy-description">', '</div></div>' );
					} ?>

				</header><!-- .entry-header -->

				<div id="post-wrapper">
					<div class="grid-wrapper">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();
							// Move Jetpack share links below author box
							if ( function_exists( 'sharing_display' ) && ! function_exists( 'dsq_comment' ) ) {
								remove_filter( 'the_content', 'sharing_display', 19 );
								remove_filter( 'the_excerpt', 'sharing_display', 19 );
							}

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
