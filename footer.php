<?php
/**
 * Footer template.
 *
 * @package NovaShopCommerce
 */

?>
<footer class="site-footer">
	<div class="novashop-container site-footer__grid">
		<div class="site-footer__brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<h2><?php bloginfo( 'name' ); ?></h2>
			<?php endif; ?>
			<p><?php echo esc_html( novashop_get_option( 'footer_text' ) ); ?></p>
		</div>

		<?php for ( $index = 1; $index <= 3; $index++ ) : ?>
			<div class="site-footer__column">
				<?php
				if ( is_active_sidebar( 'footer-' . $index ) ) {
					dynamic_sidebar( 'footer-' . $index );
				}
				?>
			</div>
		<?php endfor; ?>
	</div>

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
