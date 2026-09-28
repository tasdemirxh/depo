<?php
/**
 * Template Name: NovaShop Fashion Home
 * Template Post Type: page
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="novashop-section">
		<div class="novashop-container">
			<?php
			novashop_section_heading(
				__( 'Fashion demo', 'novashop' ),
				__( 'Editorial storefront for apparel collections', 'novashop' ),
				__( 'Use this template for lookbook-led fashion, accessories, and seasonal drops.', 'novashop' )
			);

			if ( novashop_is_woocommerce_active() && shortcode_exists( 'products' ) ) {
				echo do_shortcode( '[products limit="8" columns="4" orderby="date"]' );
			} else {
				novashop_woocommerce_notice();
			}
			?>
		</div>
	</section>
</main>

<?php
get_footer();
