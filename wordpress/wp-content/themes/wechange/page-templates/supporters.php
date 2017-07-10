<?php // Template Name: Supporters ?>

<?php get_header(); ?>
	
	<?php if ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/page', 'supporters' ); ?>
	<?php endif; ?>
	
<?php get_footer(); ?>