<?php
/**
 * 404 template.
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main novashop-container novashop-empty-state">
	<p class="novashop-eyebrow"><?php esc_html_e( '404', 'novashop' ); ?></p>
	<h1><?php esc_html_e( 'Page not found', 'novashop' ); ?></h1>
	<p><?php esc_html_e( 'The page you are looking for may have moved, or it no longer exists.', 'novashop' ); ?></p>
	<?php get_search_form(); ?>
	<?php novashop_button( home_url( '/' ), __( 'Back to homepage', 'novashop' ) ); ?>
</main>

<?php
get_footer();
