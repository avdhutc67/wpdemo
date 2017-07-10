<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); echo apply_filters( THEMEPREFIX . 'body_attributes', $attributes = null ); ?>>
	<header id="header">
		<nav id="main-nav">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php do_action( 'curly_logo' ); ?>
						<label class="toggle-nav-label visible-xs" for="toggle-main-nav"><i class="fa fa-bars fa-lg"></i></label>
						<input type="checkbox" id="toggle-main-nav" class="toggle-nav-input">
						<?php  
							global $wechange;
							
							if( WeChange::Mode() ){
								$args = array(
									'theme_location' => 'main_navigation',
									'container' => null,
									'menu_class'	=> 'menu nav',
									'fallback_cb'	=> array( $wechange, 'navigation' ),
									'depth'	=> 0
								);
							} else{
								$args = array(
									'theme_location' => 'main_navigation',
									'container' => null,
									'depth'	=> 0
								);
							}
							
							wp_nav_menu( $args );	
						?>
					</div><!-- .col-xs-12 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</nav><!-- #main-nav -->
  	</header><!-- #header -->
  	<div id="content" class="clearfix">