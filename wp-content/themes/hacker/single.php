<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Hacker
 */

get_header(); the_post(); ?>
<main id="main" class="site-main" role="main">
	<article id="post-<?php the_ID(); ?>" <?php post_class('Article'); ?>>
		<h3 class="Article__title"><?php the_title(); ?></h3>
		<div class="Article__top-meta">
			<?php hacker_posted_on(); ?>
		</div>
		<?php if(get_post_format() == 'image') : ?>
		<div class="Extendfull featured-media">
			<div class="Extendfull__inner">
			<?php the_post_thumbnail('full'); ?>
			</div>
		</div>
		<!-- END .Extendfull -->
		<?php elseif (get_post_format() == 'video') : ?>
		<div class="featured-media video-embed">
			<?php echo get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
		</div>
		<!-- END .featured-media -->
		<?php elseif (has_post_thumbnail()) : ?>
		<div class="featured-media">
			<?php the_post_thumbnail(); ?>
		</div>
		<!-- END .featured-media -->
		<?php endif; ?>
		
		<div class="Article__content">
		<?php 
			the_content( sprintf(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'hacker' ),
				get_the_title()
			) ); 
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'hacker' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'hacker' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
		</div>
		<!-- END .Article__content -->
		<footer class="Article__footer">
			<?php hacker_entry_footer(); ?>
		</footer>
		<!-- END .Article__footer -->
	</article>
	<!-- END .Article -->
	<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() )  {
			comments_template();
		}	
	?>
</main>
<!-- END #main -->

<?php
get_footer();