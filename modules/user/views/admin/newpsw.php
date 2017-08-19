<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
     <div class="alert alert-success" role="alert"><?=Yii::t('admin','Изменить пароль на сгенерированный системой')?>
        </div>

 
 
 <?php $form = ActiveForm::begin(); $psw=Yii::$app->getSecurity()->generateRandomString(6); ?>
  
   <?= $form->field($model, 'password')->textInput( ['value' =>$psw ,'readonly'=>'readonly'] ); ?>
   <?= $form->field($model, 'repassword',[  'template' => "{input}\n{hint}\n{error}"])->hiddenInput(['value' => $psw ]); ?>
  
  <?= Html::submitButton(Yii::t('admin', 'Change'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
  
</form>

<br>


 <div class="alert alert-success" role="alert">
 <?=Yii::t('admin','Ввести свой пароль')?>
 </div>
 
 <?php $form = ActiveForm::begin(); ?>
   
   <?= $form->field($model, 'password')->passwordInput(); ?>
   <?= $form->field($model, 'repassword')->passwordInput(); ?>
  
  <?= Html::submitButton(Yii::t('admin', 'Change'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
  
</form>
