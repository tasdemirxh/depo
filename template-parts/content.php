<?php
/**
 * Default content card.
 *
 * @package NovaShopCommerce
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'novashop-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="novashop-card__image" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'large' ); ?>
		</a>
	<?php endif; ?>

	<div class="novashop-card__body">
		<header class="entry-header">
			<?php
			if ( is_singular() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
			?>
		</header>

		<div class="entry-content">
			<?php
			if ( is_singular() ) {
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'novashop' ),
					'after'  => '</div>',
				) );
			} else {
				the_excerpt();
			}
			?>
		</div>
	</div>
</article>
