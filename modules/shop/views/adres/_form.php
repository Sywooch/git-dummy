

<h2>Курсы</h2>

<?php


    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use app\components\widgets\Language;

    $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'price')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'format1')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'format2')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'format3')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'persent')->textInput(['maxlength' => 255]) ?>


<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
    

