<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    use \app\modules\catalog\models\Catalog;
 use \app\modules\catalog\models\Balance_out;
    use yii\helpers\ArrayHelper;
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
            'comment',
            'comment_time',
            [
                'attribute'=>'userid',
                'value'=>function($model){      return $model->user ? $model->user->username : null;        },#
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id',  'username' )
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'approve'=>function ($url, $model) {

                        if($model->isapprove)
                            $class='glyphicon glyphicon-plus-sign';
                        else
                            $class='glyphicon-minus-sign';
                        return \yii\helpers\Html::a( '<span class="glyphicon '.$class.' "></span>',$url,[ ] );
                    }
                ],
                'template'=>' {approve} ',

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
 


 
