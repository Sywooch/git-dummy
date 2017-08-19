<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset_main;

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

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Be Actionner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">




    <link rel="icon" href="/images/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="FAVICON" type="image/x-icon"/>




    <link href="/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/mediaquery.css">
    <link rel="stylesheet" href="/css/font-awesome.css"/>
    <link rel="stylesheet" href="/css/style_spikemaster.css"/>
    <link href="/js/bxslider/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <link href="/css/jnice.css" rel="stylesheet" type="text/css"/>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>

    <script src="/js/bxslider/jquery.bxslider.min.js"></script>
    <script src="/js/flexMenu/modernizr.custom.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Quantico:700' rel='stylesheet' type='text/css'>
    <script src="/js/flexMenu/flexmenu.js"></script>


    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="/css/owl.carousel.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen, projection">


    <script src="/js/init.js"></script>
    <script src="/js/spikemaster.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
<?php if(yii::$app->controller->id != 'profile'):?>
<div id="page">
<?php endif; ?>



<header id="header">

    <div class="ct<? if(yii::$app->controller->id != 'profile'):?> ft-aut1<?php endif; ?>">

        <a href="/" class="logo"><img src="/img/logo.png" alt=""></a>

        <div class="main-menu">

            <div class="curr1" dt="0"></div>

            <ul>

                <?
                    echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'tpl'=>'widgets/cats_menu','submenu'=>1]);

                ?>

            </ul>

        </div>

        <div class="ln1"></div>


        <?      echo  (new \app\components\widgets\Language)->mainList();                 ?>
        <?      echo  \app\modules\user\widgets\AuthWidget::widget();                 ?>

        <div class="bf2<? if(yii::$app->controller->id != 'profile'):?> bf22<?php endif; ?>"></div>

        <div class="ln1"></div>

        <div class="bf1"></div>

        <div class="search1">

            <div class="poss-mob1" style="">


                <div class="ov-search1">
                    <form method="get" action="/search">

                    <input type="submit" class="search-submit" value="">

                    <div><input autocomplete="off" type="text" name="key<?=mktime()?>" class="et-srh1" value="<?=Yii::t('app', 'ПОИСК')?>" data-place="<?=Yii::t('app', 'ПОИСК')?>"></div>
                    </form>
                </div>

            </div>

            <div class="bt-mob1"></div>

        </div>

        <div class="modal-ff1" style="left: 291px; width: 437px;">



        </div>

    </div>

</header>


<div style="height: 133px; padding: 0px; border: 0px none;" class="cart_and_draw"><div class="" style="border-color: rgb(51, 51, 51); border-radius: 0px; border-style: none; border-width: 0px; border-collapse: separate; border-image: none; border-spacing: 0px; box-shadow: none; box-sizing: border-box; outline: 0px none rgb(51, 51, 51); outline-offset: 0px; overflow: visible; padding: 0px; width: 60px;">
<!--        <a class="cart" href="#"><img src="/img/icon_cart.png" alt=""><span>12</span></a>-->
       <?php if($wc=\app\modules\system\models\Notice::Activity(2)):?>
        <a class="product_draw" href="#"><img src="/img/products_draw.png" alt=""><span><?=$wc?></span></a>
        <?php endif; ?>
    </div>
</div>


<?=$content?>

<?php if($item = \app\modules\system\models\Notice::MessageForWinner()):
    $img = app\modules\system\models\Pictures::getImages('catalog',$item->catalogid);
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
                        <p class="title_red_big">Поздровляем!</p>
                        <p>Вы - выиграли</p>
                        <p class="name_prize"><?=$item->catalog->catalog_name?></p>
                        <div class="for_img"><img src="<?=(new app\components\ImageComponent)->adaptive($img[0],316,256);?>" alt="Iphone 6"></div>
                        <p>Что Вы сейчас чувствуете?</p><textarea name="" id="winner-message" cols="30" rows="10"></textarea>
                        <input type="submit" value="Отправить" class="winner-message green_button button">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.winner-message').click(function(){

        $.ajax({
            url:  '/bit/winner' ,
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            type:'POST'            ,
            data:'product=<?=$item->catalogid?>&bitid=<?=$item->id?>&msg='+$('#winner-message').val(),
            success: function(data)
            {
                $('.prize_popup').fadeOut(300);
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
                    <div class="hideon320 prefooter_title">О нас</div>

                    <ul class="hideon320">
                        <?
                            echo  \app\modules\menu\widgets\view\ViewWidget::widget(['code'=>'top','tpl'=>'widgets/top_menu']);

                        ?>

                    </ul>

                    <div class="showon320 showList prefooter_list">
                        <div class="prefooter_title">О нас</div>
                        <ul>
                            <?
                                echo  \app\modules\menu\widgets\view\ViewWidget::widget(['code'=>'top','tpl'=>'widgets/top_menu']);

                            ?>
                        </ul>
                    </div>

                    <div class="showon320 showList prefooter_list">
                        <div class="prefooter_title">Помощь</div>
                        <ul>
                            <?
                                echo  \app\modules\menu\widgets\view\ViewWidget::widget(['code'=>'bottom','tpl'=>'widgets/top_menu']);

                            ?>
                        </ul>
                    </div>
                    <div class="showon320 showList prefooter_list">
                        <div class="prefooter_title">Каталог</div>
                        <ul class="cat">
                            <?
                                echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'tpl'=>'widgets/cats_menu_bottom','submenu'=>0]);

                            ?>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hidelist">
                    <div class="prefooter_list">
                        <div class="prefooter_title">Помощь</div>
                        <ul>
                            <?
                                echo  \app\modules\menu\widgets\view\ViewWidget::widget(['code'=>'bottom','tpl'=>'widgets/top_menu']);

                            ?>
                        </ul>
                    </div>
                </div>
                <div class="mr_l_25 col-lg-5 col-md-5 col-sm-3 col-xs-3 hidelist">
                    <div class="prefooter_list">
                        <div class="prefooter_title">Каталог</div>
                        <ul class="cat">
                            <?
                                echo  \app\modules\terms\widgets\cats\CatsWidget::widget(['termid'=>1,'tpl'=>'widgets/cats_menu_bottom','submenu'=>0]);

                            ?>
                           <!-- <li class="showhide-li hide-cat"><a href="#">Технологии</a></li>-->
                            <li id="show-categories"><span class="asq">Все категории</span><span class="asq hide-cat">Свернуть</span></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="footer-col-50p col-lg-1 col-md-1 col-sm-2 col-xs-2 fr">
                    <div class="to_right">
                        <div class="prefooter_title">Присоединиться</div>
                        <ul>
                            <li><a class="twitter" href="#">Twitter</a></li>
                            <li><a class="facebook" href="#">Facebook</a></li>
                            <li><a class="instagram" href="#">Instagram</a></li>
                            <li><a class="vkontakte" href="#">VKontakte</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="center-content">
        <div class="width50perscent">
            <img style="padding-bottom: 1px;"  src="/img/footer_logo.png"><br>
            <span class="copyright-footer">&copy; 2015 beauctionner</span>
        </div>
        <div class="width50perscent">
            <ul class="footer_cards">
                <li class="first-card-li">При поддержке: </li>
                <li><img style="margin-bottom: -1px;" src="/img/cards.png"></li>
            </ul>
        </div>
    </div>
</div>

<?php
    if(yii::$app->controller->id != 'login' && yii::$app->controller->id != 'profile')
        $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
