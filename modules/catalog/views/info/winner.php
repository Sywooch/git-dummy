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

<?php
if(count($all))
        foreach($all as $row):
?>
    <div class="widget lazur-bg p-xl">



        <div class="row">
            <div class="col-lg-4">
                <h2>
                    <a href="/user/admin/update?id=<?=$row->user->id?>" style="color: #fff"><?=$row->user->username?></a>
                </h2>
                <ul class="list-unstyled m-t-md">
                    <li>
                        <span class="fa fa-envelope m-r-xs"></span>
                        <label>Имя:</label>
                        <?=$row->user->name?>
                    </li>
                    <li>
                        <span class="fa fa-envelope m-r-xs"></span>
                        <label>Email:</label>
                        <?=$row->user->email?>
                    </li>
                    <li>
                        <span class="fa fa-home m-r-xs"></span>
                        <label>Address:</label>
                        <?=$row->user->place?>, <?=$row->user->adres?>
                    </li>
                    <li>
                        <span class="fa fa-phone m-r-xs"></span>
                        <label>Тел.:</label>
                        <?=$row->user->phone?>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <h2>
                    Товары
                </h2>
                <ul class="list-unstyled m-t-md">
                    <?php if(count($row->user->bitsnonarchive))
                            foreach($row->user->bitsnonarchive as $bit):?>
                                <li data-bid="<?=$bit->id?>">

                                    <label><?=$bit->catalog->catalog_name?></label><br>

                                    <a href="/tickets/admin/mcreate" style="color: #FFF"> <span class="small fa fa-envelope-o m-r"> Написать сообщение</span></a>
                                    <span class="small fa fa-comment<?=$bit->isapprove?'':'-o'?> m-r"> Одобрить</span>
                                    <span class="small fa fa-send<?=$bit->ispost?'':'-o'?> m-r"> Отправить в доставку</span>

                                    <span class="small fa  fa-eye m-r-xs"  > В архив</span>

                                    <div class="alert alert-info">Отзыв <span class="fa fa-pencil-square"></span><br>
                                        <textarea style="width: 100%; border: 0px; background-color: #d9edf7"><?=$bit->comment?></textarea><br>
                                        <span class=" small fa fa-save"> Сохранить</span>
                                    </div>

                                </li>
                            <?php endforeach; ?>
                </ul>
            </div>


        </div>
    </div>
 <?php endforeach; ?>
<style>
    .small{ font-size: 17px; cursor: pointer}
</style>
 <script>

     $('.fa-save').click(function(){
         var el = $(this),
             id = $(this).parent('div').parent("li").attr("data-bid"),
             val = el.parent('div').children('textarea').val();

         $.ajax({
             url: "/catalog/info/updatemsg?id="+id,
             type:"POST",
             data:{"msg":val},
             success: function(data) {
                 el.html(" Обновлено");
             }
         })
     });

     $(".fa-comment-o").click(function(){

        var el = $(this),
        id = $(this).parent("li").attr("data-bid");
        $.ajax({
            url: "/catalog/info/approve?id="+id,
            success: function(data) {
                el.toggleClass("fa-comment-o").toggleClass("fa-comment");
            }
        })
});

     $(".fa-send-o").click(function(){

         var el = $(this),
             id = $(this).parent("li").attr("data-bid");
         $.ajax({
             url: "/catalog/info/send?id="+id,
             success: function(data) {
                 el.toggleClass("fa-send-o").toggleClass("fa-send");
             }
         })
     });

     $(".fa-eye").click(function(){

         var el = $(this),
             id = $(this).parent("li").attr("data-bid");
         $.ajax({
             url: "/catalog/info/archive?id="+id,
             success: function(data) {
                 el.parent("li").remove();
             }
         })
     });
 </script>