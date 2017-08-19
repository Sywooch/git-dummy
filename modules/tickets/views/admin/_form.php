



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

  $form = ActiveForm::begin(); ?>


    
     <? #echo $form->field($model, 'static_page_text')->textarea() ?>

   <?
   echo $form->field($model, 'static_page_text')->widget(letyii\tinymce\Tinymce::className(), [
    'options' => [
        'id' => 'static_page_text',
    ],
    'configs' => [ 
				  'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
]


       		 ],
   
]); 

?>

 

    
	 <?php
	 use app\components\widgets\plupload\PluploadWidget;
	 echo  PluploadWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->static_page_id ]);
	 ?>
     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

