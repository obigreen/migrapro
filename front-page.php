<?php
/**
 * Главная страница интерактивного бриф-конструктора.
 *
 * @package BriefCube
 */

$hero_badge = briefcube_get_field( 'briefcube_hero_badge', 'brief builder / 01' );
$hero_title = briefcube_get_field( 'briefcube_hero_title', 'Соберите ясный бриф на сайт за несколько минут.' );
$hero_text  = briefcube_get_field( 'briefcube_hero_text', 'BriefCube превращает четыре простых выбора в основу будущего веб-проекта. Без таблиц, долгих писем и пустого листа.' );
$brief_state = isset( $_GET['brief'] ) ? sanitize_key( wp_unslash( $_GET['brief'] ) ) : '';

get_header();
?>
<main id="main-content">
	<section class="hero" aria-labelledby="hero-title">
		<div class="site-shell hero__grid">
			<div class="hero__copy">
				<p class="eyebrow"><span></span><?php echo esc_html( $hero_badge ); ?></p>
				<h1 id="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
				<p class="hero__text"><?php echo esc_html( $hero_text ); ?></p>
				<a class="button button--dark" href="#brief">Собрать бриф <span aria-hidden="true">↓</span></a>
				<div class="hero__note"><span aria-hidden="true">✦</span> База для разговора, а не шаблон вместо вас.</div>
			</div>
			<div class="hero__scene-wrap" aria-label="Интерактивная 3D-сцена с кубом" data-cube-scene>
				<canvas class="hero__canvas" data-cube-canvas></canvas>
				<div class="hero__scene-label hero__scene-label--one">цель</div>
				<div class="hero__scene-label hero__scene-label--two">идея</div>
				<div class="hero__scene-label hero__scene-label--three">стиль</div>
				<p class="hero__scene-caption">Поверните сценарий<br>в нужную сторону.</p>
			</div>
		</div>
	</section>

	<section id="brief" class="brief-section" aria-labelledby="brief-title">
		<div class="site-shell">
			<div class="section-heading">
				<p class="eyebrow"><span></span>конструктор / 02</p>
				<h2 id="brief-title">Четыре решения.<br>Одна понятная заявка.</h2>
				<p>Выберите опции, а финальная карточка соберёт краткое описание задачи.</p>
			</div>

			<?php if ( 'sent' === $brief_state ) : ?>
				<p class="form-notice form-notice--success" role="status">Готово — бриф сохранён. Он уже ждёт в админке WordPress.</p>
			<?php elseif ( 'invalid' === $brief_state ) : ?>
				<p class="form-notice" role="alert">Заполните имя и корректный email, чтобы сохранить бриф.</p>
			<?php elseif ( 'error' === $brief_state ) : ?>
				<p class="form-notice" role="alert">Не удалось сохранить бриф. Попробуйте ещё раз.</p>
			<?php endif; ?>

			<form class="brief-builder" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-brief-form>
				<input type="hidden" name="action" value="briefcube_submit_request">
				<?php wp_nonce_field( 'briefcube_submit_request', 'briefcube_nonce' ); ?>
				<input type="hidden" name="project_type" value="">
				<input type="hidden" name="project_goal" value="">
				<input type="hidden" name="visual_style" value="">
				<input type="hidden" name="timeline" value="">

				<ol class="brief-builder__steps" aria-label="Шаги брифа">
					<li><button type="button" data-cube-step="0" class="is-active"><span>01</span>Формат</button></li>
					<li><button type="button" data-cube-step="1"><span>02</span>Цель</button></li>
					<li><button type="button" data-cube-step="2"><span>03</span>Стиль</button></li>
					<li><button type="button" data-cube-step="3"><span>04</span>Срок</button></li>
				</ol>

				<div class="brief-builder__body">
					<div class="brief-builder__questions">
						<fieldset class="brief-question" data-question="project_type">
							<legend><span>01</span> Что собираем?</legend>
							<div class="choice-grid">
								<button type="button" data-brief-choice data-field="project_type" data-value="Лендинг"><b>Лендинг</b><small>сфокусированная история</small></button>
								<button type="button" data-brief-choice data-field="project_type" data-value="Сайт компании"><b>Сайт компании</b><small>структура и доверие</small></button>
								<button type="button" data-brief-choice data-field="project_type" data-value="Личный проект"><b>Личный проект</b><small>идея с характером</small></button>
							</div>
						</fieldset>

						<fieldset class="brief-question" data-question="project_goal">
							<legend><span>02</span> Главная цель?</legend>
							<div class="choice-grid choice-grid--two">
								<button type="button" data-brief-choice data-field="project_goal" data-value="Получать заявки"><b>Получать заявки</b><small>конверсия и диалог</small></button>
								<button type="button" data-brief-choice data-field="project_goal" data-value="Показать продукт"><b>Показать продукт</b><small>ясно и убедительно</small></button>
								<button type="button" data-brief-choice data-field="project_goal" data-value="Собрать аудиторию"><b>Собрать аудиторию</b><small>интерес и подписки</small></button>
								<button type="button" data-brief-choice data-field="project_goal" data-value="Проверить идею"><b>Проверить идею</b><small>быстрый старт</small></button>
							</div>
						</fieldset>

						<fieldset class="brief-question" data-question="visual_style">
							<legend><span>03</span> Какое настроение?</legend>
							<div class="choice-grid choice-grid--two">
								<button type="button" data-brief-choice data-field="visual_style" data-value="Строго и чисто"><b>Строго и чисто</b><small>воздух, сетка, типографика</small></button>
								<button type="button" data-brief-choice data-field="visual_style" data-value="Смело и ярко"><b>Смело и ярко</b><small>контраст и эмоция</small></button>
								<button type="button" data-brief-choice data-field="visual_style" data-value="Технологично"><b>Технологично</b><small>свет, глубина, движение</small></button>
								<button type="button" data-brief-choice data-field="visual_style" data-value="Тепло и человечно"><b>Тепло и человечно</b><small>мягкость и детали</small></button>
							</div>
						</fieldset>

						<fieldset class="brief-question" data-question="timeline">
							<legend><span>04</span> Когда стартуем?</legend>
							<div class="choice-grid choice-grid--two">
								<button type="button" data-brief-choice data-field="timeline" data-value="На этой неделе"><b>На этой неделе</b><small>есть готовые материалы</small></button>
								<button type="button" data-brief-choice data-field="timeline" data-value="В течение месяца"><b>В течение месяца</b><small>идём спокойно</small></button>
								<button type="button" data-brief-choice data-field="timeline" data-value="Пока исследую"><b>Пока исследую</b><small>собираю направление</small></button>
								<button type="button" data-brief-choice data-field="timeline" data-value="Нужен план"><b>Нужен план</b><small>начинаю с нуля</small></button>
							</div>
						</fieldset>
					</div>

					<aside class="brief-summary" aria-live="polite">
						<p class="brief-summary__eyebrow">ваш черновик</p>
						<h3>Будущий проект</h3>
						<dl>
							<div><dt>Формат</dt><dd data-summary="project_type">—</dd></div>
							<div><dt>Цель</dt><dd data-summary="project_goal">—</dd></div>
							<div><dt>Стиль</dt><dd data-summary="visual_style">—</dd></div>
							<div><dt>Старт</dt><dd data-summary="timeline">—</dd></div>
						</dl>
						<div class="brief-summary__contacts">
							<label>Как к вам обращаться<input name="brief_name" type="text" autocomplete="name" required placeholder="Имя"></label>
							<label>Email для ответа<input name="brief_email" type="email" autocomplete="email" required placeholder="you@example.com"></label>
						</div>
						<button class="button button--lime" type="submit">Сохранить бриф <span aria-hidden="true">↗</span></button>
						<p>Демо сохраняет бриф в приватных записях WordPress. Письма никуда не отправляются.</p>
					</aside>
				</div>
			</form>
		</div>
	</section>

	<section id="process" class="process-section">
		<div class="site-shell">
			<div class="section-heading section-heading--row">
				<div><p class="eyebrow"><span></span>сценарий / 03</p><h2>Не анкета.<br>Начало разговора.</h2></div>
				<p>Куб — не декоративный объект. Его грани отражают четыре решения, из которых складывается направление проекта.</p>
			</div>
			<ol class="process-list">
				<li><span>01</span><h3>Выбираете</h3><p>Только то, что уже понятно прямо сейчас.</p></li>
				<li><span>02</span><h3>Собираете</h3><p>Краткую и живую основу для обсуждения.</p></li>
				<li><span>03</span><h3>Продолжаете</h3><p>Дорабатываете идею без потери контекста.</p></li>
			</ol>
		</div>
	</section>

	<section id="benefits" class="benefits-section">
		<div class="site-shell benefits-section__grid">
			<div class="benefits-section__quote">«Чёткий первый шаг<br>лучше идеального<br>пустого листа».</div>
			<div class="benefits-section__cards">
				<article><span>✦</span><h3>Редактируемо</h3><p>Тексты первого экрана меняются из WordPress через ACF.</p></article>
				<article><span>⌘</span><h3>Доступно</h3><p>Интерфейс работает без drag-and-drop и уважает настройки движения.</p></article>
				<article><span>◌</span><h3>Расширяемо</h3><p>Заявки уже сохраняются в админке; дальше легко добавить email и CRM.</p></article>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
