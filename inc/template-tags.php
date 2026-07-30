<?php
/**
 * Reusable template helpers.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Estimated reading time for the hero banner, e.g. "06 Minute".
 */
function kumo_reading_time( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = max( 1, (int) round( $words / 200 ) );

	return sprintf( '%02d Minute', $minutes );
}

/**
 * Small author + date meta line used on cards and hero — author name and
 * date sit on a single line together.
 */
function kumo_author_meta( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$author  = get_the_author_meta( 'ID', get_post_field( 'post_author', $post_id ) );
	?>
	<span class="author">
		<?php echo get_avatar( $author, 24 ); ?>
		<?php echo esc_html( get_the_author_meta( 'display_name', $author ) ); ?>
		<span class="author__date">&mdash; <?php echo esc_html( get_the_date( 'M j, Y', $post_id ) ); ?></span>
	</span>
	<?php
}

/**
 * The homepage hero post: prefers a post flagged "_kumo_featured",
 * falls back to the latest sticky post, then the latest post overall.
 */
function kumo_get_hero_post() {
	$featured = get_posts( array(
		'posts_per_page' => 1,
		'meta_key'       => '_kumo_featured',
		'meta_value'     => '1',
		'no_found_rows'  => true,
	) );
	if ( ! empty( $featured ) ) {
		return $featured[0];
	}

	$sticky = get_option( 'sticky_posts' );
	if ( ! empty( $sticky ) ) {
		$posts = get_posts( array(
			'posts_per_page' => 1,
			'post__in'       => $sticky,
			'orderby'        => 'date',
			'no_found_rows'  => true,
		) );
		if ( ! empty( $posts ) ) {
			return $posts[0];
		}
	}

	return null;
}

/**
 * Posts flagged "_kumo_popular" for the homepage Popular block.
 */
function kumo_get_popular_posts( $count = 4, $exclude = array() ) {
	return get_posts( array(
		'posts_per_page' => $count,
		'meta_key'       => '_kumo_popular',
		'meta_value'     => '1',
		'post__not_in'   => $exclude,
		'no_found_rows'  => true,
	) );
}

/**
 * Social share links for the single-post rail.
 */
function kumo_share_links( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$url     = urlencode( get_permalink( $post_id ) );
	$title   = urlencode( get_the_title( $post_id ) );

	return array(
		'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
		'twitter'  => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
		'pinterest'=> "https://pinterest.com/pin/create/button/?url={$url}&description={$title}",
		'email'    => "mailto:?subject={$title}&body={$url}",
	);
}

/**
 * Render a category thumbnail <img>, using kumo_get_category_image_url()
 * from inc/category-meta.php with a safe placeholder fallback.
 */
function kumo_category_thumb( $term_id, $size = 'kumo-card' ) {
	$url = function_exists( 'kumo_get_category_image_url' ) ? kumo_get_category_image_url( $term_id, $size ) : '';
	if ( $url ) {
		echo '<img src="' . esc_url( $url ) . '" alt="" loading="lazy" />';
	}
}
