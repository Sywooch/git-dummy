



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

   ?>

    
    <?= $form->field($model, 'news_name')->textInput(['maxlength' => 255]) ?>

   <!-- <?/*= $form->field($model, 'news_title')->textInput(['maxlength' => 255]) */?>
	<?/*= $form->field($model, 'news_keys') */?>
    <?/*= $form->field($model, 'news_meta') */?>
    -->

    
    
 
    
     

<!--   --><?/*
   echo $form->field($model, 'news_text')->widget(letyii\tinymce\Tinymce::className(), [
    'options' => [        'id' => 'news_text',    ],
    'configs' => [ 
				  'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",]

       		    ],
]); 

*/?>

<?
   echo $form->field($model, 'news_preview')->widget(letyii\tinymce\Tinymce::className(), [
    'options' => ['id' => 'news_preview'],
    'configs' => [ 
				  'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"]
				 ],
]); 

?>

 



