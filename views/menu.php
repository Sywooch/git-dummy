<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\BaseUrl;


    $menu=[
        ['label' => \Yii::t('admin', 'На сайт'), 'url' => ['/']],
        ['label' => \Yii::t('admin', 'Слайдер'), 'url' => ['/gallery/admin/index'],
        'active'=>'gallery'],


       ['label' => \Yii::t('admin', 'Статичные страницы'), 'url' => ['/staticpage/admin/index'], 'active'=>'staticpage'],

        ['label' => \Yii::t('admin', 'Товары, БД'), 'url' => ['/catalog/admin/index'] , 'active'=>'catalog'],


        ['label' => \Yii::t('admin', 'Категории'), 'url' => ['/terms/default/index'] , 'active'=>'terms'],
        ['label' => \Yii::t('admin', 'FAQ'), 'url' => ['/news/admin/index']],
        ['label' => \Yii::t('admin', 'Билинг'), 'url' => ['/catalog/balancehistory/index'] ,
         'active'=>'catalog'
        ],


      /*  [
            'label' => \Yii::t('admin', 'Розыгрыши'),

            'items'=>[
                ['active'=>'catalog','label' => \Yii::t('admin', 'В процессе'), 'url' => ['/catalog/bits/index?status=0']],
                ['active'=>'catalog','label' => \Yii::t('admin', 'Проигрыш'), 'url' => ['/catalog/bits/index?status=2']],
                ['active'=>'catalog','label' => \Yii::t('admin', 'Истек срок'), 'url' => ['/catalog/bits/index?status=3']],
                ['active'=>'catalog','label' => \Yii::t('admin', 'Победители'), 'url' => ['/catalog/bits/index?status=1']],
            ]
        ],*/
        [

            'label' => \Yii::t('admin', 'Сообщения'),
            'items'=>
                [
                    [ 'active'=>'tickets','label' => \Yii::t('admin', 'Сообщения'), 'url' => ['/tickets/admin/message']],
                    [ 'active'=>'tickets','label' => \Yii::t('admin', 'Активность'), 'url' => ['/tickets/admin/activity']],
                ]
        ]        ,
       // ['label' => \Yii::t('admin', 'Заявки на вывод средств'), 'url' => ['/catalog/balanceout/index']],


        ['label' => \Yii::t('admin', 'Магазин'),
         'items'=>[

             ['label'=>\Yii::t('admin', 'Магазин'), 'url' => ['/shop/admin/index']],
          //   ['label'=>\Yii::t('admin', 'Курсы валют'), 'url' => ['/shop/curs/index']],
         ]
        ],
        /* ['label' => \Yii::t('admin', 'Отзывы'), 'url' => ['/reviews/admin/index']],
          */


        ['label' => \Yii::t('admin', 'Доставка'), 'url' => ['/catalog/delivery/index'] ,  'active'=>'catalog',],
        ['label' => \Yii::t('admin', 'Общая статистика'), 'url' => ['/catalog/info/index'] ,  'active'=>'catalog'],


        [
            'label' => \Yii::t('admin', 'Настройки'),

            'items'=>
                [
                    ['label' => \Yii::t('admin', 'Пользователи'), 'url' => ['/user/admin/index'],
                     'active'=>'user',],
                    ['label' => \Yii::t('admin', 'Меню'), 'url' => ['/menu/default/index']
                    , 'active'=>'menu',],
                    [
                        'label' => \Yii::t('admin', 'Текстовые блоки'),
                        'active'=>'system',
                        'url' => ['/system/text/index']

                    ],
                    [
                        'label' => \Yii::t('admin', 'Курсы валют'),
                        'active'=>'system',
                        'url' => ['/system/course/index']
                    ],
                    [
                        'label' =>\Yii::t('admin', 'Менеджер Картинок'),
                        'active'=>'system',
                        'url' => ['/system/images/index']
                    ],
                   /*
                    [
                        'label' => \Yii::t('admin', 'Файловый менеджер'),
                        'url' => ['/system/filemanager/index']
                    ],
                    [
                        'label' => \Yii::t('admin', 'Backup'),
                        'url' => ['/backup']
                    ],

                    [
                        'label' => \Yii::t('admin', 'Задачи'),
                        'url' => ['/system/task/index']
                    ],
                    [
                        'label' =>'Seo',
                        'url' => ['/seo/default/index']
                    ],
                    */
                    [
                        'label' => \Yii::t('admin', 'Настройки'),
                        'active'=>'system',
                        'url' => ['/system/config/index']
                    ],

                ]

        ],

        ['label' => 'Выход', 'url' => ['/user/logout/index']],                           ];
?>



<ul class="nav" id="side-menu">
    <li class="nav-header">
        <div class="dropdown profile-element">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Админ</strong>
                             </span>  </b></span> </span> </a>

        </div>
        <div class="logo-element">
            IN+
        </div>
    </li>







<?php

foreach(yii::$app->modules as $model){
    if(isset($model->id) && $model->id!='debug' && $model->id!='gii' )
        $active = $model->id;
};

    foreach($menu as $point):
?>

        <?php if(!isset($point['items'])): ?>
        <li <?=(getMenu($active,$point))?'class="active"':''?>>

                <a href="<?=BaseUrl::to(  $point['url'] )?>">
                <i class="fa fa-th-large"></i>
                <span class="nav-label"><?=$point['label']?></span>
                 </a>
        </li>
        <?php else: ?>

        <li <?=(getMenu($active,$point))?'class="active"':''?>>

                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label"><?=$point['label']?></span><span class="fa arrow"></span></a>



                      <ul class="nav nav-second-level">
                    <?php foreach($point['items'] as $item): ?>

                        <li><a href="<?=BaseUrl::to(  $item['url'] )?>"><?=$item['label']?></a></li>

                    <?php endforeach; ?>
                    </ul>

        </li>

        <?php endif; ?>

<?php endforeach;
function getMenu($model,$el){
    if($model == $el['active']){
            if(strstr( $el['url'][0],('/'.$model.'/'.yii::$app->controller->id))){
                return true;
            }
     }elseif(isset($el['items']) ){
        foreach($el['items'] as $sel){
            if(getMenu($model,$sel ))
                return true;
        }
    }
}?>

</ul>







