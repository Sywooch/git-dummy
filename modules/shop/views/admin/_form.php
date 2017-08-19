<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use app\modules\shop\models\ShopItem;
    use app\modules\shop\models\Shop;



  $form = ActiveForm::begin(); ?>
<h1>Заказ номер <?=$model->shop_id?></h1>

<legend>Информация о получателе</legend>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'fio')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
    </div>

</div>

<legend>Адрес доставки</legend>
<div class="row">
    <div class="col-md-4"><?= $form->field($model, 'country')->textInput(['maxlength' => 255]) ?></div>
  <!--  <div class="col-md-4"><?/*= $form->field($model, 'obl')->textInput(['maxlength' => 255]) */?></div>
    <div class="col-md-4"><?/*= $form->field($model, 'town')->textInput(['maxlength' => 255]) */?></div>-->
    <div class="col-md-4"><?= $form->field($model, 'index')->textInput(['maxlength' => 255]) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'adres')->textInput(['maxlength' => 255]) ?></div>
</div>

<!--<legend>Оплата и доставка</legend>
<div class="row">
    <div class="col-md-4"><?/*= $form->field($model, 'shoppayid')->textInput(['maxlength' => 255]) */?></div>
    <div class="col-md-4"><?/*= $form->field($model, 'delivery')->textInput(['maxlength' => 255]) */?></div>
</div>-->



<div class="row">
    <div class="col-md-4"><?= $form->field($model, 'shopcatid')->dropDownList(\app\modules\terms\models\Terms::dropDown(14)) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'message')->textarea() ?></div>
</div>

<legend>Товары заказа</legend>




                    <?php if(count($model->items)):?>
                        <table id="cart_summary" class="table table-striped">
                            <thead>
                            </thead>

                            <tbody>

                            <?php
                                $items = $model->items;

                                $sum = $count = 0;
                                if (is_array($items)): ?>
                                    <?php foreach($items as $item):
                                        $img = app\modules\system\models\Pictures::getImages('catalog',$item->item->catalog_id);
                                        $sum= $item->count * $item->price +$sum;
                                        $count=  $item->count  +$count;            ?>

                                        <tr data-id="<?=$item->shop_item_id?>">
                                            <td>
                                                <a class="product_link" href="<?=$item->item->catalog_url?>"><?=$item->item->catalog_name?></a>
                                            </td>

                                            <td>
                                                <?php if($item->colorid):?>
                                                    <?=$item->color->terms_text?>
                                                <?php else: ?>
                                                    <?=$item->size->terms_text?>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?=$item->count?> шт
                                            </td>

                                            <td>
                                                <?=$item->price?> $
                                            </td>

                                            <td>
                                                <?=$item->price*$item->count?> $
                                            </td>
                                            <td>
                                                <?=Html::a('Возврат', '/shop/admin/cancel-one?id='.$item->shop_item_id, [
                                                    'title' => Yii::t('yii', 'Cancel'),
                                                ]);?>
                                            </td>




                                        </tr>

                                    <?php endforeach; ?>
                                <?php endif; ?>









                            <tr class="cart_total_price ">
                                <td colspan="4" style="text-align: right">Итого </td>
                                <td class="price" id="total_product"><?=$sum?> $</td>
                            </tr>




                            </tbody>

                        </table>
                    <?php endif; ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>



<?php
Yii::$app->view->registerJs('

$(".statusid").change(function(){
var el=$(this),
    status=el.val(),
    id=el.parent("td").parent("tr").data("id");

$.ajax({
    url: "/shop/admin/changestatusitem?id="+id+"&status="+status,
    success: function(data) {}
    })
});

');