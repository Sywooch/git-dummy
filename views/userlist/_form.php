



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\Userlist;

  $form = ActiveForm::begin(); ?>

   <div class="row" style="padding-left: 40px;">


    <?= $form->field($model, 'workerid')->dropDownList( ArrayHelper::map(\app\models\User::find()->where('role = 5')->all(),'id','username'), ['prompt'=>'']) ?>

    <?= $form->field($model, 'status')->dropdownList(Userlist::getStatus()) ?>
           <div class="form-group">
               <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
           </div>

       </div>




   </div>

     

    <?php ActiveForm::end(); ?>
    

<script>




    <?php



    Yii::$app->view->registerJs('

                ');
    ?>

</script>


