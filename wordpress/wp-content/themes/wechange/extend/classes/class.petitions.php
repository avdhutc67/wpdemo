<?php 


/**
* Petitions Engine
*/
class CurlyPetitions {

	public function __construct(){
		
		/** Shortcodes */
		add_shortcode( 'petition-counter', array( $this, 'total') );
		
		/** Ajax */
		add_action( 'wp_ajax_sign_petition', array( $this, 'sign' ) );
		add_action( 'wp_ajax_nopriv_sign_petition', array( $this, 'sign' ) );
		
		/** Add Petitioner Role */
		add_action( "after_switch_theme", array( $this, 'petitioner' ) );
		
		/** Load Assets */
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
		
		/** Petition Counter */
		add_action( 'petition-counter', array( $this, 'counter' ) );
		
		/** Petition Supporters */
		add_action( 'petition-supporters', array( $this, 'supporters' ) );
		
		/** Petition Sign */
		add_action( 'sign-petition', array( $this, 'form') );
		
		add_action( 'show_user_profile', array( $this, 'display_user_signature' ) );
		add_action( 'edit_user_profile', array( $this, 'display_user_signature' ) );
		
		/** Signature Column */
		add_filter( 'manage_users_columns' , array( $this, 'add_signature_column' ) );
		add_action( 'manage_users_custom_column',  array( $this, 'add_signature_column_content' ), 10, 3 );
		
	}
	
	
	
	/** User Profile Signature */	
	function display_user_signature( $user ) { ?>
	    <table class="form-table">
	        <tr>
	            <th><label><?php _e( 'User Signature', 'CURLYTHEME' ) ?></label></th>
	            <td><?php echo get_user_meta( $user->ID, 'petition_signature', true ); ?></td>
	        </tr>
	    </table>
	    <?php
	}
	
	
	
	
	
	/** Add Signature Column */
	function add_signature_column($columns) {
	   $columns['signature'] = __( 'Signature', 'CURLYTHEMES' );
	   return $columns;
	}
	
	
	/** Add Signature Column Content */
	function add_signature_column_content( $value, $column_name, $user_id ) {
	    $signature = get_user_meta( $user_id, 'petition_signature', true );
		if ( 'signature' == $column_name )
			return $signature;
	    return $value;
	}
	
	
	
	
	
	/** Supporters List */
	function supporters(){
		
		$supporters = self::transient_supporters();
		
		if( ! empty( $supporters ) ) :
			
			$count = count( $supporters ) > 7 ? 7 : count( $supporters ); 
			if( $count <= 1 ){
				$random = array(0);
			} else {
				$random = array_rand( $supporters, $count );
			}
			
			?>
			
			<div id="supporters-masonry">
				
				<?php
				
					foreach( $random as $supporter ) : 
						
						?>
						
						<div class="supporter" id="petition-<?php echo $supporters[$supporter]->ID ?>" data-container="body" data-toggle="popover" data-placement="auto" data-html="true" data-content="<q><?php echo get_user_meta( $supporters[$supporter]->ID, 'description', true ) ?></q><cite><?php echo $supporters[$supporter]->display_name ?></cite>">
							<?php echo get_avatar( $supporters[$supporter]->ID, 512 ); ?>
						</div>
						
						<?php
							
					endforeach;
				
				?>
			
			</div>
			
			<?php
		
		endif;		
		
	}
	
	
	
	
	/** Counter */
	function total(){
		
		$supporters = self::transient_supporters();
		$supporters = count( $supporters );
		
		return "<strong class='counter' data-number='$supporters'>1</strong>";
	}
	
	
	
