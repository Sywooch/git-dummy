/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(window).resize(function(){
    $('.hiden-menu-list').html(' ');
    var menuWidth = $('.line-menu').width();
    var menuShow = false;
    var elWidth = 0;
    $('.line-menu li').each(function(){
        $(this).show();
        elWidth += $(this).width()+5;
        if(elWidth > menuWidth){
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
    if(menuShow){
        elWidth = 0;
        $('.line-menu li:visible').each(function(){
            elWidth += $(this).width()+5;
        });
        menuWidth = menuWidth - 60;
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


