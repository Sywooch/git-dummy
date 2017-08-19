<?php
    use yii\helpers\Html;
    use app\modules\shop\models\ShopItem;
    use app\modules\shop\models\Shop;
    use yii\widgets\ActiveForm;
?>




                              <?php  $model=new \app\modules\shop\models\NewOrder();?>

                                   <?php $form = ActiveForm::begin([
                                        'id' => 'checkout',
                                      'options'=>[  'class'=>'form-horizontal']
                                    ]); ?>

                            <div class="registration">
                                <div class="form-group"> <button onclick="window.location='/user/login'" class="btn btn-default" type="button">Авторизуйтесь если у Вас есть аккаунт</button> </div>
                                <div class="msg" style="padding: 5px;">

                                </div>

                                <div class="col-sm-6">
                                    <input type="radio" name="type" class="status-form"  value="0"> Купить без регистрации
                                 </div>
                                <div class="col-sm-6">
                                <input type="radio" name="type" class="status-form" checked="checked" value="1"> Купить с регистрацией
</div>

                                <div class="col-sm-6" id="all-data">
                                    <?= $form->field($model, 'Rname')->textInput(['maxlength' => 255]) ?>
                                    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
                                    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                                    <?= $form->field($model, 'Aphone')->textInput(['maxlength' => 255]) ?>
                                </div>
                                <div class="col-sm-6" id="reg-data">

                                    <?= $form->field($model, 'password')->textInput(['maxlength' => 255]) ?>
                                    <?= $form->field($model, 'Rrepassword')->textInput(['maxlength' => 255]) ?>
                                </div>
<div style="clear:both;"></div>
                                <p><strong>Доставка</strong></p>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'Acounty')->textInput(['maxlength' => 255]) ?>
                                    <?= $form->field($model, 'Aoblast')->textInput(['maxlength' => 255]) ?>

<div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <?= $form->field($model, 'Aindex')->textInput(['maxlength' => 255])->label('Индекс') ?>
                                    </div>

                                    <div class="col-sm-4 col-xs-12">
                                        <?= $form->field($model, 'Ahouse')->textInput(['maxlength' => 255]) ?>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <?= $form->field($model, 'Aflat')->textInput(['maxlength' => 255]) ?>
                                    </div>
</div>
                                </div>
                                <div class="col-sm-6">

                                    <?= $form->field($model, 'Atown')->textInput(['maxlength' => 255]) ?>
                                    <?= $form->field($model, 'Astreet')->textInput(['maxlength' => 255]) ?>
                                    <div class="form-group"> <button class="btn btn-default send-order" style="margin-top: 34px;" type="submit">Далее</button> </div>


                                </div>



                                </div>
  </form>
<style>
    .form-group{
        margin-bottom: 0px;;
    }
</style>