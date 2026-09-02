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
 * Show 4 posts per page on category archives so Previous/Next pagination kicks in.
 */
function kumo_category_posts_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_category() ) {
		$query->set( 'posts_per_page', 4 );
	}
}
add_action( 'pre_get_posts', 'kumo_category_posts_per_page' );

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
require KUMO_DIR . '/inc/submit-post.php';
require KUMO_DIR . '/inc/security.php';

/**
 * -----------------------------------------------------------
 * GEO — Generative Engine Optimization
 * -----------------------------------------------------------
 * Makes the site easy for AI answer engines (ChatGPT, Perplexity,
 * Claude, Gemini, etc.) to crawl, understand and cite:
 *  - robots.txt explicitly welcomes AI answer-engine crawlers
 *  - /llms.txt gives them a clean, always-current summary of the site
 *  - the 404 page keeps both humans and bots on a useful path instead
 *    of a dead end, and is marked noindex so it never gets indexed
 */

/**
 * Find the live URL for a page built from a specific page template,
 * regardless of what slug the page was given.
 */
function kumo_geo_page_url( $template ) {
	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => $template,
		'fields'         => 'ids',
	) );
	return $pages ? get_permalink( $pages[0] ) : '';
}

/**
 * Append AI-crawler rules to WordPress's virtual robots.txt.
 */
function kumo_geo_robots_txt( $output, $public ) {
	if ( '0' === (string) $public ) {
		return $output; // "Discourage search engines" is on — leave WP's blanket Disallow alone.
	}

	$output .= "\n# --- GEO: AI answer engines -------------------------------\n";
	$output .= "# These crawl to answer questions and cite the source back.\n";
	foreach ( array( 'OAI-SearchBot', 'ChatGPT-User', 'PerplexityBot', 'Perplexity-User', 'Claude-User', 'Claude-SearchBot', 'Google-Extended' ) as $bot ) {
		$output .= "User-agent: {$bot}\nAllow: /\n\n";
	}

	$output .= "# --- GEO: AI model-training crawlers ----------------------\n";
	$output .= "# Allowed so this content can be cited from these models too.\n";
	$output .= "# Change a line to \"Disallow: /\" if you'd rather that bot not train on this site.\n";
	foreach ( array( 'GPTBot', 'ClaudeBot', 'CCBot', 'meta-externalagent' ) as $bot ) {
		$output .= "User-agent: {$bot}\nAllow: /\n\n";
	}

	$output .= "# Machine-readable site summary for LLMs\n";
	$output .= '# ' . home_url( '/llms.txt' ) . "\n";

	return $output;
}
add_filter( 'robots_txt', 'kumo_geo_robots_txt', 10, 2 );

/**
 * Serve /llms.txt: a short Markdown summary of the site — who it is,
 * what it covers, and where the important pages and freshest posts
 * live — built live from the site's own data so it never goes stale.
 * Spec: https://llmstxt.org
 */
function kumo_geo_llms_txt() {
	$path = trim( (string) parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	if ( 'llms.txt' !== $path ) {
		return;
	}

	nocache_headers();
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: noindex' );

	$name        = get_bloginfo( 'name' );
	$description = get_bloginfo( 'description' );

	echo '# ' . $name . "\n\n";
	echo '> ' . ( $description ? $description : $name . ' — an editorial blog.' ) . "\n\n";

	echo "## Key pages\n";
	echo '- [Home](' . home_url( '/' ) . ")\n";
	$about = kumo_geo_page_url( 'page-about.php' );
	if ( ! $about ) {
		$about_page = get_page_by_path( 'about' );
		if ( $about_page ) {
			$about = get_permalink( $about_page );
		}
	}
	if ( $about ) {
		echo '- [About](' . $about . ")\n";
	}
	$categories_page = kumo_geo_page_url( 'page-categories.php' );
	if ( $categories_page ) {
		echo '- [Categories](' . $categories_page . ")\n";
	}
	$contact = kumo_geo_page_url( 'page-contact.php' );
	if ( $contact ) {
		echo '- [Contact](' . $contact . ")\n";
	}

	$cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC', 'number' => 12 ) );
	if ( $cats ) {
		echo "\n## Categories\n";
		foreach ( $cats as $cat ) {
			echo '- [' . html_entity_decode( $cat->name, ENT_QUOTES ) . '](' . get_category_link( $cat ) . '): ' . $cat->count . " posts\n";
		}
	}

	$recent = get_posts( array( 'numberposts' => 10, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
	if ( $recent ) {
		echo "\n## Recent posts\n";
		foreach ( $recent as $p ) {
			echo '- [' . html_entity_decode( get_the_title( $p ), ENT_QUOTES ) . '](' . get_permalink( $p ) . '): ' . html_entity_decode( wp_trim_words( get_the_excerpt( $p ), 20, '…' ), ENT_QUOTES ) . "\n";
		}
	}

	echo "\n## Sitemap\n- [XML sitemap](" . home_url( '/wp-sitemap.xml' ) . ")\n";

	exit;
}
add_action( 'template_redirect', 'kumo_geo_llms_txt', 0 );

/**
 * Keep the 404 page out of AI/search indexes — it has no unique content
 * of its own and shouldn't compete with real pages for a citation.
 */
function kumo_geo_404_noindex( $robots ) {
	if ( is_404() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'kumo_geo_404_noindex' );
