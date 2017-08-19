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
 

    <?php // echo $this->render('_search', ['model' => $searchModel]);

    ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',



            [
                'attribute'=>'catalogid',
                'value'=>function($model){      return $model->catalog ? $model->catalog->catalog_name : null;        },#
                'filter'=>\yii\helpers\ArrayHelper::map(
                    \app\modules\catalog\models\Catalog::find()->all(),
                    'catalog_id',
                    'catalog_name'
                )
            ],

            [
                'attribute'=>'userid',
                'value'=>function($model){      return $model->user ? $model->user->username : null;        },#
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id',  'username' )
            ],

            [
                'attribute'=>'info',
                'format'=>'html',

            ],
            [
                'header'=>'Телефон',
                'value'=>function($model){      return $model->user ? $model->user->phone : null;        },#

            ],
            [
                'attribute'=>'statusid',
                'format'=>'raw',
                'value'=>function($model){      return \yii\helpers\Html::dropDownList('statusid', $model->statusid, \app\models\Todeliver::getStatus(),['class'=>'status']);   },#

                'filter'=>\app\models\Todeliver::getStatus()

            ],


			

        ],
    ]);
	
 


Yii::$app->view->registerJs(' $(".status").change(function(){
			var el=$(this),
			id=$(this).parent("td").parent("tr").attr("data-key");
             $.ajax({
                 url: "'.Url::to( ['/catalog/delivery/status','id'=>'' ]).'"+id+"&status="+el.val(),
                success: function(data) {
                }
        })
    });');
 ?>
    
<style>.checkbox_block{ cursor:pointer}</style>
 


 
