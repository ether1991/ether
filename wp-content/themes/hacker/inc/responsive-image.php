<?php
/**
 * Change default 'srcset' images width.
 * 
 * @param  [type] $max_width [description]
 * @return int Max image width.
 */
function hacker_max_srcset_image_width( $max_width ) {
	return 2880; // Retina Macbook Pro 15
}
add_filter( 'max_srcset_image_width', 'hacker_max_srcset_image_width' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function hacker_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'full' === $size ) {
		$attr['sizes'] = '100vw';
	} elseif ( 'post-thumbnail' == $size ) {
		$attr['sizes'] = '(max-width: 720px) calc(100vw - 20px), 700px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'hacker_post_thumbnail_sizes_attr', 10 , 3 );