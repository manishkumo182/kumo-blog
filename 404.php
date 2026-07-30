<?php
/**
 * 404 template.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<section class="section" style="text-align:center; padding-bottom:60px;">
	<h1 class="archive-header__title" style="font-size:64px;">404</h1>
	<p class="archive-header__desc"><?php esc_html_e( "The page you're looking for doesn't exist.", 'kumo-blog' ); ?></p>
	<div style="max-width:420px; margin:24px auto;">
		<?php get_search_form(); ?>
	</div>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-dark"><?php esc_html_e( 'Back to home', 'kumo-blog' ); ?></a>
</section>

<?php get_footer(); ?>
