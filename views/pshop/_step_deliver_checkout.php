<?php
    use yii\helpers\Html;
    use app\modules\shop\models\ShopItem;
    use app\modules\shop\models\Shop;
    use yii\widgets\ActiveForm;
?>



<?php if($dataPost):?>

                            <?php $form = ActiveForm::begin([
                            'id' => 'checkout-last',
                            'class'=>'form-horizontal'
                        ]);
                            $data=unserialize(base64_decode($dataPost));
                        ?>
                            <input type="hidden" name="topay" value="1">
                            <input type="hidden" name="dataPost" value="<?=$dataPost?>">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group"> <label for="" class="control-label">Фамилия Имя </label>
                                    <p class="form-control-static"><?=$data['username']?> <?=$data['Rname']?></p>
                                </div>

                                <div class="form-group"> <label for="" class="control-label">E-mail</label>
                                    <p class="form-control-static"><?=$data['email']?></p>
                                </div>
                                <div class="form-group"> <label for="" class="control-label">Телефон</label>
                                    <p class="form-control-static"><?=$data['Aphone']?></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group"> <label for="" class="control-label">Адрес доставки</label>
                                    <p class="form-control-static"><?=$data['Rname']?><br/><?=$data['Aphone']?> </p>
                                    <p class="form-control-static"><?=$data['Aindex']?>, <?=$data['Acounty']?><br/><?=$data['Aoblast']?>,
                                    <?=$data['Atown']?><br/>ул. <?=$data['Astreet']?>, <?=$data['Ahouse']?> <?=$data['Aflat']?></p>
                                </div>
                            </div>
                            <div style="clear: both"> </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="" class="control-label">Варианты доставки внутри страны</label>
                                        <select name="NewOrder[delivery]" id="" class="form-control">
                                            <option value="Курьер">Курьер</option>
                                            <option value="Самовывоз">Самовывоз</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                             <div class="form-group"> <button type="submit" class="btn btn-default">Далее</button> </div>
                               <!-- <div class="form-group">
                                    <label for="" class="control-label">Варианты оплаты</label>
                                    <select name="pay" class="form-control">
                                        <option value="Visa, Mastercard">Visa, Mastercard</option>
                                        <option value="Пополнение счета в банке">Пополнение счета в банке</option>
                                    </select>

                                </div>-->
                            </div>

                        </form>



                        <?php  else: ?>



<?php $form = ActiveForm::begin([
    'id' => 'checkout-last',
    'class'=>'form-horizontal'
]); ?>
<input type="hidden" name="topay" value="1">

<div class="col-md-6 col-xs-12">
    <div class="form-group"> <label for="" class="control-label">Имя</label>
        <p class="form-control-static"><?=yii::$app->user->identity->name?></p>
    </div>

    <div class="form-group"> <label for="" class="control-label">Фамилия</label>
        <p class="form-control-static"><?=yii::$app->user->identity->username?></p>
    </div>
    <div class="form-group"> <label for="" class="control-label">E-mail</label>
        <p class="form-control-static"><?=yii::$app->user->identity->email?></pE-mail>
    </div>
    <div class="form-group"> <label for="" class="control-label">Телефон</label>
        <p class="form-control-static"><?=yii::$app->user->identity->phone?></p>
    </div>
    <div class="form-group">
        <p class="form-control-static"><a href="/user/profile">Изменить контактную информацию</a></p>
    </div>


</div>
<div class="col-md-6 col-xs-12">
    <?php $adres = \app\modules\shop\models\ShopAdres::find()->where(' userid = '.yii::$app->user->getId().' and isselect = 1 ')->one(); ?>
    <div class="form-group"> <label for="" class="control-label">Адрес доставки</label>
        <p class="form-control-static"><?=$adres->name?><br/><?=$adres->phone?> </p>
        <p class="form-control-static"><?=$adres->post_index?>, <?=$adres->country?><br/> <?=$adres->oblast?>, <?=$adres->town?><br/>ул. <?=$adres->street?>, <?=$adres->house?> <?=$adres->flat?></p>
    </div>
    <div class="form-group">
        <p class="form-control-static"><a href="/shop-delivery/index">Изменить адрес</a></p>
    </div>



</div>
<div style="clear: both"> </div>
<div class="col-md-6 col-xs-12">

</div>


<div class="col-md-6 col-xs-12">
    <div class="form-group">
        <label for="" class="control-label">Варианты доставки внутри страны</label>

        <select name="delivery" id="" class="form-control">
            <option value="Курьер">Курьер</option>
            <option value="Самовывоз">Самовывоз</option>

        </select>
        <!-- <p class="form-control-static text-right"><a href="">Подробнее</a></p>-->
    </div>
</div>


<div class="form-group"> <button type="submit" class="btn btn-default">Далее</button> </div>

</form>

<?php endif; ?>