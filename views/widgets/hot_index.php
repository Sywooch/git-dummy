<?php
use yii\helpers\Html;
 ?>
 
 
        
<?php 
 $item=0;
 if($data)
 	foreach($data as $row)
	{

         $img = app\modules\system\models\Pictures::getImages('catalog',$row['catalog_id']);
\yii::$app->params['hot'][]=$row['catalog_id'];
?>


        <div href="<?=$row['catalog_url']?>" class="item <?=(($item%3)==0 ? ' first_item': '')?>">
            <a href="<?=$row['catalog_url']?>" >
            <div class="<?=$row->getBonus()?>"></div>
            <div class="main-item-image-wrapp">
                <img width="320" height="355" class="item_image" src="
                <?=($row['iszoomer'])?(new app\components\ImageComponent)->crop($img[0],320,355):(new app\components\ImageComponent)->adaptive($img[0],320,355);  ?>                  ">
            </div>
            </a>

            <div class="item_preview">
                <div class="item-preview-wrapp item-preview-slider">
                    <?php for($i=0;$i<3 ;$i++):
                        if(isset($img[$i])):?>
                            <img class="<?=(($i==0)?'green_prev':'white_prev')?>"
                                 data-img="<?=($row['iszoomer'])?(new app\components\ImageComponent)->crop($img[$i],320,355):(new app\components\ImageComponent)->adaptive($img[$i],320,355);  ?>
                                 <?/*=(new app\components\ImageComponent)->adaptive($img[$i],320,355);  */?>"
                                 src="<?=($row['iszoomer'])?(new app\components\ImageComponent)->crop($img[$i],90,55):(new app\components\ImageComponent)->adaptive($img[$i],90,55);  ?>
                                 <?/*=(new app\components\ImageComponent)->crop($img[$i],90,55);  */?>">
                        <?php endif; endfor; ?>
                </div>
            </div>


            <a href="<?=$row['catalog_url']?>" >
                <div class="item_content">
                    <div class="name_item">
                        <?php if($row['hot']>50 || $row->persentToEnd()>=80):?><img src="/img/fire_icon.png"><?php endif; ?>
                        <span><?=$row->getName(34)?></span>
                    </div>
                    <span><?=$row->terms->terms_text?></span>
                    <?php $bits = \app\models\Bits::getInfo($row->catalog_id);?>
                    <div class="done-range">
                        <div class="done-range-progressbar" style="width:<?=$row->persentToEnd()?>% "></div>
                    </div>
            <?=$this->render('../bottom_preview',['row'=>$row])?>
                </div>
</a>


        </div>



 
 <?  $item++; } ?>
 

			