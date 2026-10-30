<?php
/**
 * Customizer: colours, header, footer, layout.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {
	$wp->add_panel( 'blogwings', array( 'title' => __( 'BlogWings options', 'blogwings' ), 'priority' => 30 ) );

	$sections = array(
		'blogwings_colors' => __( 'Colours & layout', 'blogwings' ),
		'blogwings_header' => __( 'Header', 'blogwings' ),
		'blogwings_footer' => __( 'Footer', 'blogwings' ),
		'blogwings_blog'   => __( 'Blog', 'blogwings' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp->add_section( $id, array( 'title' => $title, 'panel' => 'blogwings' ) );
	}

	$add = function ( $id, $default, $section, $label, $type = 'text', $sanitize = 'sanitize_text_field', $choices = array() ) use ( $wp ) {
		$wp->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => $sanitize, 'transport' => 'refresh' ) );
		if ( 'color' === $type ) {
			$wp->add_control( new WP_Customize_Color_Control( $wp, $id, array( 'label' => $label, 'section' => $section ) ) );
			return;
		}
		$args = array( 'label' => $label, 'section' => $section, 'type' => $type );
		if ( $choices ) {
			$args['choices'] = $choices;
		}
		$wp->add_control( $id, $args );
	};
	$bool = function ( $v ) {
		return $v ? 1 : 0;
	};

	$add( 'blogwings_brand', '#5b3df5', 'blogwings_colors', __( 'Brand colour', 'blogwings' ), 'color', 'sanitize_hex_color' );
	$add( 'blogwings_accent', '#00b89c', 'blogwings_colors', __( 'Accent colour', 'blogwings' ), 'color', 'sanitize_hex_color' );
	$add( 'blogwings_container', 1240, 'blogwings_colors', __( 'Container width (px)', 'blogwings' ), 'number', 'absint' );
	$add( 'blogwings_default_mode', 'light', 'blogwings_colors', __( 'Default colour mode', 'blogwings' ), 'select', function ( $v ) {
		return in_array( $v, array( 'light', 'dark', 'system' ), true ) ? $v : 'light';
	}, array( 'light' => __( 'Light (white)', 'blogwings' ), 'dark' => __( 'Dark', 'blogwings' ), 'system' => __( 'Follow visitor’s device', 'blogwings' ) ) );
	$add( 'blogwings_dark_toggle', 1,'blogwings_colors', __( 'Show dark-mode toggle', 'blogwings' ), 'checkbox', $bool );

	$add( 'blogwings_badge', __( 'Updated today', 'blogwings' ), 'blogwings_header', __( 'Header status badge (empty to hide)', 'blogwings' ) );
	$add( 'blogwings_cta_label', __( 'Detect a site', 'blogwings' ), 'blogwings_header', __( 'Header button label', 'blogwings' ) );
	$add( 'blogwings_cta_url', '/theme-detector/', 'blogwings_header', __( 'Header button URL', 'blogwings' ), 'text', 'esc_url_raw' );
	$add( 'blogwings_search', 1, 'blogwings_header', __( 'Show search button', 'blogwings' ), 'checkbox', $bool );
	$add( 'blogwings_sticky', 1, 'blogwings_header', __( 'Sticky header', 'blogwings' ), 'checkbox', $bool );

	$add( 'blogwings_footer_about', __( 'A daily tracker of the WordPress ecosystem — rankings, movement and real-world usage for every theme, plugin and author.', 'blogwings' ), 'blogwings_footer', __( 'About text', 'blogwings' ), 'textarea', 'sanitize_textarea_field' );
	foreach ( blogwings_social_networks() as $key => $net ) {
		/* translators: %s network name */
		$add( 'blogwings_social_' . $key, $net['url'], 'blogwings_footer', sprintf( __( '%s URL (empty to hide)', 'blogwings' ), $net['label'] ), 'url', 'esc_url_raw' );
	}
	$add( 'blogwings_newsletter', 1, 'blogwings_footer', __( 'Show newsletter in footer', 'blogwings' ), 'checkbox', $bool );
	$add( 'blogwings_copyright', '', 'blogwings_footer', __( 'Copyright text (empty = automatic)', 'blogwings' ), 'text', 'wp_kses_post' );

	$add( 'blogwings_sidebar', 1, 'blogwings_blog', __( 'Show sidebar on blog', 'blogwings' ), 'checkbox', $bool );
	$add( 'blogwings_blog_title', __( 'Notes from the data', 'blogwings' ), 'blogwings_blog', __( 'Blog page heading', 'blogwings' ) );
	$add( 'blogwings_blog_intro', __( 'Analysis, trends and the stories behind the rankings.', 'blogwings' ), 'blogwings_blog', __( 'Blog page intro', 'blogwings' ), 'textarea', 'sanitize_textarea_field' );
} );
