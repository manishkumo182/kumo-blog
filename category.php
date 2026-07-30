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
	<div class="post-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content-card', null, array( 'show_excerpt' => false ) ); ?>
		<?php endwhile; ?>
	</div>

	<div class="pagination">
		<?php
		echo paginate_links( array(
			'prev_text' => __( '←', 'kumo-blog' ),
			'next_text' => __( '→', 'kumo-blog' ),
		) );
		?>
	</div>
<?php else : ?>
	<p><?php esc_html_e( 'No posts found in this category yet.', 'kumo-blog' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
