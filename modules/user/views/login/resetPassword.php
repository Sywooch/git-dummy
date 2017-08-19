<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\ResetPasswordForm */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>




<div class="breadcrumb" style="margin-left: 20px;">
    <div class="breadcrumb_inset">
        <a class="breadcrumb-home" href="/" title="Вернуться на главную"><i class="icon-home"></i></a>
        <span class="navigation-pipe ">&gt;</span>
        <span class="navigation_page"><?= Html::encode($this->title) ?></span>
    </div>
</div>
<div class="row ">
    <div class="loader_page">

        <div id="center_column" class="center_column span9 clearfix" style="padding-left: 25px;">




            <div class="row-fluid">


                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                            <?= $form->field($model, 'password')->passwordInput() ?>
                            <div class="form-group">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
</div></div></div>