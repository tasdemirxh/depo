<?php
/**
 * Template Name: NovaShop Electronics Home
 * Template Post Type: page
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="novashop-section novashop-section--muted">
		<div class="novashop-container">
			<?php
			novashop_section_heading(
				__( 'Electronics demo', 'novashop' ),
				__( 'Product-first homepage for technology stores', 'novashop' ),
				__( 'Use this template for high-volume catalogs, featured devices, and conversion-focused product grids.', 'novashop' )
			);

			if ( novashop_is_woocommerce_active() && shortcode_exists( 'novashop_ajax_filters' ) ) {
				echo do_shortcode( '[novashop_ajax_filters]' );
			} elseif ( novashop_is_woocommerce_active() && shortcode_exists( 'products' ) ) {
				echo do_shortcode( '[products limit="8" columns="4"]' );
			} else {
				novashop_woocommerce_notice();
			}
			?>
		</div>
	</section>
</main>

<?php
get_footer();
