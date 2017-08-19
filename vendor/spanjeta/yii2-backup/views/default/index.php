<div class="backup-default-index">

<?php
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Manage',
		'url' => array (
				'index' 
		) 
];

use yii\bootstrap\ButtonGroup;
?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
<div class="alert alert-success">
	<?php echo Yii::$app->session->getFlash('success'); ?>
</div>
<?php endif; ?>

<h1>Manage database backup files</h1>
 <?php
	 	use yii\helpers\Url;	
		
		 
			 echo ButtonGroup::widget([
    'buttons' => [
        [
		 'label' => Yii::t('admin', 'Create Backup'),
		 'options' => [ 	
		 				'onclick' =>'window.location="'.Url::toRoute('/backup/default/create').'"',
					  ],
			
		] 
    ]
]);
 

			 
			?>
	<div class="row">
   
		 
<?php

echo $this->render ( '_list', array (
		'dataProvider' => $dataProvider 
) );
?>
		 
		 
	</div>

</div>