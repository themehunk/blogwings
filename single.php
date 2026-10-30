<?php
/**
 * Single post.
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
			<header class="bwt-posthead">
				<?php blogwings_meta(); ?>
				<?php the_title( '<h1>', '</h1>' ); ?>
				<?php if ( has_excerpt() ) : ?>
					<p class="bwt-posthead__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<div class="bwt-byline"><?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?><span><?php esc_html_e( 'By', 'blogwings' ); ?> <strong><?php the_author(); ?></strong></span></div>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="bwt-hero-img"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>
			<div class="bwt-entry"><?php the_content(); ?></div>
			<?php wp_link_pages(); ?>
			<footer class="bwt-postfoot">
				<?php the_tags( '<div class="bw-chips">', '', '</div>' ); ?>
				<?php
				if ( blogwings_has_bwing() ) {
					echo do_shortcode( '[bwing_newsletter]' );
				}
				?>
			</footer>
		</article>
		<?php
		the_post_navigation( array(
			'prev_text' => '<small>' . esc_html__( 'Previous', 'blogwings' ) . '</small><span>%title</span>',
			'next_text' => '<small>' . esc_html__( 'Next', 'blogwings' ) . '</small><span>%title</span>',
			'class'     => 'bwt-postnav',
		) );
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>
<?php
get_footer();
