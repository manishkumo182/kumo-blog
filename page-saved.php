<?php
/**
 * Template Name: Saved Posts
 * Reads the visitor's saved-post IDs from localStorage (set by the Save
 * button on single posts) and renders them via the REST API. Nothing is
 * stored server-side — this list is per-browser.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<header class="archive-header">
	<h1 class="archive-header__title"><?php the_title(); ?></h1>
	<p class="archive-header__desc"><?php esc_html_e( 'Articles you\'ve saved on this device.', 'kumo-blog' ); ?></p>
</header>

<p id="saved-posts-empty"><?php esc_html_e( 'You haven\'t saved any articles yet. Look for the bookmark icon at the top of any article.', 'kumo-blog' ); ?></p>
<div class="post-grid" id="saved-posts-list"></div>

<?php get_footer(); ?>