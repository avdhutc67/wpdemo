<?php 
	

/**
* WeChange
*/
class WeChange {

	public function __construct(){
		
		/** Logo Hook */
		add_action( 'curly_logo', array( $this, 'logo' ) );
		
		/** Navigation Hook */
		add_action( THEMEPREFIX . '_gallery', array( $this, 'gallery' ), 10, 1 );
		
		/** Body Attributes */
		add_filter( THEMEPREFIX . 'body_attributes', array( $this, 'body_attr'), 10, 1 );
		
		/** One Page Body Class Hook */
		add_filter( 'body_class', array( $this, 'one_page' ) );
		
		/** Load Assets */
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
		
		/** Theme Support */
		add_action( 'after_setup_theme', array( $this, 'theme_slug_setup' ) );
		
		/** Widget Areas */
		add_action( 'widgets_init', array( $this, 'widgets' ) );
		
		/** Add MIME Types */
		add_filter( 'upload_mimes', array( $this, 'custom_mime_types' ) );
		
		/** Add Sharing */
		add_action( THEMEPREFIX . '_sharing', array( $this, 'sharing' ), 10, 1 );
		
		/** Petition Comments */
		add_action( 'petition-comments', array( $this, 'comments' ) );
		
		/** Facebook Admin */
		add_action( 'wp_head', array( $this, 'fb_og' ) );
		
		/** Theme Localization */
		add_action( 'after_setup_theme' , array( $this, 'theme_localization' ) );
		
		/** Register Navigation */
		add_action( 'after_setup_theme', array( $this, 'register_navigation' ) );
		
		/** Menu Filter */
		add_filter( 'nav_menu_link_attributes', array( $this, 'menu_filter'), 3, 10 );
		
		/** Generator */
		add_action('wp_head', array($this, 'meta_generator'), 6);
		
		/** Page Heading */
		add_action( 'curly_page_heading', array( $this, 'page_heading' ), 10, 3 );
				
	}
	
	
	
	/** Theme Mode */
	public static function Mode( $return = false ){
		
		$front 		= get_option( 'show_on_front' );
		$front_id 	= get_option( 'page_on_front' );
		
		if( $front === 'page' && $front_id !== '0' && $front_id !== 0 && $front_id !== false ){
			
			if( get_post_meta( $front_id, '_wp_page_template', TRUE ) === 'page-templates/one-page.php' ){
				
				if( $return === false )
					return true;
				else
					return $front_id;	
			}
			
		}
		
		return false;
		
	}
	
	
	
	
	/** Navigation Hook */
	function navigation(){
		
		$pages = get_pages( 
				array(
					'sort_order' => 'ASC',
					'sort_column' => 'menu_order',
					'hierarchical' => 1,
					'exclude' => WeChange::Mode( true ),
					'parent' => 0,
					'post_type' => 'page',
					'post_status' => 'publish'
				) 
			); 
		
		if( is_array( $pages ) ){
				$base = home_url( '/' );
				$html  = '<ul id="main-menu" class="menu nav">';
				foreach( $pages as $page ){
					$html .= '<li class="menu-item">';
					$html .= "<a href='#$page->post_name' class='smooth-scroll' data-base='$base'>".$page->post_title.'</a>';
					$html .= '</li>';
				}
				$html .= '</ul>';
			}	
		
		echo $html ? $html : null;
	}
	
	
	
	
	
	/** Get Page Heading */
	function page_heading( $id, $before, $after ){
		
		global $post;
		
		if ( is_page() || is_single() || is_attachment() ) 
			if( get_post_type() == "post" )
				$html = get_the_title( get_option( 'page_for_posts' ) );
			else
			$html = get_the_title( $id );
			
		elseif	( is_home() )
			$html = get_the_title( get_option('page_for_posts', true ) );
			
		elseif ( is_category() || is_tax() )
			$html = single_cat_title('' , false);
			
		elseif ( is_search() )
			$html = __('Search Results' , 'CURLYTHEME');
			
		elseif ( is_404() )
			$html = __('Page could not be found. 404 Error' , 'CURLYTHEME');	
			
		else
			$html = get_the_title();
		
		if ( ! $before ) {
			$before = '<h1>';
		}
		if ( ! $after ) {
			$after = '</h1>';
		}
		
		$subtitle = ( isset( $post ) ) ? get_post_meta( $post->ID, THEMEPREFIX.'_header_subtitle', true ) : null;
		$subtitle = ( $subtitle ) ? '<small>'.$subtitle.'</small>' : null;
			
		echo $before.$html.$subtitle.$after;		
	}
	
	
	
	
	
	
	/** Register Navigation */
	function register_navigation(){
		register_nav_menu( 'main_navigation', __( 'Main Navigation', 'CURLYTHEME' ) );
	}
	
	
	
