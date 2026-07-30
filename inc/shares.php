<?php
/**
 * Click-to-share counter for single posts. Same pattern as inc/likes.php —
 * stores the total in post meta, incremented via AJAX whenever a share
 * icon is clicked.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_get_share_count( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return (int) get_post_meta( $post_id, '_kumo_shares', true );
}

function kumo_handle_share_post() {
	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid post.', 'kumo-blog' ) ), 400 );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'kumo_share_' . $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid request.', 'kumo-blog' ) ), 403 );
	}

	$count = kumo_get_share_count( $post_id ) + 1;
	update_post_meta( $post_id, '_kumo_shares', $count );

	wp_send_json_success( array( 'count' => $count ) );
}
add_action( 'wp_ajax_kumo_share_post', 'kumo_handle_share_post' );
add_action( 'wp_ajax_nopriv_kumo_share_post', 'kumo_handle_share_post' );
