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
                        }?>
                    <div class="table-row clearfix" >
                        <div class="data-row"><div> <?=date("d.m.Y",strtotime($model->date_modified))?><sup><?=date("h:i:s",strtotime($model->date_modified))?></sup></div></div>
                        <div class="stuff-row"><!--<a class="active-<?/*=$model->statusid!=4?'order':'rate'*/?>" href="<?/*=$model->catalog->catalog_url*/?>">--><?=$model->message?><!--</a>--></div>
                        <div class="order-status-row">
                            <?php
                            //    print_r($model->toArray());
                                    $bits = \app\models\Auct::getInfo($model->complite);

                            /*print_r($bits);*/
                                switch($model->statusid){
                                          case 1:  echo $model->getStatusText(2).' ( '.(($bits->catalog)?$bits->catalog->persentToEnd():'').'% ) ';break; ?>
                                    <?php case 4:  echo '<div class="win-rate">'.$model->getStatusText(2).'</div>';break; ?>
                                    <?php case 5:  echo '<div class="lose-rate">'.$model->getStatusText(2).'</div>';break; ?>
                                    <?php case 3:  echo '<div class="lose-rate" >'.$model->getStatusText(2).'</div>';break; ?>
                                    <?php case 2:  echo '<div class="overdue-rate">'.$model->getStatusText(2).'</div>';break; ?>

                            <?php }?>



                        </div>
                    </div>
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
