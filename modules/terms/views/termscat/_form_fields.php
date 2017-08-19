



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;

  ?>


    <?= $form->field($model, 'terms_cat_text')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'langid')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'lang')->hiddenInput()->label(false) ?>
    
  
 

