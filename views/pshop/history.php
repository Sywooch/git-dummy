<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Заказы');
$this->params['breadcrumbs'][] = ['url'=>'/user/profile', 'label'=>yii::t('app','Мой аккаунт')];
$this->params['breadcrumbs'][] = ['label'=>$this->title];



?>


<?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $this->params['breadcrumbs'], 'ppc'=>'']/* ['label'=>$this->title ]]*/ );

?>





<div class="profile-box m-b-50">
    <div class="center-content clearfix">

        <?    echo $this->render('@app/views/usermenu', ['title'=>Yii::t('app', 'Заказы') ]); ?>


        <div class="profile-right">

            <div class="content-filter clearfix">

                <div class="fl period">
                    <p class="hidden-xs choose-period"><?=Yii::t('app', 'ВЫБРАТЬ ПЕРИОД')?></p>
                    <div class="input-filter">
                        <div class="input-filter-placeholder"><?=Yii::t('app', 'с')?>:</div>
                        <div class="calender"></div>
                        <input type="text" value="<?=yii::$app->request->get('datefrom')?>" class="firstinput datepicker p-l-20 <?=(yii::$app->language!='ru')?'from-date':''?>" >
                    </div>
                    <div class="input-filter">
                        <div class="input-filter-placeholder"><?=Yii::t('app', 'до')?>:</div>
                        <div class="calender"></div>
                        <input type="text" class="datepicker p-l-30 <?=(yii::$app->language!='ru')?'to-date':''?>"  value="<?=yii::$app->request->get('dateto')?>" >
                    </div>
                </div>

                <div class="fr filter">
                    <p>
                        <span class="thx_shanin hidden-sm"><?=Yii::t('app', 'Поиск')?></span>
                        <input data-page="/basket-history" data-url="/basket-history" value="<?=\yii::$app->request->get('key')?>"  class="search_filter_input ma-search act1" data-place="" type="text">
                    </p>
                </div>

            </div>

            <div id="result-messages">

                <? echo $this->render('_ajax_history',['models'=>$models,'pages'=>$pages]); ?>


            </div>
        </div>

    </div>
</div>



<script>
    $('.p-l-30').change(function(){
        window.location='/basket-history?datefrom='+$('.p-l-20').val()+'&dateto='+$(this).val()+'&key='+$('.search_filter_input').val() ;
    });
</script>