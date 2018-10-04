<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Paperback
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( comments_open() || '0' != get_comments_number() ) {

if ( post_password_required() ) {
	return;
}

$comment_style = get_option( 'paperback_comment_style', 'click' );
?>

	<div id="comments" class="comments-area <?php echo esc_attr( $comment_style ); ?>">

		<?php if ( have_comments() ) : ?>
			<h3 class="comments-title">
				<span><?php
					printf(
						esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'paperback' ) ),
						number_format_i18n( get_comments_number() ),
						'<span>' . get_the_title() . '</span>'
					);
				?></span>
			</h3>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 50,
						'callback'    => 'paperback_comment'
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'paperback' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'paperback' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'paperback' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'paperback' ); ?></p>
		<?php endif; ?>

		<?php comment_form(); ?>

	</div><!-- #comments -->

<?php } // If comments are open and we have comments ?>
