<?php
    use yii\helpers\Html;
    use app\modules\shop\models\ShopItem;
  //  $items = ShopItem::find()->where([ 'ip'=>$_SERVER['REMOTE_ADDR'] ])->all();
?>

<?php $count = ShopItem::Qty(); ?>
<?php if($count): ?>
<a class="cart" href="/checkout"><img src="/img/icon_cart.png" alt=""><span><?=ShopItem::Qty()?></span></a>
<?php endif; ?>
