<?php
use yii\helpers\Html;
?>


        <div class="item_info clearfix">

            <div>
                <span><?=$row->persentToEnd()?>%</span>
                <span><?=yii::t('app','прогресс')?></span>
            </div>
            <div>
                <span><?=\app\modules\system\models\Course::getPrice($row->catalog_price); ?></span>
                <span><?=yii::t('app','цена')?></span>
            </div>
            <div>
                <span><?=\app\modules\system\models\Course::getPrice($row->getPriceOne()); ?></span>
                <span><?=yii::t('app','купить за')?></span>
            </div>
        </div>
