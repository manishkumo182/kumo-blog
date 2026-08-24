<?php
/**
 * The header for our theme.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
	<div class="kumo-container site-header__top">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-branding__logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding__wordmark">
					<?php bloginfo( 'name' ); ?>
					<small><?php esc_html_e( 'Blog', 'kumo-blog' ); ?></small>
				</a>
			<?php endif; ?>
			<span class="site-tagline">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
				<?php echo esc_html( date_i18n( 'l, F j, Y' ) ); ?>
			</span>
		</div>

		<form role="search" method="get" class="header-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			<input type="search" name="s" placeholder="<?php echo esc_attr( get_theme_mod( 'kumo_search_placeholder', 'Search news, article, research...' ) ); ?>" value="<?php echo get_search_query(); ?>" />
		</form>

		<div class="site-header__actions">
			<?php $submit_post_page = kumo_get_submit_post_page(); ?>
			<a href="<?php echo esc_url( is_user_logged_in() && $submit_post_page ? get_permalink( $submit_post_page ) : wp_login_url() ); ?>" class="icon-btn" aria-label="<?php esc_attr_e( 'Account', 'kumo-blog' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
			</a>
			<?php $saved_page = get_page_by_path( 'saved-posts' ); ?>
			<a href="<?php echo esc_url( $saved_page ? get_permalink( $saved_page ) : home_url( '/' ) ); ?>" class="icon-btn" aria-label="<?php esc_attr_e( 'Saved posts', 'kumo-blog' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
			</a>
			<a href="<?php echo esc_url( get_theme_mod( 'kumo_subscribe_url', '#newsletter' ) ); ?>" class="btn-subscribe">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
				<?php echo esc_html( get_theme_mod( 'kumo_subscribe_text', 'Subscribe' ) ); ?>
			</a>
		</div>
	</div>

	<nav id="site-navigation" class="main-navigation kumo-container">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'kumo-blog' ); ?></button>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'fallback_cb'    => false,
		) );
		?>
	</nav>
</header>

<div id="content" class="site-content kumo-container">
