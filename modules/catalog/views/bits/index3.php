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

        'datetime'



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
 


 
