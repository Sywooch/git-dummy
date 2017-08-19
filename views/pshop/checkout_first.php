<?php
    use yii\helpers\Html;
    use app\modules\shop\models\ShopItem;
    use app\modules\shop\models\Shop;
    use yii\widgets\ActiveForm;
    $items = ShopItem::find()->where([ 'ip'=>$_SERVER['REMOTE_ADDR'] ])->all();
?>


<?   // echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>'Оформить заказ' ]] )?>


<div class="categories">
    <div class="container">
        <div class="block_title">
            <h2>Корзина</h2>
            <div class="clearfix"></div>
        </div>
        <hr>
        <div class="cart">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p class="text-right"><a href="?delete=all">Очистить корзину</a></p>
                <div class="order-items-wrapper">
                    <div class="order-items">
                        <table class="table ">
                            <tbody>
                            <?php
                                $count=$weight = $sum = 0;
                                if (is_array($items)): ?>
                                    <?php foreach($items as $item):
                                        $img = app\modules\system\models\Pictures::getImages('catalog',$item->item->catalog_id);
                                        $sum= $item->count * $item->price +$sum;
                                        $weight = $item->count * $item->mean +$weight;
                                        $count=$item->count+$count;
                                        ?>


                                        <tr data-id="<?=$item->shop_item_id?>">
                                            <td class="" style="width: 160px">
                                                <a href="<?=$item->item->catalog_url?>"><img src="<?=(new app\components\ImageComponent)->crop( app\modules\system\models\Pictures::findOne($item->itemid),121,121);  ?>" alt=""></a>
                                            </td>
                                            <td>
                                                <div class="row"> <span> <p><?=$item->item->catalog_name_en?></p> </span> </div>
                                                <div class="row hidden-xs">
                                                    <p><?=$item->item->catalog_name?></p>
                                                </div>


                                                <div class="row hidden-xs view<?=$item->shop_item_id?>" >
                                                    <?php if($item->colorid ) : ?>
                                                        <p><span>Цвет: </span><?=$item->color->terms_text?></p>
                                                    <?php endif; ?>

                                                    <?php if($item->mean ) : ?>
                                                        <p><span>Объем: </span><?=$item->mean?> мл</p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="row hidden-xs on-edit<?=$item->shop_item_id?>"  style="display: none">
                                                    <?php if(count($item->item->color)):?>
                                                        <select name="" class="makeMeFancy color<?=$item->shop_item_id?>">
                                                            <?php foreach($item->item->color as $color): ?>
                                                                <option value="<?=$color->terms->terms_id?>"
                                                                        data-icon="<?=$color->terms->getImage([22,22])?>"
                                                                        data-html-text="<?=$color->terms->terms_text?>"><?=$color->terms->terms_text?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php else:?>
                                                        <div style="padding-bottom: 5px;">
                                                            <?php $prices=$item->item->price;
                                                                foreach($prices as $price):?>
                                                                    <button  class="weight<?=$item->shop_item_id?> ml_button" value="<?=$price->mean?>"><?=$price->mean?> ml</button>
                                                                <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="counter">
                                                    <span class="plus"><img src="/images/ar_top.png"></span>

                                                    <input class=" change-count count<?=$item->shop_item_id?>" style="width: 50px;" type="text" value="<?=$item->count?>" size="5">
                                                    <span class="minus"><img src="/images/ar_down.png"></span>

                                                </div>

                                                  </td>
                                            <td class="price hidden-xs"> <span>Цена</span>
                                                <p><?=$item->item->getPriceValue()?></p>
                                            </td>
                                            <td class="all-price"> <span>Сумма</span>
                                                <p><strong><?=$item->item->returnFormatPrice($item->count*$item->price)?></strong></p>
                                            </td>
                                            <td class="action hidden-xs" style="width: 30px;"> <a href="#" data-id="<?=$item->shop_item_id?>" class="edit-btn"><span class="glyphicon glyphicon-pencil"></span></a> </td>
                                            <td class="action" > <a class="del-btn" href="#" class="del-btn"><span class="glyphicon glyphicon-trash"></span></a> </td>
                                        </tr>






                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <hr>
                    <div class="row summury">
                        <div class="col-sm-3 col-xs-12"> <a href="">Добавить комментарий к заказу</a> </div>
                        <div class="col-sm-5 col-xs-12">
                            <p class="text-right all-count"><strong>Всего <?=$count?> шт.</strong></p>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <p class="">Промокод или номер подарочного сертификата</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- if success -->
                                <div class="form-group promocode"> <input type="text" class="form-control error">
                                    <!-- if success  add class [glyphicon glyphicon-ok]-->
                                    <!-- else -->
                                    <!-- addclass [glyphicon glyphicon-remove] --><i class="glyphicon glyphicon-remove"></i> </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <table class="table">
                                <tr>
                                    <td class="text-right">Итого</td>
                                    <td><strong><?=\yii::$app->currency->getPrice($sum)?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Доставка</td>
                                    <td><strong><?=\yii::$app->currency->getPrice($deliver=\app\modules\shop\models\Shop::delivery( $weight ))?></strong></td>
                                </tr>
                                <!--<tr class="discount">
                                    <td class="text-right">Скидка</td>
                                    <td><strong>-10 500 тг.</strong></td>
                                </tr>-->
                                <tfoot>
                                <tr>
                                    <td class="text-right"><strong>К оплате</strong></td>
                                    <td><strong><?=\yii::$app->currency->getPrice($sum+$deliver)?></strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12 col-xs-offset-0 col-sm-offset-4 text-right"> <a href="/">Продолжить покупки</a> </div>
                        <div class="col-sm-4 col-xs-12 pull-right"> <button class="btn btn-default" onclick="window.location='/checkout-end'">Оформить заказ</button> </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>


