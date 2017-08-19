<?php
    use yii\helpers\Html;
    use yii\helpers\BaseUrl;
?>



<?

    array_unshift($breadcrumbs,[ 'label' =>yii::t('app','Каталог'),'url'=>'/product' ]  );
    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $breadcrumbs,'ppc'=>'p-c-c-10 p-l']);?>




<div class=" lines-sep zindex">
    <ul class="center-content horisontal_menu menu flex">
        <?
            echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'tpl'=>'widgets/cats_menu','submenu'=>0]);

        ?>
    </ul>
</div>
<!--
<div class="lines-sep toplayer">
    <div class="center-content p-c-c-10">
        <div class="line-menu">
            <ul class="clearfix">

                <?/*                    echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'tpl'=>'widgets/cats_menu','submenu'=>0]);

                */?>
            </ul>
            <div class="hiden-menu">
                <div class="hiden-menu-button">
                    <span class="fa fa-bars"></span>
                </div>
                <div class="hiden-menu-list">

                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="catalog-list-menu-icon">
    <div class="center-content">
        <ul class="clearfix">


            <li <?=yii::$app->request->get('order')=='hot.desc'?'class="active"':''?>>
                <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=hot.desc'?>"><span class="fire-icon"></span></a>
            </li>
            <li <?=yii::$app->request->get('order')=='popular.desc'?'class="active"':''?>>
                <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=popular.desc'?>"><span class="star-icon"></span></a>
            </li>
            <li <?=yii::$app->request->get('order','catalog_date.desc')=='catalog_date.desc'?'class="active"':''?>>
                <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=catalog_date.desc'?>"><span class="cart-icon"></span></a>
            </li>
            <li <?=yii::$app->request->get('order')=='timeend.desc'?'class="active"':''?>>
                <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=timeend.desc'?>"><span class="time-icon"></span></a>
            </li>
        </ul>
    </div>
</div>
<div class="center-content  p-c-c-10">
<div class="row">
    <div class="page-title page-title-inline">
        <?=$label?>
    </div>
    <div class="unpadding-tacenter-on360  pull-right p-t-30 p-b-20 tarights filter-catalog-list">
        <span class="filter-name"><?=yii::t('app','Товаров на странице')?>:</span>
        <div class="filter-select-wrap">
            <div class="filter-selected"><?=yii::$app->request->get('per-page',12)?></div>
            <ul class="filter-select">
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('per-page').'&per-page=12'?>">
                       12
                    </a>
                </li>
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('per-page').'&per-page=18'?>">
                        18
                    </a>
                </li>
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('per-page').'&per-page=30'?>">
                        30
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="unpadding-tacenter-on360 pull-right p-t-30 p-b-20 taright filter-catalog-list">
        <span class="filter-name"> <?=yii::t('app','Сортировать по')?>:</span>
        <div class="filter-select-wrap ">
            <?php
            $order=[0=>yii::t('app','Новинки'),
                    'hot.desc'=>yii::t('app','Горячие'),
                    'popular.desc'=>yii::t('app','Популярные'),
                     'timeend.desc'=>yii::t('app','В стадии завершения'),
                    'catalog_date.desc'=>yii::t('app','Новинки'),];
            ?>
            <div class="filter-selected"><?=$order[yii::$app->request->get('order','0')]?></div>
            <ul class="filter-select">
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=hot.desc'?>">
                        <?=yii::t('app','Горячие')?>
                    </a>
                </li>
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=popular.desc'?>">
                        <?=yii::t('app','Популярные')?>
                    </a>
                </li>
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=timeend.desc'?>">
                        <?=yii::t('app','В стадии завершения')?>
                    </a>
                </li>
                <li>
                    <a href="?<?=yii::$app->request->QueryParamToString('order').'&order=catalog_date.desc'?>">
                     <?=yii::t('app','Новинки')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="catalog-list clearfix">
<div class="catalog-list-body clearfix">




<?php foreach($models as $model):
    echo $this->render('_item',array('model'=>$model));
    endforeach;?>

</div>
</div>

    <div class="paginator paginator_center">
            <?=\app\components\LinkPager::widget([
                'pagination' => $pages,
                'options'=>['class'=>'clearfix'],

                'prevPageLabel'=>yii::t('app','Предыдущая'),
                'nextPageLabel'=>yii::t('app','Следующая'),
                'prevPageCssClass'=>'paginator-prev',
                'nextPageCssClass'=>'paginator-next',
                'maxButtonCount'=>3,
            ]);?>
    </div>
</div>
<div class="grey-bg">
    <div class="center-content">

        <?=\app\modules\staticpage\models\Staticpage::getText(52)?>
    </div>
</div>