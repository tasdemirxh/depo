<?php
/**
 * WooCommerce template wrapper.
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main novashop-container novashop-shop-page">
	<?php if ( novashop_is_woocommerce_active() ) : ?>
		<?php woocommerce_content(); ?>
	<?php else : ?>
		<?php novashop_woocommerce_notice(); ?>
	<?php endif; ?>
</main>

<?php
get_footer();
