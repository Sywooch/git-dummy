
 
 <?
 use yii\helpers\Html;
use yii\grid\GridView;
 
echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'filename',
            'mimeType',
			'byteSize',
			'NotActive',
            

            [
			'class' => 'yii\grid\ActionColumn',
			'buttons'=>[
                  
		  'view'=>function ($url, $model) {
           	 return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>',$url,['class'=>"various fancybox.ajax", 'data-fancybox-type'=>"ajax"  ] );
               },
			 
           	 ],
           'template'=>' {delete}',
			
			],
        ],
    ]); ?>
 