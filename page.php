<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Paperback
 */

get_header();

$comment_style = get_option( 'paperback_comment_style', 'click' );

if ( comments_open() ) {
	$comments_status = 'open';
} else {
	$comments_status = 'closed';
}
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				// Move Jetpack share links below author box
				if ( function_exists( 'sharing_display' ) ) {
					remove_filter( 'the_content', 'sharing_display', 19 );
					remove_filter( 'the_excerpt', 'sharing_display', 19 );
				}

				// Page content template
				get_template_part( 'template-parts/content-page' ); ?>

				<!-- Comment toggle and share buttons -->
				<div class="share-comment <?php echo esc_attr( $comment_style ); ?>">

					<?php if ( function_exists( 'sharing_display' ) ) { ?>
						<div class="share-icons <?php echo esc_attr( $comments_status ); ?>">
							<?php echo sharing_display(); ?>
						</div>
					<?php } ?>

					<?php if ( comments_open() ) { ?>
						<a class="comments-toggle button" href="#">
							<span><i class="fa fa-comments"></i>
								<?php if ( '0' != get_comments_number() ) {
									esc_html_e( 'Show comments', 'paperback' );
								} else {
									esc_html_e( 'Leave a comment', 'paperback' );
								} ?>
							</span>
							<span><i class="fa fa-times"></i> <?php esc_html_e( 'Hide comments', 'paperback' ); ?></span>
						</a>
					<?php } ?>
				</div>

				<?php // Comments template
				comments_template();

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar();

get_footer(); ?>
