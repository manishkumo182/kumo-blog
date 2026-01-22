<?php
get_header();

// Load the main content template part
get_template_part('components/global/generic/content');

// Call custom function with the post ID
if (is_single()) {
    da_get_post_views(get_the_ID());
}

get_footer();
