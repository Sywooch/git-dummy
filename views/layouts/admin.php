<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset_admin;
    /* @var $this \yii\web\View */
    /* @var $content string */
AppAsset_admin::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- start: GOOGLE FONTS -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <!-- end: GOOGLE FONTS -->
    <?php $this->head() ?>

</head>
<body>

<?php $this->beginBody() ?>



<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">

            <?=$this->render('@app/views/menu')?>






        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">


                </div>


            </nav>
        </div>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2><?=($this->params['name'])?$this->params['name']:'Главная'?></h2>
                <!--<ol class="breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a>Tables</a>
                    </li>
                    <li class="active">
                        <strong>Static Tables</strong>
                    </li>
                </ol>-->
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">

            <?=$content?>

        </div>


    </div>
</div>

<?php $this->endBody() ?>

<?php  

    Yii::$app->view->registerCssFile(Yii::$app->params['sitehost'].'assets/selectsize/css/selectize.default.css');
    Yii::$app->view->registerJsFile(Yii::$app->params['sitehost'].'assets/selectsize/selectize.js');


?>



  



</body>
</html>
<?php $this->endPage() ?>
