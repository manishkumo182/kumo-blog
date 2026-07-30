<?php
/**
 * Generic archive (tags, author, date). Category archives use category.php.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-home">&larr; <?php esc_html_e( 'Back to home', 'kumo-blog' ); ?></a>

<header class="archive-header">
	<h1 class="archive-header__title"><?php the_archive_title(); ?></h1>
	<?php the_archive_description( '<div class="archive-header__desc">', '</div>' ); ?>
</header>

<?php if ( have_posts() ) : ?>
	<div class="post-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content-card', null, array( 'show_excerpt' => false ) ); ?>
		<?php endwhile; ?>
	</div>
	<div class="pagination">
		<?php echo paginate_links( array( 'prev_text' => __( '←', 'kumo-blog' ), 'next_text' => __( '→', 'kumo-blog' ) ) ); ?>
	</div>
<?php else : ?>
	<p><?php esc_html_e( 'No posts found.', 'kumo-blog' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
