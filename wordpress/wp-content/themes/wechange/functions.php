<?php 
	
	/** Theme Prefix */
	if ( ! defined('THEMEPREFIX') ) {
		define('THEMEPREFIX', 'wechange');
	}
	
	if ( ! isset( $content_width ) ) $content_width = 650;
	
	include( trailingslashit( get_template_directory() ) . 'framework/classes/class.customizer.php' );
	include( trailingslashit( get_template_directory() ) . 'framework/classes/class.page.gallery.php' );
	include( trailingslashit( get_template_directory() ) . 'framework/classes/class.meta-options.php' );
	include( trailingslashit( get_template_directory() ) . 'framework/classes/class.ips.php' );
	include( trailingslashit( get_template_directory() ) . 'framework/classes/class.color.php' );
	include( trailingslashit( get_template_directory() ) . 'framework/classes/class.typography.php' );
	
	include( trailingslashit( get_template_directory() ) . 'extend/class.init.php' );
	include( trailingslashit( get_template_directory() ) . 'extend/classes/class.petitions.php' );
	include( trailingslashit( get_template_directory() ) . 'extend/classes/class.render.css.php' );
	include( trailingslashit( get_template_directory() ) . 'extend/classes/class.comments.php' );
	
	//delete_transient( 'supporters' );
?>