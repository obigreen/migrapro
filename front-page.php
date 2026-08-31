<?php
/**
 * Главная страница: шапка и hero-блок.
 *
 * Резервные значения сохраняют вёрстку до установки ACF. После установки
 * плагина поля с этими именами станут редактируемыми в админке.
 *
 * @package MigraPro
 */

$hero_title       = migrapro_get_field_value( 'hero_title', 'Миграционные услуги в Москве и Московской области' );
$hero_description = migrapro_get_field_value( 'hero_description', 'РВП, ВНЖ, гражданство РФ: собираем полный пакет документов и ведём дело до результата. Компаниям — легальное оформление иностранных сотрудников.' );
$hero_kicker      = migrapro_get_field_value( 'hero_kicker', 'Выберите свой путь.' );
$hero_image       = migrapro_get_image_url( 'hero_image', get_theme_file_uri( '/assets/images/hero.webp' ) );

$citizen_title       = migrapro_get_field_value( 'citizen_card_title', 'Оформляю статус себе или семье' );
$citizen_description = migrapro_get_field_value( 'citizen_card_description', 'РВП, ВНЖ, гражданство РФ. Проверим основание, соберём документы, подадим без ошибок. Не знаете, с чего начать — начните с консультации.' );
$citizen_eyebrow     = migrapro_get_field_value( 'citizen_card_eyebrow', 'Иностранным гражданам' );
$citizen_primary     = migrapro_get_field_value( 'citizen_primary_label', 'Бесплатная консультация' );
$citizen_primary_url = migrapro_get_field_value( 'citizen_primary_url', '#consultation' );
$citizen_secondary   = migrapro_get_field_value( 'citizen_secondary_label', 'Смотреть услуги и цены' );
$citizen_secondary_url = migrapro_get_field_value( 'citizen_secondary_url', '#services' );

$employer_title       = migrapro_get_field_value( 'employer_card_title', 'Оформляю иностранных сотрудников' );
$employer_description = migrapro_get_field_value( 'employer_card_description', 'Разрешения на работу, ВКС, кадровые уведомления в МВД. Более 10 лет в миграционном праве, работаем с компаниями Москвы и области.' );
$employer_eyebrow     = migrapro_get_field_value( 'employer_card_eyebrow', 'Работодателям' );
$employer_button      = migrapro_get_field_value( 'employer_button_label', 'Решение для работодателей' );
$employer_button_url  = migrapro_get_field_value( 'employer_button_url', '#employers' );

$region_offices = migrapro_get_field_value( 'region_offices', 'Офисы в Подольске и Одинцово' );
$region_area    = migrapro_get_field_value( 'region_area', 'Работаем по Москве и Московской области' );

$stats = array(
	array( 'icon' => 'badge-check', 'title' => migrapro_get_field_value( 'stat_1_title', 'Более 10 лет' ), 'text' => migrapro_get_field_value( 'stat_1_text', 'помогаем с миграционными документами' ) ),
	array( 'icon' => 'clipboard-check', 'title' => migrapro_get_field_value( 'stat_2_title', '6 000+' ), 'text' => migrapro_get_field_value( 'stat_2_text', 'оформлений по РВП, ВНЖ и гражданству' ) ),
	array( 'icon' => 'building', 'title' => migrapro_get_field_value( 'stat_3_title', '2 офиса' ), 'text' => migrapro_get_field_value( 'stat_3_text', 'Подольск и Одинцово: приём рядом с домом, без поездки в центр' ) ),
	array( 'icon' => 'star', 'title' => migrapro_get_field_value( 'stat_4_title', '4,8' ), 'text' => migrapro_get_field_value( 'stat_4_text', 'рейтинг на Яндекс.Картах и 2ГИС' ) ),
);

get_header();
?>

<main id="main-content" class="main">
	<section class="hero" aria-labelledby="hero-title">
		<div class="container">
			<div class="hero__stage" style="<?php echo esc_attr( '--hero-visual-image: url(\'' . esc_url( $hero_image ) . '\');' ); ?>">
				<div class="hero__copy">
					<h1 id="hero-title" class="hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="hero__subtitle"><?php echo esc_html( $hero_description ); ?></p>
					<p class="hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
				</div>

				<div id="consultation" class="hero__cards">
					<article class="hero__card">
						<div class="hero__card-content">
							<p class="hero__card-eyebrow"><?php echo esc_html( $citizen_eyebrow ); ?></p>
							<div class="hero__card-text">
								<h2 class="hero__card-title"><?php echo esc_html( $citizen_title ); ?></h2>
								<p class="hero__card-description"><?php echo esc_html( $citizen_description ); ?></p>
							</div>
						</div>
						<div class="hero__card-buttons">
							<a class="hero__card-button button--primary" href="<?php echo esc_url( $citizen_primary_url ); ?>"><?php echo esc_html( $citizen_primary ); ?></a>
							<a class="hero__card-button button--secondary" href="<?php echo esc_url( $citizen_secondary_url ); ?>"><?php echo esc_html( $citizen_secondary ); ?></a>
						</div>
					</article>

					<article id="employers" class="hero__card">
						<div class="hero__card-content">
							<p class="hero__card-eyebrow"><?php echo esc_html( $employer_eyebrow ); ?></p>
							<div class="hero__card-text">
								<h2 class="hero__card-title"><?php echo esc_html( $employer_title ); ?></h2>
								<p class="hero__card-description"><?php echo esc_html( $employer_description ); ?></p>
							</div>
						</div>
						<div class="hero__card-buttons">
							<a class="hero__card-button button--primary" href="<?php echo esc_url( $employer_button_url ); ?>"><span><?php echo esc_html( $employer_button ); ?></span><?php echo migrapro_icon( 'arrow-up-right', 'hero__card-arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
						<div class="hero__card-buttons hero__card-buttons--mobile">
							<a class="hero__card-button button--primary" href="<?php echo esc_url( $citizen_primary_url ); ?>"><?php echo esc_html( $citizen_primary ); ?></a>
							<a class="hero__card-button button--secondary" href="<?php echo esc_url( $citizen_secondary_url ); ?>"><?php echo esc_html( $citizen_secondary ); ?></a>
						</div>
					</article>

					<article class="hero__region" aria-label="Регион работы">
						<div class="hero__region-content">
							<p><?php echo esc_html( $region_offices ); ?></p>
							<p><?php echo esc_html( $region_area ); ?></p>
						</div>
					</article>
				</div>
			</div>

			<ul class="hero__stats" aria-label="MigraPro в цифрах">
				<?php foreach ( $stats as $stat ) : ?>
					<li class="hero-stat">
						<span class="hero-stat__icon-wrap"><?php echo migrapro_icon( $stat['icon'], 'hero-stat__icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span class="hero-stat__content">
							<strong class="hero-stat__title"><?php echo esc_html( $stat['title'] ); ?></strong>
							<span class="hero-stat__text"><?php echo esc_html( $stat['text'] ); ?></span>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
</main>

<?php get_footer(); ?>
