<?php
/**
 * 404.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="bwt-container bwt-main">
	<div class="bwt-404">
		<span class="bwt-404__code">404</span>
		<h1><?php esc_html_e( 'This page flew away', 'blogwings' ); ?></h1>
		<p><?php esc_html_e( 'The page you are looking for does not exist or has moved. Try searching for a theme, plugin or author instead.', 'blogwings' ); ?></p>
		<?php
		if ( blogwings_has_bwing() ) {
			echo do_shortcode( '[bwing_search]' );
		} else {
			get_search_form();
		}
		?>
		<p><a class="bw-btn bw-btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( '← Back home', 'blogwings' ); ?></a></p>
	</div>
</main>
<?php
get_footer();
