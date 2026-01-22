<?php
if (is_home()) {
  $blog_page_id = get_option('page_for_posts');
  $page_components = get_field('page_components', $blog_page_id);
} else {
  $page_components = get_field('page_components');
}
if (is_array($page_components) && !empty($page_components)) {
  $page_components = (array) $page_components;
} else {
  $page_components = array();
}

if (isset($page_components[0])) {
  $page_components = $page_components[0];
  $layouts = array_map(function ($page_component) {
    return $page_component['acf_fc_layout'];
  }, $page_components);
  if (count(array_intersect(['reviews'], $layouts))) {
    add_action('wp_enqueue_scripts', 'enqueue_swiper');
  }
}

get_header();

if ($page_components) {
  foreach ($page_components as $page_component) {
    $component_name = str_replace('_', '-', $page_component['acf_fc_layout']);
    $fields = $page_component;
    $path = get_page_component_path($component_name);
    if (file_exists($path)) {
      include $path;
    } else {
      echo "<section id='$component_name'>
        <div class='px-4 py-20 my-10 bg-gray-200 '>
          <div class='container text-2xl text-red-500'>
            <h2>Component not found: $component_name</h2>
          </div>
        </div>
      </section>";
    }
  }
}

get_footer();