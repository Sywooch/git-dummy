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


        <div class="item">
            <div class="prod1">
                <div class="ft-img-s1">
                    <div><img width="270" height="236" src="
                     <?=($row['iszoomer'])?(new app\components\ImageComponent)->crop($img[0],270,236):(new app\components\ImageComponent)->adaptive($img[0],270,236);  ?>
                     " alt=""></div>
                </div>
                <div class="tit1"><?=$row->getName(50)?></div>
                <a href="<?=$row['catalog_url']?>"></a>
            </div>
        </div>



        
        




        <? //=($i==3)?'<br class="clearBoth"/>':''; ?>
 
 
 <?
        if($i==3)$i=0;
        $i++;
        } ?>
 

			