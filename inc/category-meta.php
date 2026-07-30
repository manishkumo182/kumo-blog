<?php
/**
 * Adds a "Category Image" field to Posts → Categories (add + edit screens)
 * so category thumbnails used on the homepage "Browse by Category" strip
 * and the category archive header can be set from the dashboard.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function kumo_category_add_image_field() {
	?>
	<div class="form-field term-group">
		<label for="kumo-category-image-id"><?php esc_html_e( 'Category Image', 'kumo-blog' ); ?></label>
		<input type="hidden" id="kumo-category-image-id" name="kumo_category_image_id" value="" />
		<div id="kumo-category-image-wrapper"></div>
		<p>
			<button type="button" class="button kumo-category-image-upload"><?php esc_html_e( 'Upload / Choose Image', 'kumo-blog' ); ?></button>
			<button type="button" class="button kumo-category-image-remove"><?php esc_html_e( 'Remove Image', 'kumo-blog' ); ?></button>
		</p>
		<p class="description"><?php esc_html_e( 'Shown on the homepage "Browse by Category" section and on this category\'s archive header.', 'kumo-blog' ); ?></p>
	</div>
	<?php
}
add_action( 'category_add_form_fields', 'kumo_category_add_image_field' );

function kumo_category_edit_image_field( $term ) {
	$image_id = get_term_meta( $term->term_id, 'kumo_category_image_id', true );
	?>
	<tr class="form-field term-group-wrap">
		<th scope="row"><label for="kumo-category-image-id"><?php esc_html_e( 'Category Image', 'kumo-blog' ); ?></label></th>
		<td>
			<input type="hidden" id="kumo-category-image-id" name="kumo_category_image_id" value="<?php echo esc_attr( $image_id ); ?>" />
			<div id="kumo-category-image-wrapper">
				<?php if ( $image_id ) : ?>
					<?php echo wp_get_attachment_image( $image_id, array( 100, 100 ) ); ?>
				<?php endif; ?>
			</div>
			<p>
				<button type="button" class="button kumo-category-image-upload"><?php esc_html_e( 'Upload / Choose Image', 'kumo-blog' ); ?></button>
				<button type="button" class="button kumo-category-image-remove"><?php esc_html_e( 'Remove Image', 'kumo-blog' ); ?></button>
			</p>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'kumo_category_edit_image_field' );

function kumo_category_save_image_field( $term_id ) {
	if ( isset( $_POST['kumo_category_image_id'] ) ) {
		update_term_meta( $term_id, 'kumo_category_image_id', absint( $_POST['kumo_category_image_id'] ) );
	}
}
add_action( 'created_category', 'kumo_category_save_image_field' );
add_action( 'edited_category', 'kumo_category_save_image_field' );

function kumo_category_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'edit-tags.php', 'term.php' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	wp_add_inline_script( 'jquery', "
		jQuery(function($){
			var frame;
			$(document).on('click', '.kumo-category-image-upload', function(e){
				e.preventDefault();
				if ( frame ) { frame.open(); return; }
				frame = wp.media({
					title: 'Select Category Image',
					multiple: false,
					library: { type: 'image' }
				});
				frame.on('select', function(){
					var attachment = frame.state().get('selection').first().toJSON();
					$('#kumo-category-image-id').val(attachment.id);
					$('#kumo-category-image-wrapper').html('<img src=\"' + (attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '\" style=\"max-width:100px;height:auto;\" />');
				});
				frame.open();
			});
			$(document).on('click', '.kumo-category-image-remove', function(e){
				e.preventDefault();
				$('#kumo-category-image-id').val('');
				$('#kumo-category-image-wrapper').html('');
			});
		});
	" );
}
add_action( 'admin_enqueue_scripts', 'kumo_category_admin_assets' );

/**
 * Helper: get a category's image URL, with a graceful fallback to the
 * first post's featured image in that category so the grid never breaks.
 */
function kumo_get_category_image_url( $term_id, $size = 'kumo-card' ) {
	$image_id = get_term_meta( $term_id, 'kumo_category_image_id', true );

	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return $url;
		}
	}

	$fallback = get_posts( array(
		'posts_per_page'      => 1,
		'category'             => $term_id,
		'orderby'              => 'date',
		'order'                => 'DESC',
		'ignore_sticky_posts'  => true,
		'no_found_rows'        => true,
		'fields'               => 'ids',
	) );

	if ( ! empty( $fallback ) && has_post_thumbnail( $fallback[0] ) ) {
		return get_the_post_thumbnail_url( $fallback[0], $size );
	}

	return '';
}
