<?php
/**
 * WooCommerce integration.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set product grid columns.
 *
 * @return int
 */
function novashop_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'novashop_loop_columns' );

/**
 * Set products per shop page.
 *
 * @return int
 */
function novashop_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'novashop_products_per_page' );

/**
 * Add a cart count fragment for AJAX cart updates.
 *
 * @param array $fragments Existing fragments.
 * @return array
 */
function novashop_cart_link_fragment( $fragments ) {
	ob_start();
	novashop_cart_link();
	$fragments['a.novashop-cart-link'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'novashop_cart_link_fragment' );

/**
 * Render the cart link used in the header.
 *
 * @return void
 */
function novashop_cart_link() {
	if ( ! novashop_is_woocommerce_active() ) {
		return;
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	$url   = wc_get_cart_url();
	?>
	<a class="novashop-cart-link" href="<?php echo esc_url( $url ); ?>">
		<span><?php esc_html_e( 'Cart', 'novashop' ); ?></span>
		<strong aria-label="<?php echo esc_attr( sprintf( /* translators: %d: cart item count */ _n( '%d item in cart', '%d items in cart', $count, 'novashop' ), $count ) ); ?>">
			<?php echo esc_html( number_format_i18n( $count ) ); ?>
		</strong>
	</a>
	<?php
}

/**
 * Render account link for the header.
 *
 * @return void
 */
function novashop_account_link() {
	if ( ! novashop_is_woocommerce_active() ) {
		return;
	}
	?>
	<a class="novashop-account-link" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>">
		<?php esc_html_e( 'Account', 'novashop' ); ?>
	</a>
	<?php
}

/**
 * Customize sale flash text.
 *
 * @return string
 */
function novashop_sale_flash() {
	return '<span class="onsale">' . esc_html__( 'Sale', 'novashop' ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'novashop_sale_flash' );

/**
 * Add custom wrapper around WooCommerce notices for consistent spacing.
 *
 * @return void
 */
function novashop_before_woocommerce_content() {
	echo '<div class="novashop-shop-layout">';
}
add_action( 'woocommerce_before_main_content', 'novashop_before_woocommerce_content', 5 );

/**
 * Close custom WooCommerce wrapper.
 *
 * @return void
 */
function novashop_after_woocommerce_content() {
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'novashop_after_woocommerce_content', 50 );

/**
 * Render shop sidebar when widgets exist.
 *
 * @return void
 */
function novashop_shop_sidebar() {
	if ( is_active_sidebar( 'shop-sidebar' ) ) {
		echo '<aside class="novashop-shop-sidebar">';
		dynamic_sidebar( 'shop-sidebar' );
		echo '</aside>';
	}
}
add_action( 'woocommerce_sidebar', 'novashop_shop_sidebar' );
