/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(window).resize(function(){





    $('.hiden-menu-list').html(' ');

        if(jQuery('.line-menu li').length){
            var menuWidth = $('.line-menu').width();
            var hideWidth=$('.hiden-menu').width();
            console.log('menu full width -'+menuWidth);
            //костыль для 1000 по шириен
            if(menuWidth==960)menuWidth=960;
            if(menuWidth<=640 && menuWidth>390 )menuWidth=menuWidth-hideWidth+20;
            //menuWidth=menuWidth0;

            var menuShow = false;
            var elWidth = 0;

            console.log('menu width -'+menuWidth);
            console.log('menu hidden -'+hideWidth);

            if(menuWidth<=960)
                $('.line-menu li.active').insertBefore($('.line-menu').find('li:eq(1)'));

            jQuery('.line-menu li').each(function(){

                var nextWidth= $(this).next('li').width()*1;
                $(this).show();
                elWidth += $(this).width();

                console.log(menuWidth+' ' + elWidth + ' nextw '+ (elWidth+nextWidth)+' '+ $(this).html() );

                if(/*elWidth > menuWidth && */ (elWidth+nextWidth)> menuWidth ){
                    $(this).hide();
                    $('.hiden-menu-list').append('<div>');
                    $('a',this).clone().appendTo($('.hiden-menu-list'));
                    $('.hiden-menu-list').append('</div>');
                    $('.hiden-menu-button').show();
                    menuShow = true;
                }else{
                    $('.hiden-menu-button').hide();
                    menuShow = false;
                }
            });
        } else {



        }

    if(menuShow){

        elWidth = 0;
        $('.line-menu li:visible').each(function(){
            elWidth += $(this).width();
        });
        menuWidth = menuWidth- 60;
        var repeatCut = false;
        
        if($('.line-menu li:visible:last').width() < 60){
            repeatCut = true;
        }else{
            repeatCut = false;
        }
        if(menuWidth < elWidth ){
            $('.line-menu li:visible:last').hide();
            $('.hiden-menu-list').append('<div>');
            $('a',$('.line-menu li:visible:last')).clone().appendTo($('.hiden-menu-list'));
            $('.hiden-menu-list').append('</div>');
        }
        if(repeatCut){
            $('.line-menu li:visible:last').hide();
            $('.hiden-menu-list').append('<div>');
            $('a',$('.line-menu li:visible:last')).clone().appendTo($('.hiden-menu-list'));
            $('.hiden-menu-list').append('</div>');
        }
        
    }
    var offsetTop = 0;
    $('.catalog-list-menu li').each(function(){
        offsetTop += $(this).width();
    });
    $('.catalog-list-menu').css({
        'margin-top' : offsetTop
    });
    
});
$(document).ready(function(){
    $(window).resize();
    $('.faq-list-title').click(function(){
        $(this).parents('li').toggleClass('opened');
        return false;
    });
     $('.panel_heading').on("click",function(){
        $(this).parents().children('.panel_body').fadeToggle('fast');
        $(this).parent().toggleClass('opened');
    });
    $('.checkbox-label input').change(function(){
       if($(this).prop('checked')){
           $(this).parent().addClass('checked');
       }else{
           $(this).parent().removeClass('checked');
       } 
    });
    $('.pass-holder-button').click(function(){
        $(this).parent().toggleClass('opened');
    });
    $('.pass-holder input').change(function(){
        var parent = $(this).parent();
        $('input',parent).val($(this).val());
    });

   
//    $('.filter-selected').click(function(){
//            $(this).parent().toggleClass('opened');
//    });
});


