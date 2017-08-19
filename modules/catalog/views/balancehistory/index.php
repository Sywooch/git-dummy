<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    use \app\modules\catalog\models\Catalog;
 use \app\modules\catalog\models\Balance_out;
    use yii\widgets\ActiveForm;
?>
 <h2>Баланс</h2>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row">
    <div class="col-lg-10">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Фильтр</h5>

            </div>
            <div class="ibox-content">
                <form role="form" class="form-inline">

                    <?php $form = ActiveForm::begin([    ]); ?>
                    <?= $form->field($model, 'catalogid')->dropDownList( ArrayHelper::map(\app\modules\catalog\models\Catalog::find()->all(),'catalog_id','catalog_name'), ['prompt'=>'Товар','style'=>'width:300px;'])->label(false) ?>
                    <?= $form->field($model, 'userid')->dropDownList( ArrayHelper::map(\app\models\User::find()->all(),'id','username'), ['prompt'=>'Пользователь'])->label(false) ?>
                    <?= $form->field($model, 'date')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) ?>
                    <?= $form->field($model, 'date2')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className())->label('до'); ?>
                    <div class="form-group">
                        <?= Html::submitButton( Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

            </div>
            <div class="ibox-content">
                <form role="form" class="form-inline">

                    <form action="/catalog/balancehistry/updateinfo" method="post">

                       <div class="row" style="padding-left: 20px;"> <div class="form-group field-balance-date">
                            <label class="control-label">Проговое значение баланс, когда появялеяется уведомление</label>
                            <input class="form-control" name="lowbalance" value="<?=yii::$app->params['lowbalance']?>" type="text">
                        </div>
                        <div class="form-group field-balance-date">
                            <label class="control-label">Проговое значение для обмена бонусов на деньги</label>
                            <input class="form-control" name="bonus" value="<?=yii::$app->params['bonus']?>" type="text">
                        </div>

                        <div class="form-group field-balance-date">
                            <label class="control-label">Вознаграждение за накопленные бонусы до порогового значения</label>
                            <input class="form-control" name="bonustomoney" value="<?=yii::$app->params['bonustomoney']?>" type="text">
                        </div>
                       </div>
                        <div class="form-group">
                        <?= Html::submitButton( Yii::t('admin', 'Обновить'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    </form>

            </div>
        </div>
    </div>

</div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',



            [
                'attribute'=>'date',
                'filter'=>false
            ],

            [
                'attribute'=>'catalogid',
                'format'=>'html',
                'filter'=>false,
                'value'=>function($model){
                    return $text=$model->catalog ? $model->catalog->catalog_name : null;
                },#

            ],
            [
                'attribute'=>'userid',
                'format'=>'html',
                'filter'=>false,
                'value'=>function($model){
                    return $text=$model->user ? $model->user->username : null;
                },#

            ],

            [
                'attribute'=>'money',
                'filter'=>false,
                'value'=>function($model){        return $model->money.'$';    },#
            ],

            [
                'attribute'=>'moneychange',
                'filter'=>false,
                'value'=>function($model){        return $model->moneychange.'$';    },#
            ],
            [
                'attribute'=>'comment',
                'format'=>'html',
            ],
          
        ],
    ]);
	
 

 ?>


 
