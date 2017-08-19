<?php
use yii\helpers\Html;
 ?>
 
 
        
<?php 
 
 if($data){ ?>


     <ul class="level0">
 
 <?php
 	foreach($data as $row)
	{
?>
 	
    
 			<li class="level1 nav-5-1 first">
            	 <a  href="<?=$urlPrefix.$row['terms_url']?>" ><span><?=$row['terms_text']?></span></a>
                 
            
            </li>

 <? } ?>
 </ul>
 <? } ?>


   <!-- <li class="level1 nav-5-2 parent"><a href="#"><span>Men</span></a>
        <ul class="level1"><li class="level2 nav-5-2-1 first last"><a href="http://livedemo00.template-help.com/magento_47903/outerwear/men/test-category"><span>Test Category</span></a></li>
        </ul>
    </li>-->

            
  

	 
 

	