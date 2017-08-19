<?php
use yii\helpers\Html;
?>
 <?php
     $images = app\modules\system\models\Pictures::getImagesSlider('catalog',$data->catalog_id); ?>




<div class="navigation nav_page_item">
    <div class="bt-ct1">
        <div>
            <ul>
              <!--  <li><a href="/">Главная</a></li>-->
                <li><a href="/product"><?=yii::t('app','Каталог')?></a></li>

                <?php if(isset($breadcrumbs[0]['url'])):?>
                <li><a href="/product/<?=$breadcrumbs[0]['url']?>"><?=$breadcrumbs[0]['label']?></a></li>
                <?php endif; ?>

                <?php if(isset($breadcrumbs[1]['url'])):?>
                    <li><a href="/product/<?=$breadcrumbs[1]['url']?>"><?=$breadcrumbs[1]['label']?></a></li>
                    <li><span><?=$breadcrumbs[2]['label']?></span></li>
                <?php else: ?>
                    <li><span><?=$breadcrumbs[1]['label']?></span></li>
                <?php endif; ?>


            </ul>
        </div>
    </div>
</div>



<?//    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $breadcrumbs]);?>






    <div class="sld1">
    <div class="fl1 fl-slider fl-slider-big">
        <ul class="slides">
            <?php for($i=0;$i<10;$i++):
                if(isset($images[$i])){
                    $file = (new app\components\ImageComponent)->adaptive($images[$i]/*,1920,667*/);
                    if(is_file($_SERVER['DOCUMENT_ROOT'].str_replace('.png','.jpg',$file))) {
                        $file = str_replace('.png', '.jpg', $file);
                    }else{
                         $file = (new app\components\ImageComponent)->adaptive($images[$i],1920,667);
                    }
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
    <div class="fl2 fl-nav-big">
        <div class="fr1"></div>
        <div class="fr2"></div>
        <ul class="slides">
            <?php for($i=0;$i<10;$i++):
                if(isset($images[$i])  )
                    $file = (new app\components\ImageComponent)->crop($images[$i],90,55,false,0,'-preview-w1920-h667.png');
                else
                    $file='http://iphone6.96.lt/img/sld1.jpg';
                ?>



            <li><div><img src="<?=$file;  ?>" alt=""></div></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<div class="sz1">
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
        <?php $countBits= (yii::$app->user->getId())?\app\models\Bits::countBits($data->catalog_id,yii::$app->user->getId()):0; ?>
        <div class="rt1">


            <?php if($countBits): ?>
                <a href="<?=(yii::$app->user->getId())?'#':'/user/registration'?>"   class="make_bit_off red" data-step="1" ><?=yii::t('app','Не участвовать')?></a>
            <?php else: ?>
                <a href="<?=(yii::$app->user->getId())?'#':'/user/registration'?>"   class="make_bit" data-step="1" ><?=yii::t('app','Участвовать')?></a>
            <?php endif; ?>



        </div>
        <div class="ov-t1">
            <div class="for_item_other">
                <?php $bits = \app\models\Bits::getInfo($data->catalog_id);?>
                <div class="item1"><span id="persent"><?=$bits['persent']?>%</span><?=yii::t('app','собрано')?></div>
                <div class="item1"><span id="price"><?=$data->getPrice()?></span><?=yii::t('app','цена')?></div>
                <div class="item1"><span id="step"><?=$data->priceStep()?></span><?=yii::t('app','купить за')?></div>
            </div>
            <div class="t1"> <?=yii::t('app','Внимание!')?></div>

           <p> <?=\app\modules\system\models\TextWidget::getTpl('view_mess',['date'=>date("d-m-Y H:i:s",strtotime($data->catalog_dateend)) ]);?></p>
            <p> <?php if($date=\app\models\Bits::lastTiraj($data->catalog_id)):

                    echo yii::t('app','Последний розыгрыш был ').$date;?>
            <?php endif; ?></p>

            <?php
            if($countBits):?>
                <?=\app\modules\system\models\TextWidget::getTpl('make_bits',['bits'=>$countBits]);?>
            <?php endif; ?>
           <!-- <p>This project will only be funded if at least €30,000 funded if at least This project will only</p>
            <p><a href="">Подробнее</a></p>-->
        </div>
    </div>
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
        <div class="content1">
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
</div>
<section id="content">
    <h1><?=yii::t('app','Описание')?> <?=$data->catalog_name?></h1>

    <?=str_replace('img/','/img/',($data->catalog_text))?>
    <div class="hh1"></div>
    <div class="title1"><?=yii::t('app','Похожие товары')?></div>
    <div class="sld3">
        <div class="pv1"></div>
        <div class="nv1"></div>
        <div class="owl1 owl-carousel owl-theme">

            <?
                echo  \app\modules\catalog\widgets\items\SameCatWidget::widget(
                    [
                        'catid'=>$data->catalogcatid,
                        'tpl'=>'widgets/view_products_in_product' ,
                        'urlPrefix'=>'/product/',
                        'notin'=>$data->catalog_id,
                        'limit' => 8,

                    ]);

            ?>



        </div>
    </div>

    <? echo $this->render('reviews',['model'=>$data]);?>

</section>



<div class="modal-circles dm-overlay" id="for_circles_modal">

    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-bg-close"></div>
            <div class="dm-modal">
                <a href="#for_circles_modal" class="close"></a>
                <form>
                    <div class="ov-rd1">
                        <div class="item1 active item_for_circles">
                            <span class="st-img1"><span><img src="/img/q1.png" alt=""></span></span>
                                <span class="st-text1">
                                    <span><?=yii::t('app','Принять участие')?></span>
                                    <p></p>
                                </span>
                            <div class="all_circles">
                                <span class="circles">1</span>
                                <span class="circles">2</span>
                                <span class="circles">3</span>
                                <span class="circles">4</span>
                                <span class="circles">5</span>
                                <span class="circles">6</span>
                                <span class="circles">7</span>
                                <span class="circles">8</span>
                                <span class="circles">9</span>
                                <span class="circles">10</span>
                                <div class="clear"></div>

                            </div>
                        </div>
                    </div>
                    <div class="bt-rr1">
                       <!-- <button class="add_list_btn active">Добавить в список</button>
                        <button class="add_cart_btn">Добавить в корзину</button>-->
                        <div>
                            <span><?=yii::t('app','Ваша ставка')?>:</span>
                            <input type="text"  readonly  value="234234234">
                            <input  type="submit" value="перейти к оплате">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-bg-close"></div>
            <div class="dm-modal">
                <a href="#for_circles_modal" class="close"></a>

                    <div class="ov-rd1">
                        <div class="item1 active item_for_circles">

                                <span class="st-text1">
                                    <span></span>
                                    <p></p>
                                </span>

                        </div>
                    </div>

            </div>
        </div>
    </div>-->
</div>

<script>


    $('.make_bit_off').click(function(){
        var stepPrice='<?=str_replace($name=\app\modules\system\models\Course::getName(),'', str_replace(',','.',$data->priceStep()))?>',
            name ='<?=$name?>',
            step=$(this).attr('data-step')
            ;
        $(".agree").remove();


        $.ajax({
            url:  '/bit/makeoff?product=<?=$data->catalog_id?>' ,
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            type:'PUT',
            success: function(data)
            {
                window.location.reload();
            }
        });

    });

    $( document ).ready(function() {


        var tit1 = parseInt($('.tit1 ').css('height'));

        if(tit1 == 80)
            $('.content1-zoomer').addClass('content1-zoomer-81');
        else if(tit1 <= 80)
            $('.content1-zoomer').addClass('content1-zoomer-85');



        if ($(".content1-zoomer").length > 0) {
            $(".content1-zoomer").off().mCustomScrollbar({
                scrollInertia: 550,
                horizontalScroll: false,
                scrollButtons: {enable: true}
            });
        }



    });



    $('.make_bit').click(function(){
        var stepPrice='<?=str_replace($name=\app\modules\system\models\Course::getName(),'', str_replace(',','.',$data->priceStep()))?>',
            name ='<?=$name?>',
            step=$(this).attr('data-step')
           ;
        $(".agree").remove();


        $.ajax({
            url:  '/bit/info?step='+$(this).attr('data-step')+'&product=<?=$data->catalog_id?>' ,
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            type:'PUT',
            success: function(data)
            {
                var text='<?=\app\modules\system\models\TextWidget::getTpl('popap_on_bit');?>';

                $('body').addClass('body-active');
                $('#for_circles_modal').delay(200).fadeIn().addClass('active');
                //$('.st-text1').children('span').html("<?=yii::t('app','Принять участие')?>");

                console.log( stepPrice+'*'+step) ;
               /* if(data.status =='error'){
                    text=text+'<br><br><b>'+data.can+'</b>';
                    step=data.step;
                }
                else{*/
                    $('.dm-modal').html(data.message);
                //}
                if(data.persent)
                    $('#persent').html(data.persent+'%');

                //console.log( stepPrice+'*'+step +'='+ stepPrice*step) ;
                //result = Math.round((stepPrice*step)*100) /100;
                //var button ='<div>                                <span><?=yii::t('app','Ваша ставка')?>:</span>                                <input type="text"  readonly  value="'+result+'"><?=\app\modules\system\models\Course::getName()?>                                <input data-step="'+step+'" class="agree"  value="<?=yii::t('app','Подтвердить участие за')?>">                            </div>';
                //'<button type="button" data-step="'+step+'" class="agree" ><?=yii::t('app','Подтвердить участие за')?> '+result+
                //'<?=\app\modules\system\models\Course::getName()?></button>'

                //$('.st-text1').children('p').html(text);
                //$(button).insertAfter($('.st-text1').parent('div'));
                $('.bt-rr1').html(button);


            }
        });






        });
</script>