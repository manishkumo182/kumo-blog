<?php

/**
 * Repeat an array n times.
 * Useful for creating dummy data out of only a few items
 */
function repeatArray($array, $n) {
  $result = [];
  $eCount = count($array);
  for ($j = 0; $j < $n; $j++) {
    for ($i = 0; $i < $eCount; $i++) {
      $result[] = $array[$i];
    }
  }
  return $result;
}
;

/**
 * Error log variable of any type
 */
if (!function_exists("elog")) {
  function elog($var) {
    error_log(print_r($var, true));
  }
}
/**
 * Dump a variable of any type with pre formatting
 */
function vdump($var) {
  echo '<pre>';
  var_dump($var);
  echo '</pre>';
}


function get_svg($svg_name) {
  $file = get_stylesheet_directory() . '/src/img/svgs/' . $svg_name . '.svg';
  if (file_exists($file)) {
    return file_get_contents($file);
  }
}

function get_icon($icon_name, $type = 'outline') {
  return get_svg("heroicons/$type/$icon_name");
}

function get_social_icon($icon_name) {
  return get_svg('socials/' . $icon_name);
}

function json_encode_alpine($data) {
  return str_replace('"', "'", json_encode($data));
}

function get_img($image_id, $sizes, $atts = []) {
  if (!isset($atts['sizes'])) {
    $atts['sizes'] = $sizes;
  }
  if (!isset($atts['class'])) {
    $atts['class'] = 'h-full w-full object-cover';
  }
  return wp_get_attachment_image($image_id, 'full', false, $atts);
}

function get_img_url($img_name) {
  return get_template_directory_uri() . '/src/img/' . $img_name;
}

function get_component_path($component_path) {
  return get_template_directory() . "/components/$component_path.php";
}
function get_component_file_path($component_path) {
  return get_template_directory() . "/components/$component_path";
}

function get_page_component_path($component_name) {
  return get_component_path("page/$component_name/$component_name");
}

// this is only for sites with page components and flexible layout
// function page_has_components($components) {
//   $page_components = (array) get_field('page_components');
//   if (!$page_components[0]) {
//     return false;
//   }
//   $layouts = array_map(function ($page_component) {
//     return str_replace('_', '-', $page_component['acf_fc_layout']);
//   }, $page_components);
//   return count(array_intersect($components, $layouts)) > 0;
// }

function paginate_links_custom($url_append = '', $end_size = 1, $mid_size = 2, $prev_next = true) {
  $page_var = is_front_page() ? 'page' : 'paged';
  $big = 9999999;
  $args = array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big)) . $url_append),
    'format' => '?paged=%#%',
    'total' => get_query_var('max_num_pages') ?? 1,
    'current' => max(1, get_query_var($page_var)),

    'prev_next' => $prev_next,
    'end_size' => $end_size,
    'mid_size' => $mid_size,
  );


  // Who knows what else people pass in $args.
  $total = (int) $args['total'];
  if ($total < 2) {
    return;
  }
  $current = $args['current'];

  $page_links = array();
  $page_links['prev'] = false;
  $page_links['next'] = false;
  $page_links['numbers'] = array();
  $dots = false;

  if ($args['prev_next'] && $current && $current > 1):
    $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
    $link = str_replace('%#%', $current - 1, $link);
    $link = esc_url(apply_filters('paginate_links', $link));
    $page_links['prev'] = $link;
  endif;

  for ($n = 1; $n <= $total; $n++):
    if ($n == $current):
      $page_links['numbers'][] = array(
        'type' => 'num',
        'current' => true,
        'num' => number_format_i18n($n),
      );
      $dots = true;
    else:
      if (($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)):
        $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
        $link = str_replace('%#%', $n, $link);
        $link = esc_url(apply_filters('paginate_links', $link));
        $page_links['numbers'][] = array(
          'type' => 'num',
          'current' => false,
          'num' => number_format_i18n($n),
          'link' => $link,
        );

        $dots = true;
      elseif ($dots):
        $page_links['numbers'][] = array(
          'type' => 'dots',
        );
        $dots = false;
      endif;
    endif;
  endfor;

  if ($args['prev_next'] && $current && $current < $total):
    $link = str_replace('%_%', $args['format'], $args['base']);
    $link = str_replace('%#%', $current + 1, $link);
    $link = esc_url(apply_filters('paginate_links', $link));
    $page_links['next'] = $link;
  endif;

  return $page_links;
}

function is_landing_page(): bool {
  return get_post_type() == 'landing-page' || isset($_GET['landing_page']);
}

function get_custom_excerpt($content, $length = 100) {
  // Remove all HTML tags
  $text_content = preg_replace('/<[^>]*>/', '', $content);
  // Replace multiple spaces with single space
  $text_content = preg_replace('/\s+/', ' ', $text_content);
  // Trim leading and trailing whitespace
  $excerpt = trim($text_content);

  // Check if $length is not provided or empty
  if ($length === '' || !is_numeric($length)) {
    return $text_content; // Return full content if $length is not valid
  }

  // If $length is provided and valid, truncate the excerpt if necessary
  if (strlen($excerpt) > $length) {
    $excerpt = substr($excerpt, 0, $length) . '...';
  }

  return $excerpt;
}
function get_global_component_button($button = [], $button_styles = []) {
  extract($button);
  extract($button_styles);
  include get_template_directory() . "/components/global/button/button.php";
}

function absolute_transition() {
  return 'x-transition:enter="delay-300 ease-in-out duration-300"
  x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
  x-transition:leave="ease-in-out duration-300 order-first" x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"';
}
