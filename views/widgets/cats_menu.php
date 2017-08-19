<?php
use yii\helpers\Html;

    $terms = \app\modules\terms\models\Terms::getId(\yii::$app->request->get('url'), 1);

    if($terms->terms_parent !=0)
    {
        $url = $terms->parent->terms_url;
    }else{
        $url = \yii::$app->request->get('url');
    }
 if($data)
 	foreach($data as $row)
	{

?>




        <li <?=( $url ==$row['terms_url'])?'class="active"':''?>>

            <a href="/product/<?=$row['terms_url']?>"><?=$row['terms_text']?></a>
            <?php if($submenu /*&& \yii::$app->request->get('url') ==$row['terms_url']*/ ): ?>
            <ul>
                <?

                    echo  \app\modules\menu\widgets\cats\CatsWidget::widget(['tpl'=>'widgets/cats_menu', 'parent'=> $row['terms_id'] ]);

                ?>
            </ul>
            <?php endif; ?>
        </li>




  <? } ?>
 
 