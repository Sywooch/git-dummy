



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use app\components\widgets\Language;

  $form = ActiveForm::begin(); ?>



<?=$tabs=(new Language)->tabs()?>
<?=$tabs=(new Language)->content('../../../modules/news/views/admin/_form_fields',['form'=>$form,'model'=>$model])?>
<?= $form->field($model, 'news_url')->textInput(['maxlength' => 255]) ?>

<?= $form->field($model, 'newscatid')->dropDownList(\yii\helpers\ArrayHelper::map(
    \app\modules\terms\models\Terms::find()->where(['termscatid' => 6,'langid'=>0 ])->all(),
    'terms_id',
    'terms_text'
), ['prompt'=>'']) ?>


<?= $form->field($model, 'news_date')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) ?>
    
	 <?php
	 use app\components\widgets\plupload\PluploadWidget;
	 echo  PluploadWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->news_id ]);
	 ?>
     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

