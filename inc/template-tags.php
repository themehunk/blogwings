<?php
/**
 * Template tags.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;

function blogwings_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	echo '<a class="bwt-logo" href="' . esc_url( home_url( '/' ) ) . '" rel="home"><span class="bwt-logo__mark" aria-hidden="true"><svg viewBox="0 0 32 32"><defs><linearGradient id="bwtG" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--bw-brand)"/><stop offset="1" stop-color="var(--bw-accent)"/></linearGradient></defs><rect width="32" height="32" rx="9" fill="url(#bwtG)"/><path d="M5 18c5-1 8-4 11-11 3 7 6 10 11 11-5 1-8 3-11 7-3-4-6-6-11-7z" fill="#fff"/></svg></span><span class="bwt-logo__text">' . esc_html( get_bloginfo( 'name' ) ) . '</span></a>';
}

/**
 * Social networks with default BlogWings profiles.
 */
function blogwings_social_networks() {
	return array(
		'facebook'  => array(
			'label' => 'Facebook',
			'url'   => 'https://www.facebook.com/BblogWings/',
			'icon'  => '<path d="M14 8.5V6.6c0-.9.6-1.1 1-1.1h2.6V1.6L14 1.5c-4 0-4.9 3-4.9 4.9v2.1H6.5v4h2.6V22.5H14v-10h3.3l.4-4H14z"/>',
		),
		'x'         => array(
			'label' => 'X',
			'url'   => 'https://x.com/wpblogwings',
			'icon'  => '<path d="M18.9 2H22l-6.8 7.8L23 22h-6.2l-4.8-6.3L6.4 22H3.3l7.3-8.3L1 2h6.3l4.4 5.8L18.9 2zm-1.1 18h1.7L6.3 3.9H4.5L17.8 20z"/>',
		),
		'youtube'   => array(
			'label' => 'YouTube',
			'url'   => 'https://www.youtube.com/@wpblogwings',
			'icon'  => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2C0 8.1 0 12 0 12s0 3.9.5 5.8a3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1c.5-1.9.5-5.8.5-5.8s0-3.9-.5-5.8zM9.6 15.6V8.4l6.3 3.6-6.3 3.6z"/>',
		),
		'pinterest' => array(
			'label' => 'Pinterest',
			'url'   => 'https://in.pinterest.com/wings_blog/',
			'icon'  => '<path d="M12 0a12 12 0 0 0-4.4 23.2c-.1-.9-.2-2.4 0-3.4l1.4-6s-.4-.7-.4-1.8c0-1.7 1-2.9 2.2-2.9 1 0 1.5.8 1.5 1.7 0 1-.7 2.6-1 4-.3 1.2.6 2.2 1.8 2.2 2.1 0 3.8-2.2 3.8-5.5 0-2.9-2.1-4.9-5-4.9-3.4 0-5.4 2.6-5.4 5.2 0 1 .4 2.1.9 2.7.1.1.1.2.1.4l-.3 1.4c-.1.2-.2.3-.4.2-1.5-.7-2.4-2.9-2.4-4.6 0-3.8 2.7-7.2 7.9-7.2 4.1 0 7.3 2.9 7.3 6.9 0 4.1-2.6 7.4-6.2 7.4-1.2 0-2.4-.6-2.7-1.4l-.8 2.8c-.3 1-1 2.3-1.5 3.1A12 12 0 1 0 12 0z"/>',
		),
	);
}

/**
 * Social icon links (Customizer → BlogWings options → Footer).
 */
function blogwings_social_links( $class = 'bwt-socials' ) {
	$out = '';
	foreach ( blogwings_social_networks() as $key => $net ) {
		$url = get_theme_mod( 'blogwings_social_' . $key, $net['url'] );
		if ( ! $url ) {
			continue;
		}
		/* translators: %s network */
		$label = sprintf( __( 'BlogWings on %s', 'blogwings' ), $net['label'] );
		$out  .= '<a class="bwt-socials__link bwt-socials__link--' . esc_attr( $key ) . '" href="' . esc_url( $url ) . '" target="_blank" rel="noopener me" aria-label="' . esc_attr( $label ) . '" title="' . esc_attr( $net['label'] ) . '"><svg viewBox="0 0 24 24" aria-hidden="true">' . $net['icon'] . '</svg></a>';
	}
	return $out ? '<div class="' . esc_attr( $class ) . '">' . $out . '</div>' : '';
}

