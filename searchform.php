<?php
/**
 * Search form partial (used by get_search_form()).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<form role="search" method="get" class="header-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
	<input type="search" name="s" placeholder="<?php echo esc_attr( get_theme_mod( 'kumo_search_placeholder', 'Search news, article, research...' ) ); ?>" value="<?php echo get_search_query(); ?>" />
</form>
