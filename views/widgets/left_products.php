<?php
use yii\helpers\Html;
 ?>



<ul class="products-grid block-content" id="widget-catalogsale-products-8a7db9d09413e0632568f96a3f09bc7f">

        
<?php 
 $i=1;
 if($data)
 	foreach($data as $row)
	{

         $img = app\modules\system\models\Pictures::getImages('catalog',$row['catalog_id']);

?>
        <li class="item">
            <div class="wrapper-hover">
                <a class="product-image" href="<?=$row['catalog_url']?>" title="<?=$row['catalog_name']?>">
                    <img src="<?=(new app\components\ImageComponent)->adaptive($img[0],168,240);  ?>" alt="<?=$row['catalog_name']?> "/></a>
                <div class="product-shop">
                    <p class="product-name"><a href="<?=$row['catalog_url']?>"
                                               title="<?=$row['catalog_name']?>"><?=$row['catalog_name']?> </a></p>
                    <div class="price-box">
                       <?php if($row['catalog_priceold']): ?>
                        <p class="old-price">
                            <span class="price-label">Обычная цена:</span>
                            <span class="price" id="old-price-20-widget-catalogsale-8a7db9d09413e0632568f96a3f09bc7f">
                            <?=$row['catalog_priceold']?> руб. </span>
                        </p>
                        <?php endif; ?>
                        <p class="special-price">
                            <span class="price-label">Special Price</span>
<span class="price" id="product-price-20-widget-catalogsale-8a7db9d09413e0632568f96a3f09bc7f">
<?=$row['catalog_price']?> руб.</span>
                        </p>
                    </div>

                </div>
                <div class="label-product">
                </div>
                <div class="clear"></div>
            </div>
        </li>








 
 
 <?
        if($i==3)$i=0;
        $i++;
        } ?>




</ul>