<?php
use yii\helpers\Html;
 
 
 if($data)
 	foreach($data as $row)
	{
?>
        <li>            <a href="<?=$row['menu_url']?>"><?=$row['menu_text']?>            </a>        </li>
  <? } ?>
 
 