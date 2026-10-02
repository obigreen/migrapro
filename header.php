<?php
/**
 * Шапка BriefCube.
 *
 * @package BriefCube
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" data-site-header>
	<div class="site-shell site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="BriefCube — на главную">
			<span class="brand__mark" aria-hidden="true"><i></i><i></i><i></i></span>
			<span>brief<span>cube</span></span>
		</a>

		<button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="primary-navigation">
			<span class="screen-reader-text">Открыть меню</span>
			<span></span><span></span>
		</button>

		<nav id="primary-navigation" class="site-nav" aria-label="Основная навигация" data-site-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'briefcube_primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => 'briefcube_primary_menu_fallback',
					'depth'          => 1,
				)
			);
			?>
			<a class="site-nav__cta" href="#brief">Начать бриф <span aria-hidden="true">↗</span></a>
		</nav>
	</div>
</header>
