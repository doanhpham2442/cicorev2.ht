(function($) {
	"use strict";
	var HT = {}; // Khai báo là 1 đối tượng

	/* MAIN VARIABLE */

	var $window = $(window),
	    $document = $(document),
		$carousel = $(".owl-slide");
	    

	    // FUNCTION DECLARGE
	    $.fn.elExists = function() {
	        return this.length > 0;
	    };
		HT.carousel = () => {
			$carousel.each(function(){
				let _this = $(this);
				let option = _this.find('.owl-carousel').attr('data-owl');
				let owlInit = atob(option);
				owlInit = JSON.parse(owlInit);
				_this.find('.owl-carousel').owlCarousel(owlInit);
			});
			
		} 
		

	    
	    // Document ready functions
	    $document.on('ready', function() {
	    	HT.carousel();
	    });

	})(jQuery);
	$(function () {
		$(document).scroll(function () {
		  var $nav = $(".navbar-fixed-top");
		  $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
		});
	  });
	  (function ($) {
		"use strict";
	  
		  $(window).scroll(function() {
			  if ($(this).scrollTop() > 300) {
				  $('.scrollToTop').addClass('button-show');
			  } else {
				  $('.scrollToTop').removeClass('button-show');
			  }
		  });
		
		  $(document).ready(function() {	
			  $(".scrollToTop").click(function () {
				 //1 second of animation time
				 //html works for FFX but not Chrome
				 //body works for Chrome but not FFX
				 //This strange selector seems to work universally
				 $("html, body").animate({scrollTop: 0}, 800);
			  });
		  });
	  
	  }(jQuery));	
	  (function ($) {
		"use strict";
	  
		  $(document).ready(function () {
	   
			var locationButton = $( '.site-location > a' );
			var locationSelected = $('.site-location a .current-location');
			var locationClose = $( '.close-popup' );
			var locationHolder = $( '.select-location' );
			var locationOverlay = $( '.location-overlay' );
	  
			locationButton.each(function() {
			  $(this).on( 'click', function(e) {
				e.preventDefault();
				locationHolder.addClass( 'active' );
				  locations.select2("open");
			  });
			});
	  
			locationClose.on( 'click', function(e) {
			  e.preventDefault();
			  locationHolder.removeClass( 'active' );
			});
			
			locationOverlay.on( 'click', function(e) {
			  e.preventDefault();
			  locationHolder.removeClass( 'active' );
			});
	  
			function minPrice(min) {
			  if (!min.id) {
				return min.text;
			  }
	  
			  var $min;
	  
			  if ( min.element.dataset.min ) {
				$min = $( '<span>' + min.text + '</span><span class="min-price">' + min.element.dataset.min + '</span>' );
			  } else {
				$min = min.text;
			  }
	  
			  return $min;
			}
			
		  });
	  
	  })(jQuery);
	  	  