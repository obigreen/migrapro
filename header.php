<?php
/**
 * Шапка сайта.
 *
 * @package MigraPro
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

<header class="header" data-header>
	<div class="container">
		<div class="header__top">
			<a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'МиграПро — главная страница', 'migrapro' ); ?>">
				<img class="header__logo-img" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/logo.png' ) ); ?>" alt="<?php esc_attr_e( 'МиграПро', 'migrapro' ); ?>">
			</a>

			<div class="header__rating" aria-label="<?php esc_attr_e( 'Рейтинг 4,8 на Яндекс.Картах и 2ГИС', 'migrapro' ); ?>">
				<ul class="header__rating-list" aria-hidden="true">
					<?php for ( $star = 0; $star < 5; $star++ ) : ?>
						<li><?php echo migrapro_icon( 'rating-stars', 'header__rating-stars' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
					<?php endfor; ?>
				</ul>
				<span>4,8 на Яндекс.Картах и 2ГИС</span>
			</div>

			<div class="header__contact">
				<a href="tel:+74958590051">+7 (495) 859-00-51</a>
				<span>Пн–Пт: 09:00–18:00</span>
			</div>

			<div class="header__socials-group">
				<ul class="header__socials-list" aria-label="<?php esc_attr_e( 'Связаться в мессенджере', 'migrapro' ); ?>">
					<li><a class="header__social-link" href="#" aria-label="Telegram"><?php echo migrapro_icon( 'telegram', 'header__social-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
					<li><a class="header__social-link" href="#" aria-label="MAX"><?php echo migrapro_icon( 'max', 'header__social-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
				</ul>
				<a class="header__socials-button" href="#consultation">Бесплатная консультация</a>
			</div>

			<div class="header__mobile-actions">
				<a class="header__icon-button" href="tel:+74958590051" aria-label="<?php esc_attr_e( 'Позвонить', 'migrapro' ); ?>"><?php echo migrapro_icon( 'phone', 'header__mobile-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<button class="header__icon-button header__menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Открыть меню', 'migrapro' ); ?>" aria-expanded="false" aria-controls="primary-navigation" data-menu-toggle>
					<?php echo migrapro_icon( 'burger', 'header__mobile-icon header__mobile-icon--burger' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo migrapro_icon( 'close', 'header__mobile-icon header__mobile-icon--close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</div>
		</div>

		<div class="header__bottom">
			<nav id="primary-navigation" class="navigation" aria-label="<?php esc_attr_e( 'Основная навигация', 'migrapro' ); ?>" data-navigation>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'navigation__list',
						'fallback_cb'    => false,
						'depth'          => 2,
						'walker'         => new MigraPro_Menu_Walker(),
					)
				);
				?>
			</nav>
		</div>
	</div>
</header>
