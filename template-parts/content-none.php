<?php
/**
 * Nothing found.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="bwt-none">
	<h2><?php esc_html_e( 'Nothing here yet', 'blogwings' ); ?></h2>
	<p>
		<?php
		if ( is_search() ) {
			esc_html_e( 'No results matched your search. Try different keywords.', 'blogwings' );
		} else {
			esc_html_e( 'There is no content to show here yet.', 'blogwings' );
		}
		?>
	</p>
	<?php get_search_form(); ?>
</div>
