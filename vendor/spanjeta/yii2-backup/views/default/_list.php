<?php
use yii\helpers\Html;
use yii\grid\GridView;

echo GridView::widget([
		'id' => 'install-grid',
		'dataProvider' => $dataProvider,
		'columns' => array(
				'name',
				'size:size',
				'create_time',
				'modified_time:relativeTime',
				array(
						'class' => 'yii\grid\ActionColumn',
						'template' => '{restore}',
						'buttons' => 
						[
			                'restore' => function($id, $model) 
										{
									    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-repeat"></span>', 
																	$id
																    );
                						}
						]				
				),
				array(
						'class' => 'yii\grid\ActionColumn',
						'template' => '{delete}',

				),
		),
]); ?>