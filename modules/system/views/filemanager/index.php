<?php
/* @var $this yii\web\View */
$this->title = Yii::t('admin', 'Управление файлами')
?> 

<div class="clearfix"></div>
 <h1><?php echo $this->title?></h1> 
 
        <?php 
		
 use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

/*echo InputFile::widget([
    'language'   => 'ru',
    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'name'       => 'myinput',
	 
    'value'      => '',
]);*/

/*echo $form->field($model, 'attribute')->widget(InputFile::className(), [
    'language'      => 'ru',
    'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    'options'       => ['class' => 'form-control'],
    'buttonOptions' => ['class' => 'btn btn-default'],
    'multiple'      => false       // возможность выбора нескольких файлов
]);*/

echo ElFinder::widget([
   # 'language'         => 'ru',
    'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    #'filter'           => 'application',
	'frameOptions' => ['style'=>'min-height: 500px; width: 100%'],
#	'height' => '1000px',
	  // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    #'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);

        ?>
  