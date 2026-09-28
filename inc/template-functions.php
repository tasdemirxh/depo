<?php
/**
 * Shared template helpers.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme option defaults.
 *
 * @return array
 */
function novashop_option_defaults() {
	return array(
		'accent_color'         => '#7a4bff',
		'header_topline'       => __( 'Free shipping for orders over $99', 'novashop' ),
		'sticky_header'        => true,
		'hero_badge'           => __( 'New season collection', 'novashop' ),
		'hero_title'           => __( 'Build a stylish online store with NovaShop', 'novashop' ),
		'hero_text'            => __( 'A WooCommerce-first theme foundation with modern merchandising sections, responsive navigation, and conversion-focused layouts.', 'novashop' ),
		'hero_primary_label'   => __( 'Shop now', 'novashop' ),
		'hero_primary_link'    => '#featured-products',
		'hero_secondary_label' => __( 'Explore categories', 'novashop' ),
		'hero_secondary_link'  => '#shop-categories',
		'footer_text'          => __( 'NovaShop Commerce - a modern WooCommerce theme starter.', 'novashop' ),
	);
}

/**
 * Get a theme mod with its default fallback.
 *
 * @param string $key Option key.
 * @return mixed
 */
function novashop_get_option( $key ) {
	$defaults = novashop_option_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	return get_theme_mod( $key, $default );
}

/**
 * Check whether WooCommerce is available.
 *
 * @return bool
 */
function novashop_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

/**
 * Render a theme button.
 *
 * @param string $url   Button URL.
 * @param string $label Button label.
 * @param string $class Additional class.
 * @return void
 */
function novashop_button( $url, $label, $class = '' ) {
	if ( empty( $label ) ) {
		return;
	}

	$classes = trim( 'novashop-button ' . $class );
	?>
	<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $url ); ?>">
		<?php echo esc_html( $label ); ?>
	</a>
	<?php
}

/**
 * Render the front-page hero.
 *
 * @return void
 */
function novashop_render_hero() {
	?>
	<section class="novashop-hero">
		<div class="novashop-container novashop-hero__inner">
			<div class="novashop-hero__content">
				<?php if ( novashop_get_option( 'hero_badge' ) ) : ?>
					<p class="novashop-eyebrow"><?php echo esc_html( novashop_get_option( 'hero_badge' ) ); ?></p>
				<?php endif; ?>

				<h1><?php echo esc_html( novashop_get_option( 'hero_title' ) ); ?></h1>
				<p><?php echo esc_html( novashop_get_option( 'hero_text' ) ); ?></p>

				<div class="novashop-hero__actions">
					<?php
					novashop_button(
						novashop_get_option( 'hero_primary_link' ),
						novashop_get_option( 'hero_primary_label' )
					);
					novashop_button(
						novashop_get_option( 'hero_secondary_link' ),
						novashop_get_option( 'hero_secondary_label' ),
						'novashop-button--ghost'
					);
					?>
				</div>
			</div>

			<div class="novashop-hero__card" aria-label="<?php esc_attr_e( 'Store highlights', 'novashop' ); ?>">
				<div class="novashop-hero__stat">
					<strong><?php esc_html_e( '24h', 'novashop' ); ?></strong>
					<span><?php esc_html_e( 'Fast dispatch', 'novashop' ); ?></span>
				</div>
				<div class="novashop-hero__mock-product">
					<span class="novashop-hero__mock-badge"><?php esc_html_e( 'Best Seller', 'novashop' ); ?></span>
					<div class="novashop-hero__mock-image"></div>
					<h2><?php esc_html_e( 'Premium product layout', 'novashop' ); ?></h2>
					<p><?php esc_html_e( 'Flexible cards for featured items, campaigns, and bundles.', 'novashop' ); ?></p>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Render a fallback message when WooCommerce is not active.
 *
 * @return void
 */
function novashop_woocommerce_notice() {
	if ( novashop_is_woocommerce_active() ) {
		return;
	}
	?>
	<div class="novashop-notice">
		<strong><?php esc_html_e( 'WooCommerce is not active.', 'novashop' ); ?></strong>
		<span><?php esc_html_e( 'Install and activate WooCommerce to enable shop grids, carts, and product sections.', 'novashop' ); ?></span>
	</div>
	<?php
}

/**
 * Render a reusable section heading.
 *
 * @param string $label Small label.
 * @param string $title Heading.
 * @param string $text  Description.
 * @return void
 */
function novashop_section_heading( $label, $title, $text = '' ) {
	?>
	<header class="novashop-section-heading">
		<?php if ( $label ) : ?>
			<p class="novashop-eyebrow"><?php echo esc_html( $label ); ?></p>
		<?php endif; ?>
		<h2><?php echo esc_html( $title ); ?></h2>
		<?php if ( $text ) : ?>
			<p><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
	</header>
	<?php
}
