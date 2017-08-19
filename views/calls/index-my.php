<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
    use \app\modules\catalog\models\Catalog;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>


<h3>Предложения для прозвона</h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<ul class="nav nav-pills">

    <li><a href="?active=1">В работе</a></li>
    <li><a href="?archive=1">Архив заявок</a></li>


</ul>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'catalog_id',

            ['attribute'=>'catalog_number',
                'format'=>'html',
             'value'=>function($model){ return \yii\helpers\Html::a(  $model->catalog_number,'/calls/view?id='.$model->catalog_id,[ ] );},
            ],
            'catalog_to',
            'catalog_from',
			#'catalog_articl',
			#['attribute'=>'catalog_price','filter'=>false],
			

			[
				'attribute'=>'date_modified',
				'value' =>function($model){ return Yii::$app->formatter->asDate(strtotime($model->date_modified));},
				'filter'=>false	
			],

            [
                'attribute'=>'userid',
                'value'=>function($model){      return $model->user ? 'client'.$model->user->id : null;        },#

            ],
            [
                'attribute'=>'statusid',
                'format' => 'html',
                'value'=>function($model){

                        if($model->statusid == Catalog::STATUS_CREATED)
                            return ' <span class="label label-success created" data-status="'.Catalog::STATUS_CREATED.'" >Принять</span><br><br>
                                     <span class="label label-danger none" data-status="'.Catalog::STATUS_NONE.'">Отказаться</span> ';

                    if($model->statusid == Catalog::STATUS_ACSEPT)
                        return '<span class="label label-success done" data-status="'.Catalog::STATUS_DONE.'">Выполнена</span><br><br>
                                <span class="label label-danger error" data-status="'.Catalog::STATUS_ERROR.'">Ошибка</span><br><br>
                                <span class="label label-info comment" data-status="'.Catalog::STATUS_COMMENT.'">Уточнить</span>';

                    if($model->statusid == Catalog::STATUS_DONE)
                        return '<span class="label label-warning confirme" data-status="'.Catalog::STATUS_DONECONFRIME.'">На проверке</span>';

                    if($model->statusid == Catalog::STATUS_COMMENT)
                        return '<span class="label label-info " >Уточнение</span>';

                    if($model->statusid == Catalog::STATUS_ERROR)
                        return '<span class="label label-danger error" data-status="'.Catalog::STATUS_ERROR.'">Ошибка</span>';


                    if($model->statusid == Catalog::STATUS_DONECONFRIME)
                        return '<span class="label label-success" data-status="'.Catalog::STATUS_DONECONFRIME.'" >Подтверджена</span>';

                    if($model->statusid == Catalog::STATUS_NONE)
                        return '<span class="label label-warning " data-status="'.Catalog::STATUS_DONECONFRIME.'">Отказался</span>';

                },#
                'filter'=>\app\modules\terms\models\Terms::dropDown(7)
            ],
            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  
			   
		  'update'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>',$url,[ ] );
               }	   
           			 ],
           'template'=>' {view} ',
			
			],
        ],
    ]);






Yii::$app->view->registerJs('
    jQuery(".created").click(function(){
			var cb_el=jQuery(this).parent("td").parent("tr");
			$(this).parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
             jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+cb_el.attr("data-key")+"&status=24",
                success: function(data) {
					// cb_el.toggle("hide");
                }
        })
    });
    jQuery(".none").click(function(){
			var cb_el=jQuery(this).parent("td").parent("tr");
			$(this).parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
             jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+cb_el.attr("data-key")+"&status=116",
                success: function(data) {
					// cb_el.toggle("hide");
                }
        })
    });
    jQuery(".done").click(function(){

            jQuery("#done-text").val("");
			var cb_el=jQuery(this).parent("td").parent("tr");
			jQuery._doneel=jQuery(this);

			jQuery("#DoneModal").toggle("show");
			jQuery("#done-item-id").val(cb_el.attr("data-key"));


			/*var cb_el=jQuery(this).parent("td").parent("tr");
			$(this).parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
             jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+cb_el.attr("data-key")+"&status=112",
                success: function(data) {
					// cb_el.toggle("hide");
                }
        })*/
    });
    jQuery(".error").click(function(){

			var cb_el=jQuery(this).parent("td").parent("tr");
			$(this).parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
             jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+cb_el.attr("data-key")+"&status=113",
                success: function(data) {
					// cb_el.toggle("hide");
                }
        })
    });
    jQuery(".confirme").click(function(){

			var cb_el=jQuery(this).parent("td").parent("tr");
			$(this).parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
             jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+cb_el.attr("data-key")+"&status=112",
                success: function(data) {
					// cb_el.toggle("hide");
                }
        })
    });
    jQuery(".comment").click(function(){

            jQuery._doneel=jQuery(this);

            jQuery("#comment-text").val("");
			var cb_el=jQuery(this).parent("td").parent("tr");
			jQuery("#CommentModal").toggle("show");
			jQuery("#comment-item-id").val(cb_el.attr("data-key"));
    });

    jQuery("#add-comment").click(function(){
			     jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+jQuery("#comment-item-id").val()+"&status=114",
                  type: "POST",
                 data:{msg:$("#comment-text").val()},
                 success: function(data) {
                    jQuery("#comment-text").val("");
					jQuery("#comment-item-id").val(0);
					jQuery("#CommentModal").toggle("hide").modal("hide");
					jQuery._doneel.parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
                }
              })

			});

 jQuery("#add-done").click(function(){
			     jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+jQuery("#done-item-id").val()+"&status=112",
                  type: "POST",
                 data:{msg:$("#done-text").val()},
                 success: function(data) {
                    jQuery("#done-text").val("");
					jQuery("#done-item-id").val(0);
					jQuery("#DoneModal").toggle("hide").modal("hide");
					jQuery._doneel.parent("td").html("<span class=\"label label-primary\">Статус изменен</span>");
                }
              })

			});


    ');
 ?>


<div class="modal " id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Уточнение к задаче</h4>
            </div>
            <div class="modal-body">
               <textarea style="width: 100%; height:200px;;" id="comment-text"></textarea>
                <input type="hidden" value="0" id="comment-item-id"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="jQuery('#CommentModal').toggle('hide').modal('hide');">Закрыть</button>
                <button type="button" id="add-comment" class="btn btn-primary ">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>



<div class="modal " id="DoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Коментарий  к выполненной задаче</h4>
            </div>
            <div class="modal-body">
                <textarea style="width: 100%; height:200px;;" id="done-text"></textarea>
                <input type="hidden" value="0" id="done-item-id"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="jQuery('#DoneModal').toggle('hide').modal('hide');">Закрыть</button>
                <button type="button" id="add-done" class="btn btn-primary ">Отправить клиенту</button>
            </div>
        </div>
    </div>
</div>