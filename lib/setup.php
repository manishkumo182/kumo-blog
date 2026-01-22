<?php

/**
 * --------------------------------------------------
 * Theme Setup
 * --------------------------------------------------
 */
add_action('after_setup_theme', 'kumo_theme_setup');
function kumo_theme_setup() {

  // Register menu locations
  register_nav_menus([
    'header'   => __('Header Menu', 'kumo'),
    'footer'   => __('Footer Menu', 'kumo'),
    'footer_2' => __('Footer Menu 2', 'kumo'),
  ]);

  // Theme supports
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');

}


/**
 * --------------------------------------------------
 * Image Sizes
 * --------------------------------------------------
 */
add_image_size('480w', 480);
add_image_size('750w', 750);
add_image_size('1080w', 1080);
add_image_size('1920w', 1920);
add_image_size('3840w', 3840);

add_filter('intermediate_image_sizes_advanced', 'kumo_remove_image_sizes', 10, 2);
function kumo_remove_image_sizes($sizes, $metadata) {
  unset($sizes['medium_large']);
  unset($sizes['large']);
  unset($sizes['1536x1536']);
  unset($sizes['2048x2048']);
  return $sizes;
}


/**
 * --------------------------------------------------
 * Editor Capabilities
 * --------------------------------------------------
 */
add_action('init', function () {
  $editor = get_role('editor');
  if ($editor) {
    $editor->add_cap('edit_theme_options');
  }
});


/**
 * --------------------------------------------------
 * Excerpt Settings
 * --------------------------------------------------
 */
add_filter('excerpt_length', function () {
  return 30;
});

add_filter('excerpt_more', function () {
  return '...';
});


/**
 * --------------------------------------------------
 * ACF Options Pages
 * --------------------------------------------------
 */
if (class_exists('ACF')) {

  acf_add_options_page([
    'page_title' => __('Site Configuration', 'kumo'),
    'menu_title' => __('Site Configuration', 'kumo'),
    'redirect'   => false,
  ]);

  acf_add_options_page([
    'page_title' => __('Global Components', 'kumo'),
    'menu_title' => __('Global Components', 'kumo'),
    'redirect'   => false,
    'icon_url'   => 'dashicons-screenoptions',
  ]);
}


/**
 * --------------------------------------------------
 * Prevent Yoast Sitemap Ping on ACF Sync
 * --------------------------------------------------
 */
add_action('admin_init', 'kumo_prevent_yoast_ping_on_acf_sync');
function kumo_prevent_yoast_ping_on_acf_sync() {
  if (
    isset($_GET['acfsync']) ||
    (isset($_GET['action']) && $_GET['action'] === 'acfsync') ||
    (isset($_GET['action2']) && $_GET['action2'] === 'acfsync')
  ) {
    add_filter('wpseo_allow_xml_sitemap_ping', '__return_false');
  }
}


/**
 * --------------------------------------------------
 * Reading Time Meta
 * --------------------------------------------------
 */
add_action('save_post_post', 'kumo_update_post_reading_time', 10, 2);
function kumo_update_post_reading_time($post_ID, $post) {

  $average_wpm = 200;
  $word_count = str_word_count(strip_tags($post->post_content));
  $reading_time = ceil($word_count / $average_wpm);

  update_post_meta($post_ID, 'reading_time', $reading_time);
}


/**
 * --------------------------------------------------
 * Redirect Category Pages
 * --------------------------------------------------
 */
add_action('template_redirect', function () {
  if (is_category()) {
    wp_redirect(home_url(), 301);
    exit;
  }
});


/**
 * --------------------------------------------------
 * Auto Add IDs to Headings
 * --------------------------------------------------
 */
add_filter('the_content', 'kumo_auto_id_headings');
function kumo_auto_id_headings($content) {

  return preg_replace_callback(
    '/(<h[1-6](.*?))>(.*?)(<\/h[1-6]>)/i',
    function ($matches) {
      if (!stripos($matches[0], 'id=')) {
        return $matches[1] . $matches[2] .
          ' id="' . sanitize_title($matches[3]) . '">' .
          $matches[3] . $matches[4];
      }
      return $matches[0];
    },
    $content
  );
}


/**
 * --------------------------------------------------
 * Wrap Embedded Media
 * --------------------------------------------------
 */
add_filter('embed_oembed_html', 'kumo_wrap_embed_with_div');
function kumo_wrap_embed_with_div($html) {

  ob_start();
  include get_component_path('global/video-component/start');
  echo $html;
  include get_component_path('global/video-component/end');

  return ob_get_clean();
}
