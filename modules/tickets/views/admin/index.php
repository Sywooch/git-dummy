<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    
    
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


        [
            'attribute'=>'userid',
            'format'=>'html',
            'value'=>function($model){

                if($model->user->role == 5)
                    return ($model->user ? 'oper'.$model->user->id : null);
                else
                    return ($model->user ? 'client'.$model->user->id : null);
            },#
            'filter'=>\app\modules\terms\models\Terms::dropDown(7)
        ],

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
    

 


 
