jQuery(document).ready(function($) {
	
	// схлопываем меню под слайдером при ресайзе
	$('ul.menu.flex').flexMenu();

	// маленький слайдер в айтемах 
	$('.item-preview-slider').bxSlider({
		pager: false,
		responsive: true,
		minSlides : 2,
		maxSlides : 3,
		infiniteLoop : true,
		slideWidth : 88.625,
		moveSlides: 1,
		slideMargin : 5
	});

	// Слайдер под меню
	$('.bxslider').bxSlider({
		responsive: true,
	});

	// правкаа для отступов в айтемах горячих предложениях
	$('.hot .item').first().addClass('first_item');

    	
	// jquery ui datapicker
    $( ".datepicker" ).datepicker();

	flexMenuHover(); 		// изменяем цвет полосок в меню под слайдером ( TODO : проверить актуальность )
	itemImageChanger(); 	// скриптик для изменения изображения в айтемах
	on_hover(); 			// ховер на разные иконки которых нет в бутстраповских шрифтах
	slider_resize();		// видоизменяем слайдер при ресайзе ( TODO : проверить актуальность )
	showList();				// открываем\закрываем меню в футере
    menuOnHover();			// псевдоховер на мобильном устройстве для меню
    halfCatalogToggle();	// открываем\закрываем половину каталога в меню "Каталог" в ховере
    onTypeingSearchInput(); // открываем окно подсказки если набираем текст в input поиска

});

$(window).resize(function(){
	slider_resize();
    searchInputResize()		// ресайзим инпут поиска
});

// отображаем кнопки переключения слайдов и контент слайда 
// только после загрузки изображения ( после того как подгрузится страница )
$(window).load(function(){
	$('.slide_content, .bx-wrapper .bx-pager, .bx-wrapper .bx-controls-direction a').show();
	console.log('show');
});

function halfCatalogToggle(e){
	$('.open-close').click(function(){
		$('.hide-footer-menu').toggleClass('hide');
	});
}


function searchInputResize(){
	var deltahead = $('.head').width(); 

	if($(window).width() < 970 && $(window).width() > 622){
		$('.search_input').width(deltahead - 416);
	} else if ($(window).width() < 621) {
		$('.search_input').width($(window).width() - 65);
	} else if ($(window).width() > 970 ) {
		$('.search_input').width("60%");
	}


}	

function onTypeingSearchInput(){
	var search_input = $('.search_input');

	search_input.keyup(function(){
		$('.hint-wrapp').show();
		$('.search_input').addClass('input-shadow');
		if( search_input.val().length == 0 ) {
			$('.hint-wrapp').hide();
			$('.search_input').removeClass('input-shadow');
		}
	});
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

function showList(){
	$('.showList .prefooter_title').click(function(){
            $('.showList ul').hide();
            if($(this).is('.opened')){
                $(this).removeClass('opened');
            }else{
                $(this).parents('.showList.prefooter_list').find('ul').slideDown('fast');
                $(this).addClass('opened');
            }  
	});
}

// псевдоховер на мобильном устройстве для меню
function menuOnHover(){

    $('.dinamic_menu a, .sub').hover(function() {
       $(this).next('.sub').show();
    }, function() {
       $(this).next('.sub').hide();
    });
    $('.sub').hover(function() {
       $(this).show();
    }, function() {
       $(this).hide();
    });

    $('.dinamic_menu a').click(function(){
        if(navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/iPhone|iPad|iPod/i) || navigator.userAgent.match(/IEMobile/i))
            if($(this).next('.sub').length!=0){
                if($(this).data('click')==undefined){
                    $(this).data('click','1');
                    $('.sub').show();
                    return false;
                }
            }
    });
}
