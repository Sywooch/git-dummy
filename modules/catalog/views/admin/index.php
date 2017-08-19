<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    use \app\modules\catalog\models\Catalog;
 
?>
 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', ['modelClass' => 'Catalog',]), ['create'], ['class' => 'btn btn-info']) ?>
    </p>
    
    
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

            'catalog_id',


            'catalog_name',


            [
                'attribute'=>'date_modified',
                'value' =>function($model){ return Yii::$app->formatter->asDate(strtotime($model->date_modified));},
                'filter'=>false
            ],

            [
                'attribute'=>'catalog_public',
                'format'=>'html',
                'filter'=>false,
                'visible'=> (\yii::$app->user->identity->role == 10?true:false),
                'value'=>function($model){
                    return $text=$model->catalog_public ?
                        '<a style="cursor: default" class="btn btn-primary set-deactive btn-rounded">активно</a>' :
                        '<a style="cursor: default" class="btn btn-default set-active btn-rounded">не активно</a>';
                },#


            ],

            [
                'visible'=> (\yii::$app->user->identity->role == 10?true:false),
                'header'=>'Модерация',
                'format'=>'html',
                'filter'=>false,
                'value'=>function($model){
                    return '<a target="_blank" href="'.$model->catalog_url.'?lang=ru">RU</a>  <a target="_blank" href="'.$model->catalog_url.'?lang=en">EN</a>';
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
    });

/*
    $(document).on("click",".set-deactive",function(){
            var cb_el=$(this);
             $.ajax({
                 url: "/catalog/admin/setpublic?id="+$(this).parent("td").parent("tr").attr("data-key")+"&field=catalog_public",
                success: function(data) {

                   // cb_el.parent("td").html("<a style=\"cursor: default\" class=\"btn btn-default set-active btn-rounded set-deactive\">не активно</a>");
                    cb_el.addClass("btn-default").addClass("set-deactive").removeClass("btn-primary").removeClass("set-active").html("не активно");
                }
             })
    });*/

    $(document).on("click",".btn-rounded",function(){
            var cb_el=$(this);
             $.ajax({
                 url: "/catalog/admin/setpublic?id="+$(this).parent("td").parent("tr").attr("data-key")+"&field=catalog_public",
                success: function(data) {

                    if(cb_el.hasClass("btn-primary"))
                        cb_el.addClass("btn-default").removeClass("btn-primary").html("не активно");
                    else
                        cb_el.removeClass("btn-default").addClass("btn-primary").html("активно");

                    //parent("td").html("<a style=\"cursor: default\" class=\"btn btn-primary set-active btn-rounded\">активно</a>");

                }
             })
    });

    ');
 ?>
    
<style>.checkbox_block{ cursor:pointer}</style>
 


 
