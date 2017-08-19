<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', ['modelClass' => 'Shop',]), ['create'], ['class' => 'btn btn-info']) ?>
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

            'shop_id',
           
            'fio',
				'email',
				'phone',
            
			 [
                'attribute'=>'shopcatid',
                'value'=>function($model){      return $model->status ? $model->status->terms_text : null;        },#
                'filter'=>\yii\helpers\ArrayHelper::map(
														\app\modules\terms\models\Terms::find()->where(['termscatid' => 7 ])->all(),
														'terms_id',
														'terms_text'
													  )
            ],
			[
				'attribute'=>'shop_date',
				'value' =>function($model){ return Yii::$app->formatter->asDate(strtotime($model->shop_date));},
				'filter'=>false	
			],
            [
			'class' => 'yii\grid\ActionColumn',
            'template'=>' {cancel}  {update} {delete}',
			'buttons'=>[
				'cancel'=>function ($url, $model) {

					return Html::a('<span class="glyphicon glyphicon-off"></span>', $url, [
							'title' => Yii::t('yii', 'Cancel'),
					]);
				}
	]
                  
		  


			
			],
        ],
    ]); ?>
    

 


 
