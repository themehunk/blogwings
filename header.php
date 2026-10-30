<?php
/**
 * Header.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
$badge = get_theme_mod( 'blogwings_badge', __( 'Updated today', 'blogwings' ) );
$cta   = get_theme_mod( 'blogwings_cta_label', __( 'Detect a site', 'blogwings' ) );
$cta_u = get_theme_mod( 'blogwings_cta_url', '/theme-detector/' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="bwt-skip" href="#bwt-content"><?php esc_html_e( 'Skip to content', 'blogwings' ); ?></a>

<header class="bwt-header<?php echo get_theme_mod( 'blogwings_sticky', 1 ) ? ' is-sticky' : ''; ?>" data-bwt-header>
	<div class="bwt-container bwt-header__inner">
		<div class="bwt-header__brand">
			<?php blogwings_logo(); ?>
			<?php if ( $badge ) : ?>
				<span class="bwt-badge"><i class="bw-dot"></i><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>
		</div>

		<nav class="bwt-nav" id="bwt-nav" aria-label="<?php esc_attr_e( 'Primary', 'blogwings' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'bwt-menu',
				'depth'          => 2,
				'walker'         => new BlogWings_Walker(),
				'fallback_cb'    => 'blogwings_menu_fallback',
			) );
			?>
			<?php if ( $cta ) : ?>
				<a class="bw-btn bw-btn--primary bw-btn--sm bwt-nav__cta-mobile" href="<?php echo esc_url( blogwings_url( $cta_u ) ); ?>"><?php echo esc_html( $cta ); ?></a>
			<?php endif; ?>
		</nav>

		<div class="bwt-header__actions">
			<?php if ( get_theme_mod( 'blogwings_search', 1 ) ) : ?>
				<button class="bwt-icon-btn" type="button" data-bwt-search-open aria-label="<?php esc_attr_e( 'Search', 'blogwings' ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
				</button>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'blogwings_dark_toggle', 1 ) ) : ?>
				<button class="bwt-icon-btn" type="button" data-bwt-theme-toggle aria-label="<?php esc_attr_e( 'Toggle dark mode', 'blogwings' ); ?>">
					<svg class="bwt-i-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
					<svg class="bwt-i-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
				</button>
			<?php endif; ?>
			<?php if ( $cta ) : ?>
				<a class="bw-btn bw-btn--primary bw-btn--sm bwt-header__cta" href="<?php echo esc_url( blogwings_url( $cta_u ) ); ?>"><?php echo esc_html( $cta ); ?></a>
			<?php endif; ?>
			<button class="bwt-icon-btn bwt-burger" type="button" data-bwt-burger aria-controls="bwt-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'blogwings' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<div class="bwt-searchlay" data-bwt-search hidden>
	<div class="bwt-searchlay__box" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'blogwings' ); ?>">
		<?php
		if ( blogwings_has_bwing() ) {
			echo do_shortcode( '[bwing_search]' );
		} else {
			get_search_form();
		}
		?>
		<p class="bwt-searchlay__hint"><?php esc_html_e( 'Search themes, plugins and authors · Esc to close', 'blogwings' ); ?></p>
	</div>
</div>

<div id="bwt-content" class="bwt-site">
