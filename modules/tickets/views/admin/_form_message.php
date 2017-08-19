



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;

  $form = ActiveForm::begin(); ?>

<h3>Создать сообщение</h3>

<?= $form->field($model, 'statusid')->dropDownList($model->getStatus(1), ['prompt'=>'']) ?>
<?= $form->field($model, 'userid')->dropDownList(ArrayHelper::map(\app\models\User::find()->where("role=1")->all(),'id','username'), ['prompt'=>'']) ?>
<?= $form->field($model, 'textstatusid')->dropDownList(app\modules\system\models\TextWidget::$status, ['prompt'=>'']) ?>
   <?
   echo $form->field($model, 'message')->widget(letyii\tinymce\Tinymce::className(), [
    'options' => [
        'id' => 'message',
    ],
    'configs' => [ 
				  'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
]


       		 ],
   
]); 

?>

 

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

