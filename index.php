<?php
/**
 * Blog index, archives and search results.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
get_header();
$bwt_side = get_theme_mod( 'blogwings_sidebar', 1 );
?>
<main id="primary" class="bwt-container bwt-main">
	<?php blogwings_breadcrumbs(); ?>
	<header class="bwt-pagehead">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<h1><?php echo esc_html( get_theme_mod( 'blogwings_blog_title', __( 'Notes from the data', 'blogwings' ) ) ); ?></h1>
			<p><?php echo esc_html( get_theme_mod( 'blogwings_blog_intro', __( 'Analysis, trends and the stories behind the rankings.', 'blogwings' ) ) ); ?></p>
		<?php elseif ( is_archive() ) : ?>
			<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php the_archive_description( '<div class="bwt-pagehead__desc">', '</div>' ); ?>
		<?php elseif ( is_search() ) : ?>
			<?php /* translators: %s query */ ?>
			<h1><?php printf( esc_html__( 'Results for “%s”', 'blogwings' ), esc_html( get_search_query() ) ); ?></h1>
		<?php else : ?>
			<h1><?php esc_html_e( 'Latest posts', 'blogwings' ); ?></h1>
		<?php endif; ?>
	</header>

	<div class="bwt-layout<?php echo $bwt_side ? ' has-sidebar' : ''; ?>">
		<div class="bwt-layout__main">
			<?php if ( have_posts() ) : ?>
				<div class="bwt-cards">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/card' );
					endwhile;
					?>
				</div>
				<?php blogwings_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content-none' ); ?>
			<?php endif; ?>
		</div>
		<?php
		if ( $bwt_side ) {
			get_sidebar();
		}
		?>
	</div>
</main>
<?php
get_footer();
