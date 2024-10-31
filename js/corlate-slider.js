jQuery(function($) {'use strict',




	//#main-slider
	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 8000
		});
	});
	$(function(){
		$('.carousel-inner .item:first-child').addClass('active');
		$('.carousel li:first-child').addClass('active');
	
	});

});