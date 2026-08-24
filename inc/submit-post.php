<?php
/**
 * Front-end post submission: lets any logged-in user write a post from
 * the site itself (no wp-admin access needed). Submissions are always
 * saved as "Pending Review" — nothing goes live until an editor approves
 * it from the dashboard, so this stays fully moderated.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_handle_post_submit() {
	$referer = wp_get_referer() ?: home_url( '/' );

	if ( ! is_user_logged_in() ) {
		wp_safe_redirect( wp_login_url( $referer ) );
		exit;
	}

	if ( ! isset( $_POST['kumo_submit_post_nonce'] ) || ! wp_verify_nonce( $_POST['kumo_submit_post_nonce'], 'kumo_submit_post' ) ) {
		wp_safe_redirect( add_query_arg( 'submitted', 'error', $referer ) . '#submit-post' );
		exit;
	}

	// Honeypot: real users never see or fill this field, so a non-empty
	// value means a bot filled every input. Pretend success so it doesn't
	// learn to look for a different signal, but don't save anything.
	if ( ! empty( $_POST['kumo_hp_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'submitted', 'success', $referer ) . '#submit-post' );
		exit;
	}

	$title    = isset( $_POST['post_title'] ) ? sanitize_text_field( wp_unslash( $_POST['post_title'] ) ) : '';
	$excerpt  = isset( $_POST['post_excerpt'] ) ? sanitize_textarea_field( wp_unslash( $_POST['post_excerpt'] ) ) : '';
	$content  = isset( $_POST['post_content'] ) ? wp_kses_post( wp_unslash( $_POST['post_content'] ) ) : '';
	$category = isset( $_POST['post_category'] ) ? absint( $_POST['post_category'] ) : 0;

	$category_valid = $category && get_term( $category, 'category' ) && ! is_wp_error( get_term( $category, 'category' ) );

	if ( ! $title || ! $content || ! $category_valid ) {
		wp_safe_redirect( add_query_arg( 'submitted', 'error', $referer ) . '#submit-post' );
		exit;
	}

	$post_id = wp_insert_post( array(
		'post_type'    => 'post',
		'post_title'   => $title,
		'post_content' => $content,
		'post_excerpt' => $excerpt,
		'post_status'  => 'pending',
		'post_author'  => get_current_user_id(),
		'post_category' => array( $category ),
	), true );

	if ( is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'submitted', 'error', $referer ) . '#submit-post' );
		exit;
	}

	if ( ! empty( $_FILES['featured_image']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attachment_id = media_handle_upload( 'featured_image', $post_id );
		if ( ! is_wp_error( $attachment_id ) ) {
			set_post_thumbnail( $post_id, $attachment_id );
		}
	}

	$notify_to = get_option( 'admin_email' );
	if ( is_email( $notify_to ) ) {
		$author = wp_get_current_user();
		wp_mail(
			$notify_to,
			sprintf( __( 'New post pending review: %s', 'kumo-blog' ), $title ),
			sprintf(
				"%s submitted a new post for review.\n\n%s",
				$author->display_name,
				admin_url( 'post.php?post=' . $post_id . '&action=edit' )
			)
		);
	}

	wp_safe_redirect( add_query_arg( 'submitted', 'success', $referer ) . '#submit-post' );
	exit;
}
add_action( 'admin_post_kumo_submit_post', 'kumo_handle_post_submit' );
add_action( 'admin_post_nopriv_kumo_submit_post', 'kumo_handle_post_submit' );
