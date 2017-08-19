<?php
use yii\helpers\Html;
 ?>



<table class="member_auction">


    <tr  >
        <td class="hidden-xs">№</td>
        <td><?=\yii::t('app','Имя')?></td>
        <td><?=\yii::t('app','Дата')?></td>
        <td><?=\yii::t('app','Ставка')?></td>
    </tr>
<?php

 $i=1;
 if($data)
 	foreach($data as $row)
	{

?>

    <tr <?=($i==count($data))?'class="green_tr"':''?>  >
        <td class="hidden-xs"><?=$i?></td>
        <td><?=$row->user->username?></td>
        <td><?=$row->datetime?></td>
        <td><?=$row->price()?></td>
    </tr>
  <? $i++;
    $name=$row->user->username;
    $date=$row->datetime;
    $price=$row->price();
    } ?>
<?php if(!count($data)):?>
    <tr <?=($i==count($data))?'class="green_tr"':''?>  >
        <td colspan="4">
        <?=yii::t('app','Нет участников')?></td>
    </tr>
<?php endif; ?>

</table>
<?php if(count($data)):?>

<p>               <?=\yii::t('app','Информация о торгах обновляется в таблице ежесекундно.')?>
    <?=\yii::t('app','Количество участников')?> - <?=($i-1)?>,<br>
    <?=\yii::t('app','последняя ставка')?> - <?=$price?> <?=\yii::t('app','сделана пользователем')?> <?=$name?> <?=$date?>
</p>
<?php endif; ?>