<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Phosphor
 */

if ( ! is_active_sidebar( 'sidebar-1' ) || phosphor_get_effective_layout() == 'fullwidth' ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
