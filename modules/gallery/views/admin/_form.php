



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

  $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'gallery_name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'gallery_url')->textInput(['maxlength' => 255]) ?>
   
    <?= $form->field($model, 'gallerycatid')->dropDownList(\app\modules\terms\models\Terms::dropDown(8), ['prompt'=>'']) ?>
     
    <? $model->gallery_date = Yii::$app->formatter->asDate(strtotime($model->gallery_date),"php:d-m-Y H:i");?>

<?= $form->field($model, 'lang')->dropDownList(\app\components\widgets\Language::getArrayLangs(), ['prompt'=>'']) ?>

   <?
   echo $form->field($model, 'gallery_text')->widget(letyii\tinymce\Tinymce::className(), [
    'options' => [
        'id' => 'gallery_text',
    ],
    'configs' => [ 
				  'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
]


       		 ],
   
]); 

?>

 

    
	 <?php
	 use app\components\widgets\plupload\PluploadWidget;
	 echo  PluploadWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->gallery_id ]);
	 ?>
     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

