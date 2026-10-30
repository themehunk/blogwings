<?php
/**
 * Search form.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
$bwt_id = wp_unique_id( 'bwt-s-' );
?>
<form role="search" method="get" class="bwt-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $bwt_id ); ?>"><?php esc_html_e( 'Search for:', 'blogwings' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $bwt_id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search the blog…', 'blogwings' ); ?>">
	<button type="submit" class="bw-btn bw-btn--primary bw-btn--sm"><?php esc_html_e( 'Search', 'blogwings' ); ?></button>
</form>
