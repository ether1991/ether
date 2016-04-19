<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Phosphor
 */
?>
		</div><!-- .content-inner -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer clearfix" role="contentinfo">
		<div class="footer-inner wrap">
			<div class="site-copyright">
				<?php
					global $theme_settings;
					echo esc_html($theme_settings['footer']['footer_text']);
				?>
			</div>
			<div class="site-info">
				<?php phosphor_credits(); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>