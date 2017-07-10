<?php
	
$font_styles = array(
	0 => __( 'Light', 'CURLYTHEMES' ),
	1 => __( 'Light Italic', 'CURLYTHEMES' ),
	2 => __( 'Normal', 'CURLYTHEMES' ),
	4 => __( 'Italic', 'CURLYTHEMES' ),
	3 => __( 'Bold', 'CURLYTHEMES' ),
	5 => __( 'Bold Italic', 'CURLYTHEMES' )
);
$font_variants = array(
	0 => __( 'Normal', 'CURLYTHEMES' ),
	1 => __( 'Capitalize', 'CURLYTHEMES' ),
	2 => __( 'Uppercase', 'CURLYTHEMES' ),
	3 => __( 'Small Caps', 'CURLYTHEMES' )
);

$font_list = array(); 

if ( get_transient( 'google_font_list' ) === false ) {
	set_transient( 'google_font_list', json_decode( get_option( THEMEPREFIX.'_google_font_list' ) , true ), 60 * 60 * 24 * 30 );
}
$fonts = get_transient( 'google_font_list' );
foreach ( $fonts['items'] as $key => $font ) { 
	$font_list[ $font['family'] ] = $font['family'];
}
	
	
// Remove Default Controls
// Remove Background Color
$options[] = array(
	'type'		=> 'remove',
	'id'		=> 'blogdescription'
);
$options[] = array(
	'type'		=> 'remove',
	'id'		=> 'header_textcolor'
);




/** Update Existing */
/** Site Title & Tagline Image */
$options[] = array(
	'type'		=> 'update_section',
	'id'		=> 'title_tagline',
	'panel'		=> 'header_panel',
	'title'		=> __( 'Site Title & Taglines', 'CURLYTHEME' ),
	'priority'	=> 1
	
);



/** Header Panel */
$options[] = array(
	'label'    	=> __( 'Header', 'CURLYTHEME' ),
	'type'		=> 'panel',
	'id'   		=> 'header_panel',
	'priority'	=> 10
);




/** Site Title */
$options[] = array(
	'label'     => __( 'Tagline', 'CURLYTHEME' ),
	'type'		=> 'textarea',
	'id'   		=> 'tagline',
	'section'	=> 'title_tagline',
);



/** Site Logo Section */
$options[] = array(
	'label'    	=> __( 'Site Logo', 'CURLYTHEME' ),
	'type'		=> 'section',
	'id'   		=> 'logo_section',
	'panel'		=> 'header_panel',
	'desc' 		=> __('Upload both retina and non-retina versions of your logo','CURLYTHEME')
);
$options[] = array(
	'label'     => __( 'Logo', 'CURLYTHEME' ),
	'type'		=> 'image',
	'id'   		=> 'logo',
	'section'	=> 'logo_section',
	'desc' => __('The logo will appear at the top-left corner of your site','CURLYTHEME')
);
$options[] = array(
	'label'     => __( 'Retina Logo @2x', 'CURLYTHEME' ),
	'type'		=> 'image',
	'id'   		=> 'logo_retina',
	'section'	=> 'logo_section',
	'desc' => __('Be sure that this complies with the retina standards','CURLYTHEME')
);





/** Colors */
$options[] = array(
	'label'     => __( 'Text Color', 'CURLYTHEME' ),
	'type'		=> 'color',
	'id'   		=> 'color_text',
	'section'	=> 'colors',
	'default'	=> '#565656',
	'desc'		=> __( 'This color is used for general text color', 'CURLYTHEME' ) 
);
$options[] = array(
	'label'     => __( 'Background Color', 'CURLYTHEME' ),
	'type'		=> 'color',
	'id'   		=> 'color_bg',
	'section'	=> 'colors',
	'default'	=> '#ffffff',
	'desc'		=> __( 'This color is used as background color', 'CURLYTHEME' ) 
);
$options[] = array(
	'label'     => __( 'Primary Color', 'CURLYTHEME' ),
	'type'		=> 'color',
	'id'   		=> 'color_primary',
	'section'	=> 'colors',
	'default'	=> '#D44234',
	'desc'		=> __( 'This color is used for buttons, links and visual elements', 'CURLYTHEME' ) 
);




