<?php
/**
 * Разметка стандартного меню WordPress в классах готовой вёрстки.
 *
 * @package MigraPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MigraPro_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * Открывает выпадающий список для дочерних пунктов «Услуг».
	 *
	 * @param string   $output HTML меню.
	 * @param int      $depth Текущая глубина.
	 * @param stdClass $args  Аргументы wp_nav_menu().
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );

		if ( 0 === $depth ) {
			$output .= "\n{$indent}<div id=\"services-submenu\" class=\"navigation__submenu\"><ul class=\"navigation__submenu-list\">\n";
			return;
		}

		$output .= "\n{$indent}<ul class=\"navigation__submenu-list\">\n";
	}

	/**
	 * Закрывает выпадающий список.
	 *
	 * @param string   $output HTML меню.
	 * @param int      $depth Текущая глубина.
	 * @param stdClass $args  Аргументы wp_nav_menu().
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= 0 === $depth ? "{$indent}</ul></div>\n" : "{$indent}</ul>\n";
	}

	/**
	 * Выводит один пункт меню. Дочерние пункты первого уровня образуют подменю.
	 *
	 * @param string   $output HTML меню.
	 * @param WP_Post  $item   Пункт меню.
	 * @param int      $depth  Глубина пункта.
	 * @param stdClass $args   Аргументы wp_nav_menu().
	 * @param int      $id     ID пункта.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$classes[]    = 'navigation__item';

		if ( 0 !== $depth ) {
			$classes[] = 'navigation__sub-item';
		}

		if ( $has_children ) {
			$classes[] = 'navigation__item--services';
		}

		$class_names = implode( ' ', array_filter( array_map( 'sanitize_html_class', $classes ) ) );
		$output     .= '<li class="' . esc_attr( $class_names ) . '">';

		if ( $has_children && 0 === $depth ) {
			$output .= '<button class="navigation__submenu-toggle" type="button" aria-expanded="false" aria-controls="services-submenu">';
			$output .= '<span class="navigation__label">' . esc_html( $item->title ) . '</span>';
			$output .= migrapro_icon( 'menu-lines', 'navigation__submenu-icon' );
			$output .= '</button>';
			return;
		}

		$link_classes = 0 === $depth ? 'navigation__link' : 'navigation__link navigation__sub-link';
		$attributes   = array(
			'href'  => ! empty( $item->url ) ? $item->url : '#',
			'title' => $item->attr_title,
			'target' => $item->target,
			'rel'   => $item->xfn,
			'class' => $link_classes,
		);
		$attributes   = apply_filters( 'nav_menu_link_attributes', $attributes, $item, $args, $depth );
		$attribute_html = '';

		foreach ( $attributes as $name => $value ) {
			if ( false !== $value && '' !== $value && null !== $value ) {
				$attribute_html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
			}
		}

		$output .= '<a' . $attribute_html . '>';

		if ( 0 === $depth ) {
			$output .= esc_html( $item->title );
		} else {
			$output .= '<span class="navigation__label">' . esc_html( $item->title ) . '</span>';

			if ( ! empty( $item->description ) ) {
				$output .= '<span class="navigation__description">' . esc_html( $item->description ) . '</span>';
			}
		}

		$output .= '</a>';
	}
}
