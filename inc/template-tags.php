<?php
/**
 * Небольшие вспомогательные функции шаблонов.
 *
 * @package MigraPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Возвращает SVG-иконку из локального спрайта темы.
 *
 * @param string $icon_id Идентификатор символа в sprite.svg.
 * @param string $class   CSS-класс SVG.
 * @return string
 */
function migrapro_icon( $icon_id, $class = '' ) {
	$classes = trim( 'icon ' . $class );

	return sprintf(
		'<svg class="%1$s" aria-hidden="true" focusable="false"><use href="%2$s#%3$s"></use></svg>',
		esc_attr( $classes ),
		esc_url( get_theme_file_uri( '/assets/images/sprite.svg' ) ),
		esc_attr( $icon_id )
	);
}

/**
 * Возвращает значение поля ACF или безопасное демонстрационное значение.
 *
 * Пока ACF не установлен либо поле ещё пустое, вёрстка не ломается.
 *
 * @param string $field_name Имя поля ACF.
 * @param mixed  $fallback   Значение по умолчанию.
 * @return mixed
 */
function migrapro_get_field_value( $field_name, $fallback = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	$value = get_field( $field_name );

	return '' !== $value && null !== $value && false !== $value ? $value : $fallback;
}

/**
 * Приводит ACF-поле типа «Изображение» к URL.
 *
 * @param string $field_name Имя поля ACF.
 * @param string $fallback   Резервное изображение темы.
 * @return string
 */
function migrapro_get_image_url( $field_name, $fallback ) {
	$image = migrapro_get_field_value( $field_name, $fallback );

	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return $image['url'];
	}

	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, 'full' );

		return $url ? $url : $fallback;
	}

	return is_string( $image ) ? $image : $fallback;
}
