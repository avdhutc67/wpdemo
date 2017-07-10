(function($) {
  "use strict";

	
	/** Comments */
	wp.customize( 'comments', function( value ) {
		value.bind( function( newval ) { 
			if( newval === '2' ){
				wp.customize.control( 'comments_disqus' ).activate();
				wp.customize.control( 'comments_facebook' ).deactivate();
			} else if( newval === '3' ){
				wp.customize.control( 'comments_facebook' ).activate();
				wp.customize.control( 'comments_disqus' ).deactivate();
			} else{
				wp.customize.control( 'comments_disqus' ).deactivate();
				wp.customize.control( 'comments_facebook' ).deactivate();
			}
		} );
	} );
	
	/** Petition Type */
	wp.customize( 'petition_type', function( value ) {
		value.bind( function( newval ) { 
			if( newval === '1' ){
				wp.customize.control( 'petition_needed' ).activate();
			} else{
				wp.customize.control( 'petition_needed' ).deactivate();
			}
		} );
	} );
	
})(jQuery);