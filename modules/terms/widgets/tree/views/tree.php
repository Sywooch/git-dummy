<?php 
use yii\helpers\Html;

 
	 
	
	foreach( $data as $term){ 
 ?>
 	   <div class="alert alert-warning" role="alert" style="padding:5px; margin:2px; margin-left:<?=$offset?>px ">
        	<?



echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-remove"></span>'), ['default/delete','id'=>$term->terms_id,'parent'=>$term->terms_id], 
					[
						'class'=>'close various fancybox.ajax', 
						'data-fancybox-type'=>"ajax",
						"data-dismiss"=>"alert", 
						"aria-hidden"=>"true" , 
						'data-confirm'=>Yii::t('admin',"Вы уверены, что хотите удалить этот элемент?") 
					]) ;
					
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-pencil"></span>'), ['default/update','id'=>$term->terms_id], 
					[
						'class'=>'close various fancybox.ajax' , 
						'data-fancybox-type'=>"ajax"
					]) ;
					
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-tree-conifer"></span>'), ['default/create','parent'=>$term->terms_id], 
					[
						'class'=>'close various fancybox.ajax', 
						'data-fancybox-type'=>"ajax" 
					]) ;
	 		
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon glyphicon-'.(($term->terms_public == 1)?'ok':'remove').'-sign"></span>'),'#', 
					[
						'class'=>'close attr-public', 
						'data-id'=>$term->terms_id, 
					]) ;
				
?>
				
                
            <?= $term->terms_text; ?>
            <input class="order_input close" value="<?=$term->terms_order?>" data-id="<?=$term->terms_id?>" style="width:50px; background-color:#E4E1E1; height:25px; ">
       </div>
       	
 <?
 $where=['termscatid'=>$term->termscatid, 'termsparent' => $term->terms_id, 'offset' =>$offset+20   ];
 
  echo  app\modules\terms\widgets\tree\TreeWidget::widget($where);?>	
             	
   <? } ?>     
  
   
