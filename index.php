<?php
/**
 * Запасной шаблон для записей и экранов, не входящих в лендинг.
 *
 * @package BriefCube
 */

get_header();
?>
<main class="fallback-page">
	<div class="site-shell">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
