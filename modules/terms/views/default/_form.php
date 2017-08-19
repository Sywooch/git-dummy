

<? if($model->termscatid){ ?>
<h1>Редактирование <?= app\modules\terms\models\Terms_cat::getbyId($model->termscatid)->terms_cat_text; ?>  <?= $model->terms_text?> </h1>
<? }else{ ?>
<h1>Создать</h1>
<? } ?>
<div style=" min-width:1000px;">
<?php 

use app\modules\terms\models\Terms;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\plupload\PluploadWidget;
use yii\bootstrap\Tabs;
    use app\components\widgets\Language;
  $form = ActiveForm::begin(); ?>

    <?=$tabs=(new Language)->tabs()?>
    <?=$tabs=(new Language)->content('../../../modules/terms/views/default/_form_fields',['form'=>$form,'model'=>$model])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>