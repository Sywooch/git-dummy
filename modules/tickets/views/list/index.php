<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    
    <h4>Ваши тикеты</h4>

<ul class="nav nav-pills nav-stacked">
    <li class="active" style="width: 200px;">
        <a href="/tickets/create">                        Создать тикет        </a>
    </li>

</ul>

	<?php if(Yii::$app->session->hasFlash('updated')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('updated') ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
           
            'title',
            // 'userid',


        [
            'attribute'=>'statusid',
            'format'=>'html',
            'value'=>function($model){
                return $model->terms ? $model->terms->terms_text : null;        },#
            'filter'=>\app\modules\terms\models\Terms::dropDown(13)
        ],


            'date_modified',

            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  'view'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>',$url,['class'=>"various fancybox.ajax", 'data-fancybox-type'=>"ajax"  ] );
               },
			   
		   			 ],
           'template'=>'{view}   {delete}',
			
			],
        ],
    ]); ?>
    

 


 
