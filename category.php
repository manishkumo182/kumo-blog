<?php
/**
 * Category archive: back-to-home button, category header, post grid, pagination.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
$term = get_queried_object();
?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-home">
	&larr; <?php esc_html_e( 'Back to home', 'kumo-blog' ); ?>
</a>

<header class="archive-header">
	<h1 class="archive-header__title"><?php echo esc_html( $term->name ); ?></h1>
	
</header>

<?php if ( have_posts() ) : ?>
	<div class="post-list">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content-row' ); ?>
		<?php endwhile; ?>
	</div>

	<div class="pagination pagination--prevnext">
		<?php previous_posts_link( '&laquo; ' . __( 'Previous', 'kumo-blog' ) ); ?>
		<?php next_posts_link( __( 'Next', 'kumo-blog' ) . ' &raquo;' ); ?>
	</div>
<?php else : ?>
	<p><?php esc_html_e( 'No posts found in this category yet.', 'kumo-blog' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
