<?php // Template Name: Petition ?>

<?php get_header(); ?>
	
	<?php if ( have_posts() ) : the_post(); ?>
		<div class="content-padding-bottom-lg">
		<?php get_template_part( 'template-parts/page', 'petition' ); ?>
		</div>
	<?php endif; ?>
	
<?php get_footer(); ?>