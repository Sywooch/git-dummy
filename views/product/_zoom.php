
<?php
    use yii\helpers\Html;
?>

<link rel="stylesheet" type="text/css" href="/js/countdown/css/jquery.countdown.css">
<script type="text/javascript" src="/js/countdown/jquery.plugin.js"></script>
<script type="text/javascript" src="/js/countdown/jquery.countdown.js"></script>

<?php
    $images = app\modules\system\models\Pictures::getImages('catalog',$data->catalog_id); ?>






<?php for($i=0;$i<7;$i++):
    if(isset($images[$i])  ){
        //$file = (new app\components\ImageComponent)->crop($images[$i],90,55,false,0,'-preview-w1920-h667.png');
        $f1[]= $file = (new app\components\ImageComponent)->crop($images[$i],'470',450);

       // $f2[]= $file2 = (new app\components\ImageComponent)->adaptive($images[$i],1000,1000);

        $f2[$i] = (new app\components\ImageComponent)->adaptive($images[$i]/*,1920,667*/);

        /*echo $file2=str_replace('http://bountymart.com','',str_replace('.png','.jpg',$file));
        echo '<br>';
        if(is_file($_SERVER['DOCUMENT_ROOT'].$file2)) {
             $f2[$i] = $file2;
        }else{*/
            $f2[$i] = (new app\components\ImageComponent)->adaptive($images[$i],1000,1000);
        /*}
        echo  $f2[$i].'<br>';*/

        $f3[]= (new app\components\ImageComponent)->crop($images[$i],90,90);

        $f1[$i]= (new app\components\ImageComponent)->convertJpg($f1[$i]);
        $f2[$i]= (new app\components\ImageComponent)->convertJpg($f2[$i]);
        $f3[$i]= (new app\components\ImageComponent)->convertJpg($f3[$i]);

    }
    endfor;
?>




<div class="sld1">
    <div class="fl1 fl-slider fl-slider-detail">
        <ul class="slides">

            <?php for($i=0;$i<7;$i++):
                if(isset($f2[$i])  ){
                    $file = $f2[$i];
                }
                else
                    $file='http://iphone6.96.lt/img/sld1.jpg';
            ?>
             <li><div><img src="<?=$file;  ?>" alt=""></div></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<div class="sld-nav-sld1">
    <div class="fl2 fl-nav fl-nav-detail">
        <div class="fr1"></div>
        <div class="fr2"></div>
        <ul class="slides">

            <?php for($i=0;$i<7;$i++):
                if(isset($f3[$i])  ){

                    $file = $f3[$i];
                }
                else
                    $file='http://iphone6.96.lt/img/sld1.jpg';
            ?>

                <li><div><img src="<?=$file;  ?>" alt=""></div></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>





