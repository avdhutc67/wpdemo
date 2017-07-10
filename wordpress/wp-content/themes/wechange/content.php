<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class('animated content-page content-padding-lg'); ?>>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="section-title"><?php the_title(); ?></h1>
			</div><!-- .col-sm-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<?php the_content(); ?>
			</div><!-- .col-sm-5 -->
		</div><!-- .row -->
	</div><!-- #sign-row -->
</section><!-- #sign-it -->