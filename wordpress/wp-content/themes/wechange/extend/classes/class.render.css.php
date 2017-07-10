<?php 

/**
 * Render Global CSS
 * This will render out all the theme mod's CSS reules
 *
 * @since 4.0
 */
class CurlyRenderCSS{
	
	/** Colors */
	public $_color_text;
	public $_color_primary;
	public $_color_bg;
		
	public function __construct(){
		
		/** Colors */
		$this->_color_text = 
			new CurlyThemesColor( get_theme_mod('color_text', '#565656') );
		$this->_color_primary = 
			new CurlyThemesColor( get_theme_mod('color_primary', '#D44234' ) );
		$this->_color_bg = 
			new CurlyThemesColor( get_theme_mod('color_bg', '#ffffff') ); 
		
		
		
		/** Render Typography */
		add_action( 'wp_enqueue_scripts', array( $this, 'render_typography' ) );	
		
		/** Render Colors */
		add_action( 'wp_enqueue_scripts', array( $this, 'render_colors' ) );
		
		
		
		/** Render Editor Style */
		add_action( 'after_setup_theme', array( $this, 'mce_styles' ) );
		
		/** Render Editor Typography */
		add_action( 'curly_editor_style', array( $this, 'render_typography' ), 10, 1 );
		add_action( 'curly_editor_style_import', array( $this, 'render_editor_typography' ), 10, 1 );
		
		/** Render Editor Colors */
		add_action( 'curly_editor_style', array( $this, 'render_colors' ), 30, 1 );
		
	}
	
	
	
	
	/** Editor Styles */
	function mce_styles() {
		add_editor_style( 'editor-style.php' );
	}
	
	
	
	
	/** Setup Post Meta */
	function setup_post_meta(){
		$this->_post_meta = get_post_meta( get_queried_object_id() );
	}
	
	
	
		
	/** Render Typography */
	function render_typography( $echo = false ){
		
		$fonts = array();
		
		/** Body Font */
		$fonts = CurlyThemesLoadFonts::fonts_array( 
			$fonts, 
			get_theme_mod( 'font', 'Lora' ), 
			CurlyThemesLoadFonts::font_weight( get_theme_mod( 'font_style', 2 ) ) 
		);
		
		/** Font Pair */
		$fonts = CurlyThemesLoadFonts::fonts_array( 
			$fonts, 
			get_theme_mod( 'font_pair', 'Roboto' ), 
			CurlyThemesLoadFonts::font_weight( 2 ) 
		);
		
		/** Letter Font */
		$fonts = CurlyThemesLoadFonts::fonts_array( 
			$fonts, 
			get_theme_mod( 'font_letter', 'Cutive Mono' ), 
			CurlyThemesLoadFonts::font_weight( 2 ) 
		);
		
		$this->_typography = $fonts;
		
		wp_enqueue_style('curly-google-fonts', CurlyThemesLoadFonts::fonts( $fonts ) );
		
		/** Custom Typography */
		$font_body = new CurlyThemesFont(
			get_theme_mod( 'font', 'Lora' ), 
			get_theme_mod( 'font_size', 14 ), 
			get_theme_mod( 'font_style', 2 ), 
			get_theme_mod( 'font_variant', 0 )
		);
		$font_pair = new CurlyThemesFont(
			get_theme_mod( 'font_pair', 'Roboto' ), 
			get_theme_mod( 'font_size', 14 ), 
			get_theme_mod( 'font_style', 2 ), 
			get_theme_mod( 'font_variant', 0 )
		);
		$font_letter = new CurlyThemesFont(
			get_theme_mod( 'font_letter', 'Cutive Mono' ), 
			get_theme_mod( 'font_size', 14 ) + 2, 
			get_theme_mod( 'font_style', 2 ), 
			get_theme_mod( 'font_variant', 0 )
		);
		
		$css = "
			body{ 
				$font_body->_family 
				$font_body->_style 
				$font_body->_variant 
				$font_body->_rem 
			}
			p, li, span, div{
				$font_body->_rem
				line-height: ". $font_body->_size * 0.128571428 .";
			}
			.lead{
				font-size: ". $font_body->_size * 0.128571428 ."rem;
			}
			#main-nav,
			#petitioned,
			#petitioners-counter,
			#petition-to,
			#author,
			input,
			textarea,
			select,
			#footer,
			time,
			.comment-meta h6,
			.comment-reply-link,
			.comment-edit-link,
			.comments-title,
			.fs-lightbox,
			.tags{
				$font_pair->_family
			}
			#footer p{
				font-size: ". ( $font_body->_size - 2 ) / 10 ."rem;
			}
			#letter-container{
				$font_letter->_family
			}

		";
		
		if( $echo === true ){
			echo apply_filters( 'curly_minify_css', htmlspecialchars_decode( $css ) );
		} else {
			wp_add_inline_style( 'curly-style', apply_filters( 'curly_minify_css', htmlspecialchars_decode( $css ) ) ); 
		}
	}
	
	
	
		
	/** Render Colors */
	function render_colors( $echo = false ){
		
		/** Basic */
		$css = "
			html, body {
				color: $this->_color_text;
				background-color: $this->_color_bg;
			}
			a{
				color: {$this->_color_text->darken()};
			}
			a:hover,
			.btn:hover{
				color: $this->_color_text;
			}
			::selection {
			  color: {$this->_color_primary->contrast()};
			  background-color: $this->_color_primary;
			}
			::-moz-selection {
			  color: {$this->_color_primary->contrast()};
			  background-color: $this->_color_primary;
			}
			input[type=submit],
			input[type=submit]:hover{
				border-color: $this->_color_primary;
				background-color: $this->_color_primary;
				color: {$this->_color_primary->contrast()};
			}
			input[type=text], 
			input[type=search],
			input[type=password],
			input[type=email], 
			input[type=number], 
			input[type=url], 
			input[type=date], 
			input[type=tel], 
			select, 
			textarea,
			.form-control{
				border-color: {$this->_color_text->opacity(0.25)};
				background-color: $this->_color_bg;
				color: $this->_color_text;
			}
			input[type=text]:focus, 
			input[type=search]:focus,
			input[type=password]:focus,
			input[type=email]:focus, 
			input[type=number]:focus, 
			input[type=url]:focus, 
			input[type=date]:focus, 
			input[type=tel]:focus,
			select:focus, 
			textarea:focus{
				border-color: {$this->_color_text->opacity(0.65)};
			}
			code{
				color: $this->_color_primary;
			}
			kbd{
				color: {$this->_color_text->contrast()}
			}
			pre{
				color: $this->_color_text;
				border-color: ".$this->_color_text->opacity(0.25)."
			}
			.form-group[data-required]::before, 
			div[data-required]::before{
				color: $this->_color_primary;
			}
		";
		
		/** Typography */
		$css .= "
			h1,
			h2,
			h3,
			h4,
			h6{
				color: $this->_color_text;
			}
			h5{
				color: $this->_color_primary;
			}
		";
		
		/** Header */
		$css .= "
			#header{
				box-shadow: 0px 1px 3px {$this->_color_text->opacity(0.15)};
			}
			#main-nav{
				background-color: {$this->_color_bg->opacity(0.925)};
			}
			#main-nav .menu .menu-item > a,
			#main-nav .menu .page_item > a{
				color: $this->_color_text;
				border-bottom-color: {$this->_color_text->opacity(0.1)};
			}
			#main-nav .menu .menu-item:hover > a,
			#main-nav .menu .page_item:hover > a{
				color: {$this->_color_text->opacity(0.75)};
			}
			#main-nav .menu .active > a,
			#main-nav .menu .current_page_item > a{
				color: $this->_color_primary !important;
				border-bottom-color: $this->_color_primary;
			}
			.toggle-nav-label{
				color: {$this->_color_text->darken()};
			}
			.pagination .nav-links .page-numbers{
				background-color: {$this->_color_text->opacity(0.1)};
				color: $this->_color_text;
			}
			.pagination .nav-links .page-numbers:hover{
				background-color: {$this->_color_text->opacity(0.2)};
				color: $this->_color_text
			}
			.pagination .nav-links .current, 
			.pagination .nav-links .current:hover, 
			.pagination .nav-links .current:focus{
				background-color: $this->_color_primary;
				border-color: $this->_color_primary;
				color: $this->_color_bg
			}
			.post-navigation{
				border-color: {$this->_color_text->opacity(0.1)};
			}
			.post-navigation .nav-previous::before, 
			.post-navigation .nav-next::before{
				color: $this->_color_primary;
			}
		";
		
		/** Footer */
		$css .= "
			#footer{
				background: {$this->_color_text->darken()};
				color: {$this->_color_bg->opacity(0.8)};
			}
			#footer a{
				color: $this->_color_bg;
			}
		";
		
		/** Bootstrap Overwrite */
		$css .= "
			.btn-primary{
				background-color: $this->_color_primary;
				border-color: $this->_color_primary;
				box-shadow: 0px 3px 0px 0px {$this->_color_primary->darken()};
				color: {$this->_color_primary->contrast()};
			}
			.btn-primary:hover{
				background-color: {$this->_color_primary->darken()};
				border-color: {$this->_color_primary->darken()};
				color: {$this->_color_primary->contrast()};
			}
		";
		
		/** WordPress */
		$css .= "
			#timeline .entry.sticky > div{
				background: {$this->_color_primary->opacity(0.25)};
			}
			#timeline .entry.sticky h5,
			#timeline .entry.sticky p{
				color: $this->_color_primary;
			}
			#timeline time::before{
				background-color: $this->_color_primary;
			}
			#timeline .entry > div{
				background-color: {$this->_color_text->opacity(0.05)}
			}
			.fn::before{
				color: $this->_color_primary;
			}
			.comments-count{
				background-color: {$this->_color_text->opacity(0.1)}
			}
			.sidebar-widget li{
				border-bottom-color: {$this->_color_bg->opacity(0.1)}
			}
			.sidebar-widget li::before{
				color: $this->_color_primary
			}
			.form-control.error{
				border-color: $this->_color_primary
			}
			#petition-errors{
				color: $this->_color_primary
			}
		";
		
		/** Templating */
		$css .= "
			#splash{
				color: $this->_color_bg;
			}
			.hero{
				background-color: $this->_color_text;
			}
			.hero::before{
				background: {$this->_color_bg->contrast( 0.15 )};
			}
			#petitioners-counter{
				background-color: {$this->_color_text->lighten()}
			}
			#petitioners-counter.success{
				background-color: $this->_color_primary;
				color: {$this->_color_primary->contrast()};
			}
			#petitioners-counter .progress-bar{
				background: $this->_color_primary;
			}
			#petitioners-counter.success .progress-bar{
				background: {$this->_color_primary->contrast()};
			}
			#petitioned{
				background-color: {$this->_color_text->opacity( 0.05 )};
			}
			.supporters-container{
				background-color: $this->_color_text;
			}
			.supporters-container .avatar{
				border-color: $this->_color_bg;
			}
			.supporters-container .avatar:hover{
				border-color: $this->_color_primary;
			}
			.supporters-container .section-title,
			.supporters-container h3{
				color: $this->_color_bg;
				text-shadow: 1px 1px 3px {$this->_color_bg->contrast(0.05)};
			}
			.supporters-container h3 > small{
				color: $this->_color_bg;
				border-bottom: 1px solid $this->_color_bg;
			}
			#sign-row::after{
				background: $this->_color_text;
				color: {$this->_color_text->contrast()};
				content: '".__( 'OR', 'CURLYTHEME' )."';
			}
			#letter-container{
				background-color: {$this->_color_text->opacity( 0.05 )};
			}
			.fs-lightbox-overlay{
				background-color: $this->_color_bg
			}
			.fs-lightbox{
				box-shadow: 0 0 25px {$this->_color_text->opacity(0.25)};
			}
		";

		if( $echo === true ){
			echo apply_filters( 'curly_minify_css', htmlspecialchars_decode( $css ) );
		} else {
			wp_add_inline_style( 'curly-style', apply_filters( 'curly_minify_css', htmlspecialchars_decode( $css ) ) ); 
		}
	}
	
	
	
	
	/** Editor Typography */
	function render_editor_typography() {
		
		$this->render_typography( false );
		
		$url = CurlyThemesLoadFonts::fonts( $this->_typography );
		echo "@import url('$url');";
	}
}
new CurlyRenderCSS();
?>