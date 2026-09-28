<?php
/**
 * Wishlist, compare, and quick view features.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allowed collection types.
 *
 * @return array
 */
function novashop_collection_types() {
	return array( 'wishlist', 'compare' );
}

/**
 * Validate a collection type.
 *
 * @param string $type Raw type.
 * @return string
 */
function novashop_sanitize_collection_type( $type ) {
	$type = sanitize_key( $type );

	return in_array( $type, novashop_collection_types(), true ) ? $type : '';
}

/**
 * Check whether a commerce action is enabled.
 *
 * @param string $feature Feature key.
 * @return bool
 */
function novashop_is_commerce_feature_enabled( $feature ) {
	return (bool) novashop_get_theme_option( 'enable_' . sanitize_key( $feature ) );
}

/**
 * Validate a WooCommerce product ID.
 *
 * @param int $product_id Product ID.
 * @return WC_Product|false
 */
function novashop_get_valid_product( $product_id ) {
	if ( ! novashop_is_woocommerce_active() ) {
		return false;
	}

	$product_id = absint( $product_id );
	$product    = $product_id ? wc_get_product( $product_id ) : false;

	return $product && 'publish' === get_post_status( $product_id ) ? $product : false;
}

/**
 * Get collection cookie name.
 *
 * @param string $type Collection type.
 * @return string
 */
function novashop_collection_cookie_name( $type ) {
	return 'novashop_' . $type;
}

/**
 * Read product IDs from a collection.
 *
 * @param string $type Collection type.
 * @return array
 */
function novashop_get_collection( $type ) {
	$type = novashop_sanitize_collection_type( $type );

	if ( ! $type ) {
		return array();
	}

	if ( is_user_logged_in() ) {
		$items = get_user_meta( get_current_user_id(), 'novashop_' . $type, true );
	} else {
		$cookie = novashop_collection_cookie_name( $type );
		$items  = isset( $_COOKIE[ $cookie ] ) ? json_decode( wp_unslash( $_COOKIE[ $cookie ] ), true ) : array();
	}

	if ( ! is_array( $items ) ) {
		$items = array();
	}

	$items = array_filter( array_map( 'absint', $items ) );
	$items = array_values( array_unique( $items ) );

	return array_slice( $items, 0, 48 );
}

/**
 * Save product IDs to a collection.
 *
 * @param string $type  Collection type.
 * @param array  $items Product IDs.
 * @return void
 */
