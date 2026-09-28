<?php
/**
 * Search form template.
 *
 * @package NovaShopCommerce
 */

?>
<?php $novashop_search_id = 'search-field-' . wp_unique_id(); ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $novashop_search_id ); ?>">
		<?php esc_html_e( 'Search for:', 'novashop' ); ?>
	</label>
	<input
		id="<?php echo esc_attr( $novashop_search_id ); ?>"
		type="search"
		class="search-field"
		placeholder="<?php esc_attr_e( 'Search products or articles...', 'novashop' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
	/>
	<button type="submit" class="search-submit"><?php esc_html_e( 'Search', 'novashop' ); ?></button>
</form>
