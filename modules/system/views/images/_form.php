


<div style=" min-width:1000px;">
<?php 

use app\modules\terms\models\Terms;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


  $form = ActiveForm::begin([ 'id'=>'images_form' ]); ?>

	<div id="images_error"></div>
    <?= $form->field($model, 'alt')->textInput(['maxlength' => 255]) ?>
    
	<?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), 
		[
			'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
			'id' => 'ajax_submit'
		]
		) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$('#ajax_submit').click(function(){
		 
	$.ajax({
    url : '/system/images/update?id=<?=$model->id?>',
    type: "POST",
    data : $('#images_form').serialize(),
	dataType: "json",
    success: function(data, textStatus, jqXHR)
    {
		data = jQuery.parseJSON(data);
 	
	 
            <?= Yii::$app->session->getFlash('updated') ?>
        
		
    	if(data.error == 1)
		{
			$('#images_error').html( '<div class="alert alert-error" role="alert">'+data.message+'</div>' );	
		}
		
		if(data.error == 0)
		{
			$('#images_form').html( '<div class="alert alert-success" role="alert">'+data.message+'</div>' );	
		}
		
		 
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 
    }
	});
	 
	return false;
	});
</script>