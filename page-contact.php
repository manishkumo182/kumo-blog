<?php
/**
 * Template Name: Contact
 * Contact page: info column + message form. Copy, contact details and
 * the notification address are all editable under Customize → Contact Page.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$badge      = get_theme_mod( 'kumo_contact_badge', 'Contact' );
$heading    = get_theme_mod( 'kumo_contact_heading', 'How can we help you today?' );
$subheading = get_theme_mod( 'kumo_contact_subheading', 'Our dedicated customer support team is just a message or call away.' );
$email      = get_theme_mod( 'kumo_contact_email', 'info@kumo-labs.com' );
$phone      = get_theme_mod( 'kumo_contact_phone', '' );
$location   = get_theme_mod( 'kumo_contact_location', '' );
$button_txt = get_theme_mod( 'kumo_contact_button_text', 'Submit' );
$status     = isset( $_GET['contact'] ) ? sanitize_key( $_GET['contact'] ) : '';
?>

<div class="contact-page" id="contact">
	<div class="contact-grid">

		<div class="contact-intro">
			<span class="contact-badge">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m2 7 10 6 10-6"></path></svg>
				<?php echo esc_html( $badge ); ?>
			</span>

			<h1 class="contact-title"><?php echo esc_html( $heading ); ?></h1>
			<p class="contact-subtitle"><?php echo esc_html( $subheading ); ?></p>

			<ul class="contact-info-list">
				<li class="contact-info-item">
					<span class="contact-info-icon">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m2 7 10 6 10-6"></path></svg>
					</span>
					<span>
						<span class="contact-info-label"><?php esc_html_e( 'Email:', 'kumo-blog' ); ?></span>
						<strong class="contact-info-value"><a href="<?php echo esc_attr( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a></strong>
					</span>
				</li>
				<li class="contact-info-item">
					<span class="contact-info-icon">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
					</span>
					<span>
						<span class="contact-info-label"><?php esc_html_e( 'Phone:', 'kumo-blog' ); ?></span>
						<strong class="contact-info-value"><a href="<?php echo esc_attr( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></strong>
					</span>
				</li>
				<li class="contact-info-item">
					<span class="contact-info-icon">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
					</span>
					<span>
						<span class="contact-info-label"><?php esc_html_e( 'Location:', 'kumo-blog' ); ?></span>
						<strong class="contact-info-value"><a href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $location ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $location ); ?></a></strong>
					</span>
				</li>
			</ul>
		</div>

		<div class="contact-form-card">
			<?php if ( 'success' === $status ) : ?>
				<div class="contact-notice contact-notice--success"><?php esc_html_e( 'Thanks — your message has been sent. We\'ll get back to you shortly.', 'kumo-blog' ); ?></div>
			<?php elseif ( 'error' === $status ) : ?>
				<div class="contact-notice contact-notice--error"><?php esc_html_e( 'Please fill in all required fields with a valid email address and try again.', 'kumo-blog' ); ?></div>
			<?php endif; ?>

			<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="kumo_contact" />
				<?php wp_nonce_field( 'kumo_contact', 'kumo_contact_nonce' ); ?>

				<div class="form-row">
					<div class="form-group">
						<label for="contact-first-name"><?php esc_html_e( 'First name*', 'kumo-blog' ); ?></label>
						<input type="text" id="contact-first-name" name="first_name" required />
					</div>
					<div class="form-group">
						<label for="contact-last-name"><?php esc_html_e( 'Last name*', 'kumo-blog' ); ?></label>
						<input type="text" id="contact-last-name" name="last_name" required />
					</div>
				</div>

				<div class="form-group">
					<label for="contact-email"><?php esc_html_e( 'Work email*', 'kumo-blog' ); ?></label>
					<input type="email" id="contact-email" name="email" placeholder="<?php esc_attr_e( 'Enter email', 'kumo-blog' ); ?>" required />
				</div>

				<div class="form-group">
					<label for="contact-phone"><?php esc_html_e( 'Phone number*', 'kumo-blog' ); ?></label>
					<div class="phone-input-group">
						<select name="phone_code" aria-label="<?php esc_attr_e( 'Country code', 'kumo-blog' ); ?>">
							<option value="+1">+1</option>
							<option value="+44">+44</option>
							<option value="+61">+61</option>
							<option value="+91">+91</option>
							<option value="+971">+977</option>
						</select>
						<input type="tel" id="contact-phone" name="phone" placeholder="<?php esc_attr_e( 'Enter phone number', 'kumo-blog' ); ?>" required />
					</div>
				</div>

				<div class="form-group">
					<label for="contact-message"><?php esc_html_e( 'Message*', 'kumo-blog' ); ?></label>
					<textarea id="contact-message" name="message" rows="5" placeholder="<?php esc_attr_e( 'Enter a question, feedback, or suggestions…', 'kumo-blog' ); ?>" required></textarea>
				</div>

				<button type="submit" class="btn-contact-submit"><?php echo esc_html( $button_txt ); ?></button>
			</form>
		</div>

	</div>
</div>

<?php get_footer(); ?>
