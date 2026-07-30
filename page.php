<?php
/**
 * Static page template.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();
	?>
	<article <?php post_class(); ?>>
		<header class="archive-header">
			<h1 class="archive-header__title"><?php the_title(); ?></h1>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="single-hero__media"><?php the_post_thumbnail( 'kumo-hero' ); ?></div>
		<?php endif; ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</article>
	<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
<?php endwhile; ?>

<?php get_footer(); ?>
