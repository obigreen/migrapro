<?php
/**
 * Поля ACF для hero-блока.
 *
 * Группа появляется при редактировании любой страницы. После создания
 * страницы «Главная» и назначения её главной в «Настройки → Чтение» значения
 * из этой группы использует front-page.php.
 *
 * @package MigraPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Создаёт компактное описание текстового поля ACF.
 *
 * @param string $key   Уникальный ключ ACF.
 * @param string $label Подпись в админке.
 * @param string $name  Имя, по которому поле читается в шаблоне.
 * @param string $type  Тип поля ACF.
 * @param array  $extra Дополнительные параметры ACF.
 * @return array
 */
function migrapro_acf_field( $key, $label, $name, $type = 'text', $extra = array() ) {
	return array_merge(
		array(
			'key'   => $key,
			'label' => $label,
			'name'  => $name,
			'type'  => $type,
		),
		$extra
	);
}

/**
 * Регистрирует понятную группу полей, не привязывая данные к коду шаблона.
 */
function migrapro_register_hero_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_migrapro_hero',
			'title'  => 'MigraPro: hero-блок',
			'fields' => array(
				array( 'key' => 'field_migrapro_intro_tab', 'label' => 'Основной блок', 'type' => 'tab' ),
				migrapro_acf_field( 'field_migrapro_hero_title', 'Заголовок', 'hero_title', 'textarea', array( 'rows' => 3, 'new_lines' => '' ) ),
				migrapro_acf_field( 'field_migrapro_hero_description', 'Описание', 'hero_description', 'textarea', array( 'rows' => 4, 'new_lines' => '' ) ),
				migrapro_acf_field( 'field_migrapro_hero_kicker', 'Подзаголовок над карточками', 'hero_kicker' ),
				migrapro_acf_field( 'field_migrapro_hero_image', 'Декоративная иллюстрация', 'hero_image', 'image', array( 'return_format' => 'url', 'preview_size' => 'medium', 'library' => 'all' ) ),

				array( 'key' => 'field_migrapro_citizen_tab', 'label' => 'Карточка «Иностранным гражданам»', 'type' => 'tab' ),
				migrapro_acf_field( 'field_migrapro_citizen_eyebrow', 'Надзаголовок', 'citizen_card_eyebrow' ),
				migrapro_acf_field( 'field_migrapro_citizen_title', 'Заголовок', 'citizen_card_title', 'textarea', array( 'rows' => 2, 'new_lines' => '' ) ),
				migrapro_acf_field( 'field_migrapro_citizen_description', 'Описание', 'citizen_card_description', 'textarea', array( 'rows' => 4, 'new_lines' => '' ) ),
				migrapro_acf_field( 'field_migrapro_citizen_primary_label', 'Текст основной кнопки', 'citizen_primary_label' ),
				migrapro_acf_field( 'field_migrapro_citizen_primary_url', 'Ссылка основной кнопки', 'citizen_primary_url', 'url' ),
				migrapro_acf_field( 'field_migrapro_citizen_secondary_label', 'Текст дополнительной кнопки', 'citizen_secondary_label' ),
				migrapro_acf_field( 'field_migrapro_citizen_secondary_url', 'Ссылка дополнительной кнопки', 'citizen_secondary_url', 'url' ),

				array( 'key' => 'field_migrapro_employer_tab', 'label' => 'Карточка «Работодателям»', 'type' => 'tab' ),
				migrapro_acf_field( 'field_migrapro_employer_eyebrow', 'Надзаголовок', 'employer_card_eyebrow' ),
				migrapro_acf_field( 'field_migrapro_employer_title', 'Заголовок', 'employer_card_title', 'textarea', array( 'rows' => 2, 'new_lines' => '' ) ),
				migrapro_acf_field( 'field_migrapro_employer_description', 'Описание', 'employer_card_description', 'textarea', array( 'rows' => 4, 'new_lines' => '' ) ),
				migrapro_acf_field( 'field_migrapro_employer_label', 'Текст кнопки', 'employer_button_label' ),
				migrapro_acf_field( 'field_migrapro_employer_url', 'Ссылка кнопки', 'employer_button_url', 'url' ),

				array( 'key' => 'field_migrapro_region_tab', 'label' => 'Регион и цифры', 'type' => 'tab' ),
				migrapro_acf_field( 'field_migrapro_region_offices', 'Офисы', 'region_offices' ),
				migrapro_acf_field( 'field_migrapro_region_area', 'География работы', 'region_area' ),
				migrapro_acf_field( 'field_migrapro_stat_1_title', 'Цифра 1', 'stat_1_title' ),
				migrapro_acf_field( 'field_migrapro_stat_1_text', 'Подпись 1', 'stat_1_text' ),
				migrapro_acf_field( 'field_migrapro_stat_2_title', 'Цифра 2', 'stat_2_title' ),
				migrapro_acf_field( 'field_migrapro_stat_2_text', 'Подпись 2', 'stat_2_text' ),
				migrapro_acf_field( 'field_migrapro_stat_3_title', 'Цифра 3', 'stat_3_title' ),
				migrapro_acf_field( 'field_migrapro_stat_3_text', 'Подпись 3', 'stat_3_text' ),
				migrapro_acf_field( 'field_migrapro_stat_4_title', 'Цифра 4', 'stat_4_title' ),
				migrapro_acf_field( 'field_migrapro_stat_4_text', 'Подпись 4', 'stat_4_text' ),
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
add_action( 'acf/init', 'migrapro_register_hero_fields' );
