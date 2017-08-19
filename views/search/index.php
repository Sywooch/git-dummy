
<?php

    use yii\helpers\BaseUrl;
?>
<!-- Breadcrumb -->
<div class="breadcrumb" style="margin-left: 20px;">
    <div class="breadcrumb_inset">
        <a class="breadcrumb-home" href="/" title="Вернуться на главную"><i class="icon-home"></i></a>
        <span class="navigation-pipe ">&gt;</span>
        <span class="navigation_page">Поиск   </span>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="loader_page">

    <div id="center_column" class="center_column span9 clearfix">





        <h1>        <span>			Поиск          </span></h1>




        <style>
            .pagination ul > li {
                display: inline;
            }
        </style>




        <ul id="product_list" class="grid row">
        <?php if(is_array($data))
                    foreach($data as $model): ?>
<?

    $img = app\modules\system\models\Pictures::getImages('catalog',$model->catalog_id); ?>







<li class="ajax_block_product span3 num-2 ">
    <a href="<?=$model->catalog_url?>" class="product_img_link" title="<?=$model->catalog_name?>">
        <img src="<?=(new app\components\ImageComponent)->adaptive($img[0],270,270);  ?>" alt="" />
    </a>
    <div class="center_block">

        <div class="clear"></div>
        <h5><a class="product_link" href="<?=$model->catalog_url?>" title="<?=$model->catalog_name?>"><?=$model->catalog_name?></a></h5>

    </div>
    <div class="right_block">


        <?php if($model->catalog_priceold): ?><span class="price-old" style="display: inline"> <?=app\modules\shop\models\Curs::price($model->catalog_priceold)?></span><?php endif; ?>
        <span class="price price-new" style="display: inline"><?=app\modules\shop\models\Curs::price($model->catalog_price)?></span>



        <div class="clear noneclass"></div>
        <a class="ajax_add_to_cart_button exclusive "   href="<?=$model->catalog_url?>" title="В корзину">
            <span>В корзину</span>
        </a>

        <a class="button" href="<?=$model->catalog_url?>" title="Подробнее">Подробнее</a>
    </div>
</li>



        <?php endforeach; ?>


</ul>













    </div>

    <!-- Right -->
    <aside id="right_column" class="span3 column right_home">

        <section id="blockbestsellers" class="block products_block column_box" style="box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.14);">
            <h4><span><span>Новинки</span> </span><i class="column_icon_toggle icon-plus-sign"></i></h4>
            <div class="block_content toggle_content">
                <ul>

                    <?
                        echo  \app\modules\catalog\widgets\items\ProductsWidget::widget(
                            [
                                'field'=>'catalog_new',
                                'tpl'=>'widgets/left_products' ,
                                'urlPrefix'=>'/product/',
                                'limit' => 3

                            ]);

                    ?>



                </ul>

            </div>
        </section>
    </aside>
</div>

