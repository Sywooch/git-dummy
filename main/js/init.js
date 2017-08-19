$(function(){
	
	$('.slider1').mobilyslider();
	
	$('.slider2').mobilyslider({
		transition: 'horizontal',
		animationSpeed: 500,
		autoplay: true,
		autoplaySpeed: 3000,
		pauseOnHover: true,
		bullets: false
	});
	
	$('.slider3').mobilyslider({
		transition: 'fade',
		animationSpeed: 2000,
		autoplay: true,
		bullets: true,
		arrowsHide: false
	});
	
	
});
