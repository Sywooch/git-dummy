
<div class="slider">


    <!--<div style=" background-position: center; background-image: url(/img/bx_loader.gif); width: 100%; height: 100%;    ">
        </div>-->
    <ul class="bxslider">

        <?
        echo \app\modules\gallery\widgets\ViewWidget::widget(['catid' => 0, 'tpl' => 'widgets/view_gallery']);

        ?>


    </ul>
</div>

<div class="boxshadow zindex">
    <ul class="center-content horisontal_menu menu flex">
        <?
        echo \app\modules\terms\widgets\cats\CatsWidget::widget(['termid' => 1, 'tpl' => 'widgets/cats_menu', 'submenu' => 0]);

        ?>
    </ul>
</div>
<div class="hot boxshadow">
    <div class="center-content wrapper clearfix">
        <div class="wrapper hot_label clearfix">
            <span class="section-title"><?= yii::t('app', 'Горячие предложения') ?></span>
            <a class="section-title-link"
               href="/product?order=hot.desc"><?= yii::t('app', 'Все горячие предложения') ?></a>
        </div>
        <div class="x-scroll-block center-content">
            <div class="scroller clearfix">

                <?
                echo \app\modules\catalog\widgets\items\ProductsWidget::widget(['field' => 'catalog_public', 'order' => 'persent DESC', 'tpl' => 'hot_index', 'limit' => 3]);

                ?>

            </div>
        </div>
    </div>
</div>

<div class="all_items wrapper">

    <div class="center-content padding15 clearfix">

        <div class="wrapper popular-wrapp clearfix">
            <span class="section-title"><?= yii::t('app', 'Самые популярные') ?></span>
            <a class="section-title-link"
               href="/product?order=popular.desc"><?= yii::t('app', 'Все популярные предложения') ?></a>
        </div>
        <div class="item-wrapp-main-page">

            <?
            if(count(\yii::$app->params['hot'])){
            echo \app\modules\catalog\widgets\items\ProductsWidget::widget(['field' => 'catalog_public',
                'where' => is_array(\yii::$app->params['hot']) ? ' langid not in(' . implode(',', \yii::$app->params['hot']) . ') and catalog_id NOT IN(' . implode(',', \yii::$app->params['hot']) . ')' : '',
                'order' => 'catalog_look DESC', 'tpl' => 'popular_index', 'limit' => 18]);
            }else{
                \yii::$app->params['hot']=[0];
            }
            ?>


        </div>
    </div>
    <Div class="center more_offers"><a class="  gray_link ajax-get-more " href="#"><img class="rotate"
                                                                                        src="/verst/img/more_items.png"><?= yii::t('app', 'еще предложения') ?>
        </a></Div>
</div>
<script>
    var page = 2;
    var loading = 0;
    $('.ajax-get-more').click(function () {
        var a = $(this);
        if (loading == 0) {
            loading = 1;
            /*alert($('.item-wrapp-main-page').width());*/
            a.children('img').toggleClass("down");
            ;
            $.ajax({
                url: '/popular?page=' + page + '&not=<?=implode(',',\yii::$app->params['hot'])?>',
                headers: {"X-CSRF-Token": $('meta[name=csrf-token]').attr("content")},
                type: 'GET',
                success: function (data) {
                    loading = 0;
                    $('.item-wrapp-main-page').append(/*'<div class="clearfix"></div>'+*/data);
                    page++;
                }
            });
        }
        return false;
    });

</script>

<div class="gray_bg gray-bg-fix border_bottom">
    <div class="center-content padding15 clearfix condition-wrapper">

        <div class="wrapper work-condition">
            <span class="section-title"><?= yii::t('app', 'Условия работы') ?></span>

            <div class="clear"></div>
        </div>


        <?= \app\modules\staticpage\models\Staticpage::getText(42) ?>

    </div>
</div>


<div class="grey-bg whitebg boxshadow topline">
    <div class="center-content">


        <?= \app\modules\staticpage\models\Staticpage::getText(44) ?>

    </div>
</div>
</div>