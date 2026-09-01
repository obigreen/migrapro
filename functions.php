<?php
/**
 * Настройка темы MigraPro.
 *
 * @package MigraPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( '/inc/template-tags.php' );
require_once get_theme_file_path( '/inc/class-migrapro-menu-walker.php' );
require_once get_theme_file_path( '/inc/acf-fields.php' );

/**
 * Регистрирует возможности темы и место для меню из админки WordPress.
 */
function migrapro_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Основное меню', 'migrapro' ),
		)
	);
}
add_action( 'after_setup_theme', 'migrapro_setup' );

/**
 * Подключает стили и скрипт исходной вёрстки.
 */
function migrapro_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'migrapro-main',
		get_theme_file_uri( '/assets/css/main.css' ),
		array(),
		$theme_version
	);

	wp_enqueue_style(
		'migrapro-adaptive',
		get_theme_file_uri( '/assets/css/adaptive.css' ),
		array( 'migrapro-main' ),
		$theme_version
	);

	wp_enqueue_script(
		'migrapro-navigation',
		get_theme_file_uri( '/assets/js/navigation.js' ),
		array(),
		$theme_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'migrapro_enqueue_assets' );

/**
 * Напоминает установить ACF: тема продолжит работать с демонстрационными данными.
 */
function migrapro_acf_admin_notice() {
	if ( function_exists( 'get_field' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	echo '<div class="notice notice-info"><p>';
	echo esc_html__( 'Тема MigraPro готова к ACF. Установите и активируйте Advanced Custom Fields, чтобы редактировать содержимое hero-блока из админки.', 'migrapro' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'migrapro_acf_admin_notice' );
