<?php
use yii\helpers\Html;
 ?>
 
 

<?php 
 
 if($data)
 	foreach($data as $row)
	{
?>


        <li class="even">
            <div class="moduleItemIntrotext">
                <span class="moduleItemDateCreated"><?=$row['news_date']?></span>
                <h5><a class="moduleItemTitle" href="<?=$row['news_url']?>"><?=$row['news_name']?></a></h5>
                <?=$row['news_preview']?>
            </div>
            <div class="clr"></div>
            <div class="clr"></div>




            <div class="clr"></div>
        </li>

 
 
 
 <? } ?>
