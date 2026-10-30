<?php
/**
 * Primary menu walker: top-level items with the class "bw-mega bw-mega--theme|plugin|author"
 * get a live "Top right now" panel next to their sub-menu.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;

class BlogWings_Walker extends Walker_Nav_Menu {

	private $mega = array();

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= $depth ? '<ul class="sub-menu">' : '<div class="bwt-drop"><ul class="sub-menu">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
		if ( 0 === $depth ) {
			$type = end( $this->mega );
			if ( $type && function_exists( 'bwing_enqueue' ) ) {
				$labels  = array(
					'theme'  => __( 'Top themes right now', 'blogwings' ),
					'plugin' => __( 'Top plugins right now', 'blogwings' ),
					'author' => __( 'Top authors right now', 'blogwings' ),
				);
				$output .= '<div class="bwt-drop__panel">' . do_shortcode( '[bwing_mini_top type="' . esc_attr( $type ) . '" count="5" title="' . esc_attr( $labels[ $type ] ) . '"]' ) . '</div>';
			}
			$output .= '</div>';
		}
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( 0 === $depth ) {
			$type = '';
			foreach ( (array) $item->classes as $c ) {
				if ( preg_match( '/^bw-mega--(theme|plugin|author)$/', $c, $m ) ) {
					$type = $m[1];
				}
			}
			$this->mega[] = $type;
		}
		$has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );
		parent::start_el( $output, $item, $depth, $args, $id );
		if ( $has_children && 0 === $depth ) {
			$output .= '<button class="bwt-drop__toggle" aria-expanded="false" aria-label="' . esc_attr__( 'Open submenu', 'blogwings' ) . '"><svg viewBox="0 0 12 12" aria-hidden="true"><path d="M3 4.5 6 7.5 9 4.5"/></svg></button>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			array_pop( $this->mega );
		}
		parent::end_el( $output, $item, $depth, $args );
	}
}

/** Fallback when no menu is assigned. */
function blogwings_menu_fallback() {
	echo '<ul class="bwt-menu">';
	wp_list_pages( array( 'title_li' => '', 'depth' => 1, 'number' => 6 ) );
	echo '</ul>';
}
