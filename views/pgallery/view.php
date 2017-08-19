
<?php
    $images = app\modules\system\models\Pictures::getImages('gallery',$data->gallery_id); ?>

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
                             Галерея - <?=$data->gallery_name?>
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

                         <?php for($i=0;$i<count($images);$i++):?>
                             <div class="catItemImageBlock" style="width:285px; height:174px; ;float: left;<?=($i%2==0)?'padding-right: 20px;':''?>">
			                	<span class="catItemImage">
											<a class="touch" href="<?=(new app\components\ImageComponent)->adaptive($images[$i],1024,1024);  ?>" >
                                                <img height="174" width="285"  style="visibility: visible; opacity: 1;" src="<?=(new app\components\ImageComponent)->crop($images[$i],285,174);  ?>">
                                                <span style="opacity: 0; top: -50%;" class="zoomIcon"></span>
                                                <strong></strong></a>
								 </span>
                                 <div class="clr"></div>
                             </div>
                         <?php endfor;?>




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
