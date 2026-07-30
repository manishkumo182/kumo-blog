<?php
/**
 * Customizer: everything editable from Appearance → Customize
 * without touching code — header tagline/search/subscribe button,
 * newsletter block, footer description, social links, copyright.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_customize_register( $wp_customize ) {

	/* -------------------------------------------------
	 * Header options
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'kumo_header', array(
		'title'    => __( 'Header Options', 'kumo-blog' ),
		'priority' => 25,
	) );

	$wp_customize->add_setting( 'kumo_header_tagline', array(
		'default'           => 'Trending Articles Of India',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_header_tagline', array(
		'label'   => __( 'Small tagline next to logo', 'kumo-blog' ),
		'section' => 'kumo_header',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_search_placeholder', array(
		'default'           => 'Search news, article, research...',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_search_placeholder', array(
		'label'   => __( 'Search box placeholder text', 'kumo-blog' ),
		'section' => 'kumo_header',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_subscribe_text', array(
		'default'           => 'Subscribe',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_subscribe_text', array(
		'label'   => __( 'Subscribe button text', 'kumo-blog' ),
		'section' => 'kumo_header',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_subscribe_url', array(
		'default'           => '#newsletter',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'kumo_subscribe_url', array(
		'label'   => __( 'Subscribe button link', 'kumo-blog' ),
		'section' => 'kumo_header',
		'type'    => 'url',
	) );

	/* -------------------------------------------------
	 * Newsletter block (shown on home + category pages)
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'kumo_newsletter', array(
		'title'    => __( 'Newsletter Block', 'kumo-blog' ),
		'priority' => 26,
	) );

	$wp_customize->add_setting( 'kumo_newsletter_heading', array(
		'default'           => 'Our Newsletter',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_newsletter_heading', array(
		'label'   => __( 'Heading', 'kumo-blog' ),
		'section' => 'kumo_newsletter',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_newsletter_subtext', array(
		'default'           => 'Subscribe Our Newsletter And Get Updates',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_newsletter_subtext', array(
		'label'   => __( 'Subtext', 'kumo-blog' ),
		'section' => 'kumo_newsletter',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_newsletter_button', array(
		'default'           => 'Subscribe',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_newsletter_button', array(
		'label'   => __( 'Button text', 'kumo-blog' ),
		'section' => 'kumo_newsletter',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_newsletter_action', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'kumo_newsletter_action', array(
		'label'       => __( 'Form action URL (Mailchimp/other provider)', 'kumo-blog' ),
		'description' => __( 'Leave blank to just store submissions as a "kumo_subscriber" comment-free no-op.', 'kumo-blog' ),
		'section'     => 'kumo_newsletter',
		'type'        => 'url',
	) );

	/* -------------------------------------------------
	 * Footer
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'kumo_footer', array(
		'title'    => __( 'Footer Options', 'kumo-blog' ),
		'priority' => 27,
	) );

	$wp_customize->add_setting( 'kumo_footer_about', array(
		'default'           => 'Building the future of research, engineering and technology journalism.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'kumo_footer_about', array(
		'label'   => __( 'About text under logo', 'kumo-blog' ),
		'section' => 'kumo_footer',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'kumo_footer_copyright', array(
		'default'           => '© ' . date( 'Y' ) . ' Kumo Blog. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_footer_copyright', array(
		'label'   => __( 'Copyright line', 'kumo-blog' ),
		'section' => 'kumo_footer',
		'type'    => 'text',
	) );

	$socials = array(
		'facebook'  => 'Facebook URL',
		'twitter'   => 'Twitter / X URL',
		'instagram' => 'Instagram URL',
		'linkedin'  => 'LinkedIn URL',
	);
	foreach ( $socials as $key => $label ) {
		$wp_customize->add_setting( "kumo_social_{$key}", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "kumo_social_{$key}", array(
			'label'   => __( $label, 'kumo-blog' ),
			'section' => 'kumo_footer',
			'type'    => 'url',
		) );
	}

	/* -------------------------------------------------
	 * Contact page
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'kumo_contact', array(
		'title'    => __( 'Contact Page', 'kumo-blog' ),
		'priority' => 28,
	) );

	$wp_customize->add_setting( 'kumo_contact_badge', array(
		'default'           => 'Contact',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_contact_badge', array(
		'label'   => __( 'Badge label', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_contact_heading', array(
		'default'           => 'How can we help you today?',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_contact_heading', array(
		'label'   => __( 'Heading', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_contact_subheading', array(
		'default'           => 'Our dedicated customer support team is just a message or call away.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'kumo_contact_subheading', array(
		'label'   => __( 'Subheading', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'kumo_contact_email', array(
		'default'           => 'info@kumo-labs.com',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_contact_email', array(
		'label'   => __( 'Displayed email', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_contact_phone', array(
		'default'           => '+1 (800) 123-4567',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_contact_phone', array(
		'label'   => __( 'Displayed phone', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_contact_location', array(
		'default'           => 'Silicon Valley, CA 94043 United States',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_contact_location', array(
		'label'   => __( 'Displayed location', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_contact_button_text', array(
		'default'           => 'Submit',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kumo_contact_button_text', array(
		'label'   => __( 'Submit button text', 'kumo-blog' ),
		'section' => 'kumo_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kumo_contact_notify_email', array(
		'default'           => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'kumo_contact_notify_email', array(
		'label'       => __( 'Send submissions to this email', 'kumo-blog' ),
		'description' => __( 'Every submission is also saved under Contact Messages in the dashboard.', 'kumo-blog' ),
		'section'     => 'kumo_contact',
		'type'        => 'email',
	) );

	$wp_customize->add_setting( 'kumo_color_contact_accent', array(
		'default'           => '#6C5CE7',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kumo_color_contact_accent', array(
		'label'   => __( 'Accent color (contact page)', 'kumo-blog' ),
		'section' => 'kumo_contact',
	) ) );

	/* -------------------------------------------------
	 * Colors
	 * ------------------------------------------------- */
	$wp_customize->add_setting( 'kumo_color_accent', array(
		'default'           => '#F9D9DE',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kumo_color_accent', array(
		'label'   => __( 'Accent color (newsletter block)', 'kumo-blog' ),
		'section' => 'colors',
	) ) );
}
add_action( 'customize_register', 'kumo_customize_register' );

/**
 * Print customizer-controlled colors as CSS variables.
 */
function kumo_customizer_css() {
	$accent         = get_theme_mod( 'kumo_color_accent', '#F9D9DE' );
	$contact_accent = get_theme_mod( 'kumo_color_contact_accent', '#6C5CE7' );
	echo '<style>:root{ --kumo-accent: ' . esc_attr( $accent ) . '; --kumo-contact-accent: ' . esc_attr( $contact_accent ) . '; }</style>';
}
add_action( 'wp_head', 'kumo_customizer_css' );
