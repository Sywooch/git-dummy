<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
    use yii\widgets\ActiveForm;
?>

 <h4><?=$model->title?></h4>
<?php
    if(count($model->mes)):
        foreach($model->mes as $row):?>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$row->user->username?> <?=$row->date_modified?></h3>
                </div>
                <div class="panel-body">
                   <?=$row->message?>
                </div>
            </div>

        <?php endforeach;
    endif;
?>

<?php $form = ActiveForm::begin();  ?>

<h4>Написать ответ</h4>

<?= $form->field($model, 'statusid')->dropDownList(\app\modules\terms\models\Terms::dropDown(13), ['prompt'=>'']) ?>

<?= $form->field($modelc, 'userid')->hiddenInput(['value'=>yii::$app->user->getId()])->label(false) ?>
<?= $form->field($modelc, 'tcatid')->hiddenInput(['value'=>$model->id])->label(false) ?>
<?= $form->field($modelc, 'message')->textarea() ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Создать') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

