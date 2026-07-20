<?php
function kumo_enqueue_scripts() {
    $dist = get_template_directory_uri() . '/dist';

    // CSS
    wp_enqueue_style(
        'kumo-styles', 
        $dist . '/styles.f29b2ccc6acfa216594f.css',
        [], 
        '1.0'
    );

    // JS
    wp_enqueue_script(
        'kumo-main', 
        $dist . '/main.51aee64369cdac5fe41b.js', 
        ['jquery'], 
        '1.0', 
        true
    );

    wp_enqueue_script(
        'kumo-styles-js', 
        $dist . '/styles.356ff9d7261ce2da25ad.js', 
        [], 
        '1.0', 
        true
    );
}
add_action('wp_enqueue_scripts', 'kumo_enqueue_scripts');
