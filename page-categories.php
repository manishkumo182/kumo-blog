<?php
/**
 * Template Name: Categories
 * Lists every category on the site, linking through to each category archive.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$categories = get_categories( array(
	'hide_empty' => false,
	'orderby'    => 'name',
	'order'      => 'ASC',
	'exclude'    => array( get_option( 'default_category' ) ),
) );
?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-home">
	&larr; <?php esc_html_e( 'Back to home', 'kumo-blog' ); ?>
</a>

<header class="archive-header">
	<h1 class="archive-header__title"><?php the_title(); ?></h1>
</header>

<?php if ( ! empty( $categories ) ) : ?>
	<div class="category-strip">
		<?php foreach ( $categories as $cat ) : ?>
			<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="category-card">
				<span class="category-card__thumb"><?php kumo_category_thumb( $cat->term_id ); ?></span>
				<span>
					<span class="category-card__name"><?php echo esc_html( $cat->name ); ?></span><br />
					<span class="category-card__count">
						<?php if ( $cat->description ) : ?>
							<?php echo esc_html( $cat->description ); ?>
						<?php else : ?>
							<?php echo esc_html( number_format_i18n( $cat->count ) ); ?> <?php esc_html_e( 'posts', 'kumo-blog' ); ?>
						<?php endif; ?>
					</span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<p><?php esc_html_e( 'No categories yet.', 'kumo-blog' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
