<?php
use yii\helpers\Html;
 
 
 if($data)
 	foreach($data as $row)
	{

?>




        <li>
            <a href="#" class="select-link" data-id="<?=$row['terms_id']?>"><?=$row['terms_text']?></a>
        </li>




  <? } ?>
 
 