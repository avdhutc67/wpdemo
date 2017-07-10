<?php get_header(); ?>

<section class="container-fluid">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	     <?php get_template_part( 'content', get_post_format() );  ?>
	     <?php endwhile; ?>
	 <?php else : get_template_part( 'content' , 'missing' ); endif; ?>
</section>

<?php get_footer(); ?>