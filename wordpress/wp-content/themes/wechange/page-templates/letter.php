<?php // Template Name: Letter ?>

<?php get_header(); ?>
	
	<?php if ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/page', 'letter' ); ?>
	<?php endif; ?>
	
<?php get_footer(); ?>