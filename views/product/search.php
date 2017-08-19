<?php
    use yii\helpers\Html;
    use yii\helpers\BaseUrl;
?>



<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $breadcrumbs,'ppc'=>'p-c-c-10 p-l']);?>




<div class="block-search-page">
    <div class="center-content p-c-c-10 p-l">
        <div class="menu-name"><?=$label?></div>
        <form  class="search-form-for-result">
            <label for=""><?=yii::t('app','Критерии поиска')?></label>
            <div class="clear"></div>
            <div class="main-type-input">
                <input type="text" name="key" id="search-key" value="<?=yii::$app->request->get('key');?>">
                <input type="hidden" name="catid" id="search-catid">
                <input type="hidden" name="subcatid" id="search-subcatid">
            </div>

            <div class="filter-select-wrap ">
                <div class="filter-selected"><?=yii::t('app','Все категории')?></div>
                <ul class="filter-select">
                    <?
                        echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'tpl'=>'widgets/cats_menu_search','submenu'=>0]);

                    ?>
                </ul>
            </div>
            <script>
                $('.select-link').click(function(){
                    var id = $(this).attr('data-id');

                    $('#search-catid').val(id);
                    $('#select-subcat').find('.filter-selected').html('<img src="/img/load.gif" />');
                    $(this).parent('li').parent('ul').parent('div').find('.filter-selected').html($(this).html());
                    $.ajax({
                        url:  '/subcat' ,
                        headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
                        type:'POST',
                        data:'catid='+id,
                        success: function(data)
                        {

                            if(data){
                                $('#subcat').html(data);
                                $('#select-subcat').find('.filter-selected').html('<?=\yii::t('app','Подкатегории')?>');



                            } else {
                                $('#select-subcat').find('.filter-selected').html('<?=\yii::t('app','Нет под категорий')?>');
                                $('#subcat').html('');
                            }

                        }
                    });
                    return false;
                });


            </script>
            <div class="filter-select-wrap" id="select-subcat" >
                <div class="filter-selected"><?=yii::t('app','Все разделы')?></div>
                <ul class="filter-select" id="subcat">

                </ul>
            </div>
            <!--<label class="check func-links">
                <div class="jq-checkbox"><input type="checkbox" name="insubcats"><div class="jq-checkbox__div"></div></div>  <?/*=yii::t('app','Поиск в подкатегориях')*/?>
            </label>-->
            <div class="clear"></div>
            <label class="check func-links">
                <div class="jq-checkbox2"><input type="checkbox" value="1" name="indesc" <?php if(\yii::$app->request->get('indesc')) echo 'checked'; ?>><div class="jq-checkbox__div2"></div></div>  <?=yii::t('app','Поиск в описание товара')?>
            </label>
            <div class="clear"></div>
            <input type="submit" value="<?=yii::t('app','ПОИСК')?>" class="button-green button">
        </form>

    </div>
</div>

<div class="center-content m-b-50 p-c-c-10">
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




<?php
    if(count($models)):
        foreach($models as $model):
        echo $this->render('_item',array('model'=>$model));
        endforeach;
    else:?>
        <?=yii::t('app','Ничего не найдено')?>
    <?php endif;?>

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
        <?=\app\modules\staticpage\models\Staticpage::getText(44)?>
    </div>
</div>