<?php
/**
 * Mega menu management.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render menu item fields in Appearance > Menus.
 *
 * @param int     $item_id Menu item ID.
 * @param WP_Post $item    Menu item object.
 * @return void
 */
function novashop_menu_item_custom_fields( $item_id, $item ) {
	$enabled = (bool) get_post_meta( $item_id, '_novashop_mega_enabled', true );
	$columns = absint( get_post_meta( $item_id, '_novashop_mega_columns', true ) );
	$columns = $columns ? $columns : 3;
	?>
	<p class="field-novashop-mega description description-wide">
		<label>
			<input type="checkbox" name="menu-item-novashop-mega[<?php echo esc_attr( $item_id ); ?>]" value="1" <?php checked( $enabled ); ?>>
			<?php esc_html_e( 'Enable NovaShop mega menu for this item', 'novashop' ); ?>
		</label>
	</p>
	<p class="field-novashop-mega-columns description description-thin">
		<label for="menu-item-novashop-mega-columns-<?php echo esc_attr( $item_id ); ?>">
			<?php esc_html_e( 'Mega columns', 'novashop' ); ?><br>
			<input id="menu-item-novashop-mega-columns-<?php echo esc_attr( $item_id ); ?>" type="number" min="2" max="6" name="menu-item-novashop-mega-columns[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $columns ); ?>">
		</label>
	</p>
	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'novashop_menu_item_custom_fields', 10, 2 );

/**
 * Save menu item mega menu fields.
 *
 * @param int $menu_id         Menu ID.
 * @param int $menu_item_db_id Menu item ID.
 * @return void
 */
function novashop_update_menu_item( $menu_id, $menu_item_db_id ) {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$enabled = isset( $_POST['menu-item-novashop-mega'][ $menu_item_db_id ] );
	$columns = isset( $_POST['menu-item-novashop-mega-columns'][ $menu_item_db_id ] )
		? absint( wp_unslash( $_POST['menu-item-novashop-mega-columns'][ $menu_item_db_id ] ) )
		: 3;

	update_post_meta( $menu_item_db_id, '_novashop_mega_enabled', $enabled ? '1' : '' );
	update_post_meta( $menu_item_db_id, '_novashop_mega_columns', min( 6, max( 2, $columns ) ) );
}
add_action( 'wp_update_nav_menu_item', 'novashop_update_menu_item', 10, 2 );

/**
 * Add frontend classes for mega menu items.
 *
 * @param array   $classes Menu item classes.
 * @param WP_Post $item    Menu item object.
 * @return array
 */
function novashop_nav_menu_css_class( $classes, $item ) {
	if ( get_post_meta( $item->ID, '_novashop_mega_enabled', true ) ) {
		$columns   = absint( get_post_meta( $item->ID, '_novashop_mega_columns', true ) );
		$columns   = min( 6, max( 2, $columns ? $columns : 3 ) );
		$classes[] = 'menu-item-novashop-mega';
		$classes[] = 'menu-item-novashop-mega-' . $columns;
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'novashop_nav_menu_css_class', 10, 2 );
