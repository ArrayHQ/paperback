<?php
/**
 * This template displays the search form.
 *
 * @package Paperback
 */
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'paperback' ); ?></label>

		<input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" class="search-input" placeholder="<?php esc_attr_e( 'Search here...', 'paperback' ); ?>" />

		<button type="submit" id="searchsubmit">
			<i class="fa fa-search"></i> <span><?php echo esc_html_e( 'Search', 'paperback' ); ?></span>
		</button>
	</div>
</form>