 



<?

    $img = app\modules\system\models\Pictures::getImages('catalog',$model->catalog_id); ?>




<div class="x3box m-b-50">
    <div class="catalog-item">
        <a class="catalog-item-img" href="<?=$model->catalog_url?>">
            <img    src="
             <?=($model->iszoomer)?(new app\components\ImageComponent)->crop($img[0],321,221):(new app\components\ImageComponent)->adaptive($img[0],321,221);  ?>
             " alt="">
        </a>
        <div class="<?=$model->getBonus()?>"></div>
        <div class="item_content">
            <div class="name_item">
                <a href="<?=$model->catalog_url?>">
                    <?php if($model->hot>50 || $model->persentToEnd()>=80):?>
                        <img src="/verst/img/fire_icon.png" alt="">
                    <?php endif; ?>
                    <span><?=$model->getName(34)?></span></a>
            </div>

            <span><a href="/product/<?=$model->terms->terms_url?>"><?=$model->terms->terms_text?></a></span>
                        <span class="item_description">
                               <?=$model->getShortPreview()?>
                        </span>
            <?php $bits = \app\models\Bits::getInfo($model->catalog_id);?>
            <div class="done-range">
                <div class="done-range-progressbar" style="width:<?=$model->persentToEnd()?>% "></div>
            </div>
            <?=$this->render('../bottom_preview',['row'=>$model])?>
        </div>
    </div>
</div>



 