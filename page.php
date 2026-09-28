<?php
/**
 * Page template.
 *
 * @package NovaShopCommerce
 */

get_header();
?>

<main id="primary" class="site-main novashop-container novashop-page">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'page' );

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>

<?php
get_footer();