	/** Transient */
	public static function transient_supporters(){
		
		//delete_transient( 'supporters' );
		
		if ( false === get_transient( 'supporters' ) ) {
			
			$blog_id = is_multisite() ? $GLOBALS['blog_id'] : '';
			
			$args = array(
				'blog_id'      => $blog_id,
				'role'         => 'petitioneer'
			);
			set_transient( 'supporters', get_users( $args ) );
		}
		
		return get_transient( 'supporters' );
		
	}
	
	
	
	
	/** Petition Counter */
	function counter(){
			
		$supporters_count = self::transient_supporters();
		$supporters_count = count( $supporters_count );
		$supporters_count += $supporters_count === 0 ? 1 : 0;
		
		$supporters = preg_replace( 
			'/{{COUNT}}/', 
			"<strong class='counter' data-number='$supporters_count'>1</strong>", 
			esc_attr( get_theme_mod( 
				'petition_counter', 
				__( 'With {{COUNT}} supporters', 'CURLYTHEME' ) 
			) )
		);
		
		$petition_type = esc_attr( get_theme_mod( 'petition_type', 0 ) );
		
		if( $petition_type === 0 ){
			
			$needed = $supporters_count;
			
			switch( true ){
				 case $needed < 10 : $needed_count = 10; break;
				 case $needed >= 10 && $needed < 50 : $needed_count = 50; break;
				 case $needed >= 50 && $needed < 100 : $needed_count = 100; break;
				 case $needed >= 100 && $needed < 500 : $needed_count = 500; break;
				 case $needed >= 500 && $needed < 1000 : $needed_count = 1000; break;
				 case $needed >= 1000 && $needed < 5000 : $needed_count = 5000; break;
				 case $needed >= 5000 && $needed < 10000 : $needed_count = 10000; break;
				 case $needed >= 10000 && $needed < 50000 : $needed_count = 50000; break;
				 case $needed >= 50000 && $needed < 100000 : $needed_count = 100000; break;
				 case $needed >= 100000 && $needed < 500000 : $needed_count = 500000; break;	
				 case $needed >= 500000 && $needed < 1000000 : $needed_count = 1000000; break;
				 case $needed >= 1000000 && $needed < 5000000 : $needed_count = 5000000; break;
				 case $needed >= 5000000 && $needed < 10000000 : $needed_count = 10000000; break;
				 case $needed >= 10000000 && $needed < 50000000 : $needed_count = 50000000; break;					
			}

			$needed = $needed_count - $supporters_count;
			
			$needed = preg_replace( 
				array(
					'/{{NEEDED}}/',
					'/{{TOTAL}}/'
				), 
				array(
					"<strong class='counter' data-number='$needed'>1</strong>",
					"<strong class='counter' data-number='$needed_count'>$needed_count</strong>"
				), 
				esc_attr( get_theme_mod( 
					'petition_needed_banner', 
					__( '{{NEEDED}} needed to reach {{TOTAL}}', 'CURLYTHEME' ) 
				) )
			);
		} else {
			$needed_count = esc_attr( get_theme_mod( 'petition_needed', 100 ) ); 
			$needed = $needed_count - $supporters_count;
			$overall = $needed - $needed_count >= 0 ? true : false;
			$needed = preg_replace( 
				array(
					'/{{NEEDED}}/',
					'/{{TOTAL}}/'
				), 
				array(
					"<strong class='counter' data-number='$needed'>1</strong>",
					"<strong class='counter' data-number='$needed_count'>$needed_count</strong>"
				), 
				esc_attr( get_theme_mod( 
					'petition_needed_banner', 
					__( '{{NEEDED}} needed to reach {{TOTAL}}', 'CURLYTHEME' ) 
				) )
			);
		}
		
		$percentage = $supporters_count * 100 / $needed_count ;	
		
		?>
		<div id="petitioners-counter" class="<?php echo $overall === true ? 'success' : '' ?>">
			<div><?php echo $supporters; ?></div>
			<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
				<span class="sr-only"><?php echo $percentage; ?>%</span>
			</div>
			</div>
			<div class="text-right"><?php echo $needed; ?></div>
		</div><!-- petitioners-counter -->
		<?php
		
	}
	
	
	
	
	
