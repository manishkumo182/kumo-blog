<?php

/**
 * Turns off the rating function in woocommerce
 */
add_action('admin_init', 'remove_or_handle_wp_defaults', 100);
function remove_or_handle_wp_defaults()
{
  // Redirect any user trying to access comments page
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url());
    exit;
  }
  // Remove comments metabox from dashboard
  // Disable support for comments and trackbacks in post types
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
  foreach (get_post_types() as $post_type) {
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
  //Remove wp_block_support
  remove_submenu_page('themes.php', 'edit.php?post_type=wp_block');
}
// Remove comments links from admin bar
add_action('init', function () {
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
  //Disable default field for pages
  remove_post_type_support('page', 'editor');
  remove_post_type_support('page', 'thumbnail');
});
/**
 * Close comments on the front and admin
 */
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
// Remove comments page in menu
add_action('admin_menu', function () {
  remove_menu_page('edit-comments.php');
});
//Remove Comment Menu from admin bar
add_action('wp_before_admin_bar_render', function () {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
});

/**
 * Disable Gutenberg in the whole site
 */
add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('global-styles');
  wp_dequeue_style('classic-theme-styles');
}, 20);

/**
 * Disable access to ACF for safety reason 
 * Only accessible to "Super Admin"
 */
function remove_acf_menu_for_non_super_admins()
{
  // Check if the current user is not a super admin
  if (!is_super_admin()) {
    // Remove the ACF menu
    remove_menu_page('edit.php?post_type=acf-field-group');
  }
}
add_action('admin_menu', 'remove_acf_menu_for_non_super_admins', 99);
