<?php
/**
 * Header template.
 *
 * @package NovaShopCommerce
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'novashop' ); ?></a>

<header class="site-header">
	<?php if ( novashop_get_option( 'header_topline' ) ) : ?>
		<div class="site-header__top">
			<div class="novashop-container">
				<span><?php echo esc_html( novashop_get_option( 'header_topline' ) ); ?></span>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'secondary',
					'container'      => false,
					'menu_class'     => 'site-header__mini-menu',
					'fallback_cb'    => '__return_false',
					'depth'          => 1,
				) );
				?>
			</div>
		</div>
	<?php endif; ?>

	<div class="site-header__main">
		<div class="novashop-container site-header__inner">
			<?php novashop_render_header_builder(); ?>
		</div>
	</div>

	<div id="site-search-panel" class="site-search-panel" hidden>
		<div class="novashop-container">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>
