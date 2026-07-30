<?php
/**
 * Homepage: Hero, Browse by Category, Latest posts grid, Popular block.
 * Content is fully dashboard-driven — see the "Kumo Blog — Homepage
 * Placement" box on each post, and Posts → Categories for category images.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$hero_post = kumo_get_hero_post();
$exclude_ids = $hero_post ? array( $hero_post->ID ) : array();
$blog_page_id = (int) get_option( 'page_for_posts' );
$blog_url = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );
$categories_page = get_page_by_path( 'categories' );
$categories_url = $categories_page ? get_permalink( $categories_page ) : $blog_url;
?>

<?php if ( $hero_post ) : setup_postdata( $hero_post ); ?>
<section class="section hero-post">
	<a href="<?php echo esc_url( get_permalink( $hero_post ) ); ?>" class="hero-post__media">
		<?php echo get_the_post_thumbnail( $hero_post, 'kumo-hero' ); ?>
	</a>
	<div class="hero-post__meta">
		<div class="hero-post__meta-left">
			<?php
			$cats = get_the_category( $hero_post->ID );
			if ( ! empty( $cats ) ) :
				?>
				<span class="tag-pill"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
			<?php $hero_author_id = get_the_author_meta( 'ID', get_post_field( 'post_author', $hero_post->ID ) ); ?>
			<span class="author hero-post__author">
				<?php echo get_avatar( $hero_author_id, 24 ); ?>
				<?php echo esc_html( get_the_author_meta( 'display_name', $hero_author_id ) ); ?>
			</span>
		</div>
		<div class="hero-post__meta-right">
			<div class="hero-post__date">
				<?php echo esc_html( get_the_date( 'F j, Y', $hero_post ) ); ?> 
			</div>
			<a href="<?php echo esc_url( get_permalink( $hero_post ) ); ?>" class="hero-post__readmore">
				<?php esc_html_e( 'Read Article', 'kumo-blog' ); ?>
				<span class="icon-circle" aria-hidden="true">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 9L9 3M9 3H4M9 3V8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			</a>
		</div>
	</div>
	<h1 class="hero-post__title">
		<a href="<?php echo esc_url( get_permalink( $hero_post ) ); ?>"><?php echo esc_html( get_the_title( $hero_post ) ); ?></a>
	</h1>
</section>
<?php wp_reset_postdata(); endif; ?>

<?php
$all_categories = get_categories( array(
	'hide_empty' => false,
	'orderby'    => 'name',
	'order'      => 'ASC',
	'exclude'    => array( get_option( 'default_category' ) ),
) );

$hero_cat_id = ! empty( $cats ) ? $cats[0]->term_id : 0;
$categories  = array();

if ( $hero_cat_id ) {
	foreach ( $all_categories as $key => $cat ) {
		if ( $cat->term_id === $hero_cat_id ) {
			$categories[] = $cat;
			unset( $all_categories[ $key ] );
			break;
		}
	}
}
$categories = array_slice( array_merge( $categories, $all_categories ), 0, 4 );

if ( ! empty( $categories ) ) :
	?>
	<section class="section">
		<div class="section__head">
			<h2 class="section__title"><?php esc_html_e( 'Browse by Category', 'kumo-blog' ); ?></h2>
			<a href="<?php echo esc_url( $categories_url ); ?>" class="section__more"><?php esc_html_e( 'View All', 'kumo-blog' ); ?>
				<span class="icon-circle" aria-hidden="true">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 9L9 3M9 3H4M9 3V8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			</a>
		</div>
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
	</section>
<?php endif; ?>

<?php
$latest = new WP_Query( array(
	'posts_per_page'      => 6,
	'post__not_in'        => $exclude_ids,
	'ignore_sticky_posts'  => true,
) );
if ( $latest->have_posts() ) :
	?>
	<section class="section">
		<div class="section__head">
			<h2 class="section__title"><?php esc_html_e( 'Latest Research & Engineering Papers', 'kumo-blog' ); ?></h2>
			<a href="<?php echo esc_url( $blog_url ); ?>" class="section__more"><?php esc_html_e( 'View All', 'kumo-blog' ); ?>
				<span class="icon-circle" aria-hidden="true">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 9L9 3M9 3H4M9 3V8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			</a>
		</div>
		<div class="post-grid">
			<?php while ( $latest->have_posts() ) : $latest->the_post(); ?>
				<?php get_template_part( 'template-parts/content-card', null, array( 'show_excerpt' => true ) ); ?>
			<?php endwhile; ?>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>

<?php
$popular = kumo_get_popular_posts( 4, $exclude_ids );
if ( empty( $popular ) ) {
	$popular = get_posts( array( 'posts_per_page' => 4, 'post__not_in' => $exclude_ids, 'ignore_sticky_posts' => true ) );
}
if ( ! empty( $popular ) ) :
	$feature = array_shift( $popular );
	?>
	<section class="section">
		<div class="section__head">
			<h2 class="section__title"><?php esc_html_e( 'Popular', 'kumo-blog' ); ?></h2>
			<a href="<?php echo esc_url( $blog_url ); ?>" class="section__more"><?php esc_html_e( 'View All', 'kumo-blog' ); ?>
				<span class="icon-circle" aria-hidden="true">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 9L9 3M9 3H4M9 3V8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			</a>
		</div>
		<div class="popular-layout">
			<div class="popular-feature" style="background-image:url('<?php echo esc_url( get_the_post_thumbnail_url( $feature->ID, 'kumo-hero' ) ); ?>');">
				<div class="popular-feature__wrap">
					<div class="popular-feature__card">
						<?php kumo_author_meta( $feature->ID ); ?>
						<h3 class="popular-feature__title"><?php echo esc_html( get_the_title( $feature ) ); ?></h3>
						<a href="<?php echo esc_url( get_permalink( $feature ) ); ?>" class="btn-dark">
							<?php esc_html_e( 'View More', 'kumo-blog' ); ?>
							
						</a>
					</div>
				</div>
			</div>
			<div class="popular-list">
				<?php foreach ( $popular as $item ) : ?>
					<a href="<?php echo esc_url( get_permalink( $item ) ); ?>" class="popular-list__item">
						<span class="popular-list__thumb"><?php echo get_the_post_thumbnail( $item, 'thumbnail' ); ?></span>
						<span>
							<span class="popular-list__meta"><?php kumo_author_meta( $item->ID ); ?></span>
							<span class="popular-list__title"><?php echo esc_html( get_the_title( $item ) ); ?></span>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
