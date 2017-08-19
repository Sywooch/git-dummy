



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use \app\modules\catalog\models\Catalog;
  $form = ActiveForm::begin(); ?>

  <h3>Заявка на прозвон</h3>
       <div class="col-md-6">
   <?php if($model->statusid != Catalog::STATUS_COMMENT): ?>

    <?= $form->field($model, 'catalog_number')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'catalog_to')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'catalog_from')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'catalog_text')->textarea() ?>

    <?= $form->field($model, 'langid')->dropDownList(\app\modules\terms\models\Terms::dropDown(12), ['prompt'=>'']) ?>
    <?= $form->field($model, 'sexid')->dropDownList(\app\modules\terms\models\Terms::dropDown(11), ['prompt'=>'']) ?>

           <?php
               if(isset($model->catalog_id))
               echo $form->field($model, 'statusid')->dropDownList(\app\modules\terms\models\Terms::dropDown(7), ['prompt'=>'']) ?>

           <?php   echo $form->field($model, 'workerid')->dropDownList(\app\modules\catalog\models\Userlist::users(), ['prompt'=>'Любой исполнитель']) ?>




   <!-- <?/*  if( $model->catalog_date )
			$model->catalog_date = Yii::$app->formatter->asDate(strtotime($model->catalog_date),"php:d-m-Y H:i"); */?>
    --><?/*= $form->field($model, 'catalog_date')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) */?>
    <?php endif; ?>
           <?=$model->comment; $model->comment='';?>
           <?= $form->field($model, 'comment')->textarea(['value'=>'']) ?>

           <div class="form-group">
               <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
           </div>

       </div>

       <div class="col-md-6">
           <?php if($model->statusid != Catalog::STATUS_COMMENT): ?>
           <?= $form->field($model, 'tarifs')->checkboxlist(\app\modules\terms\models\Terms::dropDown(8), ['prompt'=>'','multiple' => 'multiple']) ?>
           <?= $form->field($model, 'change_number')->textInput(['maxlength' => 255]) ?>
           <?php endif; ?>
       </div>


     

    <?php ActiveForm::end(); ?>
    


    <?php



    Yii::$app->view->registerJs('


    if(!jQuery("input").filter("[value=55]").prop("checked"))

        jQuery(".field-catalog-change_number").toggle("hide");


    jQuery("input").filter("[value=55]").click(function(){

        if(jQuery(this).prop("checked") )
             jQuery(".field-catalog-change_number").toggle("show");
        else{
              jQuery(".field-catalog-change_number").toggle("hide");
              jQuery("#catalog-change_number").val("");
              }
    });

                ');


    ?>

<style>
    #catalog-tarifs label{ clear: both; display: block}
</style>

