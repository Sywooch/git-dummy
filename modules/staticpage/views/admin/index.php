<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', ['modelClass' => 'Staticpage',]), ['create'], ['class' => 'btn btn-info']) ?>
    </p>
    
    
	<?php if(Yii::$app->session->hasFlash('updated')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('updated') ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'static_page_id',
           
            'static_page_name',
             'static_page_url:url',

            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  'view'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>',$url,['class'=>"various fancybox.ajax", 'data-fancybox-type'=>"ajax"  ] );
               },
			   
		  'update'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>',$url,['class'=>"various fancybox.ajax", 'data-fancybox-type'=>"ajax"  ] );
               }	   
           			 ],
           'template'=>'{view}  {update} {delete}',
			
			],
        ],
    ]); ?>
    

 


 
