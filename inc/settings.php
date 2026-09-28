<?php
/**
 * Advanced theme settings.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advanced option defaults.
 *
 * @return array
 */
function novashop_theme_option_defaults() {
	return array(
		'enable_wishlist'          => true,
		'enable_compare'           => true,
		'enable_quick_view'        => true,
		'enable_ajax_filters'      => true,
		'enable_elementor_widgets' => true,
		'header_elements'          => 'logo,menu,search,account,wishlist,compare,cart',
		'footer_columns'           => 3,
		'loop_columns'             => 4,
		'products_per_page'        => 12,
		'active_demo'              => 'default',
	);
}

/**
 * Return all advanced options merged with defaults.
 *
 * @return array
 */
function novashop_get_theme_options() {
	$options = get_option( 'novashop_theme_options', array() );

	if ( ! is_array( $options ) ) {
		$options = array();
	}

	return wp_parse_args( $options, novashop_theme_option_defaults() );
}

/**
 * Return one advanced option.
 *
 * @param string $key Option key.
 * @return mixed
 */
function novashop_get_theme_option( $key ) {
	$options = novashop_get_theme_options();

	return isset( $options[ $key ] ) ? $options[ $key ] : null;
}

/**
 * Convert a comma-separated header builder string to a safe element list.
 *
 * @param string $value Raw header elements.
 * @return string
 */
function novashop_sanitize_header_elements( $value ) {
	$allowed = array( 'logo', 'menu', 'search', 'account', 'wishlist', 'compare', 'cart' );
	$items   = array_filter( array_map( 'trim', explode( ',', (string) $value ) ) );
	$items   = array_values( array_intersect( $items, $allowed ) );

	if ( empty( $items ) ) {
		$items = array( 'logo', 'menu', 'search', 'account', 'cart' );
	}

	return implode( ',', array_unique( $items ) );
}

/**
 * Sanitize advanced options from the settings page.
 *
 * @param array $input Raw options.
 * @return array
 */
function novashop_sanitize_theme_options( $input ) {
	$defaults = novashop_theme_option_defaults();
	$input    = is_array( $input ) ? $input : array();
	$demo     = sanitize_key( isset( $input['active_demo'] ) ? $input['active_demo'] : $defaults['active_demo'] );

	if ( ! in_array( $demo, array( 'default', 'fashion', 'electronics' ), true ) ) {
		$demo = $defaults['active_demo'];
	}

	return array(
		'enable_wishlist'          => ! empty( $input['enable_wishlist'] ),
		'enable_compare'           => ! empty( $input['enable_compare'] ),
		'enable_quick_view'        => ! empty( $input['enable_quick_view'] ),
		'enable_ajax_filters'      => ! empty( $input['enable_ajax_filters'] ),
		'enable_elementor_widgets' => ! empty( $input['enable_elementor_widgets'] ),
		'header_elements'          => novashop_sanitize_header_elements( isset( $input['header_elements'] ) ? $input['header_elements'] : $defaults['header_elements'] ),
		'footer_columns'           => min( 4, max( 1, absint( isset( $input['footer_columns'] ) ? $input['footer_columns'] : $defaults['footer_columns'] ) ) ),
		'loop_columns'             => min( 6, max( 2, absint( isset( $input['loop_columns'] ) ? $input['loop_columns'] : $defaults['loop_columns'] ) ) ),
		'products_per_page'        => min( 48, max( 4, absint( isset( $input['products_per_page'] ) ? $input['products_per_page'] : $defaults['products_per_page'] ) ) ),
		'active_demo'              => $demo,
	);
}

/**
 * Register advanced theme settings.
 *
 * @return void
 */
function novashop_register_theme_settings() {
	register_setting(
		'novashop_theme_settings',
		'novashop_theme_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'novashop_sanitize_theme_options',
			'default'           => novashop_theme_option_defaults(),
		)
	);
}
add_action( 'admin_init', 'novashop_register_theme_settings' );

/**
 * Add admin settings page under Appearance.
 *
 * @return void
 */
function novashop_add_theme_settings_page() {
	add_theme_page(
		__( 'NovaShop Settings', 'novashop' ),
		__( 'NovaShop Settings', 'novashop' ),
		'edit_theme_options',
		'novashop-settings',
		'novashop_render_theme_settings_page'
	);
}
add_action( 'admin_menu', 'novashop_add_theme_settings_page' );

