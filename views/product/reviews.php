<?php
use yii\helpers\Html;
?>
<?php $comments = $model->comments;


    $Month_r = array(
        "01" => yii::t('app',"января"),
        "02" => yii::t('app',"февраля"),
        "03" => yii::t('app',"марта"),
        "04" => yii::t('app',"апреля"),
        "05" => yii::t('app',"мая"),
        "06" => yii::t('app',"июня"),
        "07" => yii::t('app',"июля"),
        "08" => yii::t('app',"августа"),
        "09" => yii::t('app',"сентября"),
        "10" => yii::t('app',"октября"),
        "11" => yii::t('app',"ноября"),
        "12" => yii::t('app',"декабря")
    );


    $bit_step=$model->catalog_price*($model->catalog_price_step/100);


if(count($comments)):?>

<div class="title1"><?=yii::t('app','Отзывы о товаре')?></div>
<div class="reviewss">
<?php $i=0; foreach($comments as $com):  $i++;      ?>

    <? echo $this->render('_ajax_reviews',['com'=>$com,'bit_step'=>$bit_step]); ?>

<?php if($i==2)break; endforeach; ?>
</div>
<div>    <a class=" center gray_link ajax-get-more " href="#"><img class="rotate" src="/verst/img/more_items.png"><?=yii::t('app','еще отзывы')?></a></div>


    <script>
        var page=4;
        $('.ajax-get-more').click(function(){
            var a=$(this);
            /*alert($('.item-wrapp-main-page').width());*/
            a.children('img').toggleClass("down");
            $.ajax({
                url:  '/morereviews?id=<?=$model->catalog_id?>&page='+page ,
                headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
                type:'GET',
                success: function(data)
                {

                    $('.reviewss').append(/*'<div class="clearfix"></div>'+*/data);
                    page=page+2;
                }
            });
            return false;
        });

    </script>

<?php endif; ?>