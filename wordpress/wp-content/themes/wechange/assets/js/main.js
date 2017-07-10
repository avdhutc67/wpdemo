(function ($) {
    "use strict";

	/** Define Mobile Environment */
	var isMobile = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i);
	    },
	    any: function() {
	        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	    }
	};
	
	/** Header Crossfade */
	$('.crossfade').crossfade({
		threshold : 0.25
	});
	
	/** Collapse */
	$('a[data-toggle]').on('click', function (e) {
		e.preventDefault();
	});
	
	/** Affix */
	$(function() {
		if ( ! isMobile.any() ) {
		    $('.equal-height').matchHeight();
		    $("#side").stick_in_parent({
		    	offset_top: 100
		    });
	    }
	});
	
	
	
	/** Lightbox */
	if ( $('a[rel="lightbox"]').length > 0 ) {
		$(function () {
		    $('a[rel="lightbox"]').lightbox();
		});
	}
	
	
	/** Gallery Lightbox */
	if ( $('.gallery-icon > a > img').length > 0 ) {
		$(function () {
		    $('.gallery-icon > a').lightbox();
		});
	}
	
	
	
	/** Video Bg */
	if ( $(".supporters-container").length > 0 ) {
		
		var $supporters = $(".supporters-container");
		
		var $cover 	= $supporters.parent().data( 'video-cover' );
		var $video 	= $supporters.parent().data( 'video-external' );
		var $mp4 	= $supporters.parent().data( 'video-mp4' );
		var $webm 	= $supporters.parent().data( 'video-webm' );
		var $ogg 	= $supporters.parent().data( 'video-ogg' );
		
		$supporters.background({
			source: {
				poster	: $cover,
				video	: $video,
				mp4		: $mp4,
				ogg		: $ogg,
				webm	: $webm
			}
		});
		
	
	}
	
	/** Supporters Popover */
	$('.supporter').popover({
		trigger: 'hover'
	});
	
	
	
	
	/** Set-up Footer */
	$( document ).ready(function() {
		var $footer_height = $('#footer').outerHeight();
	    $('#content').css( 'padding-bottom', $footer_height );
	    $('#footer').css( 'margin-top', -$footer_height );
	});
	
	
	
	
	
	/** Waypoints */
	$( document ).ready(function() {
		
		/** Animations */
		if ( $('.animated').length > 0 && ! isMobile.any() ) {
			$('.animated').waypoint(function() {
				var target = $(this);
				if ( ! target.hasClass( 'animated_off' ) ) {
					$(target).delay(150).velocity("transition.slideUpIn");
					target.addClass( 'animated_off' );
				}
			},{
				offset: $.waypoints('viewportHeight')
			});
		} else {
			$('.animated').css('opacity', 1);
		}
		
		/** Numbers */
		$( '.counter' ).waypoint(function() {
			if( $(this).data( 'number') ) { 
				$(this).animateNumbers( $(this).data('number') );
			}
		},{
			offset: $.waypoints('viewportHeight')
		});
		
		
		/** Progress Bar */
		$('.progress-bar').waypoint(function() {
			$(this).css( 'width', $(this).attr('aria-valuenow') + "%" );
		},{
			offset: $.waypoints('viewportHeight')
		});
		
	});
	
	
	/** Default Scroll */
	$('.one-page:not(.home):not(.blog) .smooth-scroll').on( 'click', function (e) {
		window.location.replace( $(this).data( 'base' ) + $(this).attr( 'href' ) );
	});
	
	
	if( $('#supporters-masonry').length > 0 ){
		$('#supporters-masonry').imagesLoaded( function(){
			$('#supporters-masonry').masonry({
			  itemSelector	: '.supporter',
			  isFitWidth	: true,
			  gutter		: 30
			});
		});
	}
	
	
	
	if( $('#petitioned').length > 0 ){
		$('#petitioned').imagesLoaded( function(){
			$('#petitioned ol').masonry({
			  itemSelector	: 'li'
			});
		});
	}
	
	
	
	/** Nice Scroll */
	$('.one-page.home.one-page .smooth-scroll').on( 'click', function (e) {
		e.preventDefault(); 
		var target = $(this).attr('href');
		if ( ! isMobile.any() ) {
			$(target).velocity( "scroll", { duration: 1000, delay: 200 } );
		} else {
			$(target).velocity( "scroll", { duration: 1000, delay: 200, offset: -60 } );
		}
	});
	
	/** Mobile Navigation */
	if ( isMobile.any() ) {
		$('.menu-item').on( 'click', function () {
			$('#toggle-main-nav').prop('checked', false);
		});
	}
	
})(jQuery);