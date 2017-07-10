(function($) {
  "use strict";
	
	function hextorgb(hex, opacity) {
		
		hex = hex.trim();
		
		if( hex === 'transparent' ){
			return 'transparent';
		} else if( hex.substr(0, 4) === 'rgb(' ){
			opacity = opacity ? opacity : 1;
			hex = hex.substr(5, -1);
			return 'rgba( '+ hex +' , '+ opacity +' )';
		} else if( hex.substr(0, 4) === 'rgba' ){
			hex = hex.substr(5, -1);
			hex = hex.split(',');
			opacity = opacity ? opacity : hex[3];
			return 'rgba( '+ hex[0] +' , '+ hex[1]+' , '+ hex[2] +' , '+ opacity +' )';
		} else {
			opacity = opacity ? opacity : 1;
			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	    result = result ? {
	        r: parseInt(result[1], 16),
	        g: parseInt(result[2], 16),
	        b: parseInt(result[3], 16)
	    } : null;
	    
	    return 'rgba( ' + result.r + ',' + result.g + ',' + result.b + ',' + opacity + ' )';
		}
	}

	// Background Color
	wp.customize( 'color_bg', function( value ) {
		
		value.bind( function( newval ) { 
			$('html, body, input[type=text], input[type=search],input[type=password], input[type=email], input[type=number], input[type=url], input[type=date], input[type=tel], select, textarea, .form-control, .fs-lightbox-overlay').css('background-color', newval );
			$('#main-nav').css('background-color', hextorgb(newval, 0.925) );
			$('#footer').css('color', hextorgb(newval, 0.8) );
			$('#footer a, #splash, .supporters-container .section-title, .supporters-container h3, .supporters-container h3 > small').css('color', newval );
			$('.sidebar-widget li').css('border-bottom-color', hextorgb(newval, 0.1) );
			$('.supporters-container .avatar, .supporters-container h3 > small').css('border-color', newval );
		} );

	} );
	
	// Background Color
	wp.customize( 'color_text', function( value ) {
		
		value.bind( function( newval ) { 
			$('html, body, a, input[type=text], input[type=search], input[type=password], input[type=email], input[type=number], input[type=url], input[type=date], input[type=tel], select, textarea, .form-control, h1, h2, h3, h4, h6, #main-nav .menu .menu-item > a, #main-nav .menu .page_item > a').css('color', newval );
			$('input[type=text], input[type=search], input[type=password], input[type=email], input[type=number], input[type=url], input[type=date], input[type=tel], select, textarea, .form-control').css('border-color', hextorgb( newval, 0.25) );
			$('#header').css('box-shadow', '0px 1px 3px ' + hextorgb( newval, 0.15) );
			$('#main-nav .menu .menu-item > a, #main-nav .menu .page_item > a').css('border-bottom-color', hextorgb( newval, 0.1 ) );
			$('#timeline .entry > div, #petitioned, #letter-container').css('background-color', hextorgb( newval, 0.05 ) );
			$('.comments-count').css('background-color', hextorgb( newval, 0.1 ) );
			$('.hero, .supporters-container').css('background-color', newval );
			$('.fs-lightbox').css('box-shadow', '0 0 25px  ' + hextorgb(newval, 0.25) );
		} );

	} );
	
	// Primary Color
	wp.customize( 'color_primary', function( value ) {
		
		value.bind( function( newval ) { 
			$('input[type=submit], h5, #main-nav .menu .active > a, #main-nav .menu .current_page_item > a, #timeline .entry.sticky h5, #timeline .entry.sticky p').css('color', newval );
			$('input[type=submit], .btn-primary').css('border-color', newval );
			$('#main-nav .menu .active > a, #main-nav .menu .current_page_item > a').css('border-bottom-color', newval );
			$('.btn-primary, #petitioners-counter .progress-bar').css('background-color', newval );
			$('.btn-primary, input[type=submit]').css('box-shadow', '0px 3px 0px 0px' + newval );
			$('#timeline .entry.sticky > div').css('background-color', hextorgb( newval, 0.25 ) );
			$('.btn-primary').css('color', getContrast50(newval) );
		} );

	} );
	
	function getContrast50(hexcolor){
	    return (parseInt(hexcolor, 16) > 0xffffff/2) ? 'black':'white';
	}

	
})(jQuery);