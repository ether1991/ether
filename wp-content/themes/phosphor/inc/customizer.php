<?php
/**
 * Phosphor Theme Customizer
 *
 * @package Phosphor
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function phosphor_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'phosphor_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function phosphor_customize_preview_js() {
	wp_enqueue_script( 'phosphor_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'phosphor_customize_preview_js' );

function phosphor_register_custom_control_assets(){
	wp_register_script( "media-items-control-script", get_stylesheet_directory_uri() . "/js/media-items-control.js", array('jquery'), "1.0", false );
	wp_register_style( "media-items-control-styles", get_stylesheet_directory_uri() . "/css/media-items-control.css", null, "1.0", "all" );
}
add_action( 'init', 'phosphor_register_custom_control_assets' );

if( class_exists( 'WP_Customize_Control' ) ):

	class WP_Customize_Media_Items_Control extends WP_Customize_Control {
		public $type = 'media_items';

		public function enqueue(){
			wp_enqueue_script( "media-items-control-script" );
			wp_enqueue_style( "media-items-control-styles" );
		}

		public function render_content() {
		?>
			<div class="media-items-control">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
				<button type="button" class="button media-items-select"><?php _e('Choose Media Items', 'phosphor'); ?></button>
				<button type="button" class="button media-items-clear"><?php _e('Clear', 'phosphor'); ?></button>
				<div class="selected-media-items">
					<?php
						$image_ids = $this->value();
						$image_ids = !empty( $image_ids ) ? explode(',', $image_ids) : array();
						foreach($image_ids as $id){
							echo wp_get_attachment_image( $id, 'thumbnail' );
						}
					?>
				</div>
			</div>
		<?php
		}
	}

endif;