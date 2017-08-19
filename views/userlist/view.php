<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

 
<?= DetailView::widget([
        'model' => $data,
        'attributes' => [
            'catalog_number',
            'catalog_to',
            'catalog_from',
            'catalog_text',
            'langid',

            'sexid',
            'statusid',
            'change_number',
            'premium',
            'common',
            'date_modified:datetime',
        ],
    ]) ?>
    
