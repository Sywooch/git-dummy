<?php
    use yii\helpers\Html;
    use yii\helpers\BaseUrl;

    function mb_str_ireplace($co, $naCo, $wCzym)
    {
        $wCzymM = mb_strtolower($wCzym,'UTF-8');
        $coM    = mb_strtolower($co,'UTF-8');
        $offset = 0;

        while(!is_bool($poz = mb_strpos($wCzymM, $coM, $offset)))
        {
            $offset = $poz + mb_strlen($naCo);
            $wCzym = mb_substr($wCzym, 0, $poz). $naCo .mb_substr($wCzym, $poz+mb_strlen($co));
            $wCzymM = mb_strtolower($wCzym);
        }

        return $wCzym;
    }



?>








<?php if(count($models)):
    foreach($models as $model):
    $img = app\modules\system\models\Pictures::getImages('catalog',$model['catalog_id']);
    ?>
    <div class="item-st1">

        <?php $bits = \app\models\Bits::getInfo($model->catalog_id);?>

        <div class="ll1">

            <img src="
        <?=($model->iszoomer)?(new app\components\ImageComponent)->crop($img[0],70,50):(new app\components\ImageComponent)->crop($img[0],58,44,false,0);  ?>
        " alt=""></div>

        <div class="rr1"><div><span><?=$model->persentToEnd()?>%</span><?=yii::t('app','прогресс')?></div></div>

        <div class="ov-tit1">
            <div id="bit"><span>
                    <?php if(yii::$app->user->getId()):?>
                    <?=mb_str_ireplace(yii::$app->request->post('key'),'<i>'.yii::$app->request->post('key').'</i>',$model->getName(90) )?>
                    <?php else: ?>
                    <?=mb_str_ireplace(yii::$app->request->post('key'),'<i>'.yii::$app->request->post('key').'</i>',$model->getName(60) )?>
                    <?php endif; ?>
                </span></div>
            <div id="small"><span><?=mb_str_ireplace(yii::$app->request->post('key'),'<i>'.yii::$app->request->post('key').'</i>',$model->getName(60) )?></span></div>
        </div>

        <a href="<?=$model->catalog_url?>"></a>

    </div>
    <?php endforeach;?>

    <?php if(count($models) ==3): ?><a href="/search?key=<?=\yii::$app->request->post('key')?>" class="arrow_button"></a> <?php endif; ?>
<?php else:?>
    <div class="item-st1" style="padding-bottom: 0px;"><?=\yii::t('app','Ничего не найдено')?></div>
<?php endif;?>


