<?php

// Always set the return format to be id, since that is the 
// only field required by wp_get_attachment_image
add_filter('acf/load_field/type=image', 'return_format_id');
function return_format_id($field) {
  $field['return_format'] = 'id';
  return $field;
}

// Always disable selecting archives from the page link field
// Only need pages 99% of the time
add_filter('acf/load_field/type=page_link', 'disable_archive_urls');
function disable_archive_urls($field) {
  $field['allow_archives'] = 0;
  return $field;
}

// Just a quick way to add a message to a global component
add_filter('acf/load_field/type=message', 'add_global_component_message');
function add_global_component_message($field) {
  if ($field['label'] == 'Global' || $field['label'] == 'global') {
    $field['label'] = 'Note';
    $field['message'] = 'The content for this component can be edited under Global Components on the left sidebar.';
  }
  return $field;
}

// Set ACF 5 license key on theme activation.
add_action('after_switch_theme', 'activate_acf_pro');
function activate_acf_pro() {
  if (function_exists('get_field')) {
    $acf_pro_activation_key = 'b3JkZXJfaWQ9MTMzMzQ1fHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxOC0wNi0xOCAwNTozOToxOQ==';

    if (!get_option('acf_pro_license')) {
      // Connect to API.
      $post = array(
        'acf_license' => trim($acf_pro_activation_key),
        'acf_version' => acf_get_setting('version'),
        'wp_name' => get_bloginfo('name'),
        'wp_url' => home_url(),
        'wp_version' => get_bloginfo('version'),
        'wp_language' => get_bloginfo('language'),
        'wp_timezone' => get_option('timezone_string'),
      );
      $response = acf_updates()->request('v2/plugins/activate?p=pro', $post);
      // Check response is expected JSON array (not string).
      if (!is_string($response) && $response['status'] == 1) {
        // Update license.
        acf_pro_update_license($response['license']);
        // Refresh plugins transient to fetch new update data.
        acf_updates()->refresh_plugins_transient();
      }
  }
  }
}

// Make all 
// 1. Fexible content rows
// 2. Repeater fields with the 'collapse' class
// collapsed by default on page load
add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
  if (isset($_GET['message']) && $_GET['message'] != 1) {
    ?>
    <script type="text/javascript">
      (function ($) {
        $(document).ready(function () {
          $(".layout:not(.acf-clone):not(.-collapsed)").each(function (index) {
            $(this).children('.acf-fc-layout-handle').click();
          });
          $('.acf-field-repeater.collapse .acf-row:not(.acf-clone)').addClass('-collapsed');
        });
      })(jQuery);
    </script>
    <?php
  }
}