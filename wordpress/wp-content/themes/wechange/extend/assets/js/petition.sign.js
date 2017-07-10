(function($) {
	"use strict";
	
	var $button = $('#sign-petition');
	
	$button.submit(function(e){
		e.preventDefault();
		
		var data = {
			'action': 'sign_petition',
			'email'	: $( 'input[name="email"]', this ).val(),
			'fname'	: $( 'input[name="fname"]', this ).val(),
			'lname'	: $( 'input[name="lname"]', this ).val(),
			'bio'  	: $( 'textarea.bio', this ).val(),
			'signature'	: $( '#signature', this ).val()
		}; 

		$.post( petition.ajaxurl, data, function( response ) {
			
			response = JSON.parse(response);
			
			if( typeof(response.errors) !== "undefined" && response.errors !== null ){
				
				if( $( '#petition-errors' ).html() !== '' ){ $( '#petition-errors' ).html(''); }
				
				$('#sign-petition .error').each(function (){
					$(this).removeClass('error');
				});
				
				$.each( response.errors, function( key, error ){
					$( '.' + key, '#sign-petition' ).addClass( 'error' );
					$( '#petition-errors' ).append( '<li>' + error[0] + '</li>' );
				});
			} else{
				$( '<p>' + response.success + '</p>' ).insertBefore( '#sign-petition' );
				$('#sign-petition').hide();
			}
			
		});
		
	});

	
})(jQuery);