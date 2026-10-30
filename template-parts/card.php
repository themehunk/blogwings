<?php
/**
 * Post card.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'bwt-card' ); ?>>
	<a class="bwt-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'blogwings-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="bwt-card__art" style="--h:<?php echo (int) ( abs( crc32( get_the_title() ) ) % 360 ); ?>"><span><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span></span>
		<?php endif; ?>
	</a>
	<div class="bwt-card__body">
		<?php blogwings_meta(); ?>
		<h2 class="bwt-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p class="bwt-card__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
	</div>
</article>
