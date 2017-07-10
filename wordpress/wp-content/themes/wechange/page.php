<?php get_header(); ?>

<article class="container-fluid">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
						
						<?php wp_link_pages(); ?>
					</div><!-- .col-sm-5 -->
				</div><!-- .row -->
			</div>
		</section>
		<?php if ( comments_open() ) : ?>
		<div class="container">
			<div class="row content-padding animated">
				<div class="col-md-8 col-md-offset-2">
					<?php comments_template(); ?>
				</div>
			</div>
		</div>
		<?php endif; endwhile; ?>
	 <?php else : get_template_part( 'content' , 'missing' ); endif; ?>
</article>

<?php get_footer(); ?>