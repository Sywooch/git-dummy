<?php 
use yii\helpers\Html;
use yii\helpers\Url; 
 
	 
	
	foreach( $data as $term){ 
 ?>
 	   <div class="alert alert-warning" role="alert" style="padding:5px; margin:2px; margin-left:<?=$offset?>px ">
        	<?



echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-remove"></span>'), ['/terms/default/delete','id'=>$term->terms_id,'parent'=>$term->terms_id], 
					[
						'class'=>'close various fancybox.ajax', 
						'data-fancybox-type'=>"ajax",
						"data-dismiss"=>"alert", 
						"aria-hidden"=>"true" , 
						'data-confirm'=>Yii::t('admin',"Вы уверены, что хотите удалить этот элемент?") ,
						'data-toggle'=>"tooltip",
						'data-placement'=>"top", 
						'title'=>"Удалить"
					]) ;
					
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-pencil"></span>'), ['/terms/default/update','id'=>$term->terms_id], 
					[
						'class'=>'close various fancybox.ajax' , 
						'data-fancybox-type'=>"ajax",
						'data-toggle'=>"tooltip",
						'data-placement'=>"top", 
						'title'=>"Редактировать",
						'style'=>'padding-left:50px;'
					]) ;
					

	 		
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon glyphicon-'.(($term->terms_public == 1)?'ok':'remove').'-sign"></span>'),'#', 
					[
						'class'=>'close attr-public', 
						'data-id'=>$term->terms_id, 
						'data-toggle'=>"tooltip",
						'data-placement'=>"top", 
						'title'=>"Опубликовать",
						'style'=>'padding-left:50px;'
						
					]) ;
					
			
								
				
?>
				
                
            <?= $term->terms_text; ?>
            <input class="order_input close" value="<?=$term->terms_order?>" data-id="<?=$term->terms_id?>" data-toggle="tooltip" data-placement="top" title="Сортировка, укажите номер позиции"   style="width:50px; background-color:#E4E1E1; height:25px; ">
       </div>
       	
 <?
 $where=['termscatid'=>$term->termscatid, 'termsparent' => $term->terms_id, 'offset' =>$offset+20 ,'tpl'=>'type_tree'  ];
 
  echo  app\modules\terms\widgets\tree\TreeWidget::widget($where);?>	
             	
   <? } ?>     
  
 
 <?
Yii::$app->view->registerJs('

$("a").tooltip();
$("input").tooltip();

 

$(".order_input").keyup(function(){

	$.ajax({
	  url: "'.Url::to( ['/terms/default/order','id'=>'' ]).'"+$(this).attr("data-id")+"&position="+$(this).val(),
	  cache: false,
	  success: function(html){
		 $("#order_done").fadeIn(400).delay(1000).fadeOut(300);
	  }
	}); 
	
 });
 
$(".attr-public").click(function(){
 
	$.inside = $(this).children("span");
	
	 
	
	$.ajax({
	  url: "'.Url::to( ['/terms/default/attrpublic','id'=>'' ]).'"+$(this).attr("data-id"),
	  cache: false,
	  success: function(html){
		 
		 $("#public_done").fadeIn(400).delay(1000).fadeOut(300);
		 
		 if( $.inside.attr("class") == "glyphicon glyphicon glyphicon-remove-sign" )
		 	$.inside.attr("class","glyphicon glyphicon glyphicon-ok-sign");
		 else
		 	$.inside.attr("class","glyphicon glyphicon glyphicon-remove-sign");
		 
	  }
	}); 
	
 });
 
 ');
 
/*  $js = <<< JS
           $('#quote-of-the-day').click(function(){
             $.ajax({
                url: '?r=getquote',
                success: function(data) {
                    $("#quote-of-the-day").html(data)
                }
        })
    });
JS;*/

?>    
       




 


 
  
   