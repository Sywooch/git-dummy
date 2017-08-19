<?php
use yii\helpers\Html;
    use yii\helpers\Url;
 ?>






<?php

$i=1;
if($data):
    $messa=\app\modules\system\models\Notice::Activity(1);
    $activ=\app\modules\system\models\Notice::Activity(2);
    $bal=\app\modules\system\models\Notice::LowBalance(0);
    $adres=\app\modules\system\models\Notice::emptyAdres(0);
    $order=\app\modules\system\models\Notice::newOrder(0);
?>


    <div class="ac1">

        <div class="curr1 <?php
            if($order)    echo ($order)?' j3':'';
            if($messa)   echo ($messa)?' j'.$messa:'';
            if(!$messa)  echo ($activ)?' j'.$activ:'';
            if(!$activ)  echo ($bal)?' j'.$bal:'';
            if(!$bal)    echo ($adres)?' j'.$adres:'';


        ?>" dt="0"><div></div><?=Yii::t('app', 'Баланс')?> – <?=($data->balance)?\app\modules\system\models\Course::getPrice($data->balance):(\app\modules\system\models\Course::getName().'0.0')?>
            <?php if($data->bonus):?>
                <span>+<?=$data->bonus?></span>
            <?php endif;?>
        </div>



        <ul>

            <li><a class="j1 <?=($activ)?'active ':''?>" href="/activity"><span><span class="<?='pmi'.$activ?>"></span></span><?=Yii::t('app', 'Активность')?></a></li>

            <li><a class="j2 <?=($messa)?'active ':''?>" href="/message"><span><span class="<?='pmi'.$messa?>"></span></span><?=Yii::t('app', 'Сообщения')?></a></li>

            <li><a class="j3 <?=($adres)?'active ':''?>" href="/user/profile"><span><span class="<?='pmi'.$adres?>"></span></span><?=Yii::t('app', 'Профиль')?></a></li>

            <li><a class="j4 <?=($bal)?'active ':''?>" href="/balance"><span><span class="<?='pmi'.$bal?>"></span></span><?=Yii::t('app', 'Баланс')?></a></li>

            <li><a class="j6 <?=($order)?'active ':''?>" href="/basket-history"><span><span class="<?='pmi'.$order?>"></span></span><?=Yii::t('app', 'Мои заказы')?></a></li>

            <li><a class="j5" href="/user/logout"><span><span></span></span><?=Yii::t('app', 'Выход')?></a></li>

        </ul>

    </div>



<?php else:?>
    <a href="/user/registration" class="att2 j1"><?=Yii::t('app', 'регистрация')?></a>

    <a href="/user/login" class="att1 j1"><?=Yii::t('app', 'авторизация')?></a>
<?php endif; 	 ?>


