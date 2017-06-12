<?php
/*
* Wordpress Nav Class for social icons menu 
* This class is inspired by WP_Bootstrap_Nav_Walker 
*
*/
class Abbey_Social_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		
	}

	/**
	 * 
	 *
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$classes[] = 'inline-block';
		$class_names = join( ' ', apply_filters( 'abbey_social_nav_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'abbey_social_nav_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->title )	? $item->title	: '';
		$atts['target'] = ! empty( $item->target )	? $item->target	: '_blank';
		$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
		$atts['href'] = ! empty( $item->url ) ? $item->url : '';
		$atts = apply_filters( 'abbey_social_nav_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before.$args->link_after;
		$item_output .= '<i class="fa fa-' . esc_attr( strtolower($item->title) ) . '"></i>&nbsp;';
		$item_output .= '</a>';
		$item_output .= $args->after;

			$output .= apply_filters( 'abbey_social_nav_start_el', $item_output, $item, $depth, $args );
		
	}



}