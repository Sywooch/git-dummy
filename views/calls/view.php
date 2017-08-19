<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

 <h3>Информация по обзвону</h3>
<?= DetailView::widget([
        'model' => $data,
        'attributes' => [
            'catalog_number',
            'catalog_to',
            'catalog_from',
            'catalog_text',




            [
                'attribute'=>'langid',
                'value'=>  $data->lang->terms_text,
            ],

            [
                'attribute'=>'sexid',
                'value'=>  $data->sex->terms_text,
            ],


            [
                'label'=>'Статус',
             'value'=>  $data->terms->terms_text,
            ],


            'catalog_text:html',
            'comment:html',


            'date_modified:datetime',
        ],
    ]);

if(count($data->options)):?>
    
<h4>Дополнительные сведения</h4>
    <table class="table table-striped table-bordered detail-view"><tbody>
        <?php foreach($data->options as $row): ?>
        <tr><th><?=$row->terms->terms_text?> <?php if($row->terms->terms_id == 55) echo 'Номер на замену - '.$data->change_number?></th></tr>
        <?php endforeach; ?>
     </tbody>
        </table>
<?php endif;?>