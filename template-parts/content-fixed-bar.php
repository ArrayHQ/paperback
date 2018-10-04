<?php
/**
 * This template adds the fixed bar that shows when a user scrolls up
 *
 * @package Paperback
 * @since Paperback 1.0
 */

if ( 'disabled' === get_theme_mod( 'paperback_fixed_bar', 'enabled' ) ) {
	return;
}

$categories = get_categories();
?>

<div class="mini-bar">
	<?php
	// On single pages, show the next/prev post nav, otherwise show the latest featured post
	if ( is_single() ) { ?>
		<div class="mini-title">
			<!-- Next and previous post links -->
			<?php
				$prevPost = get_previous_post();

				if( $prevPost ) {
					$prevThumbnail = get_the_post_thumbnail( $prevPost->ID, 'paperback-fixed-thumb' );

					echo '<div class="fixed-nav">';

						if ( $prevThumbnail ) {
							echo '<a class="fixed-image" href=" ' . esc_url( get_permalink( $prevPost->ID ) ) . ' "> ' . $prevThumbnail . ' </a>';
						}

						echo '<div class="fixed-post-text">';
							echo '<span>' . esc_html__( 'Next', 'paperback' ) . '</span>';
							previous_post_link( '%link', '%title' );
						echo '</div>';
					echo '</div>';
			} ?>

		</div>
	<?php } else {

		// Get the featured category
		$hero_category = get_theme_mod( 'paperback_hero_header' );

		// If there is no featured category, don't return markup
		if ( $hero_category && $hero_category != '0' ) {

			$fixed_posts_args = array(
				'posts_per_page' => 1,
				'cat'            => $hero_category
			);
			$fixed_posts = new WP_Query( $fixed_posts_args );

			if ( $fixed_posts->have_posts() ) :
				$fixed_posts->the_post(); ?>
				<div class="fixed-nav">
					<!-- Grab the featured post thumbnail -->
					<?php if ( has_post_thumbnail() ) { ?>
						<a class="fixed-image" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'paperback-fixed-thumb' ); ?></a>
					<?php } ?>

					<div class="fixed-post-text">
						<span><?php esc_html_e( 'Featured', 'paperback' ); ?></span>
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</div>
				</div><!-- .fixed-nav -->
			<?php endif;
			wp_reset_query();
		}
	} ?>

	<ul class="mini-menu">
		<?php if ( has_nav_menu( 'secondary' ) ) { ?>
			<li>
				<a class="drawer-open-toggle" href="#">
					<span><i class="fa fa-search"></i> <?php esc_html_e( 'Explore', 'paperback' ); ?></span>
				</a>
			</li>
		<?php } ?>
		<li class="back-to-top">
			<a href="#">
				<span><i class="fa fa-bars"></i> <?php esc_html_e( 'Menu', 'paperback' ); ?></span>
			</a>
		</li>
		<li class="back-to-menu">
			<a href="#">
				<span><i class="fa fa-bars"></i> <?php esc_html_e( 'Menu', 'paperback' ); ?></span>
			</a>
		</li>
	</ul>
</div><!-- .mini-bar-->