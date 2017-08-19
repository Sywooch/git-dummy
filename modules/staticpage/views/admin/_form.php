



<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

    use app\components\widgets\Language;
  $form = ActiveForm::begin(); ?>


<?=$tabs=(new Language)->tabs()?>
<?=$tabs=(new Language)->content('../../../modules/staticpage/views/admin/_form_fields',['form'=>$form,'model'=>$model])?>



<?= $form->field($model, 'static_page_url')->textInput(['maxlength' => 255]) ?>
<? #= $form->field($model,'static_page_date')->widget(yii\jui\DatePicker::className(),['clientOptions' => ['defaultDate' => '2014-01-01']]) ?>
<?= $form->field($model, 'static_page_date')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) ?>

<?php
    use app\components\widgets\plupload\PluploadWidget;
    echo  PluploadWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->static_page_id ]);
?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

