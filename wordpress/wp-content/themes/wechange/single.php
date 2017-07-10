<?php get_header(); ?>

<section class="container-fluid">
	<?php if ( have_posts() ) : the_post(); ?>
	
	     <article  <?php post_class('animated content-page content-padding-lg'); ?>>
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h1 class="section-title">
							<?php the_title(); ?>
						</h1>
					</div><!-- .col-sm-12 -->
				</div><!-- .row -->
			</div><!-- .container -->
			
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<?php 
							the_post_thumbnail( 
								'full', 
								array(
									'class' => "featured-image",
								) 
							); ?>
						<?php the_content(); ?>
						
						<?php if( has_category() ) : ?>
							<div class="tags">
								<?php _e( '<strong>The Categories: </strong>', 'CURLYTHEME' ); the_category( ' &bull; ' ); ?>
							</div>
						<?php endif; ?>
						
						<?php if( has_tag() ) : ?>
							<div class="tags">
								<?php the_tags('<strong>Tags:</strong> ', ' &bull; ', ''); ?>
							</div>
						<?php endif; ?>
						
					</div><!-- .col-sm-5 -->
				</div><!-- .row -->
			</div>
		</article>
	     
	     <div class="container">
			<div class="row content-padding-bottom-lg">
				<div class="col-sm-8 col-sm-offset-2">
					
				     <!-- Link Pages -->
					<?php wp_link_pages(); ?>	
					
					<!-- Post Navigation -->
					<?php if( get_theme_mod( 'post_navigation', false ) === false ) the_post_navigation(); ?>
					
					<!-- Comments -->
					<?php if ( comments_open() ) : comments_template(); endif; ?>
					
				</div>
			</div>
	     </div>
		
	 <?php else : get_template_part( 'content' , 'missing' ); endif; ?>
</section>

<?php get_footer(); ?>