



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use \app\modules\catalog\models\Balance_out;

  $form = ActiveForm::begin(); ?>

  <h3>Заявка на прозвон</h3>
       <div class="col-md-6">

           <?php

               echo $form->field($model, 'status')->dropDownList(Balance_out::getStatus(false), ['prompt'=>'']) ?>



           <?= $form->field($model, 'comment')->textarea(['value'=>'']) ?>

           <div class="form-group">
               <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
           </div>

       </div>

     

    <?php ActiveForm::end(); ?>
    


    <?php



    Yii::$app->view->registerJs('


                ');


    ?>

<style>
    #catalog-tarifs label{ clear: both; display: block}
</style>

