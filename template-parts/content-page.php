<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Paperback
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<!-- Grab the featured image -->
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="featured-image"><?php the_post_thumbnail( 'paperback-full-width' ); ?></div>
	<?php } ?>

	<div class="entry-content">
		<?php the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'paperback' ),
			'after'  => '</div>',
		) );
		
		edit_post_link( esc_html__( 'Edit This', 'paperback' ), '<p>', '</p>');
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
