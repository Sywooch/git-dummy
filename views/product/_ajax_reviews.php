<?php
use yii\helpers\Html;
?>
<?php


    $Month_r = array(
        "01" => yii::t('app',"января"),
        "02" => yii::t('app',"февраля"),
        "03" => yii::t('app',"марта"),
        "04" => yii::t('app',"апреля"),
        "05" => yii::t('app',"мая"),
        "06" => yii::t('app',"июня"),
        "07" => yii::t('app',"июля"),
        "08" => yii::t('app',"августа"),
        "09" => yii::t('app',"сентября"),
        "10" => yii::t('app',"октября"),
        "11" => yii::t('app',"ноября"),
        "12" => yii::t('app',"декабря")
    );




 ?>

<div class="post2">
    <div class="ll1">
        <p><?=$com->user->place?>, <?=date("d",strtotime($com->comment_time))?> <?=$Month_r[date("m",strtotime($com->comment_time))]?> <?=date("Y",strtotime($com->comment_time))?></p>
        <div>
            <p><?=$com->comment?></p>
        </div>
    </div>
    <div class="rr1">
        <div class="item1"><div class="dc"><div class="dc1">
                    <?php    $img = app\modules\system\models\Pictures::getImages('user',$com->userid); ?>
                    <?php    $file=(new app\components\ImageComponent)->crop($img[0],112,112);  ?>
                    <img src="<?=($file != 'no thound file' )?$file:'/verst/img/n1.png'?>" alt=""></div></div></div>
        <div class="item1"><div class="dc"><div class="dc1"><?=$com->user->username?></div></div></div>
        <div class="item1">
            <div class="dc"><div class="dc1"><div class="prc1"><span> <?=\app\modules\system\models\Course::getPrice($com->codeindex*$bit_step)?></span><?=yii::t('app','потратил')?></div></div></div>
        </div>
    </div>
</div>
