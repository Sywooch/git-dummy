



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use \app\modules\catalog\models\Catalog;
    use app\components\widgets\Language;
  $form = ActiveForm::begin([
/*'enableAjaxValidation'=>false,
      'enableClientValidation'=>false,*/
  ]); ?>

<?php  echo  $form->errorSummary($model); ?>

<?=$tabs=(new Language)->tabs()?>
<?=$tabs=(new Language)->content('../../../modules/catalog/views/admin/_form_fields',['form'=>$form,'model'=>$model])?>

<?/*= $form->field($model, 'catalog_url')->textInput(['maxlength' => 255]) */?>
<?= $form->field($model, 'catalogcatid')->dropDownList(\app\modules\terms\models\Terms::dropDown(1), ['prompt'=>'']) ?>


<?  /*if( $model->catalog_date )
    $model->catalog_date = Yii::$app->formatter->asDate(strtotime($model->catalog_date),"php:d-m-Y H:i"); */?>
<?= $form->field($model, 'catalog_date')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) ?>

<? /* if( $model->catalog_dateend )
    $model->catalog_dateend = Yii::$app->formatter->asDate(strtotime($model->catalog_dateend),"php:d-m-Y H:i");*/ ?>
<?= $form->field($model, 'catalog_dateend')->widget(app\components\widgets\datetimepicker\DatetimepickerWidget::className()) ?>

<?= $form->field($model, 'catalog_count')->textInput(['maxlength' => 255]) ?>

<?= $form->field($model, 'catalog_bonus')->dropDownList([10=>10,20=>20,30=>30], ['prompt'=>'']) ?>

<div class="row">
    <div class="col-md-3"><?= $form->field($model, 'catalog_price')->textInput(['maxlength' => 255]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'catalog_bids')->textInput(['maxlength' => 255,'autocomplete'=>'off']) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'catalog_price_step')->textInput(['maxlength' => 255]) ?></div>
    <div class="col-md-3">
       <!-- <div class="form-group field-catalog-catalog_price_step required has-success">
            <label class="control-label" for="catalog-catalog_price_step"> Стоимость ставки</label>
            <input id="price_step" class="form-control"   value="" readonly="readonly" maxlength="255" type="text">
            <div class="help-block"></div>
        </div>-->
    </div>
</div>
<?= $form->field($model, 'timeend')->textInput(['maxlength' => 255]) ?>
<?/*= $form->field($model, 'hot')->checkbox(['maxlength' => 255]) */?><!--
--><?/*= $form->field($model, 'popular')->checkbox(['maxlength' => 255]) */?>
<?= $form->field($model, 'catalog_public')->hiddenInput(['value' => 0])->label(false); ?>
<?= $form->field($model, 'iszoomer')->checkbox(['maxlength' => 255]) ?>


<?php

    use app\components\widgets\plupload\PluploadWidget;
    echo  PluploadWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->catalog_id ]);
?>

<?php if(!$model->catalog_id): ?>
<?php endif;



    Yii::$app->view->registerJs(' $(".btn-success[type=submit]").click(function(){

            var num=10;
            if($("#catalog-iszoomer").is(":checked"))
                num=7;

            if( $(".alert-success").length < num){
                alert("Нужно больше "+num+" картинок");
                return false;
             }


    });

     /*  $("#catalog-catalog_bids").keyup(function(){
             var price = $("#catalog-catalog_price").val();
                 var steps = $(this).val();

                num  = 100/steps*100
                 num  = 100/steps*100
              $("#catalog-catalog_price_step").val( Math.ceil( num )/100  );
              $("#price_step").val( Math.ceil( price/steps*100)/100  );
             });

             $("#catalog-catalog_bids").trigger("keyup");*/
             ');
?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end(); ?>

<script>


</script>

