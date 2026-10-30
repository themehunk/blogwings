<?php
/**
 * Template Name: Full width
 * Template Post Type: page, post
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="bwt-container bwt-main">
	<?php blogwings_breadcrumbs(); ?>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'bwt-article bwt-article--full' ); ?>>
			<?php if ( ! get_post_meta( get_the_ID(), '_bwing_hide_title', true ) ) : ?>
				<header class="bwt-pagehead"><?php the_title( '<h1>', '</h1>' ); ?></header>
			<?php endif; ?>
			<div class="bwt-entry bwt-entry--full"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
