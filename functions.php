<?php
/**
 * Kumo Blog theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'KUMO_VERSION', '1.0.0' );
define( 'KUMO_DIR', get_template_directory() );
define( 'KUMO_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function kumo_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 60,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_post_type_support( 'post', 'excerpt' );

	set_post_thumbnail_size( 800, 600, true );
	add_image_size( 'kumo-hero', 1200, 500, true );
	add_image_size( 'kumo-card', 500, 375, true );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'kumo-blog' ),
	) );
}
add_action( 'after_setup_theme', 'kumo_setup' );

/**
 * Widget / footer areas — editable from Appearance → Widgets.
 */
function kumo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Column 1', 'kumo-blog' ),
		'id'            => 'footer-1',
		'description'   => __( 'First footer column (e.g. Address).', 'kumo-blog' ),
		'before_widget' => '<div class="footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-heading">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Column 2', 'kumo-blog' ),
		'id'            => 'footer-2',
		'description'   => __( 'Second footer column (e.g. Partnership).', 'kumo-blog' ),
		'before_widget' => '<div class="footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-heading">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'kumo_widgets_init' );

/**
 * Scripts & styles.
 */
function kumo_scripts() {
	wp_enqueue_style( 'kumo-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'kumo-style', get_stylesheet_uri(), array(), filemtime( KUMO_DIR . '/style.css' ) );
	wp_enqueue_script( 'kumo-main', KUMO_URI . '/assets/js/main.js', array(), filemtime( KUMO_DIR . '/assets/js/main.js' ), true );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular( 'post' ) ) {
		wp_enqueue_script( 'kumo-likes', KUMO_URI . '/assets/js/likes.js', array(), filemtime( KUMO_DIR . '/assets/js/likes.js' ), true );
		wp_localize_script( 'kumo-likes', 'kumoLikes', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );

		wp_enqueue_script( 'kumo-shares', KUMO_URI . '/assets/js/shares.js', array(), filemtime( KUMO_DIR . '/assets/js/shares.js' ), true );
		wp_localize_script( 'kumo-shares', 'kumoShares', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	if ( is_page_template( 'page-saved.php' ) ) {
		wp_enqueue_script( 'kumo-saved-posts', KUMO_URI . '/assets/js/saved-posts.js', array(), filemtime( KUMO_DIR . '/assets/js/saved-posts.js' ), true );
		wp_localize_script( 'kumo-saved-posts', 'kumoSaved', array(
			'restUrl' => esc_url_raw( rest_url() ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'kumo_scripts' );

/**
 * Includes.
 */
require KUMO_DIR . '/inc/customizer.php';
require KUMO_DIR . '/inc/category-meta.php';
require KUMO_DIR . '/inc/meta-boxes.php';
require KUMO_DIR . '/inc/template-tags.php';
require KUMO_DIR . '/inc/subscribers.php';
require KUMO_DIR . '/inc/likes.php';
require KUMO_DIR . '/inc/shares.php';
require KUMO_DIR . '/inc/contact.php';
