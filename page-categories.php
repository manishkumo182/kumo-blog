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

$categories_per_page = 4;
$categories_total     = count( $categories );
$categories_pages     = max( 1, (int) ceil( $categories_total / $categories_per_page ) );
$categories_paged     = isset( $_GET['cpage'] ) ? absint( $_GET['cpage'] ) : 1;
$categories_paged     = min( max( 1, $categories_paged ), $categories_pages );
$categories_page_items = array_slice( $categories, ( $categories_paged - 1 ) * $categories_per_page, $categories_per_page );

$popular = kumo_get_popular_posts( 5 );
if ( empty( $popular ) ) {
	$popular = get_posts( array( 'posts_per_page' => 5, 'ignore_sticky_posts' => true ) );
}
?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-home">
	&larr; <?php esc_html_e( 'Back to home', 'kumo-blog' ); ?>
</a>

<header class="archive-header">
	<h1 class="archive-header__title"><?php the_title(); ?></h1>
</header>

<div class="categories-layout">
	<div class="categories-main">
		<?php if ( ! empty( $categories_page_items ) ) : ?>
			<?php foreach ( $categories_page_items as $cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="category-row">
					<span class="category-row__body">
						<span class="category-row__meta">
							<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
							<?php echo esc_html( number_format_i18n( $cat->count ) ); ?> <?php esc_html_e( 'posts', 'kumo-blog' ); ?>
						</span>
						<span class="category-row__name"><?php echo esc_html( $cat->name ); ?></span>
						<?php if ( $cat->description ) : ?>
							<span class="category-row__desc"><?php echo esc_html( $cat->description ); ?></span>
						<?php endif; ?>
					</span>
					<span class="category-row__thumb"><?php kumo_category_thumb( $cat->term_id ); ?></span>
				</a>
			<?php endforeach; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No categories yet.', 'kumo-blog' ); ?></p>
		<?php endif; ?>

		<?php if ( $categories_pages > 1 ) : ?>
			<div class="pagination pagination--prevnext">
				<?php if ( $categories_paged > 1 ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'cpage', $categories_paged - 1 ) ); ?>">&laquo; <?php esc_html_e( 'Previous', 'kumo-blog' ); ?></a>
				<?php endif; ?>
				<?php if ( $categories_paged < $categories_pages ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'cpage', $categories_paged + 1 ) ); ?>"><?php esc_html_e( 'Next', 'kumo-blog' ); ?> &raquo;</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $popular ) ) : ?>
		<aside class="categories-sidebar">
			<h2 class="categories-sidebar__title"><?php esc_html_e( 'Most Read', 'kumo-blog' ); ?></h2>
			<ol class="most-read-list">
				<?php foreach ( $popular as $i => $item ) : ?>
					<li class="most-read-list__item">
					
						<a href="<?php echo esc_url( get_permalink( $item ) ); ?>" class="most-read-list__thumb">
							<?php echo get_the_post_thumbnail( $item, 'thumbnail' ); ?>
						</a>
						<a href="<?php echo esc_url( get_permalink( $item ) ); ?>" class="most-read-list__title"><?php echo esc_html( get_the_title( $item ) ); ?></a>
					</li>
				<?php endforeach; ?>
			</ol>
		</aside>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
