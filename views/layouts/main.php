<?php
use app\assets\AppAsset_main;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

//AppAsset_main::register($this);
if (isset(yii::$app->params['modified'])) {
    header("Last-Modified:" . date("D, d M Y H:i:s", yii::$app->params['modified']) . " GMT ");
}


?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="<?= Yii::$app->charset ?>"/>


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->params['title']) ?></title>
    <meta name="keywords" content="<?= Html::encode(Yii::$app->params['keys']) ?>"/>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="w1-verification" content="164493526298"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">


    <link rel="icon" href="/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="FAVICON" type="image/x-icon"/>


    <link href="/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/mediaquery.css">
    <link rel="stylesheet" href="/css/font-awesome.css"/>
    <link rel="stylesheet" href="/css/style_spikemaster.css"/>
    <link href="/js/bxslider/jquery.bxslider.css" rel="stylesheet"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link href="/css/jnice.css" rel="stylesheet" type="text/css"/>
    <link href="/css/etalage.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">
        if ("Microsoft Internet Explorer" == navigator.appName) {
            document.write('<link href="/css/forei.css" rel="stylesheet" type="text/css"/>');
        }
    </script>


    <script src="/js/jquery.cookie.js"></script>
    <!--<script src="/js/jzoom.min.js"></script>-->
    <script src="/js/bxslider/jquery.bxslider.js"></script>
    <script src="/js/flexMenu/modernizr.custom.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Quantico:700' rel='stylesheet' type='text/css'>
    <script src="/js/flexMenu/flexmenu.js"></script>

    <script src="/js/init.js"></script>
    <script src="/js/spikemaster.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="/js/jquery.etalage.min.js"></script>


    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="/css/owl.carousel.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen, projection">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script type="text/javascript" src="/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="/js/jquery.formstyler.min.js"></script>
    <script type="text/javascript" src="/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="/js/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>


    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body>
