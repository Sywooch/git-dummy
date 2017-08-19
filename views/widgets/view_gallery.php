<?php
use yii\helpers\Html;
 ?>



                        <?php

                            if($data)
                                foreach($data as $row)
                                {
                                    ?>
                                    <? $image = app\modules\system\models\Pictures::getImages('gallery',$row['gallery_id']); ?>


                                    <li>
                                        <div class="slide-img-wrap">
                                            <div class="slide-img-inner">
                                                <img src="<? if($image[0]) echo (new app\components\ImageComponent)->adaptive($image[0]);  ?>" alt="">
                                            </div>
                                        </div>

                                        <div class="slide_content">
                                            <?=$row['gallery_text']?>
                                            <a href="<?=$row['gallery_url']?>"><?=\yii::t('app','КУПИТЕ ПРЯМО СЕЙЧАС!')?></a>
                                        </div>
                                    </li>




<!--
                                    <div class="gallery_item" style="overflow:hidden">
                                        <img src="<?/* if($image[0]) echo (new app\components\ImageComponent)->crop($image[0],390,250);  */?>" width="390" height="250" alt="">
                                        <div class="gallery_caption">
                                            <div class="gallery_title color2"><?/*=$row['gallery_name']*/?></div>
                                            <?/*=$row['gallery_text']*/?>
                                            <a href="/gallery/<?/*=$row['gallery_url']*/?>" class="btn">подробнее</a>
                                        </div>
                                    </div>-->






                                <? } ?>





 
