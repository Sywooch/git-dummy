<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



    $this->title = Yii::t('app', 'Баланс');
    $this->params['breadcrumbs'][] = ['label'=>Yii::t('app', 'Мой аккаунт'),'url'=>'/user/profile'];
    $this->params['breadcrumbs'][] = ['label'=>$this->title];



?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $this->params['breadcrumbs'],'ppc'=>'']/* ['label'=>$this->title ]]*/ );

?>


<div class="profile-box m-b-50">
<div class="center-content clearfix">

    <?    echo $this->render('@app/views/usermenu', ['title'=>Yii::t('app', 'Баланс') ]); ?>

<div class="profile-right">


    <?  $text=\app\modules\system\models\Notice::NullBalance(1);
        if($text):?>
            <div class="notification_text_stock"><?=$text?></div>
        <?php else:?>


    <? $text=\app\modules\system\models\Notice::LowBalance(1);
        if($text):?>
            <div class="notification_text_stock"><?=$text?></div>
        <?php endif;?>
        <?php endif;?>
    <div class="content-filter clearfix">
        <div class="fl period">
            <p class="  choose-period hidden-xs"><?=Yii::t('app', 'ВЫБРАТЬ ПЕРИОД')?></p>
            <div class="input-filter">
                <div class="input-filter-placeholder"><?=Yii::t('app', 'с')?>:</div>
                <div class="calender"></div>
                <input type="text" value="<?=yii::$app->request->get('datefrom')?>"  class="firstinput datepicker p-l-20 <?=(yii::$app->language!='ru')?'from-date':''?>" >
            </div>
            <div class="input-filter">
                <div class="input-filter-placeholder"><?=Yii::t('app', 'до')?>:</div>
                <div class="calender"></div>
                <input type="text"value="<?=yii::$app->request->get('dateto')?>"   class="datepicker p-l-30 <?=(yii::$app->language!='ru')?'to-date':''?>" >
            </div>

        </div>
        <div class="fr filter">
            <p>
                <span class="thx_shanin hidden-sm"><?=Yii::t('app', 'Поиск')?></span>
                <input data-page="/balance"  data-url="/balance/typethread" value="<?=\yii::$app->request->get('key')?>" class="search_filter_input ma-search act1" data-place="" type="text">
            </p>
        </div>
    </div>

    <div id="result-messages">

        <? echo $this->render('_ajax_body',['models'=>$models,'pages'=>$pages]); ?>
    </div>

</div>
</div>
</div>
<script>
    jQuery(document).ready(function($) {
        $(".balance-update-modal").on("click", function(event){

            $('body').addClass('body-active');
            $('#balance_modal').delay(200).fadeIn().addClass('active');

        });

        $(".balance-update-modal").on("click", function(event){

            $('body').addClass('body-active');
            $('#balance_modal').delay(200).fadeIn().addClass('active');

        });
    });
</script>

