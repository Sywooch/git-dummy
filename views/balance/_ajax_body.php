<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="date-time-list">
    <div class="date-time-list-header clearfix balance-header">
        <div class="date-time-list-col dtlc-t1">
            <?=Yii::t('app', 'Основной счет')?>: <span class="green-text">
                       <span id="money-text">
                        <?=(\yii::$app->user->identity->balance)?\app\modules\system\models\Course::getPrice(\yii::$app->user->identity->balance,2):(\app\modules\system\models\Course::getName().'0.0')?>
                        </span> </span>
        </div>
        <div class="date-time-list-col dtlc-t2">
            <?=Yii::t('app', 'BOUNTY')?>: <span class="red-text">+<?=intval(\yii::$app->user->identity->bonus)?></span>
        </div>

        <div class="date-time-list-col dtlc-t3">


            <a href="<?= ( yii::$app->user->identity->isemail!=1)?'/user/profile':'#'?>" class="button button-green new-balance"><?=Yii::t('app', 'Пополнить счет')?></a>

        </div>


    </div>

    <div class="date-time-list-header clearfix dspn">
        <div class="date-time-list-col dtlc1">
            <div class="data"><a href="?<?=yii::$app->request->QueryParamToString('order')?>&order=<?=(yii::$app->request->get('order')=='desc')?'asc':'desc'?>" class="sort-link <?=(yii::$app->request->get('order')=='desc')?'down':'up'?>"><?=Yii::t('app', 'Дата')?></a></div>
        </div>
        <div class="date-time-list-col dtlc2-1">
            <?=Yii::t('app', 'Операция')?>
        </div>
        <div class="date-time-list-col dtlc3-1 small1-hide">
            <?=Yii::t('app', 'СУММА')?>
        </div>
        <div class="date-time-list-col dtlc3-1 small-hide">
            <?=Yii::t('app', 'Приход')?>
        </div>
        <div class="date-time-list-col dtlc3-1">
            <?=Yii::t('app', 'Расход')?>
        </div>
    </div>


    <?php
        if(!count($models)):
        ?>
            <br><br>
            <?php
        else:
        foreach($models as $model):?>
        <div class="date-time-list-row clearfix">
            <div class="date-time-list-col dtlc1 clearfix">
                <div class="date-time-list_date">
                    <?=date("d.m.Y",strtotime($model->date))?>
                </div>
                <div class="date-time-list_time">
                    <?=date("h:i:s",strtotime($model->date))?>
                </div>
            </div>
            <div class="date-time-list-col dtlc2-1">
                <?php if(\yii::$app->language=='en'):?>
                    <?=$model->comment?>
                <?php else: ?>
                    <?=($model->comment=='Balance refill')?'Баланс успешно пополнен!':$model->comment?>
                <?php endif; ?>

            </div>
            <div class="date-time-list-col dtlc3-1 small1-hide">
                <?=\app\modules\system\models\Course::getPrice($model->money,0)?>
            </div>
            <div class="date-time-list-col dtlc3-1">
                <?php if( $model->moneychange>0): ?>
                    <span class="green-text">

                    <?=\app\modules\system\models\Course::getPrice($model->moneychange,0)?>
                </span>
                <?php else:?>
                    <div class="date-time-list-col dtlc3-1 min-hide">
                        <span class="green-text">&nbsp;</span>
                    </div>
                <? endif; ?>
            </div>
            <div class="date-time-list-col dtlc3-1">
                <?php if( $model->moneychange<0): ?>

                    <?=\app\modules\system\models\Course::getPrice(str_replace('-','',$model->moneychange),0)?>
                <?php else:?>
                    <div class="date-time-list-col dtlc3-1 min-hide">
                        <span class="green-text">&nbsp;</span>
                    </div>
                <? endif; ?>
            </div>
        </div>
    <?php endforeach;
    endif; ?>


</div>
<div class="paginator undertable">
    <?=\app\components\LinkPager::widget([
        'pagination' => $pages,
        'options'=>['class'=>'clearfix'],
        'prevPageLabel'=>yii::t('app','Предыдущая'),
        'nextPageLabel'=>yii::t('app','Следующая'),
        'prevPageCssClass'=>'paginator-prev',
        'nextPageCssClass'=>'paginator-next',
        'maxButtonCount'=>3,
    ]);?>
</div>

<div class="modal-circles dm-overlay" id="for_modal_table" >
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-bg-close"></div>
            <div class="dm-modal">
                <a href="#balance_modal" class="close" onclick="$('#balance_modal').fadeOut(300);"></a>
                <div>
                    <div class="bt-rr1">

                    <span><?=yii::t('app','Сумма пополнения')?>, <?=\app\modules\system\models\Course::getName()?>:</span>
                    <input  value="0" id="amount"   type="text">
                    </div>
                </div>
                <button  class="add_list_btn active" id="update-balance"><?=yii::t('app','Пополнить Счет')?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal-circles dm-overlay" id="balance_modal">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-bg-close"></div>
            <div class="dm-modal">
                <a href="#balance_modal" class="close" onclick="$('#balance_modal').fadeOut(300);"></a>
                <form>

                    <div class="bt-rr1">

                        <div>


                            <span><?=yii::t('app','Сумма пополнения')?>, <?=\app\modules\system\models\Course::getName()?>:</span>
                            <input  value="0" id="amount"   type="text">

                        </div>
                        <br>
                        <Div id="balance-return"></Div>
                        <button class="button-green add_list_btn active " id="update-balance"><?=yii::t('app','Пополнить Счет')?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

$('#amount').keyup(function(){
    $(this).val($(this).val().replace(/[^0-9\.]/gim,''))
});

$('.new-balance').click(function(){
    $('#for_modal_table').addClass('active ').fadeIn();
})






    jQuery("#update-balance").click(function(){

        var el = jQuery(this);
    if($("#amount").val()*1>0){
       // alert('/pay?amount='+$("#amount").val());
        window.location='http://bountymart.com/pay?amount='+$("#amount").val();
        /*jQuery.ajax({
            url: "<?=Url::to( ['balance/update'])?>",
            type: "POST",
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            data:{amount:$("#amount").val()},
            success: function(data) {

                if(data.status == "success"){
                    window.location.reload();
                    window.location='/pay?';
                }
                else
                    jQuery("#balance-return").html("Возникла ошибка, попробуйте позже!");
            }
        })*/
    }
        return false;
    });
    $('.p-l-30').change(function(){
        window.location='/balance?datefrom='+$('.p-l-20').val()+'&dateto='+$(this).val()+'&key='+$('.search_filter_input').val() ;
    });
</script>
