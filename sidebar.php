<?php
/**
 * Blog sidebar.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
?>
<aside class="bwt-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'blogwings' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
		<section class="bwt-widget"><?php get_search_form(); ?></section>
		<?php if ( blogwings_has_bwing() ) : ?>
			<section class="bwt-widget"><?php echo do_shortcode( '[bwing_mini_top type="theme" count="5" title="' . esc_attr__( 'Top themes today', 'blogwings' ) . '"]' ); ?></section>
			<section class="bwt-widget"><?php echo do_shortcode( '[bwing_mini_top type="plugin" count="5" title="' . esc_attr__( 'Top plugins today', 'blogwings' ) . '"]' ); ?></section>
			<section class="bwt-widget"><?php echo do_shortcode( '[bwing_newsletter]' ); ?></section>
		<?php endif; ?>
		<section class="bwt-widget">
			<h3 class="bwt-widget__title"><?php esc_html_e( 'Categories', 'blogwings' ); ?></h3>
			<ul class="bwt-catlist"><?php wp_list_categories( array( 'title_li' => '', 'show_count' => true ) ); ?></ul>
		</section>
	<?php endif; ?>
</aside>
