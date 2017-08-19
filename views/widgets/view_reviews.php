<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>




Добавить отзыв


<?
    $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'reviews_text')->textArea(['rows' => '2']) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>



<div class="b_sidebar_news" style="cursor:pointer"  >
    <div class="b_sidebar_news_title">Отзывы</div>
    <ul>
        <?php

            if($data)
                foreach($data as $row)
                {
                    ?>


                    <li>	<?=$row['reviews_text']?></li>




                <? } ?>

    </ul>
</div>
