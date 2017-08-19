<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', ['modelClass' => 'News',]), ['create'], ['class' => 'btn btn-info']) ?>
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

            'news_id',
           
            'news_name',
            'news_url:url',
			 [
                'attribute'=>'newscatid',
                'value'=>function($model){      return $model->terms ? $model->terms->terms_text : null;        },#
                'filter'=>\yii\helpers\ArrayHelper::map(
														\app\modules\terms\models\Terms::find()->where(['termscatid' => 6 ])->all(),
														'terms_id',
														'terms_text'
													  )
            ],
			[
				'attribute'=>'news_date',
				'value' =>function($model){ return Yii::$app->formatter->asDate(strtotime($model->news_date));},
				'filter'=>false	
			],
            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  
			   
		  'update'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>',$url,['class'=>"various fancybox.ajax", 'data-fancybox-type'=>"ajax"  ] );
               }	   
           			 ],
           'template'=>'  {update} {delete}',
			
			],
        ],
    ]); ?>
    

 


 