/** Typography Section */
$options[] = array(
	'label'    	=> __( 'Typography', 'CURLYTHEME' ),
	'type'		=> 'section',
	'id'   		=> 'typo_section'
);
$options[] = array(
	'label'     => __( 'Main Font', 'CURLYTHEME' ),
	'type'		=> 'select',
	'id'   		=> 'font',
	'section'	=> 'typo_section',
	'default'	=> 'Lora',
	'desc'		=> __( 'This is the general font of your site. It is used for the general text, headings, buttons', 'CURLYTHEME' ),
	'choices'	=> $font_list,
	'transport'	=> 'refresh'
);
$options[] = array(
	'label'     => __( 'Font Pair', 'CURLYTHEME' ),
	'type'		=> 'select',
	'id'   		=> 'font_pair',
	'section'	=> 'typo_section',
	'default'	=> 'Roboto',
	'desc'		=> __( 'This is the font pair of your site. It is used in some sections such as footer, menu, etc', 'CURLYTHEME' ),
	'choices'	=> $font_list,
	'transport'	=> 'refresh'
);
$options[] = array(
	'label'     => __( 'Letter Font', 'CURLYTHEME' ),
	'type'		=> 'select',
	'id'   		=> 'font_letter',
	'section'	=> 'typo_section',
	'default'	=> 'Cutive Mono',
	'desc'		=> __( 'This font is used only in the letter section', 'CURLYTHEME' ),
	'choices'	=> $font_list,
	'transport'	=> 'refresh'
);
$options[] = array(
	'label'     => __( 'Text Size', 'CURLYTHEME' ),
	'type'		=> 'slider',
	'id'   		=> 'font_size',
	'section'	=> 'typo_section',
	'default'	=> 14,
	'desc'		=> __( 'Changing your text size will automatically adapt your heading size also', 'CURLYTHEME' ),
	'input_attr'=> array( 'min' => 10, 'max' => 18, 'step' => 1, 'suffix' => 'px' )
);
$options[] = array(
	'label'     => __( 'Text Style', 'CURLYTHEME' ),
	'type'		=> 'select',
	'id'   		=> 'font_style',
	'section'	=> 'typo_section',
	'default'	=> 2,
	'choices'	=> $font_styles,
	'desc'		=> __( 'Changing your text style will automatically adapt your heading style also', 'CURLYTHEME' )
);
$options[] = array(
	'label'     => __( 'Font Subset', 'CURLYTHEME' ),
	'type'		=> 'select',
	'id'   		=> 'font_subset',
	'section'	=> 'typo_section',
	'default'	=> 0,
	'choices'	=> array( 
		0 => 'No Subset - Standard Latin', 
		1 => 'Cyrillic Extended (cyrillic-ext)', 
		2 => 'Greek Extended (greek-ext)', 
		3 => 'Greek (greek)', 
		4 => 'Vietnamese (vietnamese)' , 
		5 => 'Latin Extended (latin-ext)' , 
		6 => 'Cyrillic (cyrillic)'),
	'desc'		=> __( 'Make sure the fonts you use on the website support these special characters.', 'CURLYTHEME' )
);



