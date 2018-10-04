<?php
/**
 * The template used for displaying mega menu posts in a grid
 *
 * @package Paperback
 */
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
		<a class="grid-thumb-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<!-- Grab the image -->
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'paperback-mega-thumb' );
			} else { ?>
				<img src="<?php echo get_template_directory_uri(); ?>/images/fallback-thumb.jpg" />
			<?php } ?>
		</a>

		<!-- Post title and categories -->
		<div class="grid-text">
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			<div class="grid-date">
				<span class="date"><?php echo get_the_date(); ?></span>
			</div>
		</div><!-- .grid-text -->
	</div><!-- .post -->
