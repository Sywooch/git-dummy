jQuery(document).ready(function($) {
	
	$('ul.menu.flex').flexMenu();
	$('.bxslider').bxSlider({
		responsive: true
	});

	var scrollContent = $(".scroller");

	$('#itemslider').slider({
		slide: function( event, ui ) {
			scrollContent.css('left', '-' + ui.value*6.8 + 'px');
		}
	});


	$('.item-preview-slider').bxSlider({
		responsive: true,
		slideWidth: 90,
		pager : false,
		moveSlides : 1,
		minSlides : 2,
		maxSlides : 3,
		slideMargin : 4,
		infiniteLoop : true
	});

	$('.item_page_slider').bxSlider({
		slideWidth: 90,
		pager : false,
		moveSlides : 1,
		maxSlides : 6,
		slideMargin : 20
	});

	$('.item_page_slider_content').bxSlider({
		slideWidth: 272,
		pager : false,
		moveSlides : 1,
		maxSlides : 4,
		slideMargin : 30		
	});

	$('.hot .item').first().addClass('first_item');

	flexMenuHover();  // ховер для флекс меню
	itemImageChanger();
	on_hover();
	showHint();
	showList(); // открытие\закрытие списка в футере
    menuOnHover();
    showListInFooter();
    itemMoneyCounter();
    	
	// jquery ui datapicker
    $( ".datepicker" ).datepicker();

	$(window).resize(function(){
		if($(window).width() < 986 ){
		    var height = $('.item-main-description').height();
		    $('.price-info').css('margin-top', height + 20);
			console.log(height);
		} else { 
			console.log($(window).width());
			$('.price-info').css('margin-top', 0);
		}
	});

});

$(window).load(function(){
	$('.slide_content, .bx-wrapper .bx-pager, .bx-wrapper .bx-controls-direction a').show();
});

function showHint(){
	$('#hint-overlay').click(function(){
		$('.hint-wrapp').hide();
		$(this).removeClass('hint-overlay-open').hide();
	});

	$('.search_input').keydown(function(event){
	    $('.hint-wrapp').show(function(){
	    	$('#hint-overlay').show().addClass('hint-overlay-open');
	    });
	    if(event.which == 8 && $('.search_input').val().length == 1 ) {
            console.log('backspace pressed');
			$('.hint-wrapp').hide();
        }
	});
}

function showList(){
	$('#show-categories').click(function(){
	    $('.asq, .showhide-li').toggleClass('hide-cat');
	});
}

$(window).resize(function(){
	// slider_resize();
	// resizeSearchInput(); // ресайз поиска
});


function showListInFooter(){
	$('.showList .prefooter_title').click(function(){
            $('.showList ul').hide();
            if($(this).is('.opened')){
                $(this).removeClass('opened');
            }else{
                $(this).parents('.showList.prefooter_list').find('ul').show();
                $(this).addClass('opened');
            }  
	});
}

// ресайз поиска
function resizeSearchInput(){

	var search_input = $('.search_input');
	var headwidth = $(".head").width();
	var search_input_width = headwidth - 425;
	var hint_container = $('#hint-container');

	if($(window).width() > 997){
		search_input.width('59%');
		hint_container.width(search_input.outerWidth() - 29);
	}
	if($(window).width() <= 996){
		search_input.width(195);
		hint_container.width(348);
	}
	if($(window).width() <= 624 ){
		search_input.width('59%');
		hint_container.width(search_input.width());
	}

}

function flexMenuHover() {
	$('.flexMenu-viewMore').hover(function() {
		$(this).find().attr('src','img/menu_icon_hover.png');
	}, function() {
		$(this).attr('src','img/menu_icon.png');
	});
}

function slider_resize(){
	$('.bx-viewport, .bx-wrapper img').css('min-height','345px');
	var viewport = $('.bx-viewport').height();
	var controls = $('.bx-controls.bx-has-pager.bx-has-controls-direction');
	var padding_top = 0;
	var font_size = 0;
	font_size = viewport/8;
	if(font_size > 60){
		font_size = 60;
		$('.slide_content p').css('font-size', font_size );
	}else{
		$('.slide_content p').css('font-size', font_size );
	}
}

// ховер на разные иконки которых нет в бутстраповских шрифтах
function on_hover(){
	$('.account_wrapp').hover(function() {
		$(this).find('.user_icon').css('background', 'url(../img/acc_imgs.png) no-repeat 0px -68px');
	}, function() {
		$(this).find('.user_icon').css('background','url(../img/acc.png) no-repeat 0px -68px');
	});

	$('.language').hover(function() {
		$(this).find('.flag_icon').css('background', 'url(../img/flag.png) no-repeat 0px -0px');
	}, function() {
		$(this).find('.flag_icon').css('background','url(../img/flag.png) no-repeat 0px -22px');
	});
}

function itemImageChanger(){
	$('.item_preview img').click(function(){
		var img_src = $(this).attr('src');
		$(this).parents('.item').find(".item_image").attr('src', img_src);
	});
}

// псевдоховер на мобильном устройстве для меню
function menuOnHover(){

    //$('.dinamic_menu a, .sub').hover(function() {
    //    $(this).next('.sub').show();
    //}, function() {
    //    $(this).next('.sub').hide();
    //});

    // $('.dinamic_menu a').click(function(){
    //     if(navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/iPhone|iPad|iPod/i) || navigator.userAgent.match(/IEMobile/i))
    //         if($(this).next('.sub').length!=0){
    //             if($(this).data('click')==undefined){
    //                 $(this).data('click','1');
    //                 $('.sub').show();
    //                 return false;
    //             }
    //         }
    // });
}

function itemMoneyCounter(){
	var lower = $('.lower');
	var upper = $('.upper');
	var result = parseInt($('#res_counter').text());

	lower.click(function(){
		result -= 1;
		$('#res_counter').text(result);		
	});

	upper.click(function(){
		result += 1;
		$('#res_counter').text(result);		
	});

}
