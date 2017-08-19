

<?php 

 

use app\components\ImageComponent ;

$i=1;
if(is_array($files))
{
	echo '<ul id="sortable">';	
	 foreach($files as $file){

	?>
  
    
   <li class="list-inline"  style="float:left; padding-right:10px;"  data-id="<?=$file['id']?>"  > 


<span class="glyphicon glyphicon-chevron-left" style="cursor:pointer"></span>
<img height="140" width="140" src="<?=(new app\components\ImageComponent)->adaptive($file,140,140);  ?>" class="plupload_Image_delete" data-id="<?=$file['id']?>"  />
<span class="glyphicon glyphicon-chevron-right" style="cursor:pointer"></span>

       <div style="padding-left: 20px; padding-right: 20px;">


           <a href="/system/images/crop?id=<?=$file['id']?>&cid=<?=$_GET['id']?>" title="Вырезать миниатюры" class="close various fancybox.ajax" data-fancybox-type="ajax"   >
               <span class="glyphicon glyphicon-fullscreen" style="font-size:13px; padding: 8px; padding-right: 0px;"></span></a>

           <!--<a href="/system/images/update?id=<?/*=$file['id']*/?>" title="Метка что фото используется в слайдере" class="close various fancybox.ajax" data-fancybox-type="ajax"    >
               <span class="glyphicon glyphicon-pencil" style="font-size:13px; padding: 8px; padding-right: 0px;"></span></a>-->


         <a href="/system/images/slider?id=<?=$file['id']?>"  title="Метка что фото используется в слайдере" class="slider <?=$file['isslider']?'':'close'?>  "   >
             <span class="glyphicon glyphicon-facetime-video" style="font-size:13px; padding: 8px; padding-right: 0px;"></span></a>

           <button type="button" class="close uploaded_delete" data-id="<?=$file['id']?>"  alt="Удалить" title="Удалить" style="font-size: 30px; padding: 0px;" >&times;</button>


       </div>

 </li>
    
    
   
  


<?php  	$i++; } 
  echo '</ul>';
}?>






<div style="clear:both"></div>
<div>
    <?php if(isset($_POST['Pictures']) && is_array($_POST['Pictures'])):
        foreach($_POST['Pictures'] as $id=>$hash):
            $file=(new \yii\db\Query())->from('image')->where([ 'hash_code' => $hash])->one();?>
            <div class="alert alert-success" id="o_<?=$hash?>"><?=$file['filename']?> (<?=ceil($file['byteSize']/1000)?> kb) <b><span>100%</span>
                    <input name="Pictures[<?=$id?>]" value="<?=$hash?>" type="hidden"></b>
                <button type="button" class="close plupload_added_close" data-dismiss="alert" aria-hidden="true" data-file="o_<?=$hash?>">×</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div id="filelist"  >

    Your browser doesn't have Flash, Silverlight or HTML5 support.
</div>


<div id="container">
	<button type="button" class="btn btn-success" id="pickfiles"><?= Yii::t('admin', 'Добавить файлы') ?></button>
    <button type="button" class="btn btn-warning" id="uploadfiles"><?= Yii::t('admin', 'Закачать') ?></button>
     
</div>
 
<pre id="console" style="display:none"></pre>

 <br/>