/** Petition Section */
$options[] = array(
	'label'    	=> __( 'Petition Settings', 'CURLYTHEME' ),
	'type'		=> 'section',
	'id'   		=> 'petition_section',
	'desc' 		=> __('Set up your petition details in this section','CURLYTHEME'),
	'priority'	=> 0
);
$options[] = array(
	'label'     => __( 'Petition Type', 'CURLYTHEME' ),
	'type'		=> 'radio',
	'id'   		=> 'petition_type',
	'section'	=> 'petition_section',
	'desc' 		=> __('Choose a petition type: with or without a target petitioners number','CURLYTHEME'),
	'default'	=> 0,
	'choices'	=> array(
		0	=> __( 'Standard Petition', 'CURLYTHEMES' ),
		1	=> __( 'Needed Petitioners', 'CURLYTHEMES' )
	)
);
$options[] = array(
	'label'     => __( 'Needed Petitioners', 'CURLYTHEME' ),
	'type'		=> 'number',
	'id'   		=> 'petition_needed',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter how many petitioners you need in order to send out the petition','CURLYTHEME'),
	'default'	=> 100,
	'active_cb'	=> 'wechange_petition_type'
);
$options[] = array(
	'label'     => __( 'Petitioners Needed Counter', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'petition_needed_counter',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter the petitioners counter text. You can use special strings such as: {{NEEDED}} - Petitioners Needed, {{TOTAL}} - Total Petitioners','CURLYTHEME'),
	'default'	=> __( 'With {{COUNT}} Supporters', 'CURLYTHEME' ) 
);
$options[] = array(
	'label'     => __( 'Petitioners Needed Banner', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'petition_needed_banner',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter the petitioners banner text. You can use special strings such as: {{NEEDED}} - Petitioners Needed, {{TOTAL}} - Total Petitioners','CURLYTHEME'),
	'default'	=> __( 'We still need {{NEEDED}} Supporters', 'CURLYTHEME' )
);
$options[] = array(
	'label'     => __( 'Validation Email Subject', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_email_subject',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your validation email title','CURLYTHEME'),
	'default'	=> __( 'Confirm your petition signature', 'CURLYTHEME')
);
$options[] = array(
	'label'     => __( 'Validation Email Body', 'CURLYTHEME' ),
	'type'		=> 'textarea',
	'id'   		=> 'validation_email_body',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your validation email body. You can use special strings such as: {{NAME}} - Petitioner Name, {{COUNTER}} - Petitioners Counter, {{PETITION}} - Petition Name','CURLYTHEME'),
	'default'	=> __( 'Hello {{NAME}},

Thank you for signing our petition! We already have {{COUNTER}} supporters. You can be our next supporter for {{PETITION}} and we are one step closer to our goal.

Please complete the process by confirming your e-mail address. Click on this link or paste it in your browser: {{ACTIVATION}}

Thank you for your support,
{{PETITION}}', 'CURLYTHEME')
);
$options[] = array(
	'label'     => __( 'Confirmation Email Subject', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'confirmation_email_subject',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your confirmation email title','CURLYTHEME'),
	'default'	=> __( 'Thank you for your support', 'CURLYTHEME')
);
$options[] = array(
	'label'     => __( 'Confirmation Email Body', 'CURLYTHEME' ),
	'type'		=> 'textarea',
	'id'   		=> 'confirmation_email_body',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your confirmation email body. You can use special strings such as: {{NAME}} - Petitioner Name, {{ID}} - Petitioner Unique ID, {{PETITION}} - Petition Name','CURLYTHEME'),
	'default'	=> __( 'Hello {{NAME}},

Thank you for confirming your e-mail address and showing support for {{PETITION}}. Congratulations for being awesome and for being our {{ID}} supporter.

If you want, you can put a face to the name in our list of supporters. Create a Gravatar account with this e-mail address, upload your picture and it will be displayed next to your name. You can create a Gravatar here: http://www.gravatar.com

Thank you for your support,
{{PETITION}}', 'CURLYTHEME')
);
$options[] = array(
	'label'     => __( 'Petition Comments', 'CURLYTHEME' ),
	'type'		=> 'radio',
	'id'   		=> 'comments',
	'section'	=> 'petition_section',
	'desc' => __('Choose a type of comments for your petition','CURLYTHEME'),
	'choices'	=> array(
		0	=> __( 'Disable Comments', 'CURLYTHEMES' ),
		1	=> __( 'Default WordPress', 'CURLYTHEME' ),
		2	=> __( 'Disqus Forum', 'CURLYTHEME' ),
		3	=> __( 'Facebook Comments', 'CURLYTHEME' )
	),
	'default'	=> 1
);
$options[] = array(
	'label'     => __( 'Validation Error - Email', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_email',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your email validation error text','CURLYTHEME'),
	'default'	=> __( 'Please enter a valid email address.', 'CURLYTHEME' ) 
);
$options[] = array(
	'label'     => __( 'Validation Error - First Name', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_fname',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your First Name validation error text','CURLYTHEME'),
	'default'	=> __( 'Please enter your first name.', 'CURLYTHEME' )  
);
$options[] = array(
	'label'     => __( 'Validation Error - Last Name', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_lname',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your Last Name validation error text','CURLYTHEME'),
	'default'	=> __( 'Please enter your last name.', 'CURLYTHEME' )  
);
$options[] = array(
	'label'     => __( 'Validation Error - Message', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_message',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your message validation error text','CURLYTHEME'),
	'default'	=> __( 'Please tell us why you are signing this petition.', 'CURLYTHEME' ) 
);
$options[] = array(
	'label'     => __( 'Validation Error - Already Signed', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_message',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your Already Signed error text','CURLYTHEME'),
	'default'	=> __( 'Kudos! You already signed this petition!', 'CURLYTHEME' ) 
);
$options[] = array(
	'label'     => __( 'Validation Confirmation - Success', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'validation_message',
	'section'	=> 'petition_section',
	'desc' 		=> __('Enter your sign up confirmation text','CURLYTHEME'),
	'default'	=> __( 'Thank you very much for signing our petition! We sent you a confirmation email. Please click on the confirmation link in order to validate your signature.', 'CURLYTHEME' )
);
$options[] = array(
	'label'     => __( 'Disqus Forum Name', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'comments_disqus',
	'section'	=> 'petition_section',
	'desc' => __('Type in your Disqus username','CURLYTHEME'),
	'active_cb'	=> 'wechange_comments_disqus'
);
$options[] = array(
	'label'     => __( 'Facebook Username', 'CURLYTHEME' ),
	'type'		=> 'text',
	'id'   		=> 'comments_facebook',
	'section'	=> 'petition_section',
	'desc' => __('Type in your Facebook username','CURLYTHEME'),
	'active_cb'	=> 'wechange_comments_facebook'
);




function wechange_comments_disqus(){
	if( esc_attr( get_theme_mod( 'comments', 1 ) ) === '2' ) return true;
}

function wechange_comments_facebook(){
	if( esc_attr( get_theme_mod( 'comments', 1 ) ) === '3' ) return true;
}

function wechange_petition_type(){
	if( esc_attr( get_theme_mod( 'petition_type', 0 ) ) === '1' ) return true;
}




?>
