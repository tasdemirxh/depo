<?php
/**
 * AJAX product filters.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render AJAX filters shortcode.
 *
 * @return string
 */
function novashop_ajax_filters_shortcode() {
	if ( ! novashop_is_woocommerce_active() || ! novashop_get_theme_option( 'enable_ajax_filters' ) ) {
		return '';
	}

	$categories = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		)
	);

	ob_start();
	?>
	<div class="novashop-ajax-products" data-novashop-ajax-products>
		<form class="novashop-ajax-products__filters" data-novashop-product-filters>
			<div>
				<label for="novashop-filter-category"><?php esc_html_e( 'Category', 'novashop' ); ?></label>
				<select id="novashop-filter-category" name="category">
					<option value=""><?php esc_html_e( 'All categories', 'novashop' ); ?></option>
					<?php if ( ! is_wp_error( $categories ) ) : ?>
						<?php foreach ( $categories as $category ) : ?>
							<option value="<?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>

			<div>
				<label for="novashop-filter-min-price"><?php esc_html_e( 'Min price', 'novashop' ); ?></label>
				<input id="novashop-filter-min-price" type="number" min="0" step="1" name="min_price">
			</div>

			<div>
				<label for="novashop-filter-max-price"><?php esc_html_e( 'Max price', 'novashop' ); ?></label>
				<input id="novashop-filter-max-price" type="number" min="0" step="1" name="max_price">
			</div>

			<div>
				<label for="novashop-filter-orderby"><?php esc_html_e( 'Sort by', 'novashop' ); ?></label>
				<select id="novashop-filter-orderby" name="orderby">
					<option value="date"><?php esc_html_e( 'Newest', 'novashop' ); ?></option>
					<option value="price"><?php esc_html_e( 'Price: low to high', 'novashop' ); ?></option>
					<option value="price-desc"><?php esc_html_e( 'Price: high to low', 'novashop' ); ?></option>
					<option value="popularity"><?php esc_html_e( 'Popularity', 'novashop' ); ?></option>
				</select>
			</div>

			<button type="submit"><?php esc_html_e( 'Filter products', 'novashop' ); ?></button>
		</form>

		<div class="novashop-ajax-products__results" data-novashop-filter-results>
			<?php echo novashop_get_filtered_products_html( array() ); ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'novashop_ajax_filters', 'novashop_ajax_filters_shortcode' );

/**
 * Build product query args from filter request.
 *
 * @param array $request Request values.
 * @return array
 */
function novashop_build_filter_query_args( $request ) {
	$orderby  = isset( $request['orderby'] ) ? sanitize_key( $request['orderby'] ) : 'date';
	$category = isset( $request['category'] ) ? sanitize_title( $request['category'] ) : '';
	$min      = isset( $request['min_price'] ) ? max( 0, floatval( $request['min_price'] ) ) : 0;
	$max      = isset( $request['max_price'] ) ? max( 0, floatval( $request['max_price'] ) ) : 0;

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => absint( novashop_get_theme_option( 'products_per_page' ) ),
		'ignore_sticky_posts' => true,
	);

	if ( $category ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	if ( $min || $max ) {
		$price_query = array(
			'key'     => '_price',
			'type'    => 'NUMERIC',
			'compare' => '>=',
			'value'   => $min,
		);

		if ( $max && $max >= $min ) {
			$price_query = array(
				'key'     => '_price',
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN',
				'value'   => array( $min, $max ),
			);
		}

		$args['meta_query'] = array( $price_query ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	}

	if ( 'price' === $orderby || 'price-desc' === $orderby ) {
		$args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'price-desc' === $orderby ? 'DESC' : 'ASC';
	} elseif ( 'popularity' === $orderby ) {
		$args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'DESC';
	} else {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	}

	return $args;
}

/**
 * Return filtered product loop HTML.
 *
 * @param array $request Request values.
 * @return string
 */
function novashop_get_filtered_products_html( $request ) {
	$query = new WP_Query( novashop_build_filter_query_args( $request ) );

	ob_start();

	if ( $query->have_posts() ) {
		woocommerce_product_loop_start();

		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}

		woocommerce_product_loop_end();
	} else {
		wc_no_products_found();
	}

	wp_reset_postdata();

	return ob_get_clean();
}

/**
 * AJAX handler for product filtering.
 *
 * @return void
 */
function novashop_ajax_filter_products() {
	check_ajax_referer( 'novashop_storefront', 'nonce' );

	if ( ! novashop_get_theme_option( 'enable_ajax_filters' ) ) {
		wp_send_json_error( array( 'message' => __( 'AJAX filters are disabled.', 'novashop' ) ), 403 );
	}

	wp_send_json_success(
		array(
			'html' => novashop_get_filtered_products_html( wp_unslash( $_POST ) ),
		)
	);
}
add_action( 'wp_ajax_novashop_filter_products', 'novashop_ajax_filter_products' );
add_action( 'wp_ajax_nopriv_novashop_filter_products', 'novashop_ajax_filter_products' );
