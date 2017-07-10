<?php //Template Name: One-Page ?>
<?php get_header(); ?>

<?php	
	
	$wechange_query = new WP_Query(
		array(
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'hierarchical' => 1,
			'parent' => 0,
			'posts_per_page' => -1,
			'post_type' => 'page',
			'post_status' => 'publish',
			'post__not_in' => array( WeChange::Mode( true ) )
		) 
	);
	
	if ( $wechange_query->have_posts() ) { 
		while ( $wechange_query->have_posts() ){ 
			$wechange_query->the_post(); 
			get_template_part( 
				'template-parts/page', 
				str_replace( 
					array( 'page-templates/', '.php' ), '', get_page_template_slug( get_the_id() ) 
				) 
			);
		}
	} 
	
	wp_reset_postdata(); 

?>	

<?php get_footer(); ?>