<div class="sz1 page_detail_product_see">
    <div class="for_see_img_detail_product">



        <ul id="etalage" class="photo_big_preview_detail_info">

            <?php for($i=0;$i<7;$i++):
                if(isset($f1[$i])  ){

                    $file = $f1[$i];
                    $file2 = $f2[$i];
                }
                else
                    $file='http://iphone6.96.lt/img/sld1.jpg';
                ?>


                <li>
                    <!-- This is the large (zoomed) image source: -->
                    <img class="etalage_source_image" src="<?=$file2?>" />
                    <!-- This is the thumb image source (if not provided, it will use the large image source and resize it): -->
                    <img class="etalage_thumb_image" src="<?=$file?>" />
                </li>


            <?php endfor; ?>

        </ul>


        <ul id="etalage-min" class="photo_big_preview_detail_info">

            <?php for($i=0;$i<7;$i++):
                if(isset($f1[$i])  ){

                    $file = $f1[$i];
                    $file2 = $f2[$i];
                }
                else
                    $file='http://iphone6.96.lt/img/sld1.jpg';
                ?>


                <li>
                    <!-- This is the large (zoomed) image source: -->
                    <img class="etalage_source_image" src="<?=$file2?>" />
                    <!-- This is the thumb image source (if not provided, it will use the large image source and resize it): -->
                    <img class="etalage_thumb_image" src="<?=$file?>" />
                </li>


            <?php endfor; ?>

        </ul>
        <ul id="etalage-min-min" class="photo_big_preview_detail_info">

            <?php for($i=0;$i<7;$i++):
                if(isset($f1[$i])  ){

                    $file = $f1[$i];
                    $file2 = $f2[$i];
                }/*if(isset($images[$i])  ){
                    //$file = (new app\components\ImageComponent)->crop($images[$i],90,55,false,0,'-preview-w1920-h667.png');
                    $file = (new app\components\ImageComponent)->crop($images[$i],'350',350);
                    $file2 = (new app\components\ImageComponent)->adaptive($images[$i]);
                }*/
                else
                    $file='http://iphone6.96.lt/img/sld1.jpg';
                ?>


                <li>
                    <!-- This is the large (zoomed) image source: -->
                    <img class="etalage_source_image" src="<?=$file2?>" />
                    <!-- This is the thumb image source (if not provided, it will use the large image source and resize it): -->
                    <img class="etalage_thumb_image" src="<?=$file?>" />
                </li>


            <?php endfor; ?>

        </ul>
        <span class="img-zoom-in"><span><?=yii::t('app','Наведите курсор, чтобы увеличить')?></span></span>



    </div>


    <div class="detail_info_text_product">
        <div class="ll1">
            <div class="tit1 <?=($data->hot>50)?'j1':''?>"><?=$data->catalog_name?>
                <?php if($data->catalog_bonus):?>
                    <?php  if($data->catalog_bonus): ?>
                        <span class="j<?php switch($data->catalog_bonus){
                            case '10': echo "3";break;
                            case '20': echo "1";break;
                            case '30': echo "2";break;
                        }?>"></span>
                    <?php endif;?>
                <?php endif;?>
            </div>
            <div class="content1-zoomer">
                <div class="sz2">
                    <?php
                        $char = count($data->character);
                    ?>
                    <ul>
                        <li>
                            <ul>
                                <?php for($i=0;$i<$char;$i++){

                                    echo ($data->character[$i]['orders']%2==1)?('<li><b>'.$data->character[$i]['name'].':</b> '.$data->character[$i]['attribute'].'</li>'):'';
                                }?>
                            </ul>
                        </li>
                        <li>
                            <ul>
                                <?php for($i=0;$i<$char;$i++)
                                    echo ($data->character[$i]['orders']%2==0)?('<li><b>'.$data->character[$i]['name'].':</b> '.$data->character[$i]['attribute'].'</li>'):''; ?>
                            </ul>
                        </li>
                    </ul>

                </div>
                <p><b><?=yii::t('app','Описание')?>:</b> <?=$data->catalog_shortpreview?></p>
            </div>
        </div>
        <div class="rr1">
            <div class="tit1 <?=($data->hot>50)?'j1':''?>"><?=$data->catalog_name?>
                <?php  if($data->catalog_bonus): ?>
                    <span class="j<?php switch($data->catalog_bonus){
                        case '10': echo "3";break;
                        case '20': echo "1";break;
                        case '30': echo "2";break;
                    }?>"></span>
                <?php endif;?>
            </div>
            <?php  $countBits= (yii::$app->user->getId())?\app\models\Bits::countBits($data->catalog_id,yii::$app->user->getId()):0;
            ?>

            <div class="ov-t1">
                <div class="for_item">
                    <div class="item1"><span id="persent"><?=$data->persentToEnd()?>%</span><p><?=yii::t('app','прогресс')?></p></div>
                    <div class="item1 choise_money">
                        <div class="curr1" dt="0">
                            <span id="price" >
                                <?=\app\modules\system\models\Course::getPrice($data->catalog_price); ?>
                            </span>
                            <span class="for_arrow_price"></span><p><?=yii::t('app','цена')?></p></div>
                        <ul>
                            <?php if(\yii::$app->request->get('currency')!='USD'):?>
                            <li><a class="" href="?currency=USD"><?=\app\modules\system\models\Course::getPriceCourse($data->catalog_price,'USD')?></a></li>
                            <?php endif; ?>
                            <?php if(\yii::$app->request->get('currency')!='Euro'):?>
                            <li><a class="" href="?currency=Euro"><?=\app\modules\system\models\Course::getPriceCourse($data->catalog_price,'Euro')?></a></li>
                            <?php endif; ?>
                            <?php if(\yii::$app->request->get('currency')!='RUB'):?>
                            <li><a class="" href="?currency=RUB"><?=\app\modules\system\models\Course::getPriceCourse($data->catalog_price,'RUB')?></a></li>
                            <?php endif; ?>
                         </ul>
                    </div>
                    <div class="item1"><span id="step"><?=\app\modules\system\models\Course::getPrice($data->getPriceOne()); ?></span><p><?=yii::t('app','купить за')?></p></div>
                    <span class="clear"></span>
                </div>
                <div class="rt1">
                    <a <?=(yii::$app->user->getId())?'href="#" class="make_bit"':'href="/user/registration" class="make_bit"'?>    data-step="1" ><?=yii::t('app','Участвовать')?></a>
                </div>
                <div class="clearfix"></div>
                <div class="div_auction">
                    <a  <?=(yii::$app->user->getId())?'href="#" class="icon_for_popup"':'href="/user/registration"'?> ></a>
                    <div class="inner_text_auction">
                        <div class="t1"> <?=yii::t('app','Внимание!')?></div>

                        <p> <?/*=\app\modules\system\models\TextWidget::getTpl('view_mess',['date'=>date("d-m-Y H:i:s",strtotime($data->catalog_dateend)) ]);*/?>
                            <?=\yii::t('app','До завершения аукциона осталось')?>
                             <div id="padZeroes" <?=($data->persentToEnd()>=80)?'style="color:red"':''?>><?=$date?></div></p>
                        <script>$('#padZeroes').countdown({
                                until: +<?=strtotime($data->catalog_dateend)-mktime()?>,
//                                      {until: liftoffTime,
                                layout: '{dn}  <?=\yii::t('app','дня(ей)')?> {hn}:{mn}:{sn}',
                                padZeroes: true,
                                expiryUrl: 'http://bountymart.com/<?=$data->catalog_url?>',
                            });
                        </script>
                      <!--  <p> <?php /*if($date=\app\models\Auct::lastTiraj($data->catalog_id)):*/?>
                            <?php /*endif; */?>
                        </p>
