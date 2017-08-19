<?php
use yii\helpers\Html;
?>

 <div class="container" style="padding-bottom:30px;">
 <div class="row">
 <h3>Фотогаллерея</h3>
<?= \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
        'pager'=>[
            'hideOnSinglePage'=>true,
			 
			
        ],
        'itemView'=>'_item',
		'layout' => '{items}{pager}',
    ])?>
	</div></div>