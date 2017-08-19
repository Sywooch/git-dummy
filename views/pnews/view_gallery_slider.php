<?php
use yii\helpers\Html;
 ?>



<div class="rt-grid-8 ">
    <div class="rt-block">
        <div id="rt-mainbody">
            <div class="component-content">
                <!-- Start K2 Item Layout -->
                <span id="startOfPageId82"></span>
                <div id="k2Container" class="itemView">
                    <!-- Plugins: BeforeDisplay -->
                    <!-- K2 Plugins: K2BeforeDisplay -->
                    <!-- Item Header START -->
                    <div class="itemHeader">
                        <!-- Item title -->
                        <h2 class="itemTitle">
                            Галерея
                        </h2>
                        <!-- Item Rating -->
                        <!-- Item Author -->
                        <!-- Item category -->
                        <!-- Date created -->
                        <!-- Anchor link to comments below - if enabled -->
                    </div>
                    <!-- Item Header END -->
                    <!-- Plugins: AfterDisplayTitle -->
                    <!-- K2 Plugins: K2AfterDisplayTitle -->
                    <!-- Item Body START-->
                    <div class="itemBody" id="port">




                        <?php

                            if($data)
                                foreach($data as $row)
                                {
                                    ?>
                                    <? $image = app\modules\system\models\Pictures::getImages('gallery',$row['gallery_id']); ?>



                                    <div class="catItemView groupLeading port">
                                        <!-- Plugins: BeforeDisplay -->
                                        <!-- K2 Plugins: K2BeforeDisplay -->
                                        <!-- Item Image -->
                                        <div class="catItemImageBlock"  style="padding-right: 20px;">
				<span class="catItemImage">

                                                <img width="200" style="visibility: visible; opacity: 1;" src="https://staticlivedemo00-templatemonster.netdna-ssl.com/joomla_45309/media/k2/items/cache/4965657af186b9092c7a96976ffe881c_M.jpg" alt="Curabitur interdum euismod">
                                                <span style="opacity: 0; top: -50%;" class="zoomIcon"></span>
                                                <strong></strong>
									</span>
                                            <div class="clr"></div>
                                        </div>
                                        <div class="item_container">
                                            <!--Item Header - START -->
                                            <div class="catItemHeader">
                                                <!-- Item title -->
                                                <h3 class="catItemTitle">
                                                    <?=$row['gallery_name']?>
                                                </h3>


                                            </div>
                                            <div class="catItemBody">
                                                <div class="catItemIntroText">
                                                    <div class="catItemReadMore">
                                                        <a class="k2ReadMore" href="/gallery/<?=$row['gallery_url']?>"><strong></strong><span>Подробнее					</span></a>
                                                    </div>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <!--Item body - END -->


                                        </div>
                                        <div class="clr"></div>
                                    </div>

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



                        <div class="clr"></div>
                    </div>
                    <!-- Item Body END-->
                    <!-- Item Social Buttons -->
                    <!-- Social sharing -->
                    <div class="clr"></div>
                    <!-- Plugins: AfterDisplay -->
                    <!-- K2 Plugins: K2AfterDisplay -->
                    <div class="itemBackToTop">
                        <a class="k2Anchor" href="/images/#startOfPageId82">
                            back to top			</a>
                    </div>
                    <div class="clr"></div>
                </div>
                <!-- End K2 Item Layout -->
                <!-- JoomlaWorks "K2" (v2.6.6) | Learn more about K2 at http://getk2.org -->
            </div>
        </div>
    </div>
</div>

 
