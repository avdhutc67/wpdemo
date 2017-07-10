<?php  
	
	$hero 		= get_post_meta( get_the_id(), '_' . THEMEPREFIX . '_crossfade', true );
	$hero_tilt 	= get_post_meta( get_the_id(), '_' . THEMEPREFIX . '_crossfade_blur', true );
	
	$hero 		= $hero ? " data-crossfade-start='$hero'" : null;
	$hero_tilt	= $hero_tilt ? " data-crossfade-end='$hero_tilt'" : null;
	
	$crossfade 	= $hero && $hero_tilt ? 'crossfade ' : null;
	
?>
<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class( "$crossfade hero pb-pattern o-lines-light" );  echo $hero . $hero_tilt; ?>>
	<div id="splash">
		<?php the_content(); ?>
	</div><!-- #splash -->
	<?php do_action( 'petition-counter' ) ?>
</section><!-- #home -->