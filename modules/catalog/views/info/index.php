<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    use \app\modules\catalog\models\Catalog;
 use \app\modules\catalog\models\Balance_out;
?>


<div class="ibox-content">
    <h2>Статистика за сегодня</h2>



    <div class="row">


        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align bits" id="today">
                    <div class="col-xs-3">
                        <i class="fa fa-thumbs-up fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold">Bits <?=$today['users']?></h2>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align winner" id="today">
                    <div class="col-xs-3">
                        <i class="fa fa-trophy fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"><?=$today['winner']?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align">
                    <div class="col-xs-3">
                        <i class="fa fa-frown-o fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"><?=$today['looser']?></h2>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align price" id="today">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"> <span class="fa fa-euro"><?=$today['prices']?></span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align service" id="today">
                    <div class="col-xs-3">
                        <i class="fa fa-briefcase fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"> <span class="fa fa-euro"><?=$today['services']?></span></h2>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>
<div class="row today_result">

</div>


<div class="ibox-content">
    <h2>За все время</h2>



    <div class="row">


        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align">
                    <div class="col-xs-3">
                        <i class="fa fa-thumbs-up fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold">Bits <?=$all['users']?></h2>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align winner" id="all" >
                    <div class="col-xs-3">
                        <i class="fa fa-trophy fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"><?=$all['winner']?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align">
                    <div class="col-xs-3">
                        <i class="fa fa-frown-o fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"><?=$all['looser']?></h2>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"> <span class="fa fa-euro"><?=$all['prices']?></span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="widget style1 navy-bg">
                <div class="row vertical-align">
                    <div class="col-xs-3">
                        <i class="fa fa-briefcase fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h2 class="font-bold"> <span class="fa fa-euro"><?=$all['services']?></span></h2>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
    <div class="ibox-content">
        <div class="row all_result">

            </div>
    </div>

<?php
Yii::$app->view->registerJs(' $(".winner").click(function(){
var el=$(this),
    type=el.attr("id");

$.ajax({
    url: "/catalog/info/winner?type="+type,
    success: function(data) {
     if(type=="today")
        $(".today_result").html(data);
     else
          $(".all_result").html(data);}
    })
});');
?>