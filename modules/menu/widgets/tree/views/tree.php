<?php 
use yii\helpers\Html;

    use yii\helpers\Url;

    if($data)
	foreach( $data as $menu){ 
 ?>
 	   <div class="alert alert-warning" role="alert" style="padding:5px; margin:2px; margin-left:<?=$offset?>px ">
        	<?



echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-remove"></span>'), ['default/delete','id'=>$menu->menu_id,'parent'=>$menu->menu_id], 
					[
						'class'=>'close various fancybox.ajax', 
						'data-fancybox-type'=>"ajax",
						"data-dismiss"=>"alert", 
						"aria-hidden"=>"true" , 
						'data-confirm'=>Yii::t('admin', "Вы уверены, что хотите удалить этот элемент?" ),
					]) ;
					
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-pencil"></span>'), ['default/update','id'=>$menu->menu_id,'termin'=>$menu->alias], 
					[
						'class'=>'close ' , 
						
					]) ;
					
echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon-tree-conifer"></span>'), ['default/create','parent'=>$menu->menu_id,'termin'=>$menu->alias], 
					[
						'class'=>'close various fancybox.ajax', 
						'data-fancybox-type'=>"ajax" 
					]) ;

                echo		 Html::a(Yii::t('admin', '<span class="glyphicon glyphicon glyphicon-'.(($menu->menu_public == 1)?'ok':'remove').'-sign"></span>'),'#',
                    [
                        'class'=>'close attr-public',
                        'data-id'=>$menu->menu_id,
                    ]) ;
?>
            <?= $menu->menu_text; ?>
            <input class="order_input close" value="<?=$menu->menu_order?>" data-id="<?=$menu->menu_id?>" style="width:50px; background-color:#E4E1E1; height:25px; ">
       </div>
       	
 <?
 $where=['termin'=>$menu->alias, 'termsparent' => $menu->menu_id, 'offset' =>$offset+20   ];
 
  echo  app\modules\menu\widgets\tree\TreeWidget::widget($where);?>	
             	
   <? } ?>


<?
    Yii::$app->view->registerJs('



$(".order_input").keyup(function(){

	$.ajax({
	  url: "'.Url::to( ['/menu/default/order','id'=>'' ]).'"+$(this).attr("data-id")+"&position="+$(this).val(),
	  cache: false,
	  success: function(html){
		 $("#order_done").fadeIn(400).delay(1000).fadeOut(300);
	  }
	});

 });

$(".attr-public").click(function(){

	$.inside = $(this).children("span");



	$.ajax({
	  url: "'.Url::to( ['/menu/default/attrpublic','id'=>'' ]).'"+$(this).attr("data-id"),
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



?>