	/** Generator */
	function meta_generator() {
		echo '<meta name="generator" content="'.wp_get_theme()->get( 'Name' ) . " " . wp_get_theme()->get( 'Version' ).'">';
	}
	
	
	
	/** Localization */
	function theme_localization() {
	    load_theme_textdomain('CURLYTHEME', get_template_directory() . '/languages');
	}
	
	
	
	
	/** Facebook Admin */
	function fb_og(){
		
		echo "<meta property='og:title' content='".get_bloginfo('name')."' />";
		echo '<meta property="og:description" content="'.get_bloginfo('description').'" />';
		echo '<meta property="og:url" content="'.home_url('/').'" />';
		
		$comments = esc_attr( get_theme_mod( 'comments', 1 ) );
		$facebook = esc_attr( get_theme_mod( 'comments_facebook' ) );
		
		if( $comments === '3' && ! empty( $facebook ) ) {
			echo "<meta property='fb:admins' content='$facebook'/>";
		}
	}
	
	
	
	
	/** Petition Comments */
	function comments(){
		
		$comments = esc_attr( get_theme_mod( 'comments', '1' ) );
		$disqus   = esc_attr( get_theme_mod( 'comments_disqus' ) );
		$facebook = esc_attr( get_theme_mod( 'comments_facebook' ) );
		
		if( ! empty( $disqus ) && $comments === '2' ) : 
		
		?>
		

		<div class="content-padding animated">
			<div id="disqus_thread"></div>
			<script type="text/javascript">
			  /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			  var disqus_shortname = '<?php echo $disqus ?>'; // required: replace example with your forum shortname
			
			  /* * * DON'T EDIT BELOW THIS LINE * * */
			  (function() {
			      var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			      dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			  })();
			</script>
		</div>
		
		<?php
			
		elseif( ! empty( $facebook ) && $comments === '3' ) : 
		
		?>

		<div class="content-padding animated">
			<div class="fb-comments" data-width="100%" data-href="<?php echo home_url('/'); ?>" data-numposts="5" data-version="v2.3"></div>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/<?php echo get_locale(); ?>/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		</div>

		
		<?php
		
		elseif ( comments_open() && $comments === '1' ) : global $withcomments; $withcomments = '1'; comments_template(); 
		
		endif;
		
	}

	
	
	
	
	/** Sharing */
	function sharing( $text = true, $icons = true ){			
		
		$link = urlencode( get_permalink() );
		$title = urlencode( get_the_title() );
		$fb = esc_url( add_query_arg( 
			array(
				'u' => $link, 
				't' => $title
			), 
			'http://www.facebook.com/sharer.php'
		) );
		$tw =  esc_url( add_query_arg( 'status', $title.' '.$link, 'http://twitter.com/home' ) );
		$gp = esc_url( add_query_arg( 
			array(
				'op' 	=> 'edit',
				'bkmk'	=> $link,
				'title'	=> $title
			), 
			'http://google.com/bookmarks/mark'
		) );
		$li = esc_url( add_query_arg( 
			array(
				'mini' 	=> 'true',
				'url'	=> $link,
				'title'	=> $title
			), 
			'http://linkedin.com/shareArticle'
		) );
		$em = esc_url( add_query_arg( 
			array(
				'subject' => $title,
				'body'	=> $link
			), 
			'mailto:'
		) );
		
		$_fb = $text === true ? __( 'Share Petition on Facebook', 'CURLYTHEME' ) : '';
		$_tw = $text === true ? __( 'Tweet this Petition', 'CURLYTHEME' ) : '';
		$_gp = $text === true ? __( 'Share Petition on Google+', 'CURLYTHEME' ) : '';
		$_li = $text === true ? __( 'Share Petition on LinkedIn', 'CURLYTHEME' ) : '';
		$_em = $text === true ? __( 'E-mail this Petition', 'CURLYTHEME' ) : '';
		
		$output = "
		<ul class='sharing'>
			<li><a rel='nofollow' href='$fb' class='facebook' title='Facebook'><i class='fa fa-boxed fa-fw fa-facebook'></i> ".$_fb."</a></li>
		  	<li><a rel='nofollow' href='$tw' class='twitter' title='Twitter'><i class='fa fa-boxed fa-fw fa-twitter'></i> ".$_tw."</a></li>
		  	<li><a rel='nofollow' href='$gp' class='google' title='Google'><i class='fa fa-boxed fa-fw fa-google-plus'></i> ".$_gp."</a></li>
		  	<li><a rel='nofollow' href='$li' class='linkedin' title='Linkedin'><i class='fa fa-boxed fa-fw fa-linkedin'></i> ".$_li."</a></li>
		  	<li><a rel='nofollow' href='$em' class='mail' title='Email'><i class='fa fa-boxed fa-fw fa-envelope-o'></i> ".$_em."</a></li>
		</ul>";
		
		echo $output;
		
	}
	
	
	
	
	
