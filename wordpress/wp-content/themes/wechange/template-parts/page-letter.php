<?php 

	$bg = get_post_meta( get_the_id(), '_' . THEMEPREFIX . '_bg', true );
	$bg = empty( $bg ) ? 'bg-lined-paper' : $bg;

?>
<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class("animated $bg"); ?>>
	<div class="container">
		<div class="row content-padding-lg">
			<div class="col-sm-12 text-center">
				<h2 class="section-title"><?php the_title(); ?></h2>
			</div><!-- .row -->
		</div><!-- .row -->
	</div><!-- .container -->
	<div id="letter-container">
		<div class="container">
			<div class="row content-padding-xs">
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<?php the_content(); ?>
				</div><!-- .col-sm-6 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #letter-container -->
</section><!-- #letter -->