<?php
/**
 * The template displays the hero header for EDD downloads
 *
 * @package Paperback
 */
?>

<?php
	// Get the featured category
	$hero_category = get_option( 'paperback_hero_header_edd' );

	// If there is no featured category, don't return markup
	if ( is_front_page() && $hero_category && $hero_category != '0' ) {

		$hero_posts_args = array(
			'post_type' => 'download',
			'posts_per_page' => 4,
			'tax_query' => array(
				array(
					'taxonomy' => 'download_category',
					'field' => 'slug',
					'terms' => array( $hero_category ),
				),
			),
		);
		$hero_posts = new WP_Query( $hero_posts_args );

		// Count the number of hero posts
		$hero_count = $hero_posts->found_posts;

		// Apply a class for conditional styling
		if ( $hero_count > 1 ) {
			$hero_count_class = 'multi-hero';
		} else {
			$hero_count_class = 'single-hero';
		}

		if ( $hero_posts -> have_posts() ) :
	?>
		<div class="hero-wrapper <?php echo $hero_count_class; ?>">

			<div class="hero-posts">
				<?php while( $hero_posts->have_posts() ) : $hero_posts->the_post();
					// Get the hero post template (template-parts/content-hero-item.php)
					get_template_part( 'template-parts/content-hero-item' );

					endwhile;
				?>
			</div><!-- .hero-posts -->

			<?php
			// If we have more than one post, load the carousel pager
			if ( $hero_count > 1 ) { ?>
			<div class="hero-pager-wrap">
				<div class="container">
					<div class="pager-navs"></div>
					<ul id="hero-pager">
						<?php while ( $hero_posts->have_posts() ) : $hero_posts->the_post(); ?>
							<li>
								<a>
									<?php if ( has_post_thumbnail() ) { ?>
										<div class="paging-thumb">
											<?php the_post_thumbnail( 'paperback-hero-thumb' ); ?>
										</div>
									<?php } ?>

									<div class="paging-text">
										<div class="entry-title">
											<?php the_title(); ?>
										</div>

										<div class="paging-date">
											<?php echo get_the_date(); ?>
										</div>
									</div>
								</a>
							</li>
						<?php endwhile; ?>
					</ul><!-- .hero-pager -->
				</div>
			</div>
			<?php } ?>
		</div><!-- .hero-wrapper -->
		<?php
			endif;
			wp_reset_query();
		?>
<?php } ?>

<?php if ( is_single() ) { ?>
	<div class="hero-wrapper">

		<div class="hero-posts">
			<?php get_template_part( 'template-parts/content-hero-item' ); ?>
		</div><!-- .hero-posts -->

	</div><!-- .hero-wrapper -->
<?php } ?>