-->
                        <p>
                            <?php

                                if($countBits):?>
                                    <?=\app\modules\system\models\TextWidget::getTpl('make_bits',['bits'=>$countBits]);?>
                                <?php endif; ?>
                        </p>

                        <!-- <p>This project will only be funded if at least €30,000 funded if at least This project will only</p>
                         <p><a href="">Подробнее</a></p>-->
                    </div>
                </div>
                <div class="div_security">
                    <span class="icon_for_popup icon_for_popup_security"></span>
                    <div class="inner_text_auction">
                        <div class="t1"> <?=yii::t('app','ВЫ ЗАЩИЩЕНЫ!')?></div>

                        <p><?=\yii::t('app','Возврат, если не получили товар.')?></p>
                        <p><?=\yii::t('app','Возврат, если товар не соответстует описанию.')?></p>

                        <!-- <p>This project will only be funded if at least €30,000 funded if at least This project will only</p>
                         <p><a href="">Подробнее</a></p>-->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="clear"> </div>
</div>
<div class="modal-table dm-overlay" id="for_modal_table">
    <div class="dm-table">
        <div class="dm-cell">

        </div>
    </div>
</div>



<script>

    $(document).on("click", ".item1", function() {
        $('.item1').removeClass('active');
        $('.item1').find('.jq-radio').removeClass('checked');
        $(this).addClass('active');
        console.log($(this).find('input.round').data('price') + ' ' + $('#price').val());


        $('#price-info').val($(this).find('input.round').data('price'));
        $(this).find('.jq-radio').addClass('checked');

        $('.span-comment').html( $(this).find('input').data('comment') );
        $('.agree-button').val( $(this).find('input').data('button') );

        if($(this).find('input').data('id') == 'auction' )
            $(this).find('input').css('border','2px solid #2dc16b');
        else
            $(this).find('input').css('border','2px solid red');
    });

   $(document).on("click", ".agree", function() {


        var el = $(this);
        var action=$('.item1.active').find('input').data('id');
        var type='common';
       form_field='#price-info';
       if($(this).data('action')){
           action=$(this).data('action');
           type='list';
           form_field='#price-info-list-members';
       }

      /// el.attr('disabled', 'disabled');
        $(this).html('<?=yii::t('app','Ожидайте ответа')?>, <img src="/img/bx_loader.gif" style="margin-top:7px;" />');
        if ( action == 'auction') {
            $.ajax({
                url: '/add-bit?product=<?=$data->catalog_id?>&price=' + $(form_field).val(),
                headers: {"X-CSRF-Token": $('meta[name=csrf-token]').attr("content")},
                type: 'PUT',

                success: function (data) {



                    //el.removeAttr('disabled');
                    if(type=='common'){

                       /* $('.st-text1').children('span').html(data.title);
                        $('.st-text1').children('p').html(data.message);*/

                        $('.notice').fadeIn();
                        $('.notice').html(data.message);

                       // $('.ov-rd1 .item1').hide();
                       // $('.ov-rd1 .item1').removeClass('active');
                        //$('.item_for_circles').addClass('active').fadeIn();
                        setTimeout(function () {
                            $('.notice').fadeOut();
                        }, 2000);


                        /*$('.ov-rd1 .item1').hide();
                        $('.ov-rd1 .item1').removeClass('active');
                        $('.item_for_circles').addClass('active').fadeIn();*/
                        //$('.bt-rr1').hide();
                        if (data.status == 'ok') {
                            setTimeout(function () {
                                $('.modal').add('.dm-overlay').fadeOut();
                                setTimeout(function () {
                                    $('body').removeClass('body-active');
                                }, 400);
                            }, 2000);
                        } else {
                            if (data.move) {
                                window.location = data.move;
                            }
                        }
                       // el.remove();
                    } else{
                        $('.notice').fadeIn();
                        $('.notice').html(data.message);

                        $('.ov-rd1 .item1').hide();
                        $('.ov-rd1 .item1').removeClass('active');
                        $('.item_for_circles').addClass('active').fadeIn();
                        setTimeout(function () {
                            $('.notice').fadeOut();
                        }, 2000);
                    }


                }
            });

        } else {


            $.ajax({
                url: '/add-to-basket',
                type: 'post',
                data: {'id': <?=$data->catalog_id?>},
                headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
                success: function (data) {
                    $('.basket-preview').html(data);
                    window.location='/checkout';
                }
            });

        }
        return false;
    });


    $('.close-button').click(function () {
        $('.modal').add('.dm-overlay').fadeOut();
        setTimeout(function () {
            $('body').removeClass('body-active');
        }, 400);
    });
    $('.close').click(function () {
        $('.modal').add('.dm-overlay').fadeOut();
        setTimeout(function () {
            $('body').removeClass('body-active');
        }, 400);
    });





    $('#etalage').etalage({
        zoom_area_width: 530, /*//указывает ширину блока справа*/
        zoom_area_height: 530,
        thumb_image_width: 470,
        thumb_image_height: 451,
        source_image_width: 712,
        source_image_height: 712,
        small_thumbs: 7,
        smallthumb_inactive_opacity: 1,
        smallthumbs_position: 'left',
        smallthumb_select_on_hover: true,/*//при навидение на первьюху меняется большо отображение*/
        show_icon: false,
        autoplay: false,
        keyboard: false,
        zoom_easing: false,
        show_hint: true
    });

    $('#etalage-min').etalage({
        zoom_area_width:430, /*//указывает ширину блока справа*/
        zoom_area_height:422,
        thumb_image_width: 465,
        thumb_image_height: 450,
        source_image_width: 712,
        source_image_height: 712,
        smallthumb_select_on_hover:true,/*//при навидение на первьюху меняется большо отображение*/
        small_thumbs:7,
        smallthumb_inactive_opacity: 1,
        smallthumbs_position: 'left',
        show_icon: false,
        autoplay: false,
        keyboard: false,
        zoom_easing: false,
        show_hint: true,
        click_to_zoom: false
    });
    $('#etalage-min-min').etalage({
        zoom_area_width:0, /*//указывает ширину блока справа*/
        zoom_area_height:0,
        thumb_image_width: 450,
        thumb_image_height: 450,
        source_image_width: 1012,
        source_image_height: 1012,
        smallthumb_select_on_hover:true,/*//при навидение на первьюху меняется большо отображение*/
        small_thumbs:7,
        smallthumb_inactive_opacity: 1,
        smallthumbs_position: 'left',
        show_icon: false,
        autoplay: false,
        keyboard: false,
        zoom_easing: false,
        show_hint: false,
        click_to_zoom: false,
        magnifier_opacity:1,

    });


    function windowSizeZoom(){

        if ($(window).width() <= '1186' && $(window).width() >= '970'){
            $('#etalage').css('display','none');
            $('#etalage-min').css('display','block');
            $('#etalage-min-min').css('display','none');

        }else if($(window).width() >= '1186'){
            $('#etalage').css('display','block');
            $('#etalage-min').css('display','none');
            $('#etalage-min-min').css('display','none');

        }else{
            $('#etalage').css('display','none');
            $('#etalage-min').css('display','none');
            $('#etalage-min-min').css('display','block');
        }
    }
    windowSizeZoom();





    $('.make_bit').click(function(){
        var name ='<?=$name?>';
        var el = $(this);
        //$(".agree").remove();

        $(this).html('<?=yii::t('app','Загрузка...')?>');
        $.ajax({
            url:  '/auct/info?product=<?=$data->catalog_id?>' ,
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            type:'PUT',
            success: function(data)
            {
                $('#item_for_circles').addClass('active').fadeIn();
                $('#for_circles_modal').addClass('active').fadeIn();
                $('#ajax-result-popup').html(data.message);
                el.html('<?=yii::t('app','Участвовать')?>');
            }
        });

    });

    $('.icon_for_popup').click(function(){
        var el = $(this);
        //$(".agree").remove();
        $.ajax({
            url:  '/auct/members?product=<?=$data->catalog_id?>' ,
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            type:'PUT',
            success: function(data)
            {
                $('#for_modal_table').addClass('active').fadeIn();
                $('#for_modal_table').find('.dm-cell').html(data.message);
            }
        });

    });



        var tit1 = parseInt($('.tit1').css('height'));
        console.log('height '+tit1);


    if( tit1 <= 60)
        $('.content1-zoomer').addClass('content1-zoomer-30');
    else{
        if(tit1 > 60 && tit1 <= 80)
            $('.content1-zoomer').addClass('content1-zoomer-81');
        else{
            if(tit1 > 80 &&  tit1 <= 108)
                $('.content1-zoomer').addClass('content1-zoomer-85');
            else{
                if(tit1 > 108 &&  tit1 <= 130)
                    $('.content1-zoomer').addClass('content1-zoomer-60');
                else
                    $('.content1-zoomer').addClass('content1-zoomer-20');
            }

        }
    }


    $(window).resize(function(){
        windowSizeZoom();
        $('.content1-zoomer').removeClass('content1-zoomer-30')
            .removeClass('content1-zoomer-81')
            .removeClass('content1-zoomer-85')
            .removeClass('content1-zoomer-60')
            .removeClass('content1-zoomer-20');
        var tit1 = parseInt($('.tit1').css('height'));
        console.log('height resize '+tit1);
        if( tit1 <= 60)
            $('.content1-zoomer').addClass('content1-zoomer-30');
        else{
            if(tit1 > 60 && tit1 <= 80)
                $('.content1-zoomer').addClass('content1-zoomer-81');
            else{
                if(tit1 > 80 &&  tit1 <= 108)
                    $('.content1-zoomer').addClass('content1-zoomer-85');
                else{
                    if(tit1 > 108 &&  tit1 <= 130)
                        $('.content1-zoomer').addClass('content1-zoomer-60');
                    else
                        $('.content1-zoomer').addClass('content1-zoomer-20');
                }

            }
        }

    });


        if ($(".content1-zoomer").length > 0) {
            $(".content1-zoomer").off().mCustomScrollbar({
                scrollInertia: 550,
                horizontalScroll: false,
                scrollButtons: {enable: true}
            });
        }







    if($('.fl-nav-big').length)
        $('.fl-nav-big').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 107,
            asNavFor: '.fl-slider-big'
        });

    if($('.fl-slider-big').length)
        $('.fl-slider-big').flexslider({
            animation: "slide",
            controlNav: false,
            slideshowSpeed: 450000,
            animationLoop: false,
            sync: ".fl-nav-big"
        });
    if($('.fl-nav-detail').length)
        $('.fl-nav-detail').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 80,
            asNavFor: '.fl-slider-detail'
        });

    if($('.fl-slider-detail').length)
        $('.fl-slider-detail').flexslider({
            animation: "slide",
            controlNav: false,
            smoothHeight: true,
            slideshowSpeed: 450000,
            animationLoop: false,
            sync: ".fl-nav-detail"
        });
    setTimeout(function() {
        $('.fl-slider-big').addClass('active');
        $('.fl-nav-big').addClass('active');
        $('.fl-nav-detail').addClass('active');
        $('.fl-slider-detail').addClass('active');
    },100);


    $('.fr1').click(function() {
        $('.fl1 .flex-prev').trigger('click');
    });
    $('.fr2').click(function() {
        $('.fl1 .flex-next').trigger('click');
    });


    $(document).ready(function(){
        $('.icon_for_popup').on('click',function(e){
            $('#for_modal_table').fadeIn();
            e.preventDefault();
        })
    })

</script>