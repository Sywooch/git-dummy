



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

?>

    
    <?= $form->field($model, 'static_page_name')->textInput(['maxlength' => 255]) ?>
   <?= $form->field($model, 'static_page_title')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'static_page_keys') ?>
    <?= $form->field($model, 'static_page_meta') ?>



    
 
    
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
<?= $form->field($model, 'langid')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'lang')->hiddenInput()->label(false) ?>


