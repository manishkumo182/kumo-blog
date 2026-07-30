<?php
/**
 * Lightweight newsletter subscriber storage, visible in the dashboard
 * under "Subscribers". Only used when no external form action URL is
 * set in Customize → Newsletter Block.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_register_subscriber_cpt() {
	register_post_type( 'kumo_subscriber', array(
		'labels' => array(
			'name'          => __( 'Subscribers', 'kumo-blog' ),
			'singular_name' => __( 'Subscriber', 'kumo-blog' ),
			'menu_name'     => __( 'Subscribers', 'kumo-blog' ),
		),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-email-alt',
		'supports'           => array( 'title' ),
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	) );
}
add_action( 'init', 'kumo_register_subscriber_cpt' );

function kumo_handle_subscribe() {
	if ( ! isset( $_POST['kumo_subscribe_nonce'] ) || ! wp_verify_nonce( $_POST['kumo_subscribe_nonce'], 'kumo_subscribe' ) ) {
		wp_safe_redirect( wp_get_referer() ?: home_url( '/' ) );
		exit;
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( is_email( $email ) ) {
		$existing = get_posts( array(
			'post_type'      => 'kumo_subscriber',
			'title'          => $email,
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		) );
		if ( empty( $existing ) ) {
			wp_insert_post( array(
				'post_type'   => 'kumo_subscriber',
				'post_title'  => $email,
				'post_status' => 'publish',
			) );
		}
	}

	$redirect = add_query_arg( 'subscribed', $email ? '1' : '0', wp_get_referer() ?: home_url( '/' ) );
	wp_safe_redirect( $redirect . '#newsletter' );
	exit;
}
add_action( 'admin_post_kumo_subscribe', 'kumo_handle_subscribe' );
add_action( 'admin_post_nopriv_kumo_subscribe', 'kumo_handle_subscribe' );
