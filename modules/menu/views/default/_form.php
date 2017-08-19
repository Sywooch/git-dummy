



<?php 

use app\modules\menu\models\Menu;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url; 
use yii\jui\AutoComplete;
    use app\components\widgets\Language;

  $form = ActiveForm::begin(); ?>
<br>

	 <kbd><?= \Yii::t('admin', 'Выбрать страницу из уже созданных страниц') ?></kbd><br>
<div class="form-group field-menu-menu_text required">     <?php
		echo AutoComplete::widget([
			'name' => 'country',

			
			'clientOptions' => [
			  #  'source' => ['USA', 'RUS','Самоелт','Фильмы'],
				'source' => Url::to(['default/autocomplect']),
				'name' => 'name',
			],
			
			'clientEvents' => [
				
				'select' => "function(event, ui) {
	            	
					$('#menu-menu_text').val(ui.item.name);
					$('#menu-menu_url').val(ui.item.url);
					$('#menu-tablename').val(ui.item.tb);
					$('#menu-tableid').val(ui.item.id);
					
	            }",
				'change' => "function (event, ui) 
							{
							 //alert(ui.item.id); 
							}",
			 
			], 
			 
			'options' => [
				'class' => 'form-control'
				
			]
		]);
		
Yii::$app->view->registerJs(" $('#w1').autocomplete( 'instance' )._renderItem = function( ul, item ) {
return $( '<li>' )
.append( item.name+'<br><sup>'+item.cat+'</sup>' )
.appendTo( ul );
};
");  
		
		?>
          
        </div>
<br>


<?=$tabs=(new Language)->tabs()?>
<?=$tabs=(new Language)->content('../../../modules/menu/views/default/_form_fields',['form'=>$form,'model'=>$model])?>


	<?= $form->field($model, 'menu_url')->textInput(['maxlength' => 255]) ?>
    
 	<?= $form->field($model, 'tablename',[  'template' => "{input}\n{hint}\n{error}"])->hiddenInput() ?>
    
    <?= $form->field($model, 'tableid',[  'template' => "{input}\n{hint}\n{error}"])->hiddenInput() ?>
   
    
    <? 
	if($_GET['parent']){
		$term=Menu::Find()->where([ 'menu_id' =>$_GET['parent'] ])->one();
		$model->menu_parentid = $_GET['parent'];
		}
	$model->alias=$_GET['termin'];
	echo $form->field($model, 'alias',[  'template' => "{input}\n{hint}\n{error}"])->hiddenInput();
	
	echo $form->field($model, 'menu_parentid',[  'template' => "{input}\n{hint}\n{error}"])->hiddenInput();
		?>
 
    
  
   
     

    
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
 
