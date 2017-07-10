<?php 

/** Hero Tab */
$options[] = array(
	'id'		=> 'hero_tab',
	'type'		=> 'tab',
	'name'		=> __( 'Hero Page', 'CURLYTHEME' ),
	'template'	=> array( 'page-templates/hero.php' )
);
$options[] = array(
	'id'	=> 'crossfade',
	'type'	=> 'image',
	'tab'	=> 'hero_tab',
	'name'	=> __( 'Hero Image', 'CURLYTHEME' ),
	'desc'	=> __( 'Choose your featured image, that will appear at the top of the page', 'CURLYTHEME' )
);
$options[] = array(
	'id'	=> 'crossfade_blur',
	'type'	=> 'image',
	'tab'	=> 'hero_tab',
	'name'	=> __( 'Hero Tilt Image', 'CURLYTHEME' ),
	'desc'	=> __( 'Choose your featured image, that will appear when you scroll down', 'CURLYTHEME' )
);



/** Petition Tab */
$options[] = array(
	'id'		=> 'petition_tab',
	'type'		=> 'tab',
	'name'		=> __( 'Petition', 'CURLYTHEME' ),
	'template'	=> array( 'page-templates/petition.php' )
);
$options[] = array(
	'id'		=> 'recipients_title',
	'type'		=> 'text',
	'tab'		=> 'petition_tab',
	'name'		=> __( 'Petition Recipients Title', 'CURLYTHEME' ),
	'desc'		=> __( 'Enter your text for the petition recipients list (Example: This Petition will be sent to:)', 'CURLYTHEME' )
);
$options[] = array(
	'id'	=> 'recipients',
	'type'	=> 'editor',
	'tab'	=> 'petition_tab',
	'name'	=> __( 'Petition Recipients', 'CURLYTHEME' )
);


/** Background Tab */
$options[] = array(
	'id'	=> 'bg_tab',
	'type'	=> 'tab',
	'name'	=> __( 'Background', 'CURLYTHEME' ),
	'template'	=> array( 'page-templates/letter.php' )
);
$options[] = array(
	'id'	=> 'bg',
	'type'	=> 'select',
	'tab'	=> 'bg_tab',
	'name'	=> __( 'Pre-Defined Backgrounds', 'CURLYTHEME' ),
	'choices'	=> array(
		'bg-none' 	=> __( 'Empty Background', 'CURLYTHEME'),
		'bg-lined-paper' 	=> __( 'Lined Paper', 'CURLYTHEME'),
		'bg-confectionary' 	=> __( 'Confectionary', 'CURLYTHEME'),
		'bg-notebook' 		=> __( 'Notebook', 'CURLYTHEME'),
		'bg-natural-paper' 	=> __( 'Natural Paper', 'CURLYTHEME'),
		'bg-soft-paper' 	=> __( 'Soft Paper', 'CURLYTHEME'),
		'bg-neutral-grid' 	=> __( 'Neutral Grid', 'CURLYTHEME')
	),
	'default'	=> 'bg-lined-paper',
	'desc'	=> __( 'Choose one of the six pre-designed backgrounds for your letter', 'CURLYTHEME' )
);



/** Supporters Tab */
$options[] = array(
	'id'		=> 'supporters_tab',
	'type'		=> 'tab',
	'name'		=> __( 'Supporters Page', 'CURLYTHEME' ),
	'template'	=> array( 'page-templates/supporters.php' )
);
$options[] = array(
	'id'	=> 'video_cover',
	'type'	=> 'image',
	'tab'	=> 'supporters_tab',
	'name'	=> __( 'Cover Image', 'CURLYTHEME' ),
	'desc'	=> __( 'Choose your cover image. You need one even if you use a video cover.', 'CURLYTHEME' )
);
$options[] = array(
	'id'	=> 'video_external',
	'type'	=> 'text',
	'tab'	=> 'supporters_tab',
	'name'	=> __( 'External Video Link', 'CURLYTHEME' ),
	'desc'	=> __( 'Vimeo or YouTube', 'CURLYTHEME' )
);
$options[] = array(
	'id'	=> 'video_mp4',
	'type'	=> 'video',
	'tab'	=> 'supporters_tab',
	'name'	=> __( 'Video Background MP4 File', 'CURLYTHEME' )
);
$options[] = array(
	'id'	=> 'video_webm',
	'type'	=> 'video',
	'tab'	=> 'supporters_tab',
	'name'	=> __( 'Video Background WEBM File', 'CURLYTHEME' )
);
$options[] = array(
	'id'	=> 'video_ogg',
	'type'	=> 'video',
	'tab'	=> 'supporters_tab',
	'name'	=> __( 'Video Background OGG File', 'CURLYTHEME' )
);


	
?>
