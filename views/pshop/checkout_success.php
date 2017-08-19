<?php
    use yii\helpers\Html;
    use app\modules\shop\models\ShopItem;
    use app\modules\shop\models\Shop;
    use yii\widgets\ActiveForm;
    #$items = ShopItem::find()->where([ 'ip'=>$_SERVER['REMOTE_ADDR'] ])->all();
?>



<?   // echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>'Оформить заказ' ]] )?>
<div class="categories">
    <div class="container">
        <div class="block_title">
            <h2>Заказ оформлен</h2>
            <div class="clearfix"></div>
        </div>
        <hr>
        <div class="order">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <p><strong>Ваш заказ</strong></p>
                <div class="order-items-wrapper">

  Номер вашего заказа <?=$shop->shop_id?>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