	/** Load Assets */
	function load_assets(){
		wp_enqueue_script(
			'curly-petition', 
			get_template_directory_uri() . '/extend/assets/js/petition.sign.js', 
			null, 
			null,
			true
		);
		
		wp_localize_script( 'curly-petition', 'petition', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	
	
	/** Add Petitioner Role */
	function petitioner(){
		add_role( 'petitioneer', __( 'Petitioneer', 'CURLYTHEME' ), array( 'read' => true, 'level_0' => true ) );
	}
	
	
	
	/** Sign */
	function sign(){
		
		if ( ! isset( $_POST['signature'] ) || ! wp_verify_nonce( $_POST['signature'], 'petition' ) ) {
		
		   _e( 'Sorry, your nonce did not verify.', 'CURLYTHEME' );
		
		} else {
		
			$email      =   sanitize_email( $_POST['email'] );
	        $first_name =   sanitize_text_field( $_POST['fname'] );
	        $last_name  =   sanitize_text_field( $_POST['lname'] );
	        $bio        =   esc_textarea( $_POST['bio'] );
	        $username	=   sanitize_user( $email, true );
	        $signature	=	sha1( $username );
	        
	        $validation = self::check_signature( $email, $first_name, $last_name, $bio, $username );
	        
	        if( is_wp_error( $validation ) ){
		        echo json_encode( $validation );
	        	die();
	        }
	        
	        set_transient( 
	        	$signature, 
	        	maybe_serialize( array( 
	        		'username' => $username, 
	        		'email' => $email, 
	        		'fname' => $first_name, 
	        		'lname' => $last_name, 
	        		'bio' => $bio 
	        	) )
	        );
	        
	        $user = get_user_by( 'email', $email );
	        $activation_link = get_home_url( null , "?user=$email&signature=$signature#petition-validation" );
	        
	        $email_activation = esc_textarea( get_theme_mod( 'validation_email_body', __( 'Hello {{NAME}},

Thank you for signing our petition! We already have {{COUNTER}} supporters. You can be our next supporter for {{PETITION}} and we are one step closer to our goal.

Please complete the process by confirming your e-mail address. Click on this link or paste it in your browser: {{ACTIVATION}}

Thank you for your support,
{{PETITION}}', 'CURLYTHEME') ) );
			
			$supporters = self::transient_supporters();
			$supporters = count( $supporters );
	        
	        $patterns = array();
			$patterns[0] = "/{{NAME}}/";
			$patterns[1] = "/{{COUNTER}}/";
			$patterns[2] = "/{{PETITION}}/";
			$patterns[3] = "/{{ACTIVATION}}/";
			
			$replacements = array();
			$replacements[0] = $first_name;
			$replacements[1] = $supporters;
			$replacements[2] = get_bloginfo( 'name' );
			$replacements[3] = $activation_link;
			
			$email_activation = preg_replace( $patterns, $replacements, $email_activation );
	        
	        wp_mail( 
	        	$email, 
	        	esc_attr( get_theme_mod( 'validation_email_subject', __( 'Confirm your petition signature', 'CURLYTHEME') ) ), 
	        	$email_activation 
	        );
	        
	        echo json_encode( $validation );
	        	
		}
		die();
	}
	
	
	/** Check Signature */
	public static function check_signature( $email, $first_name, $last_name, $bio, $username ){
		
		$return = new WP_Error();
		
		if( ! is_email( $email ) )
			$return->add( 
				'email', 
				esc_attr( get_theme_mod( 'validation_email', __( 'Please enter a valid email address.', 'CURLYTHEME' ) )
				) 
			);
			
        if( empty( $first_name ) ) 
        	$return->add( 
        		'fname', 
        		esc_attr( get_theme_mod( 'validation_fname', __( 'Please enter your first name.', 'CURLYTHEME' ) ) 
				) 
			);
			
        if( empty( $last_name ) )
        	$return->add( 
        		'lname', 
        		esc_attr( get_theme_mod( 'validation_lname', __( 'Please enter your last name.', 'CURLYTHEME' ) ) 
        		) 
        	);
        	
        if( empty( $bio ) ) 
        	$return->add( 
        		'bio', 
        		esc_attr( get_theme_mod( 'validation_message', __( 'Please tell us why you are signing this petition.', 'CURLYTHEME' ) ) 
        		) 
        	);
        
        if( ! empty( $email ) ){
        
	        if( is_multisite() ){
		        
		        $blog_id = get_current_blog_id();
		        $user_id = get_user_by( 'email', $email );
		        
		        if ( $user_id ){
			        if( is_user_member_of_blog( $user_id->ID, $blog_id ) )
			        	$return->add( 
			        		'username', 
			        		esc_textarea( get_theme_mod( 'validation_exists', __( 'Kudos! You already signed this petition!', 'CURLYTHEME' ) )
			        		) 
			        	);
		        }
		        
	        } else {
		        
		        if ( username_exists( $username ) )
	        	$return->add( 
	        		'username', 
	        		esc_textarea( get_theme_mod( 'validation_exists', __( 'Kudos! You already signed this petition!', 'CURLYTHEME' ) ) 
	        		) 
	        	);
	        	
	        }
        }
        	
        if( count( $return->get_error_codes() ) > 0 ) return $return;
        
        return array( 'success' => esc_textarea( get_theme_mod( 'validation_confirmation', __( 'Thank you very much for signing our petition! We sent you a confirmation email. Please click on the confirmation link in order to validate your signature.', 'CURLYTHEME' ) ) ) );
	}
	
	
	
	
	/** Form */
	function form(){ 
		
		if( isset( $_GET[ 'signature' ] ) && isset( $_GET[ 'user' ] ) ){
			
			if( false === get_transient( $_GET[ 'signature' ] ) ){
				
				echo esc_textarea( get_theme_mod( 'validation_exists', __( 'Kudos! You already signed this petition!', 'CURLYTHEME' ) ) );
				
			} else {
				$user = maybe_unserialize( get_transient( $_GET[ 'signature' ] ) );
				
				$userdata = array(
			        'role'			=>	'petitioneer',
			        'user_login'    =>   $user['username'],
			        'user_pass'		=>	 null,
			        'user_email'    =>   $user['email'],
			        'first_name'    =>   $user['fname'],
			        'last_name'     =>   $user['lname'],
			        'description'   =>   $user['bio'],
		        );
		        
		        if( is_multisite() ){
			        
			        $blog_id = get_current_blog_id();
			        $user_id = get_user_by( 'email', $user['email'] );
			        
			        if( ! $user_id  ){
				        $user_id = wp_insert_user( $userdata );
			        } else {
				        $user_id = $user_id->ID;
				        add_user_to_blog( $blog_id, $user_id, 'petitioneer' );
			        }
			        
		        } else {
			        
			        $user_id = wp_insert_user( $userdata );
		        }
		        
		        $user_signature = get_user_meta( $user_id, 'petition_signature', true );
		        
		        if(  empty( $user_signature ) ){
		        	add_user_meta( $user_id, 'petition_signature', $_GET[ 'signature' ], true );
		        }
		        
		        echo esc_textarea( get_theme_mod( 'validation_confirmation', __( 'Thank you very much for signing our petition! You have successfully committed to our cause.', 'CURLYTHEME' ) ) );
		        
		        delete_transient( $_GET[ 'signature' ] );
		        delete_transient( 'supporters' );
		        
		        $email_activation = esc_textarea( get_theme_mod( 'confirmation_email_body', __( 'Hello {{NAME}},

Thank you for confirming your e-mail address and showing support for {{PETITION}}. Congratulations for being awesome and for being our {{ID}} supporter.

If you want, you can put a face to the name in our list of supporters. Create a Gravatar account with this e-mail address, upload your picture and it will be displayed next to your name. You can create a Gravatar here: http://www.gravatar.com

Thank you for your support,
{{PETITION}}', 'CURLYTHEME') ) );

				$supporters_count = self::transient_supporters();
				$supporters_count = count( $supporters_count );
		        
		        $patterns = array();
				$patterns[0] = "/{{NAME}}/";
				$patterns[1] = "/{{ID}}/";
				$patterns[2] = "/{{PETITION}}/";
				
				$replacements = array();
				$replacements[0] = $user['fname'];
				$replacements[1] = $supporters_count;
				$replacements[2] = get_bloginfo( 'name' );
				
				$email_activation = preg_replace( $patterns, $replacements, $email_activation );
		       
		        wp_mail( 
		        	$user['email'], 
		        	esc_attr( get_theme_mod( 'confirmation_email_subject', __( 'Thank you for your support', 'CURLYTHEME') ) ), 
		        	$email_activation 
		        );
			}
			
		} else {
			$email      =   isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : null;
	        $first_name =   isset( $_POST['fname'] ) ? sanitize_text_field( $_POST['fname'] ) : null;
	        $last_name  =   isset( $_POST['lname'] ) ? sanitize_text_field( $_POST['lname'] ) : null;
	        $bio        =   isset( $_POST['bio'] ) ? esc_textarea( $_POST['bio'] ) : null;
			
			echo $this->sign_form( $email, $first_name, $last_name, $bio );
		}
	}
	
	/** Sign Form */
	function sign_form( $email, $first_name, $last_name, $bio ){
		?>
		<form id="sign-petition" method="post">
			<?php wp_nonce_field( 'petition', 'signature' ); ?>
			<div class="form-group">
				<input type="text" class="form-control email" name="email" value="<?php echo $email ?>" placeholder="<?php _e( 'E-mail Address', 'CURLYTHEME' ) ?>" />
			</div>
			<div class="form-group">
				<input type="text" class="form-control fname" name="fname" value="<?php echo $first_name ?>" placeholder="<?php _e( 'First Name', 'CURLYTHEME' ) ?>" />
			</div>
			<div class="form-group">
				<input type="text" class="form-control lname" name="lname" value="<?php echo $last_name ?>" placeholder="<?php _e( 'Last Name', 'CURLYTHEME' ) ?>" />
			</div>
			<div class="form-group">
				<textarea class="form-control bio" placeholder="<?php echo esc_attr( get_theme_mod( 'question', __( 'Why is this important to you?', 'CURLYTHEME' ) ) ) ?>" rows="3"><?php echo $bio ?></textarea>
			</div>
			<ul id="petition-errors"></ul>
			<button type="submit" class="btn btn-primary"><?php echo esc_attr( get_theme_mod( 'button', __( 'Sign Petition!', 'CURLYTHEME' ) ) ) ?></button>
		</form>
		<?php
	}

}

new CurlyPetitions();


?>