<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    use \app\modules\catalog\models\Catalog;
 
?>

<h3>Ваши заявки</h3>
<ul class="nav nav-pills">

    <li><a href="?active=1">В работе</a></li>
    <li><a href="?archive=1">Архив заявок</a></li>


</ul>
<?php if( Yii::$app->session->hasFlash('money')): ?>
    <div class="alert alert-danger fade in"><?=Yii::$app->session->getFlash('money');?></div>
<?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'attribute'=>'statusid',
                'format'=>'html',
                'value'=>function($model){
                    $text='';
                    if($model->statusid == Catalog::STATUS_DONE)
                        $text='<br><span class="label label-success confirme"  data-toggle="modal" data-target=".confrime-modal" >Посмотреть и подтвердить</span>
                               <br><br><span class="label label-warning  comment"  >Вернуть на доработку</span>';
                    return ($model->terms ? $model->terms->terms_text : null).$text;        },#
                'filter'=>\app\modules\terms\models\Terms::dropDown(7)
            ],

            [
                'attribute'=>'workerid',
                'format'=>'html',
                'value'=>function($model){
                $text=$model->worker ? 'oper'.$model->worker->id : null;
                $status=\app\modules\catalog\models\Userlist::getUserStatus($model->worker->id);

                if($status==0)
                    return Html::tag('span',$text.' '
                    .Html::tag('span','',['data-id'=>$model->worker->id,"class"=>"glyphicon glyphicon-plus-sign ".$model->worker->id,
                            "data-toggle"=>"tooltip",
                            "data-placement"=>"top",
                            "title"=>"Добавить пользователя <br>в избранные"])
                    .'  <span alt="'.$model->worker->id.'" class="glyphicon glyphicon-minus-sign '.$model->worker->id.'" data-toggle="tooltip" data-placement="top" title="Добавить пользователя <br>в черный список"></span>'
                    ,['class'=>"label label-info"]);
                elseif($status==1)
                    return '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="в избранном">'.$text .'</span> ';
                elseif($status==2)
                    return '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title="в черном списке">'.$text .'</span> ';

                },#

            ],
            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
 		                'update'=>function ($url, $model) {
                            return $model->access('update')?\yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>',$url,[ ] ):null;
                        },
                        'delete'=>function ($url, $model) {
                            return $model->access('delete')?\yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>',$url,[ ] ):null;
                        }
           			   ],
           'template'=>' {view}  {update} {delete}',
			
			],
        ],
    ]);
	
 


Yii::$app->view->registerJs('


jQuery(".confirme").click(function(){
			var cb_el=jQuery(this).parent("td").parent("tr");

			jQuery("#confrime-item-id").val(cb_el.attr("data-key"));

			 jQuery.ajax({
                 url: "'.Url::to( ['calls/getcomments','id'=>'' ]).'"+cb_el.attr("data-key"),
                 success: function(data) {
                 jQuery("#ConfrimeModal .modal-body").html(data);
                 jQuery("#ConfrimeModal").toggle("show");
                }
              });

    });


jQuery(".comment").click(function(){

            jQuery("#comment-text").val("");
			var cb_el=jQuery(this).parent("td").parent("tr");
			jQuery("#CommentModal").toggle("show");
			jQuery("#comment-item-id").val(cb_el.attr("data-key"));
    });


    jQuery("#add-comment").click(function(){
			     jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+jQuery("#comment-item-id").val()+"&status=24",
                  type: "POST",
                 data:{msg:$("#comment-text").val()},
                 success: function(data) {
                    jQuery("#comment-text").val("");
					jQuery("#comment-item-id").val(0);
					jQuery("#CommentModal").toggle("hide").modal("hide");
                }
              })

			});




jQuery("#add-confrime").click(function(){

			$(this).parent("td").html("<span class=\"label label-primary\">Подтверждена</span>");
             jQuery.ajax({
                 url: "'.Url::to( ['calls/changestatus','id'=>'' ]).'"+ jQuery("#confrime-item-id").val()+"&status=115",
                success: function(data) {
					// cb_el.toggle("hide");
					jQuery("#CommentModal").toggle("hide").modal("hide");
                }
        })
    });


$(".glyphicon-minus-sign").click(function(){
            var id = $(this).attr("class").replace(/glyphicon glyphicon-minus-sign /g,"");

             $.ajax({
                 url: "'.Url::to( ['userlist/bad','id'=>'' ]).'"+id,
                success: function(data) {

                }
        })
         $(this).parent("span").attr("class","label label-danger");
                    $(this).parent("span").children("span").toggle("hide");
});
$(".glyphicon-plus-sign").click(function(){
        var id = $(this).attr("class").replace(/glyphicon glyphicon-plus-sign /g,"");

             $.ajax({
                 url: "'.Url::to( ['userlist/good','id'=>'' ]).'"+id,
                success: function(data) {


                }
        });
        $(this).parent("span").attr("class","label label-success");
        $(this).parent("span").children("span").toggle("hide");
});

//jQuery("span[data-toggle=tooltip]").tooltip({"html":true,delay: { show: 100, hide: 500 }});



    $(".checkbox_block").click(function(){
			var cb_el=$(this);
             $.ajax({
                 url: "'.Url::to( ['admin/setpublic','id'=>'' ]).'"+$(this).parent("td").parent("tr").attr("data-key")+"&field="+$(this).attr("title"),
                success: function(data) {
                    cb_el.html(data);
					 
                }
        })
    });');
 ?>
    
<style>
    .glyphicon{
        cursor: pointer;}
    .checkbox_block{ cursor:pointer}</style>



<div class="modal comment-modal" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="CommentModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Коментарий к задаче</h4>
            </div>
            <div class="modal-body">
                <textarea style="width: 100%; height:200px;;" id="comment-text"></textarea>
                <input type="hidden" value="0" id="comment-item-id"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="jQuery('#CommentModal').toggle('hide').modal('hide');" >Закрыть</button>
                <button type="button" id="add-comment" class="btn btn-primary ">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>




<div class="modal confrime-modal" id="ConfrimeModal" tabindex="-1" role="dialog" aria-labelledby="ConfrimetModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Результат по задаче</h4>
            </div>
            <div class="modal-body" >

            </div>
            <div class="modal-footer">
                <input type="hidden" value="0" id="confrime-item-id"/>
                <button type="button" class="btn btn-default" onclick="jQuery('#ConfrimeModal').toggle('hide').modal('hide');" data-dismiss="modal">Закрыть</button>
                <button type="button" id="add-confrime" class="btn btn-primary ">Подтвердить выполнение</button>
            </div>
        </div>
    </div>
</div>


