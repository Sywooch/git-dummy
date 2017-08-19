

<h2>Текст</h2>

<?php


    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use app\components\widgets\Language;

    $form = ActiveForm::begin(); ?>



<?=$tabs=(new Language)->tabs()?>
<?=$tabs=(new Language)->content('../../../modules/system/views/text/_form_fields',['form'=>$form,'model'=>$model])?>



<?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'statusid')->dropDownList( $model->getStatus(), ['prompt'=>'']) ?>



<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
    

