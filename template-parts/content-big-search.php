<?php
/**
 * Big search field for products
 *
 * @package Paperback
 * @since Paperback 1.0
 */

$categories = get_categories();
?>

<div class="big-search">
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'paperback' ); ?></label>

		<input type="text" name="s" id="big-search" placeholder="<?php esc_html_e( 'Search here...', 'paperback' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" onfocus="if(this.value==this.getAttribute('placeholder'))this.value='';" onblur="if(this.value=='')this.value=this.getAttribute('placeholder');"/><br />

		<div class="search-controls">
		<?php
		/**
		 * Generate list of categories to search
		 */
		if ( $categories ) { ?>

			<div class="search-select-wrap">
				<select class="search-select" name="category_name">

					<option value=""><?php esc_html_e( 'Entire Site', 'paperback' ); ?></option>

					<?php
						/**
						 * Generate list of categories
						 */
						foreach ( $categories as $category ) {
							echo '<option value="' . esc_attr( $category->slug ) . '">', $category->name, "</option>";
						}
					?>
				</select>
			</div>

		<?php } ?>

			<input type="submit" class="submit button" name="submit" id="big-search-submit" value="<?php esc_attr_e( 'Search', 'paperback' ); ?>" />
		</div><!-- .search-controls -->
	</form><!-- #big-searchform -->

</div><!-- .big-search -->