<?php
/**
 * Footer.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
$copyright = get_theme_mod( 'blogwings_copyright', '' );
$disclaim  = blogwings_has_bwing() ? BWing_Settings::get( 'general', 'disclaimer' ) : '';
?>
</div><!-- .bwt-site -->

<footer class="bwt-footer">
	<div class="bwt-container">
		<div class="bwt-footer__grid">
			<div class="bwt-footer__brand">
				<?php blogwings_logo(); ?>
				<p><?php echo esc_html( get_theme_mod( 'blogwings_footer_about', __( 'A daily tracker of the WordPress ecosystem — rankings, movement and real-world usage for every theme, plugin and author.', 'blogwings' ) ) ); ?></p>
				<?php echo blogwings_social_links(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in function. ?>
			</div>
			<?php blogwings_footer_columns(); ?>
		</div>

		<?php if ( blogwings_has_bwing() && get_theme_mod( 'blogwings_newsletter', 1 ) ) : ?>
			<div class="bwt-footer__news"><?php echo do_shortcode( '[bwing_newsletter style="inline"]' ); ?></div>
		<?php endif; ?>

		<div class="bwt-footer__bottom">
			<p>
				<?php
				if ( $copyright ) {
					echo wp_kses_post( $copyright );
				} else {
					/* translators: 1 year 2 site name */
					printf( esc_html__( '© %1$s %2$s. All rights reserved.', 'blogwings' ), esc_html( gmdate( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
				}
				?>
			</p>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'bwt-footer__menu',
				'depth'          => 1,
				'fallback_cb'    => false,
			) );
			?>
		</div>
		<?php if ( $disclaim ) : ?>
			<p class="bwt-footer__disclaimer"><?php echo esc_html( $disclaim ); ?></p>
		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
