<?php
/**
 * Archive template.
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main novashop-container">
	<?php if ( have_posts() ) : ?>
		<header class="novashop-archive-header">
			<?php
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<div class="novashop-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>

<?php
get_footer();