	/** Custom MIME Types */
	function custom_mime_types( $mimes ){
		
		$mimes['mp4'] = 'video/mp4';
		$mimes['webm'] = 'video/webm';
		$mimes['ogg'] = 'video/ogg';
		$mimes['ogv'] = 'video/ogv';
		$mimes['svg'] = 'image/svg+xml';
	
		return $mimes;
	}
	
	
	
	
	/** One Page Body Class Hook */
	function one_page( $classes ){ 
		if( WeChange::Mode() ){
			$classes[] = 'one-page';
		} else{
			$classes[] = 'multi-page';
		}
		return $classes;
	}
	
	/** Gallery Hook */
	function gallery( $id ){
		$html = '<div class="row petition-gallery">';
		
		$images = get_post_meta( $id, '_' . THEMEPREFIX . '_gallery', true );
		
		if( $images ){
			$images = explode( ',', substr( $images, 0, -1 ) );
		}
		
		if( is_array( $images ) ){
			foreach( $images as $key => $image ){
				$html .= '<div class="col-xs-6">';
				$html .= '<a href="'.wp_get_attachment_url( $image, 'full' ).'" class="link-image" data-lightbox-gallery="photo_gallery" rel="lightbox" title="'.get_the_title( $id ).'">';
				$html .= wp_get_attachment_image( $image, 'medium' );
				$html .= '</a>';
				$html .= '</div>';
			}
			
		}

		$html .= '</div>';
		
		echo $html;
	}
	
	
	
	
	
