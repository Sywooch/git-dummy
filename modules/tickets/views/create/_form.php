<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;


  $form = ActiveForm::begin(); ?>

    <h4>Создать тикет</h4>
    <?= $form->field($modelc, 'title')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'message')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Создать') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

