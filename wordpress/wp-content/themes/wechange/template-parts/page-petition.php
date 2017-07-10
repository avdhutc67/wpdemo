<section id="<?php echo basename( get_permalink() ) ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="row content-padding-lg">
			<div class="col-sm-12 text-center">
				<h2 class="section-title"><?php the_title(); ?></h2>
			</div>
		</div><!-- .row -->
		
		<?php if( get_post_meta( get_the_ID(), '_' . THEMEPREFIX . '_recipients_title', true ) ) : ?>
		<div class="row">
			<div class="col-sm-12">
				<h6 id="petition-to">
					<?php echo apply_filters( 'the_title', get_post_meta( get_the_ID(), '_' . THEMEPREFIX . '_recipients_title', true ) ); ?>
				</h6>
			</div>
		</div><!-- .row -->
		<?php endif; ?>
	</div><!-- .container -->
	
	<?php if( get_post_meta( get_the_ID(), '_' . THEMEPREFIX . '_recipients', true ) ) : ?>
	<div id="petitioned">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
				<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), '_' . THEMEPREFIX . '_recipients', true ) ); ?>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #petitioned -->
	<?php endif; ?>
	
	<div class="container" id="affix">
		<div class="row content-padding">
			
			<?php $column_width = 'col-md-8 col-md-offset-2'; if( has_post_thumbnail() ) : $column_width = 'col-sm-7 col-md-7 col-md-offset-1'; ?>
			<div class="col-sm-5 col-md-4 equal-height">
				<div id="side">
					<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id(), 'full' ); ?>" data-lightbox-gallery="photo_gallery" class="link-image" rel="lightbox" title="<?php echo get_the_title( get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>"><?php the_post_thumbnail( 'large' ); ?></a> 
					<?php do_action( THEMEPREFIX . '_gallery', get_the_id() ); ?>
				</div><!-- #side -->
			</div><!-- .col-md-4 -->
			<?php endif; ?>
			
			<div class="<?php echo $column_width; ?> equal-height">
				<?php the_content() ?>
				<div id="petition-author">
					<?php echo get_avatar(  get_the_author_meta( 'ID' ), '120' ); ?>
					<?php _e( 'Petition by,', 'CURLYTHEME' ); ?><br>
					<strong><?php echo get_the_author_meta( 'display_name' ) ?></strong><br>
					<?php echo get_the_author_meta( 'description' ) ?>
				</div><!-- #author -->
				
				<?php wp_link_pages(); ?>
				
			</div><!-- .col-sm-7 -->
		</div><!-- .row -->
	</div><!-- .container -->
</section><!-- #petitioned -->