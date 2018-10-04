<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Paperback
 */

// Get the post tags
$post_tags = get_the_tags();

if ( class_exists( 'Easy_Digital_Downloads' ) ) {
    $download_tags = get_the_term_list( get_the_ID(), 'download_tag', '', _x(', ', '', 'paperback' ), '' );
    $download_cats = get_the_term_list( get_the_ID(), 'download_category', '', _x(', ', '', 'paperback' ), '' );
} else {
    $download_tags = '';
    $download_cats = '';
}
?>

	<?php if ( is_single() && ( has_category() || ! empty( $post_tags ) || ! empty( $download_tags ) || ! empty( $download_cats ) ) ) { ?>
		<div class="entry-meta">
			<ul class="meta-list">

				<!-- Categories -->
				<?php if ( has_category() || ! empty( $download_cats ) ) { ?>

					<li class="meta-cat">
						<span><?php _e( 'Posted in:', 'paperback' ); ?></span>

						<?php
						// Get the EDD categories
						if ( 'download' == get_post_type() && $download_cats ) {
							echo $download_cats;
						} else {
							// Get the standard post categories
							the_category( ', ' );
						}
						?>
					</li>

				<?php } ?>

				<!-- Tags -->
				<?php if ( $post_tags || ! empty( $download_tags ) ) { ?>

					<li class="meta-tag">
						<span><?php _e( 'Tagged in:', 'paperback' ); ?></span>

						<?php
						// Get the EDD tags
						if ( 'download' == get_post_type() && $download_tags ) {
							echo $download_tags;
						} else {
							// Get the standard post tags
							the_tags( '' );
						}
						?>
					</li>

				<?php } ?>

			</ul><!-- .meta-list -->
		</div><!-- .entry-meta -->
	<?php } ?>
