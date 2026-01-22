<?php
/**
 * Kumo Theme Functions
 */

/**
 * --------------------------------------------------
 * Include library files
 * --------------------------------------------------
 */
require_once 'lib/taxonomy.php';
require_once 'lib/enqueue-scripts.php';
require_once 'lib/disable-hide-wp-feats.php';
require_once 'lib/single-category-per-post.php';
require_once 'lib/utils.php';
require_once 'lib/setup.php';
require_once 'lib/acf.php';
require_once 'lib/cf7.php';
require_once 'lib/shortcodes.php';
require_once 'lib/replace-image-urls.php';
require_once 'lib/tailwind-nav-walker.php';
require_once 'lib/post-types.php';
require_once 'lib/updraftplus.php';
require_once 'lib/image-optimization-widget.php';


/**
 * --------------------------------------------------
 * Register Feature Categories Taxonomy
 * --------------------------------------------------
 */
function kumo_register_features_taxonomy() {

    $labels = [
        'name'              => _x('Feature Categories', 'taxonomy general name', 'kumo'),
        'singular_name'     => _x('Feature Category', 'taxonomy singular name', 'kumo'),
        'search_items'      => __('Search Categories', 'kumo'),
        'all_items'         => __('All Categories', 'kumo'),
        'parent_item'       => __('Parent Category', 'kumo'),
        'parent_item_colon' => __('Parent Category:', 'kumo'),
        'edit_item'         => __('Edit Category', 'kumo'),
        'update_item'       => __('Update Category', 'kumo'),
        'add_new_item'      => __('Add New Category', 'kumo'),
        'new_item_name'     => __('New Category Name', 'kumo'),
        'menu_name'         => __('Categories', 'kumo'),
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'feature-category'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('feature_category', ['features'], $args);
}
add_action('init', 'kumo_register_features_taxonomy');


/**
 * --------------------------------------------------
 * Enqueue Theme Assets
 * --------------------------------------------------
 */
// function kumo_theme_setup() {
//     // Register menu locations
//     register_nav_menus([
//         'header' => __('Header Menu', 'kumo'),
//         'footer' => __('Footer Menu', 'kumo'),
//     ]);

//     // Theme supports
//     add_theme_support('post-thumbnails');
//     add_theme_support('title-tag');
//     add_theme_support('html5', ['search-form', 'gallery', 'caption']);
// }
// add_action('after_setup_theme', 'kumo_theme_setup');

function kumo_enqueue_assets() {

    $css_file = get_template_directory() . '/assets/css/app.css';
    $js_file  = get_template_directory() . '/assets/js/script.js';

    // Main CSS
    wp_enqueue_style(
        'kumo-main-css',
        get_template_directory_uri() . '/assets/css/app.css',
        [],
        file_exists($css_file) ? filemtime($css_file) : null
    );

    // Main JS
    wp_enqueue_script(
        'kumo-main-js',
        get_template_directory_uri() . '/assets/js/script.js',
        [],
        file_exists($js_file) ? filemtime($js_file) : null,
        true
    );

    // Alpine.js (load once)
    wp_enqueue_script(
        'alpine',
        'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js',
        [],
        null,
        true
    );

    // Swiper
    wp_enqueue_style(
        'swiper-css',
        'https://unpkg.com/swiper/swiper-bundle.min.css',
        [],
        null
    );

    wp_enqueue_script(
        'swiper-js',
        'https://unpkg.com/swiper/swiper-bundle.min.js',
        [],
        null,
        true
    );

    // Masonry (WordPress core)
    wp_enqueue_script('masonry');
}
add_action('wp_enqueue_scripts', 'kumo_enqueue_assets');


/**
 * --------------------------------------------------
 * SVG Icon Helper
 * --------------------------------------------------
 */
function kumo_svg_icon($icon, $class = '') {
    $path = get_template_directory() . '/assets/icons/' . $icon . '.svg';

    if (file_exists($path)) {
        echo '<span class="' . esc_attr($class) . '">';
        include $path;
        echo '</span>';
    }
}


/**
 * --------------------------------------------------
 * Modify Features Query
 * --------------------------------------------------
 */
add_action('pre_get_posts', function ($query) {
    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->get('post_type') === 'features'
    ) {
        $query->set('posts_per_page', 3);
    }
});
