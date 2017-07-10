<?php 

/**
* Individual Page Background
*/

class CurlyPageBackground {

	public function __construct(){
		
		add_action( 'add_meta_boxes', array( $this, 'meta_box') );
		add_action( 'save_post', array( $this, 'save_meta_box_data' ) );
		
		/** Load Assets */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		
	}
	
	/** Add Meta Box */
	function meta_box(){
		$screens = array( 'post', 'page' );
		$template = get_page_template_slug( get_queried_object_id() );	
		if( in_array( $template, array( 'page-templates/letter.php' ) ) ){
			foreach ( $screens as $screen ) {
				add_meta_box(
					'curly_bg_metabox', 
					__( 'Page Background', 'CURLYTHEME' ), 
					array( $this, 'meta_box_callback'), 
					$screen, 
					'side'
				);
			}
		}	
	}
	
	/** Add Meta Box Callback */
	public function meta_box_callback( $post ) {
		
		wp_nonce_field( 'curly_bg_metabox', 'bg_meta_box_nonce' );
		
		$bg_default	= get_post_meta( $post->ID, '_' . THEMEPREFIX . '_bg', true );
		$bg_array 	= array(
			0 => __( 'Lined Paper', 'CURLYTHEME'),
			1 => __( 'Confectionary', 'CURLYTHEME'),
			2 => __( 'Notebook', 'CURLYTHEME'),
			3 => __( 'Natural Paper', 'CURLYTHEME'),
			4 => __( 'Soft Paper', 'CURLYTHEME'),
			5 => __( 'Neutral Grid', 'CURLYTHEME')
		);
		
		echo '<p>'.__('Choose one of our custom backgrounds:','CURLYTHEME').'</p>';
		echo '<p><select name="curly_bg" id="curly_bg">';
				foreach( $bg_array as $key => $bg ){
					echo "<option value=$key ".selected( $key, $bg_default, false ).">$bg</option>";
				}
		echo '</select></p>';
		echo "<p><strong>".__( 'Custom Background Image', 'CURLYTHEME' )."</strong></p>";
		echo "<a href='#' class='upload-image'>".__( 'Upload Custom Image', 'CURLYTHEME' )."</a>";
		echo "<a href='#' class='clear-image'>".__( 'Clear Custom Background', 'CURLYTHEME' )."</a>";
		
	}
	
	/** Save Meta Box */
	public function save_meta_box_data( $post_id ) {
		
		if ( ! isset( $_POST['bg_meta_box_nonce'] ) ) {
			return;
		}
	
		if ( ! wp_verify_nonce( $_POST['bg_meta_box_nonce'], 'curly_bg_metabox' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		if ( ! isset( $_POST['curly_bg'] ) ) {
			return;
		}
	
		$data = sanitize_text_field( $_POST['curly_bg'] );
		update_post_meta( $post_id, '_' . THEMEPREFIX . '_bg', $data );
	}
	
	/** Load Assets */
	function load_assets(){
		
		wp_enqueue_media();

		wp_enqueue_script(
			'curly-gallery',
			get_template_directory_uri() . '/framework/assets/admin/js/min/media-uploader-min.js'
		);
		
		wp_enqueue_style(
			'curly-gallery',
			get_template_directory_uri() . '/framework/assets/admin/css/gallery.css',
			null, 
			false, 
			'all'
		);
	}

}

new CurlyPageBackground();

?>