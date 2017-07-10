<?php 
	
/**
* CurlyComments
*/
class CurlyComments {

	public function __construct(){
		
		add_action( 'comment_form_before', array( $this, 'enqueue_comments_reply' ) );
		//add_filter( 'comments_open', array( $this, 'comments_open' ), 10, 2 );
		
		add_action( 'curly_comments', array( $this, 'comments_list' ) );
		add_action( 'curly_comments_form', array( $this, 'comment_form') );
		
		add_action( 'comment_form_top', array( $this, 'before_form' ) );
		add_action( 'comment_form_bottom', array( $this, 'after_form' ) );

		
	}
	
	
	
	function before_form(){
		echo '<div class="form-horizontal">';
	}
	function after_form(){
		echo '<div>';
	}
	
	
	
	function enqueue_comments_reply(){
		if( get_option( 'thread_comments' ) )  {
	        wp_enqueue_script( 'comment-reply' );
	    }
	}
	
	function comments_open( $open, $post_id ){
		if ( esc_attr( get_theme_mod( 'comments', true ) ) === true ) {	
			if ( is_page( $post_id ) ){
				$open = false;	
			}
		}
		return $open;
	}
	
	function comments_list(){
		wp_list_comments( array( 'callback' => array( $this, 'comments' ), 'style' => 'ul' ) );
	}
	
	function comment_form(){
		$req = get_option( 'require_name_email' );
		
		$user_identity = wp_get_current_user();
		$commenter = wp_get_current_commenter();
		$curly_comments_args = array(
	        'title_reply' => 
	        	__('Leave Comment','CURLYTHEME'),
	        'comment_notes_after'  => 
	        	'',
	        'comment_notes_before' => 
	        	'',
	        'class_submit'	=>
	        	'btn btn-primary submit',
	        'label_submit' => 
	        	__( 'Submit Comment' , 'CURLYTHEME'),
	        'logged_in_as' => 
	        	'<p>'. sprintf(__('You are logged in as %1$s. %2$sLog out &raquo;%3$s', 'CURLYTHEME'), 
	        	'<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity->user_login.'</a>', 
	        	'<a href="'.(function_exists('wp_logout_url') ? wp_logout_url(get_permalink()) : get_option('siteurl').'/wp-login.php?action=logout" title="').'" title="'.__('Log Out', 'CURLYTHEME').'">', 
	        	'</a>') . '</p>',
	        'comment_field' => 
	        	'<div class="form-group"><div class="comment-form-content col-lg-12"><label for="comment" class="input-textarea sr-only">' . __('<b>Comment</b> ( * )','CURLYTHEME'). '</label><textarea class="required form-control" name="comment" id="comment" rows="4" placeholder="'.__( 'Comment', 'CURLYTHEME' ).'"></textarea></div></div>',
			
			'fields' => 
				apply_filters( 
					'comment_form_default_fields', 
					array(
						'author' =>
							'<div class="form-group">' . '<div class="comment-form-author col-lg-6" '.( $req ? "data-required" : null ).'>'. '<label for="author" class="sr-only">'.__( 'Name', 'CURLYTHEME' ).'</label> ' . '<input class="form-control" id="author" name="author" type="text" placeholder="'.__( 'Name', 'CURLYTHEME' ).'" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30" /></div>',
						'email' =>
							'<div class="comment-form-email col-lg-6" '.( $req ? "data-required" : null ).'><label for="email" class="sr-only">'.__( 'Email', 'CURLYTHEME' ).'</label><input class="form-control" id="email" name="email" type="text" placeholder="'.__( 'Email', 'CURLYTHEME' ).'" value="'. esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /></div></div>',
						'url' =>
							'<div class="form-group"><div class="comment-form-url col-lg-12"><label for="url" class="sr-only"><strong>' .
							__( 'Website', 'CURLYTHEME' ) . '</strong></label> <input class="form-control" id="url" name="url" type="text" placeholder="'.__( 'Website', 'CURLYTHEME' ).'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>'
					)
				),
			);
			
		comment_form( $curly_comments_args );
	
	}
	
	function comments( $comment, $args, $depth ){
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' : ?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'CURLYTHEME' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'CURLYTHEME') ); ?></p><?php
				break;
			default :
			
			global $post; ?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<?php 
							/** Show Avatar */
							echo get_avatar( $comment, 120 );
						?>
						<header class="comment-meta comment-author vcard">
							<h6>
							<?php
								
								printf( '<cite class="fn">%1$s </cite>',
										get_comment_author_link()
								);
								printf( '<time datetime="%1$s">&mdash; %2$s</time>',
										get_comment_time( 'c' ),
										sprintf( __( '%1$s at %2$s', 'CURLYTHEME' ), get_comment_date(), get_comment_time() )
								);

							?>
							</h6>
						</header><!-- .comment-meta -->
			
						<div class="comment-content comment">
							<?php 
								
								/** Comment */
								comment_text(); 
							 	
							 	/** Reply Link */
								comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'CURLYTHEME' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
								
								edit_comment_link( __( '<i class="fa fa-pencil"></i> Edit', 'CURLYTHEME' ) );
								 
							?>
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<span class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'CURLYTHEME' ); ?></span>
							<?php endif; ?>
						</div>
					</article><?php
				break;
		endswitch;
	}

}
new CurlyComments();
?>