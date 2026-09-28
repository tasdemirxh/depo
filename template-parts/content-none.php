<?php
/**
 * Template part for empty loops.
 *
 * @package NovaShopCommerce
 */

?>
<section class="novashop-empty-state">
	<p class="novashop-eyebrow"><?php esc_html_e( 'Nothing here yet', 'novashop' ); ?></p>
	<h1><?php esc_html_e( 'No content found', 'novashop' ); ?></h1>
	<p><?php esc_html_e( 'Try searching for another keyword or browse the store categories.', 'novashop' ); ?></p>
	<?php get_search_form(); ?>
</section>
