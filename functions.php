<?php
/**
 * Основная настройка темы BriefCube.
 *
 * @package BriefCube
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( '/inc/acf-fields.php' );

/**
 * Регистрирует базовые возможности темы и область меню.
 */
function briefcube_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
	);

	register_nav_menus(
		array(
			'briefcube_primary' => __( 'Основное меню BriefCube', 'briefcube' ),
		)
	);
}
add_action( 'after_setup_theme', 'briefcube_setup' );

/**
 * Возвращает версию ассета по времени его изменения, чтобы не держать старый кэш.
 *
 * @param string $path Путь от корня темы.
 * @return string
 */
function briefcube_asset_version( $path ) {
	$file = get_theme_file_path( $path );

	return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/**
 * Подключает стили и собранный ES-модуль с Three.js.
 */
function briefcube_enqueue_assets() {
	wp_enqueue_style(
		'briefcube-main',
		get_theme_file_uri( '/assets/css/main.css' ),
		array(),
		briefcube_asset_version( '/assets/css/main.css' )
	);

	wp_enqueue_style(
		'briefcube-adaptive',
		get_theme_file_uri( '/assets/css/adaptive.css' ),
		array( 'briefcube-main' ),
		briefcube_asset_version( '/assets/css/adaptive.css' )
	);

	$scene_path = get_theme_file_path( '/assets/js/briefcube-scene.js' );

	if ( file_exists( $scene_path ) ) {
		wp_enqueue_script(
			'briefcube-scene',
			get_theme_file_uri( '/assets/js/briefcube-scene.js' ),
			array(),
			briefcube_asset_version( '/assets/js/briefcube-scene.js' ),
			true
		);
		wp_script_add_data( 'briefcube-scene', 'type', 'module' );
	}
}
add_action( 'wp_enqueue_scripts', 'briefcube_enqueue_assets' );

/**
 * Возвращает значение ACF или безопасный fallback, если плагин ещё не включён.
 *
 * @param string $field_name Имя поля.
 * @param string $fallback   Резервное значение.
 * @return string
 */
function briefcube_get_field( $field_name, $fallback ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	$value = get_field( $field_name );

	return is_string( $value ) && '' !== $value ? $value : $fallback;
}

/**
 * Fallback-навигация, пока редактор не назначил меню из админки.
 */
function briefcube_primary_menu_fallback() {
	echo '<ul class="site-nav__list">';
	echo '<li><a href="#brief">Собрать бриф</a></li>';
	echo '<li><a href="#process">Как это работает</a></li>';
	echo '<li><a href="#benefits">Что внутри</a></li>';
	echo '</ul>';
}

/**
 * Создаёт приватный тип записей для заявок. Они не выводятся на публичном сайте.
 */
function briefcube_register_request_post_type() {
	register_post_type(
		'briefcube_request',
		array(
			'labels' => array(
				'name'          => 'Брифы',
				'singular_name' => 'Бриф',
				'menu_name'     => 'Брифы',
				'add_new_item'  => 'Добавить бриф',
				'edit_item'     => 'Открыть бриф',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'supports'            => array( 'title' ),
			'menu_icon'           => 'dashicons-feedback',
			'capability_type'     => 'post',
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'briefcube_register_request_post_type' );

/**
 * Сохраняет форму конструктора брифа как приватную запись WordPress.
 */
function briefcube_submit_request() {
	if ( ! isset( $_POST['briefcube_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['briefcube_nonce'] ) ), 'briefcube_submit_request' ) ) {
		wp_die( 'Не удалось проверить форму. Вернитесь назад и попробуйте снова.' );
	}

	$name  = isset( $_POST['brief_name'] ) ? sanitize_text_field( wp_unslash( $_POST['brief_name'] ) ) : '';
	$email = isset( $_POST['brief_email'] ) ? sanitize_email( wp_unslash( $_POST['brief_email'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'brief', 'invalid', home_url( '/' ) ) . '#brief' );
		exit;
	}

	$fields = array( 'project_type', 'project_goal', 'visual_style', 'timeline' );
	$meta   = array(
		'brief_name'  => $name,
		'brief_email' => $email,
	);

	foreach ( $fields as $field ) {
		$meta[ $field ] = isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
	}

	$request_id = wp_insert_post(
		array(
			'post_type'   => 'briefcube_request',
			'post_status' => 'private',
			'post_title'  => sprintf( 'Бриф — %s — %s', $name, wp_date( 'd.m.Y H:i' ) ),
		)
	);

	if ( is_wp_error( $request_id ) ) {
		wp_safe_redirect( add_query_arg( 'brief', 'error', home_url( '/' ) ) . '#brief' );
		exit;
	}

	foreach ( $meta as $key => $value ) {
		update_post_meta( $request_id, $key, $value );
	}

	wp_safe_redirect( add_query_arg( 'brief', 'sent', home_url( '/' ) ) . '#brief' );
	exit;
}
add_action( 'admin_post_nopriv_briefcube_submit_request', 'briefcube_submit_request' );
add_action( 'admin_post_briefcube_submit_request', 'briefcube_submit_request' );

/**
 * Показывает подсказку по ACF только администраторам и не мешает работе темы.
 */
function briefcube_acf_admin_notice() {
	if ( function_exists( 'get_field' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	echo '<div class="notice notice-info"><p>BriefCube работает с демонстрационным текстом. Установите Advanced Custom Fields, чтобы редактировать hero-блок из админки.</p></div>';
}
add_action( 'admin_notices', 'briefcube_acf_admin_notice' );
