<?php
/**
 * Newsletter subscribe block — heading/subtext/action URL all editable
 * via Customize → Newsletter Block.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$action = get_theme_mod( 'kumo_newsletter_action', '' );
?>
<div class="newsletter" id="newsletter">
	<div class="newsletter__copy">
		<div class="newsletter__title"><?php echo esc_html( get_theme_mod( 'kumo_newsletter_heading', 'Our Newsletter' ) ); ?></div>
		<div class="newsletter__subtitle"><?php echo esc_html( get_theme_mod( 'kumo_newsletter_subtext', 'Subscribe Our Newsletter And Get Updates' ) ); ?></div>
	</div>
	<form class="newsletter__form" method="post" action="<?php echo $action ? esc_url( $action ) : esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( ! $action ) : ?>
			<input type="hidden" name="action" value="kumo_subscribe" />
			<?php wp_nonce_field( 'kumo_subscribe', 'kumo_subscribe_nonce' ); ?>
		<?php endif; ?>
		<input type="email" name="email" required placeholder="<?php esc_attr_e( 'Enter your email', 'kumo-blog' ); ?>" />
		<button type="submit"><?php echo esc_html( get_theme_mod( 'kumo_newsletter_button', 'Subscribe' ) ); ?></button>
	</form>
</div>
