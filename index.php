<?php
/**
 * Fallback template (blog index, and safety net for any query WP can't
 * match to a more specific template).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<header class="archive-header">
	<h1 class="archive-header__title">
		<?php
		if ( is_home() && ! is_front_page() ) {
			esc_html_e( 'Latest Posts', 'kumo-blog' );
		} else {
			the_archive_title();
		}
		?>
	</h1>
</header>

<?php if ( have_posts() ) : ?>
	<div class="post-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content-card', null, array( 'show_excerpt' => true ) ); ?>
		<?php endwhile; ?>
	</div>
	<div class="pagination">
		<?php echo paginate_links( array( 'prev_text' => __( '←', 'kumo-blog' ), 'next_text' => __( '→', 'kumo-blog' ) ) ); ?>
	</div>
<?php else : ?>
	<p><?php esc_html_e( 'Nothing found.', 'kumo-blog' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
