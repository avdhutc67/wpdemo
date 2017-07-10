<article id="<?php echo basename( get_permalink() ) ?>" <?php post_class('animated content-page content-padding'); ?>>
	<div class="text-center">
		<h1 class="section-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	</div><!-- .col-sm-12 -->
	<?php the_excerpt(); ?>
</article>