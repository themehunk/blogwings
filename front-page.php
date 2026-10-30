<?php
/**
 * Front page: the static front page content, full width. With no static front page,
 * shows the BWing home sections (or the blog when BWing is not active).
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;

if ( 'page' !== get_option( 'show_on_front' ) && ! blogwings_has_bwing() ) {
	get_template_part( 'index' );
	return;
}
get_header();
?>
<main id="primary" class="bwt-container bwt-main bwt-main--front">
	<?php
	if ( 'page' === get_option( 'show_on_front' ) ) {
		while ( have_posts() ) {
			the_post();
			echo '<div class="bwt-entry bwt-entry--full">';
			the_content();
			echo '</div>';
		}
	} else {
		echo do_shortcode( '[bwing_hero][bwing_trending][bwing_notable]<div class="bw-pair">[bwing_top type="theme"][bwing_top type="plugin"]</div><div class="bw-pair">[bwing_top_premium type="theme"][bwing_top_premium type="plugin"]</div><div class="bw-pair">[bwing_top_authors type="theme"][bwing_top_authors type="plugin"]</div>[bwing_beyond][bwing_faq][bwing_cta]' );
	}
	?>
</main>
<?php
get_footer();
