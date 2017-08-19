<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

 
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'seo_id',
            'seo_title',
            'seo_url:url',
            'seo_key',
            'seo_desc',
            'seo_text',
            'seo_page',
            'date_modified:datetime',
        ],
    ]) ?>
    