	/** Logo Hook */
	function logo( $pref = null, $suf = null ){
	
		$title 			= 	get_bloginfo( 'name' );
		$logo 			= 	esc_url_raw( get_theme_mod( 'logo' ) );
		$logo_retina 	= 	esc_url_raw( get_theme_mod( 'logo_retina' ) );

		if( $logo ) { 	
			$output = '<img src="'.$logo.'" alt="'.$title.'">'; 
		} 
		
		if ( $logo && $logo_retina ) {
			list( $width, $height, $type, $attr ) = getimagesize( $logo_retina );
			$output  = '<img src="'.$logo.'" alt="'.$title.'" class="logo-nonretina">'; 
			$output .= '<img src="'.$logo_retina.'" width="'.( $width / 2 ).'" height="'.( $height / 2 ).'" alt="'.$title.'" class="logo-retina">';
		}
		
		if ( ! $logo ) { 
			$output = $title; 
		}
		
		echo $pref.'<a href="'.home_url( '/' ).'" id="logo">'.$output.'</a>'.$suf;
	}

	
	
	
	/** Menu Filter */
	function menu_filter( $atts, $item, $args ){
		
		if( WeChange::Mode() ){
			
			if( $atts['target'] !== '_blank' ){ 
				if( strpos( $atts['href'], home_url( '/' ) ) !== false ){
					$atts['data-base'] = home_url( '/' );
					$atts['href'] =  '#' . basename( $atts['href'] );
					$atts['class'] = 'smooth-scroll';
				}
			}
			
	    }
	    return $atts;
	}
	
	
	
	
	
	
	/** Body Attributes */
	function body_attr( $attr ){
				
		if( WeChange::Mode() ){
			$attr .= ' data-spy="scroll" data-target="#main-nav" data-offset="60" ';
		}
		
		return $attr;
		
	}
	
	
	
	
	
	
	/** Load Assets */
	function load_assets(){
		
		/** Scripts */
		wp_enqueue_script(
			'curly-bs', 
			get_template_directory_uri() . '/assets/js/min/bootstrap.min.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-wp', 
			get_template_directory_uri() . '/assets/js/min/waypoints.min.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-vl', 
			get_template_directory_uri() . '/assets/js/min/velocity.min.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-vlui', 
			get_template_directory_uri() . '/assets/js/min/velocity.ui.min.js', 
			array( 'curly-vl' ), 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-cf', 
			get_template_directory_uri() . '/assets/js/jquery.crossfade.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-fs-core', 
			get_template_directory_uri() . '/assets/js/fs/core.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-fs-transition', 
			get_template_directory_uri() . '/assets/js/fs/transition.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-fs-background', 
			get_template_directory_uri() . '/assets/js/fs/background.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-fs-touch', 
			get_template_directory_uri() . '/assets/js/fs/touch.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-fs-lightbox', 
			get_template_directory_uri() . '/assets/js/fs/lightbox.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-mh', 
			get_template_directory_uri() . '/assets/js/min/jquery.matchHeight-min.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-sk', 
			get_template_directory_uri() . '/assets/js/min/jquery.sticky-kit.min.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-an', 
			get_template_directory_uri() . '/assets/js/jquery.animateNumbers.js', 
			null, 
			null, 
			true
		);
		
		wp_enqueue_script(
			'curly-masonry', 
			get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', 
			null, 
			null, 
			true
		);
		wp_enqueue_script(
			'curly-masonry-imagesLoaded', 
			get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', 
			null, 
			null, 
			true
		);
		
		wp_enqueue_script(
			'curly-main', 
			get_template_directory_uri() . '/assets/js/main.js', 
			array( 
				'jquery',
				'curly-bs',
				'curly-cf',
				'curly-wp',
				'curly-mh',
				'curly-vl',
				'curly-vlui',
				'curly-sk',
				'curly-fs-core',
				'curly-fs-transition',
				'curly-fs-background',
				'curly-fs-touch',
				'curly-fs-lightbox',
				'curly-masonry',
				'curly-masonry-imagesLoaded'
			), 
			null, 
			true
		);
		
		/** Styles */
		wp_enqueue_style( 
			'curly-bs', 
			get_template_directory_uri() . '/assets/css/min/bootstrap.min.css', 
			null, 
			null, 
			'all'
		); 
		wp_enqueue_style( 
			'curly-fa', 
			get_template_directory_uri() . '/assets/css/min/font-awesome.min.css', 
			null, 
			null, 
			'all'
		);
		wp_enqueue_style( 
			'curly-pe', 
			get_template_directory_uri() . '/assets/css/pe-icon-7-stroke.css', 
			null, 
			null, 
			'all'
		);
		wp_enqueue_style( 
			'curly-fsbx', 
			get_template_directory_uri() . '/assets/css/fs/lightbox.css', 
			null, 
			null, 
			'all'
		);
		wp_enqueue_style( 
			'curly-fswl', 
			get_template_directory_uri() . '/assets/css/fs/background.css', 
			null, 
			null, 
			'all'
		);
		wp_enqueue_style( 
			'curly-pb', 
			get_template_directory_uri() . '/assets/css/patternbolt.css', 
			null, 
			null, 
			'all'
		);
		wp_enqueue_style( 
			'curly-style', 
			get_stylesheet_uri(), 
			null, 
			false, 
			'all'
		);
	}
	
	
	
	
	
	
	/** Theme Support */
	function theme_slug_setup() {
	   add_theme_support( 'title-tag' );
	   add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	   add_theme_support( 'custom-background' );	
	   add_theme_support( 'automatic-feed-links' );
	   add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	   add_theme_support( 'post-formats', array( 'aside', 'gallery', 'chat', 'link', 'image', 'quote', 'status', 'video', 'audio') );

	}
	
	
	
	
	
	
	
	/** Widget Areas */
	function widgets(){
		if ( function_exists( 'register_sidebar' ) )
			register_sidebar(array(
			'name'			 => __('Footer' , 'CURLYTHEME'),
			'id'			 => 'sidebar_footer',
			'before_widget'	 => '<aside id="%1$s" class="sidebar-widget %2$s col-sm-4">',
			'after_widget' 	 => '</aside>',
			'before_title'	 => '<strong class="widget-title">',
			'after_title'	 => '</strong>',
			'description'	 => __( 'Use the text widgets to add as many petition recipients as needed.', 'CURLYTHEME' )
		));
	}
	
	
	
	
	

}

$wechange = new WeChange();
	
?>