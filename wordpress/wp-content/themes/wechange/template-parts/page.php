<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class('animated content-page content-padding-lg'); ?>>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="section-title"><?php the_title(); ?></h2>
			</div><!-- .col-sm-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<?php the_content(); ?>
				
				<?php wp_link_pages(); global $withcomments; $withcomments = '1'; if ( comments_open() ) :  comments_template(); endif;?>
			</div><!-- .col-sm-5 -->
		</div><!-- .row -->
	</div><!-- #sign-row -->
</section><!-- #sign-it -->