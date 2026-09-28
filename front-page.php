<?php
/**
 * Front page template.
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php novashop_render_hero(); ?>

	<section id="shop-categories" class="novashop-section">
		<div class="novashop-container">
			<?php
			novashop_section_heading(
				__( 'Shop by category', 'novashop' ),
				__( 'Merchandising-ready category blocks', 'novashop' ),
				__( 'Highlight your best departments with image-led category cards.', 'novashop' )
			);
			?>

			<?php if ( novashop_is_woocommerce_active() && shortcode_exists( 'product_categories' ) ) : ?>
				<?php echo do_shortcode( '[product_categories number="6" columns="3" parent="0"]' ); ?>
			<?php else : ?>
				<?php novashop_woocommerce_notice(); ?>
			<?php endif; ?>
		</div>
	</section>

	<section class="novashop-section novashop-section--muted">
		<div class="novashop-container novashop-promo-grid">
			<article class="novashop-promo-card">
				<p class="novashop-eyebrow"><?php esc_html_e( 'New arrivals', 'novashop' ); ?></p>
				<h2><?php esc_html_e( 'Launch seasonal drops with campaign cards', 'novashop' ); ?></h2>
				<p><?php esc_html_e( 'Use these promo areas for collections, discount campaigns, or brand stories.', 'novashop' ); ?></p>
			</article>
			<article class="novashop-promo-card novashop-promo-card--dark">
				<p class="novashop-eyebrow"><?php esc_html_e( 'Limited offer', 'novashop' ); ?></p>
				<h2><?php esc_html_e( 'Drive urgency without extra plugins', 'novashop' ); ?></h2>
				<p><?php esc_html_e( 'Simple reusable sections keep the storefront fast and flexible.', 'novashop' ); ?></p>
			</article>
		</div>
	</section>

	<section id="featured-products" class="novashop-section">
		<div class="novashop-container">
			<?php
			novashop_section_heading(
				__( 'Featured products', 'novashop' ),
				__( 'A product grid built for conversion', 'novashop' ),
				__( 'WooCommerce products inherit theme styling for cards, badges, buttons, and spacing.', 'novashop' )
			);
			?>

			<?php if ( novashop_is_woocommerce_active() && shortcode_exists( 'products' ) ) : ?>
				<?php echo do_shortcode( '[products limit="8" columns="4" visibility="featured"]' ); ?>
			<?php else : ?>
				<?php novashop_woocommerce_notice(); ?>
			<?php endif; ?>
		</div>
	</section>

	<section class="novashop-section novashop-benefits">
		<div class="novashop-container novashop-benefits__grid">
			<div>
				<strong><?php esc_html_e( 'Fast checkout', 'novashop' ); ?></strong>
				<span><?php esc_html_e( 'WooCommerce-ready buying flow.', 'novashop' ); ?></span>
			</div>
			<div>
				<strong><?php esc_html_e( 'Mobile first', 'novashop' ); ?></strong>
				<span><?php esc_html_e( 'Responsive header and product grids.', 'novashop' ); ?></span>
			</div>
			<div>
				<strong><?php esc_html_e( 'Customizer options', 'novashop' ); ?></strong>
				<span><?php esc_html_e( 'Change key storefront content visually.', 'novashop' ); ?></span>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
