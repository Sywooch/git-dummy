



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;


  $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'seo_keys')->textInput(['maxlength' => 512]) ?>
    
    <?= $form->field($model, 'seo_meta')->textInput(['maxlength' => 512]) ?>
    
    <?= $form->field($model, 'seo_url')->textInput(['maxlength' => 512]) ?>
    
    <?= $form->field($model, 'seo_page')->textInput(['maxlength' => 512]) ?>
    
     <?= $form->field($model, 'seo_text')->textarea() ?>

   
     

    
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

