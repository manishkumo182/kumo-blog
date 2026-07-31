<?php
/**
 * Template Name: About
 * About page: badge + heading, story block, stats strip and a CTA banner.
 * All copy, the story image and the CTA link are editable under
 * Customize → About Page.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$badge         = get_theme_mod( 'kumo_about_badge', 'About Us' );
$heading       = get_theme_mod( 'kumo_about_heading', "We're building the future of tech journalism" );
$subheading    = get_theme_mod( 'kumo_about_subheading', 'Kumo Blog covers the research, engineering and products shaping what comes next — reported clearly, for a curious audience.' );

$story_heading = get_theme_mod( 'kumo_about_story_heading', 'Our story' );
$story_text    = get_theme_mod( 'kumo_about_story_text', "Kumo Blog started as a small newsletter and grew into a daily source for technology coverage. We believe good reporting should be accurate, readable and free of hype.\n\nToday our team works with researchers, engineers and founders to bring their work to a wider audience." );
$story_image   = get_theme_mod( 'kumo_about_story_image', '' );

$stats = array(
	array(
		'value' => get_theme_mod( 'kumo_about_stat1_value', '120+' ),
		'label' => get_theme_mod( 'kumo_about_stat1_label', 'Articles published' ),
	),
	array(
		'value' => get_theme_mod( 'kumo_about_stat2_value', '45k' ),
		'label' => get_theme_mod( 'kumo_about_stat2_label', 'Monthly readers' ),
	),
	array(
		'value' => get_theme_mod( 'kumo_about_stat3_value', '8' ),
		'label' => get_theme_mod( 'kumo_about_stat3_label', 'Years running' ),
	),
);

$cta_heading     = get_theme_mod( 'kumo_about_cta_heading', 'Want to work with us?' );
$cta_text        = get_theme_mod( 'kumo_about_cta_text', "We're always open to pitches, partnerships and new contributors." );
$cta_button_text = get_theme_mod( 'kumo_about_cta_button_text', 'Get in touch' );
$cta_button_url  = get_theme_mod( 'kumo_about_cta_button_url', home_url( '/contact/' ) );
?>
<div class="kumo-container">
	
<div class="about-page" id="about">

	<div class="about-hero">
		<span class="about-badge">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
			<?php echo esc_html( $badge ); ?>
		</span>

		<h1 class="about-title"><?php echo esc_html( $heading ); ?></h1>
		<p class="about-subtitle"><?php echo esc_html( $subheading ); ?></p>
	</div>

	<div class="about-story">
		<div class="about-story__text">
			<h2 class="about-story__heading"><?php echo esc_html( $story_heading ); ?></h2>
			<?php echo wpautop( esc_html( $story_text ) ); ?>
		</div>
		<div class="about-story__media">
			<?php if ( $story_image ) : ?>
				<img src="<?php echo esc_url( $story_image ); ?>" alt="<?php echo esc_attr( $story_heading ); ?>" />
			<?php endif; ?>
		</div>
	</div>

	<!-- <ul class="about-stats">
		<?php foreach ( $stats as $stat ) : ?>
			<?php if ( '' === $stat['value'] && '' === $stat['label'] ) continue; ?>
			<li class="about-stats__item">
				<span class="about-stats__value"><?php echo esc_html( $stat['value'] ); ?></span>
				<span class="about-stats__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul> -->

	<!-- <div class="about-cta">
		<div>
			<h2 class="about-cta__heading"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="about-cta__text"><?php echo esc_html( $cta_text ); ?></p>
		</div>
		<a class="btn-dark about-cta__button" href="<?php echo esc_url( $cta_button_url ); ?>"><?php echo esc_html( $cta_button_text ); ?></a>
	</div>

</div> -->
		</div>

<?php get_footer(); ?>
