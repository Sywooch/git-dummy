<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use app\modules\terms\models\Terms;
use app\modules\terms\models\Terms_cat;
use app\modules\terms\widgets\tree\TreeWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?> 	 <br>

	<p>
        <?= Html::a(Yii::t('admin', 'Создать термин для {terms_cat}',['terms_cat'=>$tcat->terms_cat_text]), ['default/create'], ['class' => 'btn btn-info']) ?>
       <?= Html::a(Yii::t('admin', 'Редактировать  раздел термина'), ['termscat/update','id'=>$tcat->terms_cat_id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('admin', 'Удалить раздел термина'), ['termscat/delete','id'=>$tcat->terms_cat_id], ['class' => 'btn btn-danger', 'data-confirm'=>
		Yii::t('admin', "Вы уверены, что хотите удалить этот элемент?") ]) ?>
    </p>

<div style="width:500px;">
<? 
	echo  TreeWidget::widget(['termscatid'=>$tcat->terms_cat_id, ]);
?>	 
</div>
   