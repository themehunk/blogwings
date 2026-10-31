<?php
/**
 * BlogWings functions.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;

define( 'BLOGWINGS_VERSION', '1.0.6' );
define( 'BLOGWINGS_DIR', get_template_directory() );
define( 'BLOGWINGS_URI', get_template_directory_uri() );

require BLOGWINGS_DIR . '/inc/template-tags.php';
require BLOGWINGS_DIR . '/inc/class-blogwings-walker.php';
require BLOGWINGS_DIR . '/inc/customizer.php';

/**
 * Internal link helper (respects /index.php/ and plain permalinks via BWing).
 */
function blogwings_url( $path ) {
	if ( preg_match( '#^https?://#', $path ) ) {
		return $path;
	}
	return function_exists( 'bwing_url' ) ? bwing_url( $path ) : home_url( $path );
}

/**
 * Is the BWing companion plugin active?
 */
function blogwings_has_bwing() {
	return function_exists( 'bwing_enqueue' );
}

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'blogwings', BLOGWINGS_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 64, 'width' => 220, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/editor.css' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_image_size( 'blogwings-card', 720, 420, true );

	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'blogwings' ),
		'footer'  => __( 'Footer menu', 'blogwings' ),
	) );

	add_theme_support( 'editor-color-palette', array(
		array( 'name' => __( 'Violet', 'blogwings' ), 'slug' => 'brand', 'color' => '#5b3df5' ),
		array( 'name' => __( 'Teal', 'blogwings' ), 'slug' => 'accent', 'color' => '#00b89c' ),
		array( 'name' => __( 'Ink', 'blogwings' ), 'slug' => 'ink', 'color' => '#14142b' ),
		array( 'name' => __( 'Mist', 'blogwings' ), 'slug' => 'mist', 'color' => '#f6f6fb' ),
	) );
} );

add_action( 'widgets_init', function () {
	$args = array(
		'before_widget' => '<section id="%1$s" class="bwt-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="bwt-widget__title">',
		'after_title'   => '</h3>',
	);
	register_sidebar( array_merge( $args, array( 'id' => 'sidebar-1', 'name' => __( 'Blog sidebar', 'blogwings' ) ) ) );
	register_sidebar( array_merge( $args, array( 'id' => 'footer-1', 'name' => __( 'Footer column (optional)', 'blogwings' ), 'description' => __( 'Replaces the default footer columns when used.', 'blogwings' ) ) ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'blogwings-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap', array(), null );
	$deps = array( 'blogwings-fonts' );
	if ( blogwings_has_bwing() ) {
		bwing_enqueue();
		$deps[] = 'bwing';
	}
	wp_enqueue_style( 'blogwings', BLOGWINGS_URI . '/assets/css/main.css', $deps, BLOGWINGS_VERSION );
	wp_add_inline_style( 'blogwings', blogwings_inline_css() );
	wp_enqueue_script( 'blogwings', BLOGWINGS_URI . '/assets/js/main.js', array(), BLOGWINGS_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

add_filter( 'wp_resource_hints', function ( $urls, $type ) {
	if ( 'preconnect' === $type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

/**
 * Prevent a flash of the wrong colour scheme.
 */
add_action( 'wp_head', function () {
	echo "<script>(function(){try{var t=localStorage.getItem('bwt-mode');if(t){document.documentElement.setAttribute('data-theme',t);}}catch(e){}})();</script>\n";
}, 0 );

/**
 * Default colour mode (Customizer): light (default), dark, or follow the device.
 * Printed on <html> so it applies before any CSS or JS runs; a visitor's toggle choice overrides it.
 */
function blogwings_default_mode() {
	$mode = get_theme_mod( 'blogwings_default_mode', 'light' );
	return in_array( $mode, array( 'light', 'dark', 'system' ), true ) ? $mode : 'light';
}
add_filter( 'language_attributes', function ( $output ) {
	if ( is_admin() || 'system' === blogwings_default_mode() ) {
		return $output;
	}
	return $output . ' data-theme="' . esc_attr( blogwings_default_mode() ) . '"';
} );

/**
 * Customizer colour overrides.
 */
function blogwings_inline_css() {
	$brand  = sanitize_hex_color( get_theme_mod( 'blogwings_brand', '#5b3df5' ) );
	$accent = sanitize_hex_color( get_theme_mod( 'blogwings_accent', '#00b89c' ) );
	$css    = ':root{';
	if ( $brand && '#5b3df5' !== strtolower( $brand ) ) {
		$css .= '--bw-brand:' . $brand . ';--bw-brand-soft:color-mix(in srgb,' . $brand . ' 14%,transparent);';
	}
	if ( $accent && '#00b89c' !== strtolower( $accent ) ) {
		$css .= '--bw-accent:' . $accent . ';';
	}
	$css .= '--bwt-container:' . absint( get_theme_mod( 'blogwings_container', 1240 ) ) . 'px;}';
	return $css;
}

/**
 * Body classes.
 */
add_filter( 'body_class', function ( $classes ) {
	if ( is_page() && get_post_meta( get_the_ID(), '_bwing_hide_title', true ) ) {
		$classes[] = 'bwt-hide-title';
	}
	if ( ! blogwings_has_bwing() ) {
		$classes[] = 'bwt-no-bwing';
	}
	return $classes;
} );

/**
 * Register the Full width page template (also used by BWing pages).
 */
add_filter( 'theme_page_templates', function ( $templates ) {
	$templates['templates/full-width.php'] = __( 'Full width', 'blogwings' );
	return $templates;
} );

/**
 * On activation: assign BWing menus, and remind about the plugin.
 */
add_action( 'after_switch_theme', function () {
	if ( class_exists( 'BWing_Pages' ) ) {
		BWing_Pages::assign_menus();
	}
	set_transient( 'blogwings_welcome', 1, 60 );
} );

add_action( 'admin_notices', function () {
	if ( blogwings_has_bwing() || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	$installed = file_exists( WP_PLUGIN_DIR . '/bwing/bwing.php' );
	$url       = $installed ? wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=bwing/bwing.php' ), 'activate-plugin_bwing/bwing.php' ) : admin_url( 'plugin-install.php' );
	echo '<div class="notice notice-info"><p><strong>BlogWings</strong> — ' . esc_html__( 'Activate the BWing plugin to unlock rankings, statistics, the theme detector and the home page sections.', 'blogwings' ) . ' <a class="button button-primary" href="' . esc_url( $url ) . '">' . esc_html( $installed ? __( 'Activate BWing', 'blogwings' ) : __( 'Install plugins', 'blogwings' ) ) . '</a></p></div>';
} );

/**
 * Excerpt tweaks.
 */
add_filter( 'excerpt_length', function () {
	return 26;
} );
add_filter( 'excerpt_more', function () {
	return '…';
} );
