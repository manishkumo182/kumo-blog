<?php
/**
 * Single post: category topbar, hero image, meta, content + share rail, related articles.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();
	$cats  = get_the_category();
	$share = kumo_share_links();
	?>

	<div class="post-topbar">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="post-topbar__back">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
			<?php esc_html_e( 'Back to Articles', 'kumo-blog' ); ?>
		</a>
		<div class="post-topbar__actions">
			<button type="button" class="icon-btn save-button" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>" aria-label="<?php esc_attr_e( 'Save', 'kumo-blog' ); ?>" aria-pressed="false">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
			</button>
			<a href="<?php echo esc_url( $share['facebook'] ); ?>" class="icon-btn" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share', 'kumo-blog' ); ?>">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.6" y1="10.5" x2="15.4" y2="6.5"></line><line x1="8.6" y1="13.5" x2="15.4" y2="17.5"></line></svg>
			</a>
		</div>
	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="single-hero__media"><?php the_post_thumbnail( 'kumo-hero' ); ?></div>
	<?php endif; ?>

	<div class="hero-post__meta">
		<div class="hero-post__meta-left">
			<?php if ( ! empty( $cats ) ) : ?>
				<span class="tag-pill"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
			<?php kumo_author_meta(); ?>
		</div>
		<div class="post-engagement">
			<button
				type="button"
				class="like-button"
				data-post-id="<?php echo esc_attr( get_the_ID() ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'kumo_like_' . get_the_ID() ) ); ?>"
			>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"></path></svg>
				<span class="like-button__count"><?php echo esc_html( number_format_i18n( kumo_get_like_count() ) ); ?></span>
				<span class="like-button__label"><?php esc_html_e( 'Likes', 'kumo-blog' ); ?></span>
			</button>
		</div>
	</div>

	<h1 class="single-hero__title"><?php the_title(); ?></h1>

	<div class="single-body">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'kumo-blog' ),
				'after'  => '</div>',
			) );
			?>
		</div>

		<aside class="post-share-rail">
			<span class="post-share__label"><?php esc_html_e( 'Share', 'kumo-blog' ); ?></span>
			<div class="post-share__total">
				<span class="post-share__total-count"><?php echo esc_html( number_format_i18n( kumo_get_share_count() ) ); ?></span>
				<span class="post-share__total-label"><?php esc_html_e( 'Shares', 'kumo-blog' ); ?></span>
			</div>
			<div class="post-share">
				<?php $share_nonce = wp_create_nonce( 'kumo_share_' . get_the_ID() ); ?>
				<a href="<?php echo esc_url( $share['facebook'] ); ?>" class="share-fb" target="_blank" rel="noopener noreferrer" aria-label="Facebook" data-share-network="facebook" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>" data-nonce="<?php echo esc_attr( $share_nonce ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
				</a>
				<a href="<?php echo esc_url( $share['twitter'] ); ?>" class="share-tw" target="_blank" rel="noopener noreferrer" aria-label="Twitter" data-share-network="twitter" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>" data-nonce="<?php echo esc_attr( $share_nonce ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
				</a>
				<a href="<?php echo esc_url( $share['pinterest'] ); ?>" class="share-pin" target="_blank" rel="noopener noreferrer" aria-label="Pinterest" data-share-network="pinterest" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>" data-nonce="<?php echo esc_attr( $share_nonce ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-3.64 19.3c-.05-.83-.09-2.1.02-3 .1-.43.66-2.77.66-2.77s-.17-.34-.17-.83c0-.78.45-1.36 1.02-1.36.48 0 .71.36.71.79 0 .48-.31 1.2-.46 1.87-.13.56.28 1.02.83 1.02 1 0 1.77-1.05 1.77-2.58 0-1.35-.97-2.29-2.36-2.29-1.6 0-2.55 1.2-2.55 2.45 0 .48.19.99.42 1.27a.17.17 0 0 1 .04.16c-.05.18-.14.56-.16.64-.03.1-.09.12-.2.07-.79-.37-1.28-1.51-1.28-2.43 0-1.98 1.44-3.8 4.15-3.8 2.18 0 3.87 1.55 3.87 3.63 0 2.17-1.37 3.91-3.27 3.91-.64 0-1.24-.33-1.44-.73l-.39 1.5c-.14.55-.53 1.23-.79 1.65A10 10 0 1 0 12 2z"/></svg>
				</a>
				<a href="<?php echo esc_url( $share['email'] ); ?>" class="share-email" aria-label="Email" data-share-network="email" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>" data-nonce="<?php echo esc_attr( $share_nonce ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M3 8.5V17a2 2 0 0 0 2 2h1V9.6z"/><path fill="#34A853" d="M18 19h1a2 2 0 0 0 2-2V8.5l-3 2.3z"/><path fill="#EA4335" d="M3 8.5 12 15l9-6.5V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/><path fill="#FBBC05" d="M6 19h12V11l-6 4.5L6 11z"/></svg>
				</a>
			</div>
		</aside>
	</div>


<?php kumo_author_bio(); ?>
	<?php
	$related = get_posts( array(
		'posts_per_page' => 4,
		'post__not_in'   => array( get_the_ID() ),
		'category__in'   => wp_list_pluck( $cats, 'term_id' ),
		'no_found_rows'  => true,
	) );
	if ( ! empty( $related ) ) :
		?>
		<section class="section">
			<div class="section__head">
				<h2 class="section__title"><?php esc_html_e( 'Similar Articles', 'kumo-blog' ); ?></h2>
			</div>
			<div class="post-grid post-grid--4">
				<?php foreach ( $related as $post ) : setup_postdata( $post ); ?>
					<?php get_template_part( 'template-parts/content-card', null, array( 'show_excerpt' => false ) ); ?>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		</section>
	<?php endif; ?>

	

<?php endwhile; ?>

<?php get_footer(); ?>
