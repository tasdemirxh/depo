<?php
/**
 * Header and footer builder helpers.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return safe header builder elements.
 *
 * @return array
 */
function novashop_get_header_elements() {
	return array_filter( array_map( 'trim', explode( ',', novashop_sanitize_header_elements( novashop_get_theme_option( 'header_elements' ) ) ) ) );
}

/**
 * Render site branding.
 *
 * @return void
 */
function novashop_render_branding() {
	?>
	<div class="site-branding">
		<?php
		if ( has_custom_logo() ) {
			the_custom_logo();
		} else {
			$tag = is_front_page() && is_home() ? 'h1' : 'p';
			printf(
				'<%1$s class="site-title"><a href="%2$s">%3$s</a></%1$s>',
				esc_attr( $tag ),
				esc_url( home_url( '/' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) {
				printf( '<p class="site-description">%s</p>', esc_html( $description ) );
			}
		}
		?>
	</div>
	<?php
}

/**
 * Render primary navigation.
 *
 * @return void
 */
function novashop_render_primary_navigation() {
	?>
	<nav class="site-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'novashop' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'primary-menu',
				'fallback_cb'    => 'wp_page_menu',
			)
		);
		?>
	</nav>
	<?php
}

/**
 * Render search toggle.
 *
 * @return void
 */
function novashop_render_search_toggle() {
	?>
	<button class="site-search-toggle" type="button" aria-expanded="false" aria-controls="site-search-panel">
		<?php esc_html_e( 'Search', 'novashop' ); ?>
	</button>
	<?php
}

/**
 * Render a single header builder element.
 *
 * @param string $element Element key.
 * @return void
 */
function novashop_render_header_element( $element ) {
	switch ( $element ) {
		case 'logo':
			novashop_render_branding();
			break;
		case 'menu':
			novashop_render_primary_navigation();
			break;
		case 'search':
			novashop_render_search_toggle();
			break;
		case 'account':
			novashop_account_link();
			break;
		case 'wishlist':
			novashop_collection_link( 'wishlist' );
			break;
		case 'compare':
			novashop_collection_link( 'compare' );
			break;
		case 'cart':
			novashop_cart_link();
			break;
	}
}

/**
 * Render header builder layout.
 *
 * @return void
 */
function novashop_render_header_builder() {
	$elements = novashop_get_header_elements();
	?>
	<div class="site-header__builder">
		<div class="site-header__brand-zone">
			<?php
			if ( in_array( 'logo', $elements, true ) ) {
				novashop_render_header_element( 'logo' );
			}
			?>
		</div>

		<button class="site-nav-toggle" type="button" aria-controls="primary-menu" aria-expanded="false">
			<span></span>
			<span></span>
			<span></span>
			<?php esc_html_e( 'Menu', 'novashop' ); ?>
		</button>

		<div class="site-header__nav-zone">
			<?php
			if ( in_array( 'menu', $elements, true ) ) {
				novashop_render_header_element( 'menu' );
			}
			?>
		</div>

		<div class="site-header__actions">
			<?php
			foreach ( $elements as $element ) {
				if ( in_array( $element, array( 'logo', 'menu' ), true ) ) {
					continue;
				}

				novashop_render_header_element( $element );
			}
			?>
		</div>
	</div>
	<?php
}

/**
 * Render footer builder layout.
 *
 * @return void
 */
function novashop_render_footer_builder() {
	$columns = min( 4, max( 1, absint( novashop_get_theme_option( 'footer_columns' ) ) ) );
	?>
	<div class="novashop-container site-footer__grid site-footer__grid--columns-<?php echo esc_attr( $columns ); ?>">
		<div class="site-footer__brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<h2><?php bloginfo( 'name' ); ?></h2>
			<?php endif; ?>
			<p><?php echo esc_html( novashop_get_option( 'footer_text' ) ); ?></p>
		</div>

		<?php for ( $index = 1; $index <= $columns; $index++ ) : ?>
			<div class="site-footer__column">
				<?php
				if ( is_active_sidebar( 'footer-' . $index ) ) {
					dynamic_sidebar( 'footer-' . $index );
				}
				?>
			</div>
		<?php endfor; ?>
	</div>
	<?php
}
