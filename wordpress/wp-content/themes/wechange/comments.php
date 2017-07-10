<?php if ( post_password_required() ) return; ?>

<div id="comments" class="comments-area comments">
<?php if ( have_comments() ) : ?>
    <div class="comments-title">
	    <span class="comments-count">
        <?php
            printf( 
            	_n( '1', 
            	'%1$s', 
            	get_comments_number(), 
            	'CURLYTHEME'
            ),
            number_format_i18n( get_comments_number() )
            );
        ?>
	    </span>
        <?php do_action( THEMEPREFIX . '_sharing', false ) ?>
    </div>
    <ul class="comment-list">
        <?php do_action( 'curly_comments' ); ?>
    </ul>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	    <nav id="comment-nav-below" class="navigation" role="navigation">
	        <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'CURLYTHEME' ); ?></h1>
	        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'CURLYTHEME' ) ); ?></div>
	        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'CURLYTHEME' ) ); ?></div>
	    </nav>
    <?php endif; 
	
    if ( ! comments_open() && get_comments_number() ) : ?>
    	<p class="nocomments"><?php _e( 'Comments are closed.' , 'CURLYTHEME' ); ?></p>
    <?php endif; ?>

<?php endif; ?>

<?php do_action( 'curly_comments_form' ); ?>

</div>
		
