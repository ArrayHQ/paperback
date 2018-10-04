<?php
/**
 * @package Paperback
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post full-post' ); ?>>

		<?php
		// Featured image/video for archive and search
		if ( ! is_single() ) { ?>

			<!-- Grab the video -->
			<?php if ( get_post_meta( $post->ID, 'array-video', true ) ) { ?>
				<div class="featured-video">
					<?php echo get_post_meta( $post->ID, 'array-video', true ) ?>
				</div>
			<?php } else if ( has_post_thumbnail() ) {

				if ( is_single() ) { ?>
					<div class="featured-image"><?php the_post_thumbnail( 'paperback-full-width' ); ?></div>
				<?php } else { ?>
					<a class="featured-image" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'paperback-full-width' ); ?></a>
				<?php }
			} ?>

			<header class="entry-header">
				<?php if ( has_category() ) { ?>
					<div class="entry-cats">
						<?php
							// Limit the number of categories output on the grid to 5 to prevent overflow
							$i = 0;
							foreach( ( get_the_category() ) as $cat ) {
								echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
								if ( ++$i == 5 ) {
									break;
								}
							}
						?>
					</div>
				<?php }

				if ( is_single() ) { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } else { ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php } ?>

				<div class="byline">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Posts by ', 'paperback' ); ?> <?php esc_attr( get_the_author() ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'paperback_author_bio_avatar', 44 ) ); ?>
					</a>
					<?php the_author_posts_link();

					esc_html_e( ' on ', 'paperback' );

					echo get_the_date(); ?>
				</div>
			</header><!-- .entry-header -->

	<?php } ?>

	<div class="entry-content">
		<?php
		// Featured video for single pages
		if ( is_single() && get_post_meta( $post->ID, 'array-video', true ) ) { ?>
			<div class="featured-video">
				<?php echo get_post_meta( $post->ID, 'array-video', true ) ?>
			</div>
		<?php }

		the_content( esc_html__( 'Read More', 'paperback' ) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'paperback' ),
			'after'  => '</div>',
		) ); 
		
		edit_post_link( esc_html__( 'Edit This', 'paperback' ), '<p>', '</p>');
		?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'template-parts/content-meta' ); ?>

</article><!-- #post-## -->