/**
 * Render a checkbox option.
 *
 * @param array  $options Current options.
 * @param string $key     Option key.
 * @param string $label   Label.
 * @return void
 */
function novashop_settings_checkbox( $options, $key, $label ) {
	?>
	<label>
		<input type="checkbox" name="novashop_theme_options[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( ! empty( $options[ $key ] ) ); ?>>
		<?php echo esc_html( $label ); ?>
	</label>
	<?php
}

/**
 * Render advanced theme settings page.
 *
 * @return void
 */
function novashop_render_theme_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to edit theme settings.', 'novashop' ) );
	}

	$options = novashop_get_theme_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'NovaShop Advanced Settings', 'novashop' ); ?></h1>

		<?php if ( isset( $_GET['novashop_demo_imported'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Demo content was imported successfully.', 'novashop' ); ?></p>
			</div>
		<?php endif; ?>

		<form action="options.php" method="post">
			<?php settings_fields( 'novashop_theme_settings' ); ?>

			<h2><?php esc_html_e( 'Storefront features', 'novashop' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Commerce actions', 'novashop' ); ?></th>
					<td>
						<p><?php novashop_settings_checkbox( $options, 'enable_wishlist', __( 'Enable wishlist', 'novashop' ) ); ?></p>
						<p><?php novashop_settings_checkbox( $options, 'enable_compare', __( 'Enable compare', 'novashop' ) ); ?></p>
						<p><?php novashop_settings_checkbox( $options, 'enable_quick_view', __( 'Enable quick view modal', 'novashop' ) ); ?></p>
						<p><?php novashop_settings_checkbox( $options, 'enable_ajax_filters', __( 'Enable AJAX product filters shortcode', 'novashop' ) ); ?></p>
						<p><?php novashop_settings_checkbox( $options, 'enable_elementor_widgets', __( 'Enable Elementor widgets when Elementor is active', 'novashop' ) ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="novashop-header-elements"><?php esc_html_e( 'Header builder elements', 'novashop' ); ?></label></th>
					<td>
						<input id="novashop-header-elements" class="regular-text" type="text" name="novashop_theme_options[header_elements]" value="<?php echo esc_attr( $options['header_elements'] ); ?>">
						<p class="description"><?php esc_html_e( 'Allowed values: logo, menu, search, account, wishlist, compare, cart. Separate values with commas.', 'novashop' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="novashop-footer-columns"><?php esc_html_e( 'Footer widget columns', 'novashop' ); ?></label></th>
					<td><input id="novashop-footer-columns" type="number" min="1" max="4" name="novashop_theme_options[footer_columns]" value="<?php echo esc_attr( $options['footer_columns'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="novashop-loop-columns"><?php esc_html_e( 'Product loop columns', 'novashop' ); ?></label></th>
					<td><input id="novashop-loop-columns" type="number" min="2" max="6" name="novashop_theme_options[loop_columns]" value="<?php echo esc_attr( $options['loop_columns'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="novashop-products-per-page"><?php esc_html_e( 'Products per page', 'novashop' ); ?></label></th>
					<td><input id="novashop-products-per-page" type="number" min="4" max="48" name="novashop_theme_options[products_per_page]" value="<?php echo esc_attr( $options['products_per_page'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="novashop-active-demo"><?php esc_html_e( 'Active demo template', 'novashop' ); ?></label></th>
					<td>
						<select id="novashop-active-demo" name="novashop_theme_options[active_demo]">
							<option value="default" <?php selected( $options['active_demo'], 'default' ); ?>><?php esc_html_e( 'Default Storefront', 'novashop' ); ?></option>
							<option value="fashion" <?php selected( $options['active_demo'], 'fashion' ); ?>><?php esc_html_e( 'Fashion', 'novashop' ); ?></option>
							<option value="electronics" <?php selected( $options['active_demo'], 'electronics' ); ?>><?php esc_html_e( 'Electronics', 'novashop' ); ?></option>
						</select>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>

		<hr>

		<h2><?php esc_html_e( 'Demo import', 'novashop' ); ?></h2>
		<p><?php esc_html_e( 'Create starter pages for homepage, wishlist, compare, and shop testing.', 'novashop' ); ?></p>
		<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<input type="hidden" name="action" value="novashop_import_demo">
			<?php wp_nonce_field( 'novashop_import_demo' ); ?>
			<?php submit_button( __( 'Import demo pages', 'novashop' ), 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}