function blogwings_reading_time( $post = null ) {
	$words = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post ) ) );
	$mins  = max( 1, (int) ceil( $words / 220 ) );
	/* translators: %d minutes */
	return sprintf( _n( '%d min read', '%d min read', $mins, 'blogwings' ), $mins );
}

function blogwings_meta() {
	$cats = get_the_category();
	echo '<div class="bwt-meta">';
	if ( $cats ) {
		echo '<a class="bwt-meta__cat" href="' . esc_url( get_category_link( $cats[0] ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
	}
	echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time><span>' . esc_html( blogwings_reading_time() ) . '</span></div>';
}

function blogwings_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	$items = array( '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'blogwings' ) . '</a>' );
	if ( is_singular( 'post' ) ) {
		$blog = get_option( 'page_for_posts' );
		if ( $blog ) {
			$items[] = '<a href="' . esc_url( get_permalink( $blog ) ) . '">' . esc_html( get_the_title( $blog ) ) . '</a>';
		}
		$items[] = '<span>' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $a ) {
			$items[] = '<a href="' . esc_url( get_permalink( $a ) ) . '">' . esc_html( get_the_title( $a ) ) . '</a>';
		}
		$items[] = '<span>' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_home() ) {
		$items[] = '<span>' . esc_html( single_post_title( '', false ) ) . '</span>';
	} elseif ( is_archive() ) {
		$items[] = '<span>' . wp_kses_post( get_the_archive_title() ) . '</span>';
	} elseif ( is_search() ) {
		$items[] = '<span>' . esc_html__( 'Search', 'blogwings' ) . '</span>';
	} elseif ( class_exists( 'BWing_Router' ) && BWing_Router::current() ) {
		$cur  = BWing_Router::current();
		$base = array(
			'theme'          => array( 'themes', __( 'Themes', 'blogwings' ) ),
			'plugin'         => array( 'plugins', __( 'Plugins', 'blogwings' ) ),
			'premium-theme'  => array( 'premium-themes', __( 'Premium themes', 'blogwings' ) ),
			'premium-plugin' => array( 'premium-plugins', __( 'Premium plugins', 'blogwings' ) ),
			'author'         => array( 'authors', __( 'Authors', 'blogwings' ) ),
		);
		$b       = $base[ $cur['type'] ];
		$items[] = '<a href="' . esc_url( blogwings_url( $b[0] ) ) . '">' . esc_html( $b[1] ) . '</a>';
		$items[] = '<span>' . esc_html( $cur['object']->name ) . '</span>';
	} else {
		return;
	}
	echo '<nav class="bwt-crumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'blogwings' ) . '">' . implode( '<i aria-hidden="true">/</i>', $items ) . '</nav>'; // phpcs:ignore
}

function blogwings_pagination() {
	the_posts_pagination( array(
		'mid_size'  => 1,
		'prev_text' => '‹ ' . __( 'Prev', 'blogwings' ),
		'next_text' => __( 'Next', 'blogwings' ) . ' ›',
		'class'     => 'bwt-pagination',
	) );
}

/** Footer column fallback content (top lists from BWing, or menu links). */
function blogwings_footer_columns() {
	if ( is_active_sidebar( 'footer-1' ) ) {
		echo '<div class="bwt-footer__col bwt-footer__col--widgets">';
		dynamic_sidebar( 'footer-1' );
		echo '</div>';
		return;
	}
	if ( blogwings_has_bwing() ) {
		$cols = array(
			array( __( 'Top themes', 'blogwings' ), 'theme', '/themes/' ),
			array( __( 'Top plugins', 'blogwings' ), 'plugin', '/plugins/' ),
			array( __( 'Top authors', 'blogwings' ), 'author', '/authors/' ),
		);
		foreach ( $cols as $c ) {
			echo '<div class="bwt-footer__col"><h4>' . esc_html( $c[0] ) . '</h4>' . do_shortcode( '[bwing_mini_top type="' . $c[1] . '" count="5"]' ) . '<a class="bwt-footer__more" href="' . esc_url( blogwings_url( $c[2] ) ) . '">' . esc_html__( 'View all →', 'blogwings' ) . '</a></div>';
		}
	}
}
