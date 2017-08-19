  function testAnim(x) {
    $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
  };

  $(document).ready(function(){
    $('.js--triggerAnimation').click(function(){
      var anim = $('.js--animations').val();
      testAnim(anim);
    });

    $('.js--animations').change(function(){
      var anim = $(this).val();
      testAnim(anim);
    });
  });

  
  

$(window).scroll(function () {		
	
	if ($(this).scrollTop() > 1500) {
		$(".da-thumbs").addClass("effect-3 effect-duration-1"); $(".da-thumbs").css("visibility","visible");
	}		
	if ($(this).scrollTop() > 2500) {
		  $(".fl").animate({
			paddingTop: "300px",
			paddingBottom: "300px",
		  }, 1000 );
		setTimeout('$("#p").addClass("animated fadeIn"); $("#p").css("visibility","visible");', 200);
		setTimeout('$("#button").addClass("animated fadeIn"); $("#button").css("visibility","visible");', 600);
	}	
	if ($(this).scrollTop() > 3300) {
		setTimeout('$(".message-block").addClass("animated bounceInLeft"); $(".message-block").css("visibility","visible");', 200);
	}
	
	if ($(this).scrollTop() > 3800) {
		setTimeout('$("#foto1").addClass("animated pulse"); $("#foto1").css("visibility","visible");', 200);
		setTimeout('$("#foto2").addClass("animated pulse"); $("#foto2").css("visibility","visible");', 600);
		setTimeout('$("#foto3").addClass("animated pulse"); $("#foto3").css("visibility","visible");', 1000);
		setTimeout('$("#foto4").addClass("animated pulse"); $("#foto4").css("visibility","visible");', 1400);
	}	
	
});

$(document).ready(function(){
	$(".work ul li:nth-child(16)").mouseover(function(){
		$(".work-hover").addClass("animated zoomIn");
		$(".work-hover").css({
			'display':'block',
			'margin-top':'175px',
			'margin-left':'720px',
		});
	});
	$(".work ul li").mouseout(function(){
		$(".work-hover").css("display","none");
	});
});