<?php 

/**
* Individual Page Gallery
*/

class CurlyPageGallery {

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
		if( $template === 'page-templates/petition.php' ){
			foreach ( $screens as $screen ) {
				add_meta_box(
					'curly_gallery_metabox', 
					__( 'Page Gallery', 'CURLYTHEME' ), 
					array( $this, 'meta_box_callback'), 
					$screen, 
					'side'
				);
			}
		}	
	}
	
	/** Add Meta Box Callback */
	public function meta_box_callback( $post ) {
		
		wp_nonce_field( 'curly_gallery_metabox', 'gallery_meta_box_nonce' );
		
		$ids = '';
		echo '<div class="inside-container">';
		$galleries = substr( get_post_meta( $post->ID, '_' . THEMEPREFIX . '_gallery', true ), 0, -1 );
		
		echo '<p>'.__('Choose the images that you want to display as an image gallery:','CURLYTHEME').'</p>';
		echo '<div class="images">';
			if( $galleries ){
				$galleries = explode( ',', $galleries );
				foreach( $galleries as $key => $gallery ){
					$ids .= $gallery . ',';
					echo wp_get_attachment_image( $gallery, 'thumbnail' );
				}
			}
		echo '</div>';
		
		echo "<input type='hidden' id='curly_galleries' name='curly_galleries' value='$ids'>";
		
		echo '</div>';
		
		echo '<div class="actions"><a href="#" id="gallery-upload-button" class="button button-primary">'.__( 'Select Images', 'CURLYTHEME' ).'</a> ';
		echo '<a href="#" id="gallery-clear-button" class="delete">'.__( 'Clear Gallery', 'CURLYTHEME' ).'</a></div>';
		
	}
	
	/** Save Meta Box */
	public function save_meta_box_data( $post_id ) {
		
		if ( ! isset( $_POST['gallery_meta_box_nonce'] ) ) {
			return;
		}
	
		if ( ! wp_verify_nonce( $_POST['gallery_meta_box_nonce'], 'curly_gallery_metabox' ) ) {
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
		
		if ( ! isset( $_POST['curly_galleries'] ) ) {
			return;
		}
	
		$data = sanitize_text_field( maybe_serialize( $_POST['curly_galleries'] ) );
		update_post_meta( $post_id, '_' . THEMEPREFIX . '_gallery', $data );
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

new CurlyPageGallery();

?>