<?php
/**
 * Локальная регистрация ACF-полей для BriefCube.
 *
 * @package BriefCube
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Регистрирует компактную группу для первого экрана.
 */
function briefcube_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_briefcube_landing',
			'title'  => 'BriefCube: первый экран',
			'fields' => array(
				array(
					'key'   => 'field_briefcube_hero_badge',
					'label' => 'Бейдж',
					'name'  => 'briefcube_hero_badge',
					'type'  => 'text',
				),
				array(
					'key'       => 'field_briefcube_hero_title',
					'label'     => 'Заголовок',
					'name'      => 'briefcube_hero_title',
					'type'      => 'textarea',
					'rows'      => 3,
					'new_lines' => '',
				),
				array(
					'key'       => 'field_briefcube_hero_text',
					'label'     => 'Описание',
					'name'      => 'briefcube_hero_text',
					'type'      => 'textarea',
					'rows'      => 4,
					'new_lines' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
			),
			'position' => 'normal',
			'style'    => 'default',
		)
	);
}
add_action( 'acf/init', 'briefcube_register_acf_fields' );
