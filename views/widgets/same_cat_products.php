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


        <li class="item" style="height: 290px;">
            <div class="clearfix">
                <a href="<?=$row['catalog_url']?>" class="lnk_img" title="Neon Buddha Womens Plus-Size Cultural Cowls">
                    <img src="<?=(new app\components\ImageComponent)->adaptive($img[0],270,270);  ?>" width="270" alt="<?=$row['catalog_name']?>" />
                </a>
            </div>
            <a class="product_link noSwipe" href="<?=$row['catalog_url']?>" title="<?=$row['catalog_name']?>"><?=$row['catalog_name']?></a>
            <p class="price_display">
                <span class="price" style="font-size: 12px;">
                    <?=app\modules\shop\models\Curs::price($row['catalog_price'])?>
                     </span>
            </p>
        </li>





 
 
 <?

        $i++;
        } ?>
 
 
             	
			