<?php
/**
 * NovaShop Commerce theme bootstrap.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NOVASHOP_VERSION', '0.1.0' );
define( 'NOVASHOP_DIR', get_template_directory() );
define( 'NOVASHOP_URI', get_template_directory_uri() );

require NOVASHOP_DIR . '/inc/template-functions.php';
require NOVASHOP_DIR . '/inc/setup.php';
require NOVASHOP_DIR . '/inc/customizer.php';
require NOVASHOP_DIR . '/inc/woocommerce.php';
