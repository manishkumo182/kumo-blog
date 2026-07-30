<?php
/**
 * Post card used across home, category and related-articles grids.
 *
 * @param array $args {
 *     @type bool $show_excerpt Whether to print the trimmed excerpt. Default false.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$show_excerpt = ! empty( $args['show_excerpt'] );
?>
<article <?php post_class( 'post-card' ); ?>>
	<a href="<?php the_permalink(); ?>" class="post-card__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'kumo-card' ); ?>
		<?php endif; ?>
	</a>
	<div class="post-card__meta"><?php kumo_author_meta(); ?></div>
	<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php if ( $show_excerpt ) : ?>
		<p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
		<a href="<?php the_permalink(); ?>" class="post-card__readmore"><?php esc_html_e( 'View Post →', 'kumo-blog' ); ?></a>
	<?php endif; ?>
</article>
