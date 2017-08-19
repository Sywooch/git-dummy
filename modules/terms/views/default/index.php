<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use app\modules\terms\models\Terms;
use app\modules\terms\models\Terms_cat;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
    

?> 	<br>
 	<p>
        <?= Html::a(Yii::t('admin', 'Создать раздел термина'), ['termscat/create'], ['class' => 'btn btn-info']) ?>
    </p>
   
   
    
	<?php if(Yii::$app->session->hasFlash('updated')): ?>
        <div class="alert alert-success" role="alert">
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= Yii::$app->session->getFlash('updated') ?>
        </div>
         
    <?php endif; ?>
    
   <?
   
   
   
  $terms=Terms_cat::find()->where('langid = 0')->all();
 
  if( is_array($terms))
  {
	$i=0;
	foreach($terms as $term)
	{
		$terms_array[]=[
						'label' => $term->terms_cat_text,
						'content' => $this->render('view_terms',['tcat' => $term] ),
						'active' => check_term($i,$term),
						];
		$i++;
	}
		  
	   
		 echo Tabs::widget([
			'items' =>  
				$terms_array				
			 
		]); 
  }



function check_term ($i, $term){ 
							if(Yii::$app->session->getFlash('termscatid'))
							{
								if( $term->terms_cat_id == Yii::$app->session->getFlash('termscatid') )
									return true;
							}
							elseif( !Yii::$app->session->getFlash('termscatid') && $i == 0)
								return true;
							
							 return false;
							}
   ?>
 
 
  
       <div class="alert alert-success" role="alert" style="display:none" id="order_done">
             <?=\Yii::t('admin', 'Порядок очередности изменен, обновите странице чтобы увидеть результат')?>
        </div>
        
        <div class="alert alert-success" role="alert" style="display:none" id="public_done">
             <?=\Yii::t('admin', 'Статус изменен')?>
        </div>
     
<?
Yii::$app->view->registerJs('

var translate_field=["terms-terms_text","terms-terms_url"];

$(".order_input").keyup(function(){

	$.ajax({
	  url: "'.Url::to( ['default/order','id'=>'' ]).'"+$(this).attr("data-id")+"&position="+$(this).val(),
	  cache: false,
	  success: function(html){
		 $("#order_done").fadeIn(400).delay(1000).fadeOut(300);
	  }
	}); 
	
 });
 
$(".attr-public").click(function(){
 
	$.inside = $(this).children("span");
	
	 
	
	$.ajax({
	  url: "'.Url::to( ['default/attrpublic','id'=>'' ]).'"+$(this).attr("data-id"),
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
       




 


 
