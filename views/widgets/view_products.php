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



        <li class="item col-xs-4 ">
            <div class="wrapper-hover">
                <a href="<?=$row['catalog_url']?>" title="<?=$row['catalog_name']?>" class="product-image"><img src="<?=(new app\components\ImageComponent)->adaptive($img[0],164,164);  ?>" alt="<?=$row['catalog_name']?>"/></a>
                <div class="product-shop">
                    <h3 class="product-name"><a href="<?=$row['catalog_url']?>" title="<?=$row['catalog_name']?>"><?=$row['catalog_name']?></a></h3>
                    <div class="price-box">
<span class="regular-price" id="product-price-50-new">
<span class="price"><?=$row['catalog_price']?> руб.</span> </span>
                    </div>

                    <div class="actions">
                        <button type="button" title="Добавить в корзину" class="button btn-cart" ><span><span>Добавить в корзину</span></span></button>

                    </div>
                </div>
                <div class="label-product">
                </div>
                <div class="clear"></div>
            </div>
        </li>



        <? //=($i==3)?'<br class="clearBoth"/>':''; ?>
 
 
 <?
        if($i==3)$i=0;
        $i++;
        } ?>
 

			