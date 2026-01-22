<?php  /** Template Name: Homepage */

get_header();

// get_template_part('components/page/about-us/about-us');
get_template_part('components/page/banner/banner');



get_template_part('components/page/products/products');
// Reset global post so products render correctly
wp_reset_postdata();
get_template_part('components/page/features/features');

get_template_part('components/page/features-hack/features-hack');
get_template_part('components/page/features-recent/features-recent');
// get_template_part('components/page/newsletter/newsletter');
get_template_part('components/page/subscription/subscription');
get_footer();