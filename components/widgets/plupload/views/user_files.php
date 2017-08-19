

<?php 

 

use app\components\ImageComponent ;

$i=1;
if(is_array($files))
{
	echo '<ul id="sortable">';	
	 foreach($files as $file){

	?>
  
    
   <li class="list-inline"  style="float:left; padding-right:10px;"  data-id="<?=$file['id']?>"  > 
   <button type="button" class="close uploaded_delete" data-id="<?=$file['id']?>" style="margin-left:-22px;" >&times;</button>
   <a href="/system/images/update?id=<?=$file['id']?>" class="close various fancybox.ajax" data-fancybox-type="ajax" style=" margin-top:12px; margin-left:-12px;"   ><span class="glyphicon glyphicon-pencil" style="font-size:12px;"></span></a>
   
   <a href="/system/images/crop?id=<?=$file['id']?>" class="close various fancybox.ajax" data-fancybox-type="ajax" style=" margin-top:28px; margin-left:-12px;"   ><span class="glyphicon glyphicon-fullscreen" style="font-size:12px;"></span></a>
    
<span class="glyphicon glyphicon-chevron-left" style="cursor:pointer"></span>
<img src="<?=(new app\components\ImageComponent)->adaptive($file,140,140);  ?>" class="img-thumbnail plupload_Image_delete" data-id="<?=$file['id']?>"  />
<span class="glyphicon glyphicon-chevron-right" style="cursor:pointer"></span> 
 
 </li>
    
    
   
  


<?php  	$i++; } 
  echo '</ul>';
}?>

 


<div style="clear:both"></div>
<div id="filelist"  >Your browser doesn't have Flash, Silverlight or HTML5 support.</div>


<div id="container">
	<button type="button" class="btn btn-success" id="pickfiles"><?= Yii::t('admin', 'Добавить файлы') ?></button>
    <button type="button" class="btn btn-warning" id="uploadfiles"><?= Yii::t('admin', 'Закачать') ?></button>
     
</div>
 
<pre id="console" style="display:none"></pre>

 <br/>