function novashop_save_collection( $type, $items ) {
	$type  = novashop_sanitize_collection_type( $type );
	$items = array_slice( array_values( array_unique( array_filter( array_map( 'absint', $items ) ) ) ), 0, 48 );

	if ( ! $type ) {
		return;
	}

	if ( is_user_logged_in() ) {
		update_user_meta( get_current_user_id(), 'novashop_' . $type, $items );
		return;
	}

	$cookie = novashop_collection_cookie_name( $type );
	setcookie( $cookie, wp_json_encode( $items ), time() + MONTH_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
	$_COOKIE[ $cookie ] = wp_json_encode( $items );
}

/**
 * Toggle a product in a collection.
 *
 * @return void
 */
function novashop_ajax_toggle_collection() {
	check_ajax_referer( 'novashop_storefront', 'nonce' );

	$type       = isset( $_POST['type'] ) ? novashop_sanitize_collection_type( wp_unslash( $_POST['type'] ) ) : '';
	$product_id = isset( $_POST['productId'] ) ? absint( $_POST['productId'] ) : 0;

	if ( ! $type || ! novashop_get_valid_product( $product_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product request.', 'novashop' ) ), 400 );
	}

	if ( ! novashop_is_commerce_feature_enabled( $type ) ) {
		wp_send_json_error( array( 'message' => __( 'This feature is disabled.', 'novashop' ) ), 403 );
	}

	$items  = novashop_get_collection( $type );
	$active = in_array( $product_id, $items, true );

	if ( $active ) {
		$items = array_values( array_diff( $items, array( $product_id ) ) );
	} else {
		array_unshift( $items, $product_id );
	}

	novashop_save_collection( $type, $items );

	wp_send_json_success( array(
		'active' => ! $active,
		'count'  => count( $items ),
		'type'   => $type,
	) );
}
add_action( 'wp_ajax_novashop_toggle_collection', 'novashop_ajax_toggle_collection' );
add_action( 'wp_ajax_nopriv_novashop_toggle_collection', 'novashop_ajax_toggle_collection' );

/**
 * Render action buttons for a product.
 *
 * @return void
 */
function novashop_product_action_buttons() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$product_id = $product->get_id();
	?>
	<div class="novashop-product-actions" data-product-id="<?php echo esc_attr( $product_id ); ?>">
		<?php if ( novashop_is_commerce_feature_enabled( 'wishlist' ) ) : ?>
			<button class="novashop-action-button" type="button" data-novashop-collection="wishlist" data-product-id="<?php echo esc_attr( $product_id ); ?>">
				<?php esc_html_e( 'Wishlist', 'novashop' ); ?>
			</button>
		<?php endif; ?>

		<?php if ( novashop_is_commerce_feature_enabled( 'compare' ) ) : ?>
			<button class="novashop-action-button" type="button" data-novashop-collection="compare" data-product-id="<?php echo esc_attr( $product_id ); ?>">
				<?php esc_html_e( 'Compare', 'novashop' ); ?>
			</button>
		<?php endif; ?>

		<?php if ( novashop_is_commerce_feature_enabled( 'quick_view' ) ) : ?>
			<button class="novashop-action-button" type="button" data-novashop-quick-view="<?php echo esc_attr( $product_id ); ?>">
				<?php esc_html_e( 'Quick view', 'novashop' ); ?>
			</button>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item', 'novashop_product_action_buttons', 12 );
add_action( 'woocommerce_single_product_summary', 'novashop_product_action_buttons', 35 );

/**
 * Render a compact link with collection count.
 *
 * @param string $type Collection type.
 * @return void
 */
function novashop_collection_link( $type ) {
	$type = novashop_sanitize_collection_type( $type );

	if ( ! $type || ! novashop_is_commerce_feature_enabled( $type ) ) {
		return;
	}

	$page = get_page_by_path( $type );
	$url  = $page ? get_permalink( $page ) : home_url( '/' );
	?>
	<a class="novashop-collection-link novashop-collection-link--<?php echo esc_attr( $type ); ?>" href="<?php echo esc_url( $url ); ?>">
		<span><?php echo esc_html( ucfirst( $type ) ); ?></span>
		<strong data-novashop-count="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( number_format_i18n( count( novashop_get_collection( $type ) ) ) ); ?></strong>
	</a>
	<?php
}

/**
 * Render products saved in a collection.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function novashop_collection_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'type' => 'wishlist',
		),
		$atts,
		'novashop_collection'
	);

	$type = novashop_sanitize_collection_type( $atts['type'] );

	if ( ! $type || ! novashop_is_commerce_feature_enabled( $type ) ) {
		return '';
	}

	$items = novashop_get_collection( $type );

	ob_start();
	?>
	<div class="novashop-collection novashop-collection--<?php echo esc_attr( $type ); ?>">
		<?php if ( empty( $items ) ) : ?>
			<p><?php esc_html_e( 'No products saved yet.', 'novashop' ); ?></p>
		<?php else : ?>
			<div class="novashop-collection__grid">
				<?php foreach ( $items as $product_id ) : ?>
					<?php $product = novashop_get_valid_product( $product_id ); ?>
					<?php if ( $product ) : ?>
						<article class="novashop-collection-card">
							<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
								<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail' ) ); ?>
								<h2><?php echo esc_html( $product->get_name() ); ?></h2>
							</a>
							<div class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
							<a class="button" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-product_id="<?php echo esc_attr( $product_id ); ?>">
								<?php echo esc_html( $product->add_to_cart_text() ); ?>
							</a>
						</article>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'novashop_collection', 'novashop_collection_shortcode' );

/**
 * Wishlist shortcode wrapper.
 *
 * @return string
 */
function novashop_wishlist_shortcode() {
	return novashop_collection_shortcode( array( 'type' => 'wishlist' ) );
}
add_shortcode( 'novashop_wishlist', 'novashop_wishlist_shortcode' );

/**
 * Compare shortcode wrapper.
 *
 * @return string
 */
function novashop_compare_shortcode() {
	return novashop_collection_shortcode( array( 'type' => 'compare' ) );
}
add_shortcode( 'novashop_compare', 'novashop_compare_shortcode' );

/**
 * Return quick view modal content.
 *
 * @return void
 */
function novashop_ajax_quick_view() {
	check_ajax_referer( 'novashop_storefront', 'nonce' );

	if ( ! novashop_is_commerce_feature_enabled( 'quick_view' ) ) {
		wp_send_json_error( array( 'message' => __( 'Quick view is disabled.', 'novashop' ) ), 403 );
	}

	$product_id = isset( $_POST['productId'] ) ? absint( $_POST['productId'] ) : 0;
	$product    = novashop_get_valid_product( $product_id );

	if ( ! $product ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product request.', 'novashop' ) ), 400 );
	}

	ob_start();
	?>
	<div class="novashop-quick-view">
		<div class="novashop-quick-view__image"><?php echo wp_kses_post( $product->get_image( 'woocommerce_single' ) ); ?></div>
		<div class="novashop-quick-view__content">
			<h2><?php echo esc_html( $product->get_name() ); ?></h2>
			<div class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
			<div class="novashop-quick-view__excerpt"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div>
			<a class="novashop-button" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"><?php esc_html_e( 'View product', 'novashop' ); ?></a>
		</div>
	</div>
	<?php

	wp_send_json_success( array( 'html' => ob_get_clean() ) );
}
add_action( 'wp_ajax_novashop_quick_view', 'novashop_ajax_quick_view' );
add_action( 'wp_ajax_nopriv_novashop_quick_view', 'novashop_ajax_quick_view' );
