<?php

use yii\helpers\Html;
use yii\grid\GridView;
    use yii\helpers\Url;

    /* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    
    
	<?php if(Yii::$app->session->hasFlash('updated')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('updated') ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'reviews_id',
           
            'reviews_text',


            ['attribute'=>'reviews_public',
             'filter'=>false,
             'format' => 'html',
             'value'=>function($model){
                 return \yii\helpers\Html::Tag('div',($model->reviews_public ?
                     \yii\helpers\Html::Tag('span','',['class'=>"glyphicon glyphicon-ok"] )
                     :
                     \yii\helpers\Html::Tag('span','',['class'=>" glyphicon glyphicon-remove"])
                 ),['class'=>"btn-reviews-status",  'title'=>"reviews_public"]);
             }
            ],

            'reviews_date',
          

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
    ]);





        Yii::$app->view->registerJs(' $(".btn-reviews-status").click(function(){
			var cb_el=$(this);
             $.ajax({
                 url: "'.Url::to( ['admin/setpublic','id'=>'' ]).'"+$(this).parent("td").parent("tr").attr("data-key")+"&field="+$(this).attr("title"),
                success: function(data) {
                    cb_el.html(data);

                }
        })
    });');

    ?>



 
