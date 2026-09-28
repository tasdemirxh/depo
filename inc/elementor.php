<?php
/**
 * Elementor integration.
 *
 * @package NovaShopCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register NovaShop Elementor widgets.
 *
 * @param object $widgets_manager Elementor widget manager.
 * @return void
 */
function novashop_register_elementor_widgets( $widgets_manager ) {
	if ( ! novashop_get_theme_option( 'enable_elementor_widgets' ) || ! class_exists( '\Elementor\Widget_Base' ) ) {
		return;
	}

	if ( ! class_exists( 'Novashop_Elementor_Product_Grid' ) ) {
		/**
		 * Product grid Elementor widget.
		 */
		class Novashop_Elementor_Product_Grid extends \Elementor\Widget_Base {
			/**
			 * Widget name.
			 *
			 * @return string
			 */
			public function get_name() {
				return 'novashop_product_grid';
			}

			/**
			 * Widget title.
			 *
			 * @return string
			 */
			public function get_title() {
				return esc_html__( 'NovaShop Product Grid', 'novashop' );
			}

			/**
			 * Widget icon.
			 *
			 * @return string
			 */
			public function get_icon() {
				return 'eicon-products';
			}

			/**
			 * Widget categories.
			 *
			 * @return array
			 */
			public function get_categories() {
				return array( 'general' );
			}

			/**
			 * Register controls.
			 *
			 * @return void
			 */
			protected function register_controls() {
				$this->start_controls_section(
					'content_section',
					array(
						'label' => esc_html__( 'Products', 'novashop' ),
						'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
					)
				);

				$this->add_control(
					'limit',
					array(
						'label'   => esc_html__( 'Product limit', 'novashop' ),
						'type'    => \Elementor\Controls_Manager::NUMBER,
						'default' => 8,
						'min'     => 1,
						'max'     => 48,
					)
				);

				$this->add_control(
					'columns',
					array(
						'label'   => esc_html__( 'Columns', 'novashop' ),
						'type'    => \Elementor\Controls_Manager::NUMBER,
						'default' => 4,
						'min'     => 1,
						'max'     => 6,
					)
				);

				$this->add_control(
					'featured',
					array(
						'label'        => esc_html__( 'Featured products only', 'novashop' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'novashop' ),
						'label_off'    => esc_html__( 'No', 'novashop' ),
						'return_value' => 'yes',
						'default'      => '',
					)
				);

				$this->end_controls_section();
			}

			/**
			 * Render widget output.
			 *
			 * @return void
			 */
			protected function render() {
				if ( ! novashop_is_woocommerce_active() || ! shortcode_exists( 'products' ) ) {
					novashop_woocommerce_notice();
					return;
				}

				$settings = $this->get_settings_for_display();
				$limit    = min( 48, max( 1, absint( $settings['limit'] ) ) );
				$columns  = min( 6, max( 1, absint( $settings['columns'] ) ) );
				$featured = 'yes' === $settings['featured'] ? ' visibility="featured"' : '';

				echo do_shortcode( sprintf( '[products limit="%1$d" columns="%2$d"%3$s]', $limit, $columns, $featured ) );
			}
		}
	}

	$widgets_manager->register( new Novashop_Elementor_Product_Grid() );
}
add_action( 'elementor/widgets/register', 'novashop_register_elementor_widgets' );
