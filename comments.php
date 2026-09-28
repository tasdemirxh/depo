<?php
/**
 * Comments template.
 *
 * @package NovaShopCommerce
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				/* translators: 1: comment count, 2: post title */
				esc_html( _nx( '%1$s comment on "%2$s"', '%1$s comments on "%2$s"', get_comments_number(), 'comments title', 'novashop' ) ),
				esc_html( number_format_i18n( get_comments_number() ) ),
				esc_html( get_the_title() )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() ) {
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'novashop' ); ?></p>
		<?php
	}

	comment_form();
	?>
</section>
