<?php
use yii\helpers\Html;
?>


<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>'FAQ' ]] );


?>

<div class="line-sep"></div>
<div class="center-content content-page">
    <div class="row">
        <div class="col-md-12">
            <div class="menu-name">
                FAQ
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="simple-side-menu">
                <ul>
                    <?php foreach($menu as $row):?>
                    <li <?=($id==$row->terms_id)?'class="active"':''?>><a href="/faq/<?=$row->terms_url?>"><?=$row->terms_text?></a></li>
                    <?php endforeach;?>

                </ul>
            </div>
        </div>
        <div class="col-md-10">
            <ul class="faq-list">
                <?php $i=0; foreach($dataProvider->query->all() as $row):?>
                    <?=$this->render('_item',['model'=>$row,'index'=>$i])?>
                <?php $i++; endforeach; ?>

<!--

                --><?/*= \yii\widgets\ListView::widget([
                    'dataProvider'=>$dataProvider,
                    'pager'=>[
                        'hideOnSinglePage'=>true,
                        'disabledPageCssClass'=>'num',
                        'lastPageCssClass'=>'pagenav',
                        'nextPageCssClass'=>'pagenav',
                        'activePageCssClass'=>'active current',
                        'linkOptions'=>['class'=>'pagenav'],
                    ],
                    'itemView'=>'_item',
                    'layout' => '{items}<div class="k2Pagination">{pager}</div>',
                ])*/?>



            </ul>
        </div>
    </div>
</div>


