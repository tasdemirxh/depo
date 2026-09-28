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
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					if ( is_front_page() && is_home() ) {
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					} else {
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					}

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) {
						?>
						<p class="site-description"><?php echo esc_html( $description ); ?></p>
						<?php
					}
				}
				?>
			</div>

			<button class="site-nav-toggle" type="button" aria-controls="primary-menu" aria-expanded="false">
				<span></span>
				<span></span>
				<span></span>
				<?php esc_html_e( 'Menu', 'novashop' ); ?>
			</button>

			<nav class="site-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'novashop' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'primary-menu',
					'fallback_cb'    => 'wp_page_menu',
				) );
				?>
			</nav>

			<div class="site-header__actions">
				<button class="site-search-toggle" type="button" aria-expanded="false" aria-controls="site-search-panel">
					<?php esc_html_e( 'Search', 'novashop' ); ?>
				</button>
				<?php
				novashop_account_link();
				novashop_cart_link();
				?>
			</div>
		</div>
	</div>

	<div id="site-search-panel" class="site-search-panel" hidden>
		<div class="novashop-container">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>
