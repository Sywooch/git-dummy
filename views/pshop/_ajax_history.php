<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="date-time-list">
    <div class="table">
        <div class="table-head">
            <div class="data"><a href="?<?=yii::$app->request->QueryParamToString(['order','status'])?>&order=<?=(yii::$app->request->get('order')=='desc')?'asc':'desc'?>" class="sort-link <?=(yii::$app->request->get('order')=='desc')?'down':'up'?>"><?=Yii::t('app', 'ДАТА')?></a></div>
            <div class="stuff"><?=Yii::t('app', 'ТОВАР')?></div>
            <div class="order-status"><a href="?<?=yii::$app->request->QueryParamToString(['status','order'])?>&status=<?=(yii::$app->request->get('status')=='desc')?'asc':'desc'?>             " class="sort-link <?=(yii::$app->request->get('status')=='desc')?'down':'up'?>"><?=Yii::t('app', 'СТАТУС')?></a></div>
        </div>

        <?php foreach($models as $model):

            if($model->isread == 0){
                $model->isread=1;
                $model->save();
            }

            if(isset($model->items[0])):?>

            <div class="table-row clearfix" >
                <div class="data-row"><div> <?=date("d.m.Y",strtotime($model->shop_date))?><sup><?=date("h:i:s",strtotime($model->shop_date))?></sup></div></div>
                <div class="stuff-row">
                    <?php
                    $msgItem='';
                    $i=1;
                    foreach ($model->items as $item) {
                        $msgItem[]="($i)".$item->item->catalog_title.'<b> x '.$item->count.'</b>';
                        $i++;
                    }

                    ?>
                    <?=implode("<br>",$msgItem)?></div>
                <div class="order-status-row">
                    <?=$model->status->terms_text?>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>


    </div>

</div>
<div class="paginator undertable">
    <?php if(!\yii::$app->request->isPost): ?>
        <?=\app\components\LinkPager::widget([
            'pagination' => $pages,
            'options'=>['class'=>'clearfix'],

            'prevPageLabel'=>yii::t('app','Предыдущая'),
            'nextPageLabel'=>yii::t('app','Следующая'),
            'prevPageCssClass'=>'paginator-prev',
            'nextPageCssClass'=>'paginator-next',
            'maxButtonCount'=>3,
        ]);?>
    <?php endif;?>
</div>