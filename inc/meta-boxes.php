<?php
/**
 * Post editor meta box: lets an editor flag a post as the homepage
 * "Hero" feature and/or list it in the "Popular" section, straight
 * from the normal post edit screen — no code required.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_add_meta_boxes() {
	add_meta_box(
		'kumo_homepage_flags',
		__( 'Kumo Blog — Homepage Placement', 'kumo-blog' ),
		'kumo_render_meta_box',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'kumo_add_meta_boxes' );

function kumo_render_meta_box( $post ) {
	wp_nonce_field( 'kumo_save_meta_box', 'kumo_meta_box_nonce' );

	$featured = get_post_meta( $post->ID, '_kumo_featured', true );
	$popular  = get_post_meta( $post->ID, '_kumo_popular', true );
	?>
	<p>
		<label>
			<input type="checkbox" name="kumo_featured" value="1" <?php checked( $featured, '1' ); ?> />
			<?php esc_html_e( 'Show as Homepage Hero', 'kumo-blog' ); ?>
		</label>
	</p>
	<p class="description"><?php esc_html_e( 'The most recently published featured post is shown at the top of the homepage. If none is set, the latest post is used.', 'kumo-blog' ); ?></p>
	<hr />
	<p>
		<label>
			<input type="checkbox" name="kumo_popular" value="1" <?php checked( $popular, '1' ); ?> />
			<?php esc_html_e( 'Show in "Popular" section', 'kumo-blog' ); ?>
		</label>
	</p>
	<p class="description"><?php esc_html_e( 'Marked posts appear in the homepage Popular block. The most recent marked post becomes the large feature tile.', 'kumo-blog' ); ?></p>
	<?php
}

function kumo_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['kumo_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['kumo_meta_box_nonce'], 'kumo_save_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$is_featured = isset( $_POST['kumo_featured'] );

	update_post_meta( $post_id, '_kumo_featured', $is_featured ? '1' : '' );
	update_post_meta( $post_id, '_kumo_popular', isset( $_POST['kumo_popular'] ) ? '1' : '' );

	if ( $is_featured ) {
		$other_featured = get_posts( array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'post__not_in'   => array( $post_id ),
			'meta_key'       => '_kumo_featured',
			'meta_value'     => '1',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		) );
		foreach ( $other_featured as $other_id ) {
			delete_post_meta( $other_id, '_kumo_featured' );
		}
	}
}
add_action( 'save_post_post', 'kumo_save_meta_box' );
