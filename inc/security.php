<?php
/**
 * Lightweight anti-bot measures for forms WordPress core doesn't protect
 * on its own — currently just the front-end user registration form.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_registration_honeypot_field() {
	?>
	<p style="position:absolute; left:-9999px; top:-9999px; width:1px; height:1px; overflow:hidden; margin:0;" aria-hidden="true">
		<label for="kumo_hp_website"><?php esc_html_e( 'Website', 'kumo-blog' ); ?></label>
		<input type="text" name="kumo_hp_website" id="kumo_hp_website" tabindex="-1" autocomplete="off" />
	</p>
	<?php
}
add_action( 'register_form', 'kumo_registration_honeypot_field' );

function kumo_registration_honeypot_check( $errors ) {
	if ( ! empty( $_POST['kumo_hp_website'] ) ) {
		$errors->add( 'kumo_hp_triggered', __( '<strong>Error</strong>: Registration failed. Please try again.', 'kumo-blog' ) );
	}
	return $errors;
}
add_filter( 'registration_errors', 'kumo_registration_honeypot_check' );
