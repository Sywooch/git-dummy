<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset_admin extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '/assets/admin/';


    public $css = [
        'css/bootstrap.min.css',
        'font-awesome/css/font-awesome.min.css',


        'css/animate.css',
        'css/style.css',

        //  'js/plugins/themify-icons/themify-icons.min.css',
    ];




    public $js = [
       # 'js/jquery-2.1.1.js',
        'js/bootstrap.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/inspinia.js',
        'js/plugins/pace/pace.min.js'
         ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
