<?php
/**
 * TPA Base — Custom nav walker for dropdown menus.
 * Adds .dropdown class to parent items, renders clean dropdown markup.
 */
class TPA_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="dropdown-menu">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes      = $item->classes ?? [];
        $has_children = in_array( 'menu-item-has-children', $classes, true );

        if ( $has_children && $depth === 0 ) {
            $classes[] = 'dropdown';
        }

        $class_str = esc_attr( trim( implode( ' ', array_filter( $classes ) ) ) );
        $output   .= '<li class="' . $class_str . '">';

        $link_class = $has_children && $depth === 0 ? ' class="dropdown-toggle"' : '';
        $output    .= '<a href="' . esc_url( $item->url ) . '"' . $link_class . '>';
        $output    .= esc_html( $item->title );
        $output    .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}
