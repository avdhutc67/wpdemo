<?php get_header(); ?>

<div class="container content-padding-lg">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<?php	
			
				if ( have_posts()) : while ( have_posts() ) : the_post();
				
				get_template_part( 'content-excerpt', get_post_format() );
				
				endwhile;
				
				
				endif;
			?>
		<div class="text-center animated">
			<?php the_posts_pagination(); ?>
		</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>