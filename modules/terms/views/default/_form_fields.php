
<?php

use app\modules\terms\models\Terms;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\plupload\PluploadWidget;
use yii\bootstrap\Tabs;

  ?>

<?php 

if($_GET['parent']){
		$term=Terms::Find()->where([ 'terms_id' =>$_GET['parent'] ])->one();
		$model->terms_parent = $_GET['parent'];
		$model->termscatid = $term->termscatid;
		
		}

 $t2=$t1='';
if( $model->termscatid == 9 ){  $t1='<div style="display:none">'; }

	if($_GET['termscatid'])
	{
		$model->termscatid = $_GET['termscatid'];
	}
 
if( $model->termscatid == 9 ){  $t2='</div>'; }	
	 
    		
		
 echo Tabs::widget([
			'items' =>[ 
						[
						'label' => 'Основные',
						'content' =>$form->field($model, 'terms_text')->textInput(['maxlength' => 255]).
									$form->field($model, 'terms_about')->widget(letyii\tinymce\Tinymce::className(), [
											'options' => [        'id' => 'terms_about',    ],
											'configs' => [ 
														  'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",]
										
														],
										]).
									$form->field($model, 'terms_url')->textInput(['maxlength' => 512]).
									$form->field($model, 'terms_parent',[  'template' => "{input}\n{hint}\n{error}"])->hiddenInput(['maxlength' => 512]).
									$t1.$form->field($model, 'termscatid')->dropDownList(\yii\helpers\ArrayHelper::map(
										\app\modules\terms\models\Terms_cat::find()->where('langid=0')->all(),
										'terms_cat_id',
										'terms_cat_text'
									), ['prompt'=>'']).$t2
									,
						]/*,
						[
						'label' => 'Seo',
						'content' => 
									 $form->field($model, 'terms_title')->textInput(['maxlength' => 255]).
									 $form->field($model, 'terms_keys')->textInput(['maxlength' => 255]).
									 $form->field($model, 'terms_meta'),

						],
						 
						  
						[
						'label' => 'Фото',
						'content' =>PluploadWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->terms_id ]) ,
						]*/
					]	
			 
		]); 
 
 ?>
<?= $form->field($model, 'langid')->hiddenInput(['value'=>intval($model->langid)])->label(false) ?>
<?= $form->field($model, 'lang')->hiddenInput()->label(false) ?>
    
    
	 
    
  
  
    
    
   
     

    
