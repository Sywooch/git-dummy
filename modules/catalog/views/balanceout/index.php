<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    use \app\modules\catalog\models\Catalog;
 use \app\modules\catalog\models\Balance_out;
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    
    
	<?php if(Yii::$app->session->hasFlash('updated')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('updated') ?>
        </div>
    <?php endif; ?>
<style>
.container{ width:100%;}
</style>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'money',
            'paymenttype',

            [
             'attribute'=>'status',
             'value'=>function($model){


                 return  Balance_out::getStatus($model->status);},
             'filter'=>Balance_out::getStatus(),
            ],


            [
                'attribute'=>'date',
                'value' =>function($model){ return Yii::$app->formatter->asDate(strtotime($model->date));},
                'filter'=>false
            ],


            [
                'attribute'=>'userid',
                'format'=>'html',
                'value'=>function($model){
                    return $text=$model->user ? $model->user->username : null;
                },#

            ],
			
            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  
			   
		  'update'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>',$url,[ ] );
               }	   
           			 ],
           'template'=>'  {update} {delete}',
			
			],
        ],
    ]);
	
 


Yii::$app->view->registerJs(' $(".checkbox_block").click(function(){
			var cb_el=$(this);
             $.ajax({
                 url: "'.Url::to( ['admin/setpublic','id'=>'' ]).'"+$(this).parent("td").parent("tr").attr("data-key")+"&field="+$(this).attr("title"),
                success: function(data) {
                    cb_el.html(data);
					 
                }
        })
    });');
 ?>
    
<style>.checkbox_block{ cursor:pointer}</style>
 


 
