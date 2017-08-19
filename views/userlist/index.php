<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<h3>Избранные исполнители</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute'=>'workerid',
                'value'=>function($model){

                    return $model->worker ? $model->worker->username : null;        },#
                //'filter'=>\app\modules\terms\models\Terms::dropDown(7)
            ],


            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  
			   
		  'update'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>',$url,[ ] );
               }	   
           			 ],
           'template'=>'  {delete}',
			
			],
        ],
    ]);
	
 


Yii::$app->view->registerJs('

$(".checkbox_block").click(function(){
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



 
