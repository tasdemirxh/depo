<?php
/**
 * NovaShop Commerce theme bootstrap.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NOVASHOP_VERSION', '0.2.0' );
define( 'NOVASHOP_DIR', get_template_directory() );
define( 'NOVASHOP_URI', get_template_directory_uri() );

require NOVASHOP_DIR . '/inc/template-functions.php';
require NOVASHOP_DIR . '/inc/settings.php';
require NOVASHOP_DIR . '/inc/setup.php';
require NOVASHOP_DIR . '/inc/customizer.php';
require NOVASHOP_DIR . '/inc/woocommerce.php';
require NOVASHOP_DIR . '/inc/commerce-actions.php';
require NOVASHOP_DIR . '/inc/ajax-filters.php';
require NOVASHOP_DIR . '/inc/builders.php';
require NOVASHOP_DIR . '/inc/mega-menu.php';
require NOVASHOP_DIR . '/inc/demo-import.php';
require NOVASHOP_DIR . '/inc/elementor.php';
