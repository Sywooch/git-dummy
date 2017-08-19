<?php
use yii\helpers\Html;
 
 
 if($data)
 	foreach($data as $row)
	{
?>


        <li class="item"><a   href="<?=$row['menu_url']?>"               ><?=$row['menu_text']?></a></li>


  <? } ?>
 
 