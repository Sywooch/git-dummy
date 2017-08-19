<?php

use yii\helpers\Html;
use yii\grid\GridView;
    use app\modules\tickets\models\Tickets;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <h3>Активность</h3>

<p>
    <?= Html::a(Yii::t('admin', 'Создать активность', ['modelClass' => 'Tickets',]), ['acreate'], ['class' => 'btn btn-info']) ?>
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

            'id',
           
            'message:html',


            [
                'attribute'=>'userid',
                'value'=>function($model){      return $model->user ? $model->user->username : null;        },#
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id',  'username' )
            ],

            [
                'attribute'=>'statusid',
                'format'=>'html',
                'value'=>function($model){
                    if($model->statusid)
                        return $model->getStatus(1,$model->statusid);
                    else
                        return '';},#
                'filter'=>(new Tickets)->getStatus(1)
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
    

 


 
