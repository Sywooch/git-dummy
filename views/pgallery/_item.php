 



<? $data = app\modules\system\models\Pictures::getImages('gallery',$model->gallery_id); ?>
 
  
        
        
            
 
     <div class="gallery_item" style="overflow:hidden">
            <a href="<?=(new app\components\ImageComponent)->adaptive($data[0],1024,768);  ?>" class=" various">  <img src="<?=(new app\components\ImageComponent)->crop($data[0],250,390);  ?>" alt="<?=$model->gallery_name?>" height="250" title="<?=$model->gallery_name?>" ></a>     
             
            </div>