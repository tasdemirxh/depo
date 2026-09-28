<?php
/**
 * Theme setup, menus, sidebars, and assets.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configure theme defaults and supported WordPress features.
 */
function novashop_setup() {
	load_theme_textdomain( 'novashop', NOVASHOP_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array(
		'height'      => 72,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
		'style',
		'script',
	) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary'   => __( 'Primary menu', 'novashop' ),
		'secondary' => __( 'Secondary menu', 'novashop' ),
		'footer'    => __( 'Footer menu', 'novashop' ),
	) );
}
add_action( 'after_setup_theme', 'novashop_setup' );

/**
 * Register widget areas.
 */
function novashop_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Shop sidebar', 'novashop' ),
		'id'            => 'shop-sidebar',
		'description'   => __( 'Filters and product widgets shown on WooCommerce archive pages.', 'novashop' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $index = 1; $index <= 4; $index++ ) {
		register_sidebar( array(
			'name'          => sprintf(
				/* translators: %d: footer column number */
				__( 'Footer column %d', 'novashop' ),
				$index
			),
			'id'            => 'footer-' . $index,
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'novashop_widgets_init' );

/**
 * Enqueue frontend assets.
 */
function novashop_scripts() {
	wp_enqueue_style(
		'novashop-style',
		get_stylesheet_uri(),
		array(),
		NOVASHOP_VERSION
	);

	wp_enqueue_script(
		'novashop-theme',
		NOVASHOP_URI . '/assets/js/theme.js',
		array(),
		NOVASHOP_VERSION,
		true
	);

	wp_localize_script(
		'novashop-theme',
		'NovaShopTheme',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'novashop_storefront' ),
			'i18n'    => array(
				'loading' => __( 'Loading...', 'novashop' ),
				'error'   => __( 'Something went wrong. Please try again.', 'novashop' ),
				'close'   => __( 'Close', 'novashop' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'novashop_scripts' );

/**
 * Add theme-specific body classes.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function novashop_body_classes( $classes ) {
	$classes[] = 'novashop';

	if ( novashop_get_option( 'sticky_header' ) ) {
		$classes[] = 'has-sticky-header';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'has-contained-content';
	}

	return $classes;
}
add_filter( 'body_class', 'novashop_body_classes' );
