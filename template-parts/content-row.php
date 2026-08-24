<?php
/**
 * Post row used on category archives: date, category / author, title, thumbnail.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$cats = get_the_category();
?>
<article <?php post_class( 'post-row' ); ?>>
	<div class="post-row__date">
		<span class="post-row__date-day"><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
		<span class="post-row__date-year"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
	</div>

	<div class="post-row__body">
		<div class="post-row__meta">
			<?php if ( ! empty( $cats ) ) : ?>
				<span class="post-row__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
				<span class="post-row__sep">/</span>
			<?php endif; ?>
			<span class="post-row__author"><?php the_author(); ?></span>
		</div>
		<h2 class="post-row__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>

	<a href="<?php the_permalink(); ?>" class="post-row__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'kumo-card' ); ?>
		<?php endif; ?>
	</a>
</article>
