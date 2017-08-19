


    <div class="center-content <?=$ppc?>">
        <div class="breadcrumbs">




<?php

    echo yii\widgets\Breadcrumbs::widget([
        'homeLink'=> [
            'label' => yii::t('app','Главная'),  // required
            'url' => '/',      // optional, will be processed by Url::to()
        ],
        'activeItemTemplate' => "<li><span>{link}</span></li>",
        'itemTemplate' => '<li>{link}</li><li>&nbsp;>&nbsp;</li>', // template for all links
        'links' => $breadcrumbs,
        'options' => ['class' =>'']// 'breadcrumb']
    ]);
?>

        </div>

    </div>