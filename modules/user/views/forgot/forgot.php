<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = Yii::t('app/frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="centerColumn" id="loginDefault">

<h1 id="loginDefaultHeading">Забыли пароль</h1>

<div class="tie">
<div class="tie-indent">




<!--BOF normal login-->
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


    <fieldset class="first">
        <legend>Восстановление пароля</legend>

        <?= $form->field($model, 'email') ?>



    </fieldset>

    <div class="buttonRow back"><input class="cssButton button_login" onmouseover="this.className='cssButtonHover button_login button_loginHover'" onmouseout="this.className='cssButton button_login'" value="Восстановить пароль" style="width: 80px;" type="submit"></div>

</form>


<!--EOF normal login-->
<div class="clear"></div>
</div>
</div>


<!--<div class="site-login">
    <h1><?/*= Html::encode($this->title) */?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php /*$form = ActiveForm::begin(['id' => 'login-form']); */?>
                <?/*= $form->field($model, 'identity') */?>
                <?/*= $form->field($model, 'password')->passwordInput() */?>
                <?/*= $form->field($model, 'rememberMe')->checkbox() */?>
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?/*= Html::a('reset it', ['sign-in/request-password-reset']) */?>.
                </div>
                <div class="form-group">
                    <?/*= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) */?>
                </div>
                <h2><?php /* //echo \Yii::t('app', 'Log in with')  */?>:</h2>
                <div class="form-group">
                    <?/* //= yii\authclient\widgets\AuthChoice::widget([                     'baseAuthUrl' => ['/user/signin/oauth']                 ]) */?>
                </div>
            <?php /*ActiveForm::end(); */?>
        </div>
    </div>
</div>-->
