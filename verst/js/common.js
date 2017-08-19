$(document).ready(function() {


	

	$('input, textarea').placeholder();
	/* PIE */
	if (window.PIE) {
		$('nav').each(function() {
			PIE.attach(this);
		});
	}
	var ff;
	$('input[type=text]').focus(function() {
		if($(this).attr('data-place')==$(this).val()) {
			$(this).val('');
		}
		$(this).addClass('active');
	});
	$('input[type=text]').blur(function() {
		if($(this).val()=='') {
			$(this).val($(this).attr('data-place'));
		}
		$(this).removeClass('active');
	});
	$('.ov-search1 input[type=text]').focus(function() {
		$('.search1').addClass('active');
	});
	$('.ov-search1 input[type=text]').blur(function() {
		$('.search1').removeClass('active');
	});
	$('textarea').focus(function() {
		if($(this).attr('data-place')==$(this).val()) {
			$(this).val('');
		}
	});
	$('textarea').blur(function() {
		ff=$(this).attr('data-place');
		if($(this).val().length==0) {
			$(this).val(ff);
		}
	});
	function ress() {
		$('.post1').each(function() {
			$(this).find('.ov-t2 div').attr('style','').height($(this).height());
		});
		$('.sz1 .rr1').attr('style','').css({'min-height':$('.sz1').height()-25});
		$('.modal-tb').width($(window).width()-20).height($(window).height()-20);
		if(flag1==1) {
			$('.bt-mob1').prev().width(($('.lang1').offset().left-$('.search1').offset().left)-20);
		}
		if($(window).width()>987) {
			$('.bt-mob1').prev().attr('style','');
		}
		$('.content1').attr('style','').height(284-$('.sz1 .ll1 .tit1').innerHeight()-20);
		if($(window).width()<637) {
			$('.modal-ff1').css({'left':$('.search1').position().left,'width':$('.search1').width()});
		}
		else if($(window).width()>986) {
			$('.modal-ff1').css({'left':$('.search1').position().left,'width':$('.search1').width()});
		}
		else {
			$('.modal-ff1').css({'left':$('.search1').position().left,'width':$('.lang1').position().left-$('.search1').position().left-10});
		}
	}
	$(window).load(function() {
		$('input[type=text]').each(function() {
			$(this).attr('data-place',$(this).val());
		});
		$('textarea').each(function() {
			$(this).attr('data-place',$(this).val());
		});
		$('.fl-nav').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 107,
			asNavFor: '.fl-slider'
		});
		$('.fl-slider').flexslider({
			animation: "slide",
			controlNav: false,
			slideshowSpeed: 450000,
			animationLoop: false,
			sync: ".fl-nav"
		});
		setTimeout(function() {
			$('.fl-slider').addClass('active');
			$('.fl-nav').addClass('active');
			
		},100);
		ress();
		if($(".content1").length>0) {
		    $(".content1").mCustomScrollbar({
		        scrollInertia:550,
		        horizontalScroll:false,
		        scrollButtons:{ enable: true }
		    });
		}
		var owl = $(".owl1");
		owl.owlCarousel({
			items : 4,
			itemsDesktop : [1186,3],
			itemsDesktopSmall : [986,2],
			itemsTablet: [600,1],
			itemsMobile : false
		});
		$(".nv1").click(function(){
			owl.trigger('owl.next');
		});
		$(".pv1").click(function(){
			owl.trigger('owl.prev');
		});
		$('.ov-rd1 input').styler();
	});
	function forModalPopup(){
		if ($(window).height() < 500) {
			$('.for_solutia').css({
				'width': '109%',
				'top':' -20px',
				'left':'33px',
				'height': '200px'
			});
			$('.name_prize').css({
				'margin-bottom':'15px'
			})
			$('.prize_popup .for_img').css('display','none');
		};
		if ($(window).height() < 600 && $(window).width() < 800) {
			$('.modal-circles .modal-tb .modal-con').css('height', $(window).height() - 40);
			$('.modal-circles .modal-con').css({
				'display':'block'
			});
		};
	}
	forModalPopup();
	$(window).on('resize', function() {
		ress();
		forModalPopup();
	});
	$('.fr1').click(function() {
		$('.fl1 .flex-prev').trigger('click');
	});
	$('.fr2').click(function() {
		$('.fl1 .flex-next').trigger('click');
	});
	$('.bt-mob1').click(function() {
		$(this).hide().prev().width($('.lang1').offset().left-$('.search1').offset().left-20).parent().addClass('active2');
		$('.ov-search1 input[type=text]').focus();
		flag1=1;
	});
	var flag1=0;
	$(document).click(function(e){
		if ($(e.target).closest(".search1").length) return;
		if($(window).width()<987) {
			$('.bt-mob1').show().prev().width(32).parent().removeClass('active2');
		}
		e.stopPropagation();
		flag1=0;
	});
	$('.ov-rd1').change(function() {
		$('.jq-radio.checked').parent().addClass('active').siblings().removeClass('active');
		if($('.jq-radio.checked').parent().index()==0) {
			$('.bt-rr1 span').text('Ваша ставка:');
			$(this).siblings('.bt-rr1').children('.add_list_btn').addClass('active');
			$(this).siblings('.bt-rr1').children('.add_cart_btn').removeClass('active');
		}
		if($('.jq-radio.checked').parent().index()==1) {
			$('.bt-rr1 span').text('Сумма:');
			$(this).siblings('.bt-rr1').children('.add_cart_btn').addClass('active');
			$(this).siblings('.bt-rr1').children('.add_list_btn').removeClass('active');
		}
	})
	$('.close,.bg-modal').add('.dm-bg-close').click(function() {
		$('.modal').add('.dm-overlay').fadeOut();
		setTimeout(function(){
			$('body').removeClass('body-active');
		},400);
		
	});
	/*$('.rt1 a').click(function(e) {
		e.preventDefault();
		$('.m1').fadeIn();
		$('body').css({
			overflow:'hidden',
			position:"fixed"
		});
	});*/
	$('.rt1 a').click(function(e) {
		e.preventDefault();
		$('body').addClass('body-active');
		$('#for_circles_modal').delay(200).fadeIn().addClass('active');
		
	});
	$('.forgotten_password').click(function(e) {
		$('.modal.m2').fadeIn();
		$('body').addClass('body-active');
		if($(window).width()<772) {
			$('body').addClass('active');
		}
		e.preventDefault();
	});
	$('.main-menu .curr1').click(function() {
		if($(this).attr('dt')==0) {
			$(this).parent().addClass('active');
			$(this).attr('dt','1');
		}
		else {
			$(this).parent().removeClass('active');
			$(this).attr('dt','0');
		}
	});
	$(document).click(function(e){
		if ($(e.target).closest(".main-menu").length) return;
		$('.main-menu').removeClass('active');
		$('.main-menu .curr1').attr('dt','0');
		e.stopPropagation();
	});
	$('.ac1 .curr1').click(function() {
		if($(this).attr('dt')==0) {
			$(this).parent().addClass('active');
			$(this).attr('dt','1');
		}
		else {
			$(this).parent().removeClass('active');
			$(this).attr('dt','0');
		}
	});
	$(document).click(function(e){
		if ($(e.target).closest(".ac1").length) return;
		$('.ac1').removeClass('active');
		$('.ac1 .curr1').attr('dt','0');
		e.stopPropagation();
	});
	$('.lang1 .curr1').click(function() {
		if($(this).attr('dt')==0) {
			$(this).parent().addClass('active');
			$(this).attr('dt','1');
		}
		else {
			$(this).parent().removeClass('active');
			$(this).attr('dt','0');
		}
	});
	$(document).click(function(e){
		if ($(e.target).closest(".lang1").length) return;
		$('.lang1').removeClass('active');
		$('.lang1 .curr1').attr('dt','0');
		e.stopPropagation();
	});
	$('.hd-bl-sp1').toggle(function() {
		$(this).find('a').text('Свернуть').parent().parent().find('.hide1').addClass('hide2');
	},function() {
		$(this).find('a').text('Все категории').parent().parent().find('.hide1').removeClass('hide2');
	});
	$('.ps1').toggle(function() {
		$(this).nextAll().addClass('nt1');
	},function() {
		$(this).nextAll().removeClass('nt1');
	});
	$('.et-srh1').keyup(function() {
		$('.modal-ff1').fadeIn(300);
		if($(this).val()=='') {
			$('.modal-ff1').fadeOut(300);
		}
	});
	$('.et-srh1').blur(function() {
		$('.modal-ff1').fadeOut(300);
	});
	$('.et-srh1').focus(function() {
		$('.modal-ff1').fadeOut(300);
		if($(this).val().length>0) {
			$('.modal-ff1').fadeIn(300);
		}
	});

	$('.date-time-list .data').add('.date-time-list .order-status').on('click', function(){
		$(this).toggleClass('active');
	});
	setInterval (function(){
		var blickArray = $('#header .ac1 .curr1').add('.profile-menu li a').add('#header .ac1 ul li a').toggleClass('blink').delay(1500)
		if (blickArray.is('blick')) {
			$(this).removeClass('blink');
		};
	}, 1000);

	$('input,textarea').focus(function(){
	   $(this).data('placeholder',$(this).attr('placeholder'))
	   $(this).attr('placeholder','');
	 });
	 $('input,textarea').blur(function(){
	   $(this).attr('placeholder',$(this).data('placeholder'));
	 });

	  $('.hiden-menu-button').on('click',function(){
        $(this).parent().toggleClass('active');
    });

	  $(function () {
            var tabContainers = $('.tab-content>div'); // получаем массив контейнеров
            tabContainers.hide().filter(':first').show(); // прячем все, кроме первого
            // далее обрабатывается клик по вкладке
            $('#tabpanel ul.nav-tabs a').click(function () {
                tabContainers.hide(); // прячем все табы
                tabContainers.filter(this.hash).show(); // показываем содержимое текущего
                $('#tabpanel ul.nav-tabs a').parent().removeClass('active'); // у всех убираем класс 'selected'
                $(this).parent().addClass('active'); // текушей вкладке добавляем класс 'selected'
                return false;
            }).filter(':first').click();
        });

	(function(){
		var a = document.querySelector('.cart_and_draw'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
		window.addEventListener('scroll', Ascroll, false);
		document.body.addEventListener('scroll', Ascroll, false);
		function Ascroll() {
		  if (b == null) {
		    var Sa = getComputedStyle(a, ''), s = '';
		    for (var i = 0; i < Sa.length; i++) {
		      if (Sa[i].indexOf('box-sizing') == 0 || Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('width') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0) {
		        s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
		      }
		    }
		    a.innerHTML = '<div style="'+s+'">'+a.innerHTML+'</div>';
		    b = a.children[0];
		    a.style.height = b.getBoundingClientRect().height + 'px';
		    a.style.padding = '0';
		    a.style.border = '0';
		  }
		  var Ra = a.getBoundingClientRect(),
		      R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('.prefooter').getBoundingClientRect().top);  // селектор блока, при достижении верхнего края которого нужно открепить прилипающий элемент;  Math.round() только для IE; если ноль заменить на число, то блок будет прилипать до того, как нижний край элемента дойдёт до футера
		  if ((Ra.top - P) <= 0) {
		    if ((Ra.top - P) <= R) {
		      b.className = 'stop';
		      b.style.top = - R +'px';
		    } else {
		      b.className = 'sticky';
		      b.style.top = P + 'px';
		    }
		  } else {
		    b.className = '';
		    b.style.top = '';
		  }
		}
	})()
	
});