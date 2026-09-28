<?php
/**
 * Footer template.
 *
 * @package NovaShopCommerce
 */

?>
<footer class="site-footer">
	<?php novashop_render_footer_builder(); ?>

	<div class="site-footer__bottom">
		<div class="novashop-container">
			<span>
				<?php
				printf(
					/* translators: %s: current year */
					esc_html__( 'Copyright %s. All rights reserved.', 'novashop' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</span>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'site-footer__menu',
				'fallback_cb'    => '__return_false',
				'depth'          => 1,
			) );
			?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
