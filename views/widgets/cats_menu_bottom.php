<?php
use yii\helpers\Html;
 
 $i=0;
 if($data)
 	foreach($data as $row)
	{

?>
        <li class="<?=($i>5)?'showhide-li hide-cat':''?>">
            <a href="/product/<?=$row['terms_url']?>"><?=$row['terms_text']?></a>
        </li>

  <? $i++; } ?>
 
 