<?php if (yii::$app->controller->id != 'profile'): ?>
<div id="page">
    <?php endif; ?>


    <div class="cart_and_draw" >


            <div class="basket-preview sticky" style="top:91px !important;">
                <?php   if (Yii::$app->controller->id == 'site' || Yii::$app->controller->id == 'product'): ?>
                    <?= $this->render('//pshop/_basket') ?>

                    <?php
                    if(yii::$app->user->getId()):
                        $count=\app\models\Auct::find()->where(['userid'=>yii::$app->user->getId(), 'status'=>0])->all();
                        if(count($count)):
                            ?>
                            <a class="product_draw" href="/activity"><img src="/img/products_draw.png" alt=""><span><?= count($count) ?></span></a>
                        <?php endif; ?>
                    <?php endif; ?>

                <?php endif; ?>




            </div>



    </div>
    <?php if ($wc = \app\modules\system\models\Notice::Activity(2)): ?>
    <?php endif; ?>



    <header id="header">

        <div class="ct
                <?php if (yii::$app->controller->id != 'profile' ||
            (yii::$app->controller->id != 'site' && yii::$app->controller->action->id == 'index')
        ): ?> ft-aut1<?php endif; ?>

                <?php if (yii::$app->controller->id == 'product' && (yii::$app->controller->action->id == 'list' ||
                yii::$app->controller->action->id == 'search')
        ): ?>
                p-c-c-10
                <?php endif; ?>
                ">

            <a href="/" class="logo"><img src="/img/logo.png" alt=""></a>

            <div class="main-menu">

                <div class="curr1" dt="0"></div>

                <ul>

                    <?
                    echo \app\modules\terms\widgets\cats\CatsWidget::widget(['termid' => 1, 'tpl' => 'widgets/cats_menu', 'submenu' => 1]);

                    ?>

                </ul>

            </div>

            <div class="ln1"></div>


            <? echo (new \app\components\widgets\Language)->mainList(); ?>
            <? echo \app\modules\user\widgets\AuthWidget::widget(); ?>

            <div class="bf2<?php if (yii::$app->controller->id != 'profile'): ?> bf22<?php endif; ?>"></div>

            <div class="ln1"></div>

            <div class="bf1"></div>

            <div class="search1">

                <div class="poss-mob1" style="">


                    <div class="ov-search1">
                        <form method="get" action="/search">

                            <input type="submit" class="search-submit" value="">

                            <div><input autocomplete="off" type="text" name="key" class="et-srh1"
                                        value="<?= Yii::t('app', 'ПОИСК') ?>"
                                        data-place="<?= Yii::t('app', 'ПОИСК') ?>"></div>
                        </form>
                    </div>

                </div>

                <div class="bt-mob1"></div>

            </div>

            <div class="modal-ff1" style="left: 291px; width: 437px;">


            </div>

        </div>

    </header>




    <?= $content ?>
    <?php if ($item = \app\modules\system\models\Notice::MessageForWinner()):
        $img = app\modules\system\models\Pictures::getImages('catalog', $item->catalogid);
        ?>

        <div class="prize_popup dm-overlay active" id="">
            <div class="dm-table">
                <div class="dm-cell">
                    <div class="dm-bg-close"></div>
                    <div class="dm-modal">
                        <a href="#for_circles_modal" class="close"></a>

                        <div class="for_solutia">
                            <img src="/img/solutia.png" alt="">
                        </div>
                        <div class="modal-con">
                            <div class="for_solutia">
                                <img src="/img/solutia.png" alt="">
                            </div>
                            <div class="close"></div>
                            <form>
                                <p class="title_red_big"><?= Yii::t('app', 'Поздровляем!') ?></p>

                                <p><?= Yii::t('app', 'Вы - выиграли') ?></p>

                                <p class="name_prize"><?= $item->catalog->catalog_name ?></p>

                                <div class="for_img"><img src="
                        <?= ($item->catalog->iszoomer) ? (new app\components\ImageComponent)->crop($img[0], 316, 256) : (new app\components\ImageComponent)->adaptive($img[0], 316, 256); ?>
                        "></div>
                                <p><?= Yii::t('app', 'Что Вы сейчас чувствуете?') ?></p>

                                <div class="modal-comment-error"
                                     style="color: #ff0000; display: none; text-align: center; width: 100%;"></div>
                                <textarea name="" id="winner-message" cols="30" rows="10"></textarea>
                                <input type="submit" value="<?= Yii::t('app', 'Отправить') ?>"
                                       class="winner-message green_button button">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#winner-message').keyup(function () {

                var msg = $('#winner-message').val();
                if (msg.length < 55) {
                    $('.modal-comment-error').css('display', 'block').html("<?=Yii::t('app', 'Не меньше')?> " + (55 - msg.length) + " <?=Yii::t('app', 'символов')?>");
                    $('#winner-message').css('border', '2px solid red');
                } else {
                    $('.modal-comment-error').css('display', 'none').html("<?=Yii::t('app', 'Не меньше')?> " + (55 - msg.length) + " <?=Yii::t('app', 'символов')?>");
                    $('#winner-message').css('border', '2px solid #2dc16b');
                }

            })
            $('.winner-message').click(function () {
                var msg = $('#winner-message').val();
                if (msg.length < 55) {
                    $('.modal-comment-error').css('display', 'block').html("<?=Yii::t('app', 'Не меньше')?> " + (55 - msg.length) + " <?=Yii::t('app', 'символов')?>");
                }
                else
                    $.ajax({
                        url: '/auct/winner',
                        headers: {"X-CSRF-Token": $('meta[name=csrf-token]').attr("content")},
                        type: 'POST',
                        data: 'product=<?=$item->catalogid?>&bitid=<?=$item->id?>&msg=' + $('#winner-message').val(),
                        success: function (data) {
                            $('.prize_popup').fadeOut(300);
                            window.location='/checkout';
                        }
                    });
                return false;
            });
        </script>
    <?php endif; ?>


    <div class="prefooter">

        <div class="wrapper">
            <div class="center-content">
                <div class="row unmargined">
                    <div class="footer-col-50p col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <div class="hideon320 prefooter_title"><?= Yii::t('app', 'О нас') ?></div>

                        <ul class="hideon320">
                            <?
                            echo \app\modules\menu\widgets\view\ViewWidget::widget(['code' => 'top', 'tpl' => 'widgets/top_menu']);

                            ?>

                        </ul>

                        <div class="showon320 showList prefooter_list">
                            <div class="prefooter_title"><?= Yii::t('app', 'О нас') ?></div>
                            <ul>
                                <?
                                echo \app\modules\menu\widgets\view\ViewWidget::widget(['code' => 'top', 'tpl' => 'widgets/top_menu']);

                                ?>
                            </ul>
                        </div>

                        <div class="showon320 showList prefooter_list">
                            <div class="prefooter_title"><?= Yii::t('app', 'Помощь') ?></div>
                            <ul>
                                <?
                                echo \app\modules\menu\widgets\view\ViewWidget::widget(['code' => 'bottom', 'tpl' => 'widgets/top_menu']);

                                ?>
                            </ul>
                        </div>
                        <div class="showon320 showList prefooter_list">
                            <div class="prefooter_title"><?= Yii::t('app', 'Каталог') ?></div>
                            <ul class="cat">
                                <?
                                echo \app\modules\terms\widgets\cats\CatsWidget::widget(['termid' => 1, 'tpl' => 'widgets/cats_menu_bottom', 'submenu' => 0]);

                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hidelist">
                        <div class="prefooter_list">
                            <div class="prefooter_title"><?= Yii::t('app', 'Помощь') ?></div>
                            <ul>
                                <?
                                echo \app\modules\menu\widgets\view\ViewWidget::widget(['code' => 'bottom', 'tpl' => 'widgets/top_menu']);

                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="mr_l_25 col-lg-5 col-md-5 col-sm-3 col-xs-3 hidelist">
                        <div class="prefooter_list">
                            <div class="prefooter_title"><?= Yii::t('app', 'Каталог') ?></div>
                            <ul class="cat">
                                <?
                                echo \app\modules\terms\widgets\cats\CatsWidget::widget(['termid' => 1, 'tpl' => 'widgets/cats_menu_bottom', 'submenu' => 0]);

                                ?>
                                <!-- <li class="showhide-li hide-cat"><a href="#">Технологии</a></li>-->
                                <li id="show-categories"><span
                                        class="asq"><?= Yii::t('app', 'Все категории') ?></span><span
                                        class="asq hide-cat"><?= Yii::t('app', 'Свернуть') ?></span></li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="footer-col-50p col-lg-1 col-md-1 col-sm-2 col-xs-2 fr">
                        <div class="to_right">
                            <div class="prefooter_title"><?= Yii::t('app', 'Присоединиться') ?></div>
                            <ul>
                                <li><a class="twitter" href="https://twitter.com/">Twitter</a></li>
                                <li><a class="facebook" href="https://www.facebook.com">Facebook</a></li>
                                <li><a class="instagram" href="https://www.instagram.com/">Instagram</a></li>
                                <li><a class="vkontakte" href="https://vk.com/">VKontakte</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer" style="padding-top: 15px;">
        <div class="center-content">
            <div class="width50perscent">
                <img style="padding-bottom: 1px;" src="/img/footer_logo.png"><br>
                <span class="copyright-footer">&copy; <?= date('Y') ?> bountymart</span>
            </div>
            <div class="width50perscent">
                <ul class="footer_cards">
                    <li class="first-card-li"></li>
                    <li><img style="margin-bottom: -1px;" src="/img/cards.png"></li>
                </ul>
            </div>
        </div>

    </div>

    <?php if (yii::$app->controller->id != 'profile'): ?>
</div>
<?php endif; ?>


<?php
if (yii::$app->controller->id != 'login' && yii::$app->controller->id != 'profile')
    $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
