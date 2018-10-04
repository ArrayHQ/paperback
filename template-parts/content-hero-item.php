<?php
/**
 * The template used for displaying hero posts in the header
 *
 * @package Paperback
 */
$image_class = has_post_thumbnail() ? 'with-featured-image hero-post' : 'without-featured-image hero-post';
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( $image_class ); ?>>

		<!-- Get the hero background image -->
		<?php
		// Get header opacity from Appearance > Customize > Header & Footer Image
		$header_opacity = get_theme_mod( 'paperback_hero_opacity', '0.5' );

		$hero_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "paperback-hero" );

		if ( ! empty( $hero_src ) ) { ?>

			<div class="site-header-bg-wrap">
				<div class="header-opacity">
					<div class="header-gradient"></div>
					<div class="site-header-bg background-effect" style="background-image: url(<?php echo esc_url( $hero_src[0] ); ?>); opacity: <?php echo esc_attr( $header_opacity ); ?>;"></div>
				</div>
			</div><!-- .site-header-bg-wrap -->

		<?php } ?>

		<div class="container hero-container">
			<?php if( class_exists( 'Easy_Digital_Downloads' ) && 'download' == get_post_type() ) {
					paperback_list_edd_terms( 'hero' );
				} else {
					echo paperback_list_cats( 'hero' );
				}
			?>

			<!-- Hero title -->
			<div class="hero-text">
				<?php if ( is_single() ) { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } else { ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php }

				if ( has_excerpt() ) {
					// Removing share links from excerpt
					if ( function_exists( 'sharing_display' ) ) {
						remove_filter( 'the_content', 'sharing_display', 19 );
						remove_filter( 'the_excerpt', 'sharing_display', 19 );
					}

					the_excerpt();
				} ?>

				<div class="hero-date">
					<?php
						// Get the post author outside the loop
						global $post;
						$author_id   = $post->post_author;
					?>
					<!-- Create an avatar link -->
					<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" title="<?php esc_attr_e( 'Posts by ', 'paperback' ); ?> <?php esc_attr( get_the_author() ); ?>">
						<?php echo get_avatar( $author_id, apply_filters( 'paperback_author_bio_avatar', 44 ) ); ?>
					</a>
					<!-- Create an author post link -->
					<a href="<?php echo get_author_posts_url( $author_id ); ?>">
						<?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?>
					</a>
					<span class="hero-on-span"><?php esc_html_e( 'on', 'paperback' ); ?></span>
					<span class="hero-date-span"><?php echo get_the_date(); ?></span>
				</div>
			</div><!-- .photo-overlay -->
		</div><!-- .container -->
	</div>
