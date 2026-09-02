<?php
/**
 * 404 template.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$popular = kumo_get_popular_posts( 4 );
if ( empty( $popular ) ) {
	$popular = get_posts( array( 'posts_per_page' => 4, 'ignore_sticky_posts' => true ) );
}
$categories = get_categories( array( 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC', 'number' => 6 ) );
?>

<section class="section" style="text-align:center; padding-bottom:24px;">
	<h1 class="archive-header__title" style="font-size:64px;">404</h1>
	<p class="archive-header__desc"><?php esc_html_e( "The page you're looking for doesn't exist — it may have been moved or removed.", 'kumo-blog' ); ?></p>
	<div style="max-width:420px; margin:24px auto;">
		<?php get_search_form(); ?>
	</div>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-dark"><?php esc_html_e( 'Back to home', 'kumo-blog' ); ?></a>
</section>

<?php if ( $categories ) : ?>
<section class="section" style="text-align:center; padding-top:0; padding-bottom:24px;">
	<p class="archive-header__desc"><?php esc_html_e( 'Or browse by category:', 'kumo-blog' ); ?></p>
	<div>
		<?php foreach ( $categories as $cat ) : ?>
			<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="btn-dark" style="display:inline-block; margin:4px;"><?php echo esc_html( $cat->name ); ?></a>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( $popular ) : ?>
<section class="section">
	<header class="archive-header">
		<h2 class="archive-header__title"><?php esc_html_e( 'Popular articles', 'kumo-blog' ); ?></h2>
	</header>
	<div class="post-grid">
		<?php foreach ( $popular as $post ) : setup_postdata( $post ); ?>
			<?php get_template_part( 'template-parts/content-card', null, array( 'show_excerpt' => true ) ); ?>
		<?php endforeach; wp_reset_postdata(); ?>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
