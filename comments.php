<?php
/**
 * Comments template.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( post_password_required() ) {
	return;
}
?>
<div class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="section__title"><?php comments_number( __( 'No Comments', 'kumo-blog' ), __( '1 Comment', 'kumo-blog' ), __( '% Comments', 'kumo-blog' ) ); ?></h3>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 40,
			) );
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<?php
		comment_form( array(
			'class_submit' => 'btn-dark',
		) );
		?>
	<?php else : ?>
		<p><?php esc_html_e( 'Comments are closed.', 'kumo-blog' ); ?></p>
	<?php endif; ?>
</div>
