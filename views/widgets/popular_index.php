<?php
use yii\helpers\Html;
 ?>
 
 
        
<?php 
 $i=1;
 if($data)
 	foreach($data as $row)
	{

         $img = app\modules\system\models\Pictures::getImages('catalog',$row['catalog_id']);

?>


        <a href="<?=$row['catalog_url']?>"  class="item">
            <img   src="<?=($row['iszoomer'])?(new app\components\ImageComponent)->crop($img[0],321,221):(new app\components\ImageComponent)->adaptive($img[0],321,221);  ?>">
            <div class="<?=$row->getBonus()?>"></div>
            <div class="item_content">
                <div class="name_item">
                    <?php if((int)$row->hot>50 || $row->persentToEnd()>=80):?>
        <img src="/verst/img/fire_icon.png">
        <?php endif; ?>
        <span><?=$row->getName(35)?></span>
                </div>
                <span class="hideon1200px"><?=$row->terms->terms_text?></span>
                                        <span class="item_description">
                                                <?=$row->getShortPreview()?>
                                        </span>
                <?php $bits = \app\models\Bits::getInfo($row->catalog_id);?>
                <div class="done-range">
                    <div class="done-range-progressbar" style="width:<?=$row->persentToEnd()?>% "></div>
                </div>


                <?=$this->render('../bottom_preview',['row'=>$row])?>


              <!--  <div class="item_info clearfix">

                    <div>
                        <span><?/*=$row->persentToEnd()*/?>%</span>
                        <span><?/*=yii::t('app','прогресс')*/?></span>
                    </div>

                    <div>
                        <span><?/*=$row->getPrice()*/?></span>
                        <span><?/*=yii::t('app','купить за')*/?></span>
                    </div>

                    <div>
                        <span><?/*=$row->priceStep()*/?></span>
                        <span><?/*=yii::t('app','цена')*/?></span>
                    </div>
                </div>-->
            </div>
        </a>



 <?   } ?>
 

			