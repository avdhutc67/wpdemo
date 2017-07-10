<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom date picker
 */
class Curly_Slider_Control extends WP_Customize_Control
{
    /**
    * Enqueue the styles and scripts
    */
    public function enqueue()
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'jquery-ui-mouse' );
    }

    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {

        ?>
            <label>
              <span class="customize-control-title">
              	<?php echo esc_html( $this->label ); ?>
              	<span class="range-value"><?php echo $this->value(); echo $this->input_attrs['suffix']; ?></span>
              </span>
              <input type="hidden" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" data-customize-setting-link="<?php echo $this->id; ?>" />
              <div class="curly-slider" id="slider-<?php echo $this->id; ?>"></div>
              <span class="description customize-control-description"><?php echo $this->description; ?></span>
              <script type="text/javascript">
	              (function($) {
				  "use strict";
				  
				  $(function() {
				    $( "#slider-<?php echo $this->id; ?>" ).slider({
					    value: <?php echo $this->value(); ?>, 
						step: <?php echo $this->input_attrs['step']; ?>, 
						min: <?php echo $this->input_attrs['min']; ?>, 
						max: <?php echo $this->input_attrs['max']; ?>, 
						slide: function( event, ui ) {
							jQuery(this).siblings( '.customize-control-title' ).children('.range-value').text( ui.value + "<?php echo $this->input_attrs['suffix']; ?>" );
							jQuery(this).siblings("input[type=hidden]").val(ui.value).trigger('change'); 
						}
				    });
				  });
					
				})(jQuery);
              </script>
            </label>
        <?php
    }
}
?>