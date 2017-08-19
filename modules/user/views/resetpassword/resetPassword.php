<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>




<div class="profile-box m-b-50">
    <div class="center-content clearfix">
        <div class="row">
            <div class="menu-name tacenter">
                <?=Yii::t('app', ' Установите новый пароль  ')?>                                </div>




            <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class'=>"authorisation-form"] ]);


                if($model->getErrors()){
                    $error_class="input-error";
                }?>
            <div class="col-md-5 col-md-offset-4" style="height: 260px;">
                <div class="col-md-10">

                </div>
                <div class="grey-box1 clearfix" >




                    <div class="autorisation-row clearfix row col-md-12">
                        <div class="col-md-1">
                            <div class="autorisation-label">

                            </div>
                        </div>
                        <?= $form->field($model, 'password',
                            ['validateOnBlur'=>true,
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input ".$error_class." \">{input}</div>
                                                    </div>"])
                            ->passwordInput(['placeholder'=>'Введите новый пароль', 'value'=>Yii::$app->request->cookies->getValue('name')   ]);?>

                    </div>

                    <div class="row">
                    <div class="clearfix row col-md-12 button-100">
                        <div class="col-md-12">
                            <button class="button-green button ls-2">
                                <?=Yii::t('app', 'Изменить пароль')?>
                            </button>
                        </div>

                    </div>
                    </div>

                    </form></div>

            </div>
        </div>
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
