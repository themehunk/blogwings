<?php
/**
 * Page.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="bwt-container bwt-main bwt-main--narrow">
	<?php blogwings_breadcrumbs(); ?>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'bwt-article' ); ?>>
			<?php if ( ! get_post_meta( get_the_ID(), '_bwing_hide_title', true ) ) : ?>
				<header class="bwt-pagehead"><?php the_title( '<h1>', '</h1>' ); ?></header>
			<?php endif; ?>
			<div class="bwt-entry"><?php the_content(); ?></div>
			<?php wp_link_pages(); ?>
		</article>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>
<?php
get_footer();
