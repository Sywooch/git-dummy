

<?php
    use yii\helpers\Html;
    $images = app\modules\system\models\Pictures::getImages('catalog',$data->catalog_id);
?>



<div class="page_detail_view_product">

    <div class="navigation nav_page_item">
        <div class="bt-ct1">
            <div>
                <ul>
                    <!--  <li><a href="/">Главная</a></li>-->
                    <li><a href="/product"><?=yii::t('app','Каталог')?></a></li>

                    <?php if(isset($breadcrumbs[0]['url'])):?>
                        <li><a href="/product/<?=$breadcrumbs[0]['url']?>"><?=$breadcrumbs[0]['label']?></a></li>
                    <?php endif; ?>

                    <?php if(isset($breadcrumbs[1]['url'])):?>
                        <li><a href="/product/<?=$breadcrumbs[1]['url']?>"><?=$breadcrumbs[1]['label']?></a></li>
                        <li><span><?=$breadcrumbs[2]['label']?></span></li>
                    <?php else: ?>
                        <li><span><?=$breadcrumbs[1]['label']?></span></li>
                    <?php endif; ?>


                </ul>
            </div>
        </div>
    </div>



    <? //   echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $breadcrumbs]);?>
    <?    echo $this->render('_zoom',['data'=> $data]);?>


<div class="top-view-zomer" style="display: none">
    <div class="windows8" >
        <div class="wBall" id="wBall_1">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_2">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_3">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_4">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_5">
            <div class="wInnerBall"></div>
        </div>
    </div>
</div>



    <div class="line_gray"></div>
    <section id="content">
        <h1><?/*=yii::t('app','Описание')*/?> <?=$data->catalog_name?></h1>



        <?=str_replace('img/','/img/',($data->catalog_text))?>
        <div class="hh1"></div>
        <div class="title1"><?=yii::t('app','Похожие товары')?></div>
        <div class="sld3">
            <div class="pv1"></div>
            <div class="nv1"></div>
            <div class="owl1 owl-carousel owl-theme">

                <?
                    echo  \app\modules\catalog\widgets\items\SameCatWidget::widget(
                        [
                            'catid'=>$data->catalogcatid,
                            'tpl'=>'widgets/view_products_in_product' ,
                            'urlPrefix'=>'/product/',
                            'notin'=>$data->catalog_id,
                            'limit' => 8,

                        ]);
                ?>



            </div>
        </div>

        <? echo $this->render('reviews',['model'=>$data]);?>

    </section>


    <div class="modal m1 dm-overlay" id="for_circles_modal">
        <div class="bg-modal"></div>
        <div class="modal-tb">
            <div class="modal-con">
                <div class="close"></div>
                <form id="ajax-result-popup">
                    
                </form>
            </div>
        </div>
    </div>


</div>
