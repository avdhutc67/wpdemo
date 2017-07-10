<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class('animated'); ?>>
	<div class="container">
		<div class="row content-padding-lg animated">
			<div class="col-sm-12 text-center">
				<h2 class="section-title"><?php the_title(); ?></h2>
			</div><!-- .col-sm-12 -->
		</div><!-- .row -->
		<div class="row">
			<div class="col-sm-12">
				<div id="timeline">
					<?php  
						
						$posts_query = new WP_Query(
							array(
								'order' => 'DESC',
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page'=>-1
							) 
						);
						
						if ( $posts_query->have_posts() ) :
							while ( $posts_query->have_posts() ) : 
								$posts_query->the_post(); 
						
					?>
					<div <?php post_class( 'entry  animated' ) ?>>
						<time datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php the_time( 'l, F j, Y' ); ?></time>
						<div class="clearfix">
							<h5>
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								<?php if( has_category() ) : ?>
									<small class="tags">
										<?php the_category( ' &bull; ' ); ?>
									</small>
								<?php endif; ?>
							</h5>
							<?php the_content(); ?>
							
							<?php if( has_tag() ) : ?>
								<small class="tags">
									<?php the_tags('<strong>Tags:</strong> ', ' &bull; ', ''); ?>
								</small>
							<?php endif; ?>
							
						</div>
					</div><!-- .entry -->
					<?php 
							endwhile; 
						endif;
					?>
				</div><!-- #timeline -->
			</div><!-- .col-sm-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
</section><!-- #news -->