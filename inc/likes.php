<?php
/**
 * Click-to-like counter for single posts. Stores the count in post meta
 * so it's visible/editable from the dashboard like any other post field.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_get_like_count( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return (int) get_post_meta( $post_id, '_kumo_likes', true );
}

function kumo_handle_like_post() {
	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid post.', 'kumo-blog' ) ), 400 );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'kumo_like_' . $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid request.', 'kumo-blog' ) ), 403 );
	}

	$count = kumo_get_like_count( $post_id ) + 1;
	update_post_meta( $post_id, '_kumo_likes', $count );

	wp_send_json_success( array( 'count' => $count ) );
}
add_action( 'wp_ajax_kumo_like_post', 'kumo_handle_like_post' );
add_action( 'wp_ajax_nopriv_kumo_like_post', 'kumo_handle_like_post' );
