<?php
use yii\helpers\Html;
 ?>
 
 
        
<?php 
 
 if($data)
 	foreach($data as $row)
	{
        //$parent = \app\modules\terms\models\Terms::checkParent( $row['terms_id'] );

?>

        <li class="level0 nav-1 level-top <?=(($parent)?'parent':'')?>">
            <a href="<?=$urlPrefix.$row['terms_url']?>" class="level-top">
                <span><?=$row['terms_text']?></span></a>
            <?
                echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'parentid' =>$row['terms_id'] ,'tpl'=>'widgets/view_sub_cats' ,'urlPrefix'=>'/product/']);
            ?>
        </li>










 
 <? } ?>
 
 
             	
			