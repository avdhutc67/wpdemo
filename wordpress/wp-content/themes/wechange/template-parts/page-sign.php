<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class('animated  content-padding-lg'); ?>>
	<div class="container" id="petition-validation">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="section-title"><?php the_title(); ?></h2>
			</div><!-- .col-sm-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
	<div class="container" id="sign-row">
		<div class="row">
			<div class="col-md-4 col-md-offset-2 col-sm-6" id="sign-list">
				<?php do_action( THEMEPREFIX . '_sharing', true ) ?>
			</div>
			<div class="col-md-4  col-sm-5 col-sm-offset-1">
				<?php do_action( 'sign-petition' ); ?>
			</div>
		</div>
	</div><!-- #sign-row -->
</section><!-- #sign-it -->