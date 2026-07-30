<?php
/**
 * Contact page: stores submissions as "Contact Messages" in the dashboard
 * and emails the address set in Customize → Contact Page.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_register_contact_cpt() {
	register_post_type( 'kumo_contact_msg', array(
		'labels' => array(
			'name'          => __( 'Contact Messages', 'kumo-blog' ),
			'singular_name' => __( 'Contact Message', 'kumo-blog' ),
			'menu_name'     => __( 'Contact Messages', 'kumo-blog' ),
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-email-alt2',
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'map_meta_cap'    => true,
	) );
}
add_action( 'init', 'kumo_register_contact_cpt' );

function kumo_handle_contact_submit() {
	$referer = wp_get_referer() ?: home_url( '/' );

	if ( ! isset( $_POST['kumo_contact_nonce'] ) || ! wp_verify_nonce( $_POST['kumo_contact_nonce'], 'kumo_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $referer ) . '#contact' );
		exit;
	}

	$first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last_name  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone_code = isset( $_POST['phone_code'] ) ? sanitize_text_field( wp_unslash( $_POST['phone_code'] ) ) : '';
	$phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message    = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $first_name || ! $last_name || ! is_email( $email ) || ! $phone || ! $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $referer ) . '#contact' );
		exit;
	}

	$full_phone = trim( $phone_code . ' ' . $phone );

	$post_id = wp_insert_post( array(
		'post_type'    => 'kumo_contact_msg',
		'post_title'   => $first_name . ' ' . $last_name,
		'post_content' => $message,
		'post_status'  => 'publish',
	) );

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_kumo_contact_email', $email );
		update_post_meta( $post_id, '_kumo_contact_phone', $full_phone );

		$notify_to = get_theme_mod( 'kumo_contact_notify_email', get_option( 'admin_email' ) );
		if ( is_email( $notify_to ) ) {
			$subject = sprintf( __( 'New contact message from %s', 'kumo-blog' ), $first_name . ' ' . $last_name );
			$body    = "Name: {$first_name} {$last_name}\n"
				. "Email: {$email}\n"
				. "Phone: {$full_phone}\n\n"
				. "Message:\n{$message}";
			wp_mail( $notify_to, $subject, $body, array( 'Reply-To: ' . $email ) );
		}
	}

	wp_safe_redirect( add_query_arg( 'contact', 'success', $referer ) . '#contact' );
	exit;
}
add_action( 'admin_post_kumo_contact', 'kumo_handle_contact_submit' );
add_action( 'admin_post_nopriv_kumo_contact', 'kumo_handle_contact_submit' );
