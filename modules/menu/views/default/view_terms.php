<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use app\modules\menu\models\Menu;
use app\modules\menu\widgets\tree\TreeWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?> 	 <br>

	<p>
       <?= Html::a(Yii::t('admin', 'Создать пункт меню для {terms_cat}',['terms_cat'=>$tcat]), ['default/create','termin'=>$tcat], ['class' => 'btn btn-info']) ?>
       
        
    </p>

<div style="width:500px;">
<? 

	echo  TreeWidget::widget(['termin'=>$tcat ]);
?>	 
</div>
   