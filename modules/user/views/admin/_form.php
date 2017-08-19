<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'balance') ?>
    <?= $form->field($model, 'bonus') ?>

    <?= $form->field($model, 'persent')->label('Скидка %/Отчисления %') ?>
    <?= $form->field($model, 'place')?>

        <?= $form->field($model, 'status')->label(Yii::t('admin', 'Active'))->checkbox() ?>
        <?= $form->field($model, 'role')->dropdownList(User::getRoles()) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('admin', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
