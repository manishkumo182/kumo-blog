<?php
/**
 * The footer for our theme: newsletter block + footer widgets + bottom bar.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
</div><!-- #content -->

<div class="kumo-container">
	<?php get_template_part( 'template-parts/newsletter' ); ?>
</div>

<footer id="colophon" class="site-footer">
	<div class="kumo-container footer-columns">
		<div class="footer-brand">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<strong><?php bloginfo( 'name' ); ?></strong>
			<?php endif; ?>
			<p class="footer-about"><?php echo esc_html( get_theme_mod( 'kumo_footer_about', 'Building the future of research, engineering and technology journalism.' ) ); ?></p>
		</div>

		<div class="footer-col">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : dynamic_sidebar( 'footer-1' ); else : ?>
				<h4 class="footer-heading"><?php esc_html_e( 'Address', 'kumo-blog' ); ?></h4>
				<p class="footer-about"><?php esc_html_e( 'Add this widget area from Appearance → Widgets → Footer Column 1.', 'kumo-blog' ); ?></p>
			<?php endif; ?>
		</div>

		<div class="footer-col">
			<?php if ( is_active_sidebar( 'footer-2' ) ) : dynamic_sidebar( 'footer-2' ); else : ?>
				<h4 class="footer-heading"><?php esc_html_e( 'Partnership', 'kumo-blog' ); ?></h4>
				<p class="footer-about"><?php esc_html_e( 'Add this widget area from Appearance → Widgets → Footer Column 2.', 'kumo-blog' ); ?></p>
			<?php endif; ?>
		</div>

		<div class="footer-social">
			<?php
			$social_icons = array(
				'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>',
				'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>',
				'twitter'   => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>',
				'linkedin'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>',
			);
			$socials = array(
				'instagram' => get_theme_mod( 'kumo_social_instagram' ),
				'facebook'  => get_theme_mod( 'kumo_social_facebook' ),
				'twitter'   => get_theme_mod( 'kumo_social_twitter' ),
				'linkedin'  => get_theme_mod( 'kumo_social_linkedin' ),
			);
			foreach ( $socials as $network => $url ) :
				if ( ! $url ) continue;
				?>
				<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $social_icons[ $network ]; ?></svg>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="kumo-container site-footer__bottom">
		<?php echo esc_html( get_theme_mod( 'kumo_footer_copyright', '© ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '. All rights reserved.' ) ); ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
