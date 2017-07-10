<?php 
	
	$data 	= ' ';

	$cover 	= esc_url_raw( get_post_meta( get_the_id(), '_'. THEMEPREFIX .'_video_cover', true ) ); 
	$video 	= esc_url_raw( get_post_meta( get_the_id(), '_'. THEMEPREFIX .'_video_external', true ) );
	$mp4 	= esc_url_raw( get_post_meta( get_the_id(), '_'. THEMEPREFIX .'_video_mp4', true ) );
	$webm 	= esc_url_raw( get_post_meta( get_the_id(), '_'. THEMEPREFIX .'_video_webm', true ) );
	$ogg 	= esc_url_raw( get_post_meta( get_the_id(), '_'. THEMEPREFIX .'_video_ogg', true ) );
	
	$data .= ! empty( $cover ) ? "data-video-cover='$cover' " : '';
	$data .= ! empty( $video ) ? "data-video-video='$video' " : '';
	$data .= ! empty( $cover ) ? "data-video-mp4='$mp4' " : '';
	$data .= ! empty( $cover ) ? "data-video-webm='$webm' " : '';
	$data .= ! empty( $cover ) ? "data-video-ogg='$ogg' " : '';

?>
<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class('supporters animated'); echo $data; ?>>
	<div class="supporters-container pb-pattern o-lines-light">
		<div class="container">
			<div class="row content-padding-lg">
				<div class="col-sm-12 text-center">
					<h2 class="section-title"><?php the_title(); ?></h2>
					<div class="row content-padding">
						<?php do_action( 'petition-supporters' ) ?>
					</div>
					<?php the_content(); ?>
					
				</div><!-- .col-sm-12 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #supporters-container -->
	<div class="container">
		<div class="row content-padding animated">
			<div class="col-sm-12 col-md-8 col-md-offset-2">
				<?php do_action( 'petition-comments' ) ?>
			</div>
		</div>
	</div>	
	
</section><!-- #supporters -->