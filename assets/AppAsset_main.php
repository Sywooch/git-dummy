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
class AppAsset_main extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '/assets/';
/*
public $css = [
    'font-awesome.css',
    'jquery.bxslider.css',
    'photoswipe.css',
    'bootstrap.css',
    'extra_style.css',
    'styles.css',
    'responsive.css',
    'superfish.css',
    'camera.css',
    'widgets.css',
    'cloud-zoom.css',
    'catalogsale.css',
    'print.css',
];*/
    public  $js = [
        'bootstrap.min.js',
        'bootstrap-checkbox.min.js'
    ];




    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
