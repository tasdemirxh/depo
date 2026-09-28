<?php
/**
 * Demo import helpers.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create or return an existing page by path.
 *
 * @param string $title    Page title.
 * @param string $slug     Page slug.
 * @param string $content  Page content.
 * @param string $template Optional page template.
 * @return int
 */
function novashop_create_demo_page( $title, $slug, $content, $template = '' ) {
	$page = get_page_by_path( $slug );

	if ( $page ) {
		return absint( $page->ID );
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => wp_strip_all_tags( $title ),
			'post_name'    => sanitize_title( $slug ),
			'post_content' => wp_kses_post( $content ),
			'post_status'  => 'publish',
			'post_type'    => 'page',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		return 0;
	}

	if ( $template ) {
		update_post_meta( $page_id, '_wp_page_template', sanitize_text_field( $template ) );
	}

	return absint( $page_id );
}

/**
 * Import starter demo pages.
 *
 * @return void
 */
function novashop_handle_demo_import() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to import demo content.', 'novashop' ) );
	}

	check_admin_referer( 'novashop_import_demo' );

	$home_id = novashop_create_demo_page(
		__( 'NovaShop Home', 'novashop' ),
		'novashop-home',
		'<!-- wp:paragraph --><p>[novashop_ajax_filters]</p><!-- /wp:paragraph -->'
	);

	$fashion_home_id = novashop_create_demo_page(
		__( 'Fashion Demo Home', 'novashop' ),
		'fashion-demo-home',
		'<!-- wp:paragraph --><p>[products limit="8" columns="4"]</p><!-- /wp:paragraph -->',
		'page-templates/home-fashion.php'
	);

	$electronics_home_id = novashop_create_demo_page(
		__( 'Electronics Demo Home', 'novashop' ),
		'electronics-demo-home',
		'<!-- wp:paragraph --><p>[products limit="8" columns="4"]</p><!-- /wp:paragraph -->',
		'page-templates/home-electronics.php'
	);

	novashop_create_demo_page( __( 'Wishlist', 'novashop' ), 'wishlist', '[novashop_wishlist]' );
	novashop_create_demo_page( __( 'Compare', 'novashop' ), 'compare', '[novashop_compare]' );

	if ( novashop_is_woocommerce_active() && wc_get_page_id( 'shop' ) < 1 ) {
		$shop_id = novashop_create_demo_page( __( 'Shop', 'novashop' ), 'shop', '' );
		if ( $shop_id ) {
			update_option( 'woocommerce_shop_page_id', $shop_id );
		}
	}

	if ( 'fashion' === novashop_get_theme_option( 'active_demo' ) && $fashion_home_id ) {
		$home_id = $fashion_home_id;
	} elseif ( 'electronics' === novashop_get_theme_option( 'active_demo' ) && $electronics_home_id ) {
		$home_id = $electronics_home_id;
	}

	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	wp_safe_redirect( add_query_arg( 'novashop_demo_imported', '1', admin_url( 'themes.php?page=novashop-settings' ) ) );
	exit;
}
add_action( 'admin_post_novashop_import_demo', 'novashop_handle_demo_import' );
