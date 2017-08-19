



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

  $form = ActiveForm::begin(); ?>


<?
    echo $form->field($model, 'reviews_text')->widget(letyii\tinymce\Tinymce::className(), [
        'options' => [        'id' => 'reviews_text',    ],
        'configs' => [
            'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",]

        ],
    ]);

?>

   

    <? $model->reviews_date = Yii::$app->formatter->asDate(strtotime($model->reviews_date),"php:d-m-Y H:i");?>
<?= $form->field($model, 'reviews_date')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) ?>

     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

