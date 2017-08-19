<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', ['modelClass' => 'Тексты',]), ['create'], ['class' => 'btn btn-info']) ?>
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

            'widget_text_id',
            'title',
            'body:html',
			
            'alias',
			 							 
            
		 
            [	
			'class' => 'yii\grid\ActionColumn',
			
           'template'=>'  {update} {delete}',
			
			],
        ],
    ]); ?>
    

 


 
