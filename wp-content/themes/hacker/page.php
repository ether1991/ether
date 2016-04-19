<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Hacker
 */

get_header();the_post(); ?>
<main id="main" class="site-main" role="main">
	<article id="post-<?php the_ID(); ?>" <?php post_class('Article'); ?>>
		<div class="Article__content">
		<?php the_content(); ?>
		</div>
		<!-- END .Article__excerpt -->
		<footer class="Article__footer">
			<?php hacker_entry_footer(); ?>
		</footer>
		<!-- END .Article__footer -->
	</article>
	<!-- END .Article -->
</main>
<!-- END #main -->
<?php
get_footer();