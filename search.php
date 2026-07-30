<?php
/**
 * Search results.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<header class="archive-header">
	<h1 class="archive-header__title">
		<?php
		/* translators: %s: search query */
		printf( esc_html__( 'Search Results for: %s', 'kumo-blog' ), '<em>' . esc_html( get_search_query() ) . '</em>' );
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
	<p><?php esc_html_e( 'No results found. Try a different search.', 'kumo-blog' ); ?></p>
	<?php get_search_form(); ?>
<?php endif; ?>

<?php get_footer(); ?>
