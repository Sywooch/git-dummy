<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */




?>
 

            <div class="date-time-list">
                <div class="date-time-list-header clearfix">
                    <div class="date-time-list-col dtlc1">
                        <div class="data"><a href="?<?=yii::$app->request->QueryParamToString('order')?>&order=<?=(yii::$app->request->get('order')=='desc')?'asc':'desc'?>" class="sort-link <?=(yii::$app->request->get('order')=='desc')?'down':'up'?>"><?=Yii::t('app', 'Дата')?></a></div>
                    </div>
                    <div class="date-time-list-col dtlc2">
                        <?=Yii::t('app', 'Сообщение')?>
                    </div>
                    <div class="date-time-list-col dtlc3">
                        <?=Yii::t('app', 'Статус')?>
                    </div>
                </div>
                <?php foreach($models as $model):
                    if($model->isread == 0){
                        $model->isread=1;
                        $model->save();
                        $model->date_modified=date("Y-m-d H:i:s");
                    }
                    ?>
                <div class="date-time-list-row clearfix">
                    <div class="date-time-list-col dtlc1 clearfix">
                        <div class="date-time-list_date">
                            <?=date("d.m.Y",strtotime($model->date_modified))?>
                        </div>
                        <div class="date-time-list_time">
                            <?=date("h:i:s",strtotime($model->date_modified))?>
                        </div>
                    </div>
                    <div class="date-time-list-col dtlc2">
                        <?=$model->message?>
                    </div>
                    <div class="date-time-list-col dtlc3">

                        <?php         switch($model->statusid){
                                  case 1:  echo ' <span class="hot-state state">'.$model->getStatusText(1).'</span>';break; ?>
                            <?php case 3:  echo ' <span class="blue-state state">'.$model->getStatusText(1).'</span>';break; ?>
                            <?php case 2:  echo $model->getStatusText(1);break; ?>

                            <?php }?>




                    </div>
                </div>
                <?php endforeach; ?>

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
