<?php
/**
 * This template adds the drop down explore drawer
 *
 * @package Paperback
 * @since Paperback 1.0
 */
$post_tags = get_tags();
$post_cats = get_categories();
?>
<div class="drawer drawer-explore">
	<div class="container">
		<div class="drawer-search">
			<?php get_template_part( 'template-parts/content-big-search' ); ?>
		</div>

		<?php if ( $post_cats ) { ?>
			<div class="widget tax-widget">
				<h2 class="widget-title"><?php esc_html_e( 'Categories', 'paperback' ); ?></h2>

				<?php
					$args = array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'hide_empty' => 'true'
					);
					$categories = get_categories( $args );
					$count=0;
					foreach( $categories as $category ) {
						$count++;
						echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . sprintf( esc_html( "View all posts in %s", 'paperback' ), $category->name ) . '" ' . '>' . esc_html( $category->name ) . '</a>';
						if( $count > 19 ) break;
					}
				?>
			</div>
		<?php } ?>

		<?php if ( $post_tags  ) { ?>
			<div class="widget tax-widget">
				<h2 class="widget-title"><?php esc_html_e( 'Tags', 'paperback' ); ?></h2>

				<?php
					$tag_args = array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'hide_empty' => 'true'
					);
					$tags = get_tags( $tag_args );
					$count=0;
					foreach( $tags as $tag ) {
						$count++;
						echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" title="' . sprintf( esc_html( "View all posts in %s" ), $tag->name ) . '" ' . '>' . esc_html( $tag->name ) . '</a>';
						if( $count > 19 ) break;
					}
				?>
			</div>
		<?php } ?>

		<div class="widget tax-widget">
			<h2 class="widget-title"><?php esc_html_e( 'Archives', 'paperback' ); ?></h2>

			<?php
				wp_get_archives(
					array(
						'type'   => 'monthly',
						'limit'  => '12',
						'format' => 'custom',
					)
				);
			?>
		</div>
	</div><!-- .container -->
</div><!-- .drawer -->