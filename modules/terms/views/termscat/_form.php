



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\Language;


  $form = ActiveForm::begin(); ?>

    <?=$tabs=(new Language)->tabs()?>
    <?=$tabs=(new Language)->content('../../../modules/terms/views/termscat/_form_fields',['form'=>$form,'model'=>$model])?>

 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

