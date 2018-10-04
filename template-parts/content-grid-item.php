<?php
/**
 * The template used for displaying posts in a grid
 *
 * @package Paperback
 */
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'grid-thumb post' ); ?>>
		<?php if ( has_post_thumbnail() ) { ?>
			<a class="grid-thumb-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<!-- Grab the image -->
				<?php the_post_thumbnail( 'paperback-grid-thumb' ); ?>
			</a>
		<?php } ?>

		<!-- Post title and categories -->
		<div class="grid-text">
			<?php if( class_exists( 'Easy_Digital_Downloads' ) && 'download' == get_post_type() ) {
					paperback_list_edd_terms( 'grid' );
				} else {
					echo paperback_list_cats( 'grid' );
				}
			?>

			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			<?php
				$excerpt_length = get_theme_mod( 'paperback_grid_excerpt_length', '40' );
				if ( $excerpt_length > 0 ) {
			?>
				<p><?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); ?></p>
			<?php } ?>

			<div class="grid-date">
				<?php the_author_posts_link(); ?> <span>/</span>
				<span class="date"><?php echo get_the_date(); ?></span>
			</div>
		</div><!-- .grid-text -->
	</div><!-- .post -->
