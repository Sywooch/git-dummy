<?php
use yii\helpers\Html;

$items = $shop->items;
?>



<div class="site-error  center-content" style="height:600px;">
    <p>&nbsp;</p><p>&nbsp;</p>

    <?php if($shop):?>
        <h1><?=yii::t('app','Ваш заказ принят')?>!</h1>
    <?php else:?>
        <h1><?=yii::t('app','Баланс пополнен')?></h1>
    <?php endif; ?>







    <div class="table-responsive">
        <?php if($shop):?>
        <!--<table class="table table-bordered">
            <thead>
            <tr>
                <td class="text-center"><?/*=Yii::t('app','Фото')*/?></td>
                <td class="text-left"><?/*=Yii::t('app','Продукт')*/?></td>

                <td class="text-left"><?/*=Yii::t('app','Кол-во')*/?></td>
                <td class="text-right"><?/*=Yii::t('app','Цена')*/?></td>
                <td class="text-right"><?/*=Yii::t('app','Сумма')*/?></td>
            </tr>
            </thead>
            <tbody>

            <?php
/*            $weight = $sum = 0;
            if (is_array($items)): */?>
                <?php /*foreach($items as $item):

                    $img = app\modules\system\models\Pictures::getImages('catalog',$item->item->catalog_id);
                    $sum= $item->count * $item->price +$sum;
                    $weight = $item->count * $item->mean +$weight;
                    $img = app\modules\system\models\Pictures::getImages('catalog',$item->item->catalog_id);
                    */?>


                    <tr data-id="<?/*=$item->shop_item_id*/?>">
                        <td class="text-center">

                            <a href="<?/*=$item->item->catalog_url*/?>">
                                <img width="80" src="<?/*=(new app\components\ImageComponent)->crop($img[0],70,50);  */?>" class="img-thumbnail"></a>
                        </td>

                        <td class="text-left"><?/*=$item->item->catalog_name*/?></td>
                        <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                                <input type="number" value="<?/*=$item->count*/?>" size="1" class="form-control">
                        <span class="input-group-btn">
                        <button type="button" data-id="<?/*=$item->shop_item_id*/?>" data-toggle="tooltip" title="" class="change-count btn button-green" data-original-title="Update"><i class="fa fa-refresh"></i></button>
                        <button type="button" data-toggle="tooltip" title="" class="del-btn btn btn-danger" data-original-title="Remove"><i class="fa fa-times-circle"></i></button></span>
                            </div></td>
                        <td class="text-right"><?/*=\app\modules\system\models\Course::getPrice($item->price)*/?></td>
                        <td class="text-right"><?/*=\app\modules\system\models\Course::getPrice($item->count*$item->price)*/?></td>
                    </tr>




                <?php /*endforeach; */?>
            <?php /*endif; */?>


            </tbody>
        </table>
        <h1>Заказ оформлен</h1>-->
        <?php endif; ?>

          <p>
              <?=$msg?>
          </p>

    </div>



    <br>
    <br>
    <br> <br>
    <br> <br>
    <br>  <br><br>
</div>
