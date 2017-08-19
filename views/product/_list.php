<?php
    use yii\helpers\Html;
    use yii\helpers\BaseUrl;
?>








<?php
    foreach($models as $model):
    $img = app\modules\system\models\Pictures::getImages('catalog',$model['catalog_id']);
    ?>


    <a href="<?=$model['catalog_url']?>"  class="item">
        <img  width="321" height="221" src="<?=(new app\components\ImageComponent)->adaptive($img[0],321,221);  ?>">
        <div class="<?=$model->getBonus()?>"></div>
        <div class="item_content">
            <div class="name_item">
        <?php if((int)$model->hot>50):?>
                <img src="/verst/img/fire_icon.png">
        <?php endif; ?><span><?=$model->getName(25)?></span>
            </div>
            <span class="hideon1200px"><?=$model->terms->terms_text?></span>
                                        <span class="item_description">
                                                <?=$model->getShortPreview()?>
                                        </span>
            <?php $bits = \app\models\Bits::getInfo($model->catalog_id);?>
            <div class="done-range">
                <div class="done-range-progressbar" style="width:<?=$bits['persent']?>% "></div>
            </div>
            <div class="item_info clearfix">

                <div>
                    <span><?=$bits['persent']?>%</span>
                    <span><?=yii::t('app','cобрано')?></span>
                </div>
                <div>
                    <span><?=$model->getPrice()?></span>
                    <span><?=yii::t('app','цена')?></span>
                </div>
                <div>
                    <span><?=$model->priceStep()?></span>
                    <span><?=yii::t('app','купить за')?></span>
                </div>
            </div>
        </div>
    </a>

    <?php endforeach;?>


