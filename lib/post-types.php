<?php

// Makes urls with custom post type pagination, e.g. /resources/page/2
// query a page and not the post type (e.g. resource)
add_action('init', function () {
  add_rewrite_rule(
    '(.?.+?)/page/?([0-9]{1,})/?$',
    'index.php?pagename=$matches[1]&paged=$matches[2]',
    'top'
  );
});

add_action('init', 'register_custom_post_types');
function register_custom_post_types() {


  register_post_type('Products', array(
    'labels' => array(
      'name' => 'Products',
      'singular_name' => 'Products',
      'add_new_item' => 'Add products',
      'edit_item' => 'Edit products',
    ),
    'rewrite' => array(
      'slug' => 'products',
      'with_front' => false,
    ),
    'has_archive' => false,
    'public' => true,
    'menu_icon' => 'dashicons-products',
    'supports' => array('title'),
  ));


  
  // register_post_type('Careers', array(
  //   'labels' => array(
  //     'name' => 'Careers',
  //     'singular_name' => 'Careers',
  //     'add_new_item' => 'Add careers',
  //     'edit_item' => 'Edit careers',
  //   ),
  //   'rewrite' => array(
  //     'slug' => 'careers',
  //     'with_front' => false,
  //   ),
  //   'has_archive' => false,
  //   'public' => true,
  //   'menu_icon' => 'dashicons-chart-line',
  //   'supports' => array('title'),
  // ));


  register_post_type('Features', array(
    'labels' => array(
      'name' => 'Features',
      'singular_name' => 'Features',
      'add_new_item' => 'Add features',
      'edit_item' => 'Edit features',
    ),
    'rewrite' => array(
      'slug' => 'features',
      'with_front' => false,
    ),
    'has_archive' => false,
    'public' => true,
    'menu_icon' => 'dashicons-groups',
    'supports' => array('title'),
  ));

  // register_post_type('Teams', array(
  //   'labels' => array(
  //     'name' => 'Teams',
  //     'singular_name' => 'Teams',
  //     'add_new_item' => 'Add teams',
  //     'edit_item' => 'Edit teams',
  //   ),
  //   'rewrite' => array(
  //     'slug' => 'teams',
  //     'with_front' => false,
  //   ),
  //   'has_archive' => false,
  //   'public' => true,
  //   'menu_icon' => 'dashicons-buddicons-buddypress-logo',
  //   'supports' => array('title'),
  // ));


}