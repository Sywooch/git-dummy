
<p class="alert alert-warning">Заполнили один язык, нажали сохранить и после этого можно заполнять другой язык.
Тут нельзя заполнить  2 языка одновременно</p>
<ul class="nav nav-tabs">
    <li class="<?=(yii::$app->request->get('setlang','ru')=='ru')?'active':''?>">
        <a href="?setlang=ru"  >
            ru        </a>
    </li>
    <li class="<?=(yii::$app->request->get('setlang','ru')=='en')?'active':''?>">
        <a href="?setlang=en" >
            en        </a>
    </li>
</ul>




<?php if(Yii::$app->session->hasFlash('updated')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('updated') ?>
        </div>
    <?php endif; ?>
    
<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\system\models\CalcForm;



  $form = ActiveForm::begin(); 

  foreach ($model->attributeLabels() as $field => $name)
  {
  
  if( strstr($field,'text') )
  	echo $form->field($model, $field)->textarea() ;
  else
   echo $form->field($model, $field)->textInput(['maxlength' => 255]) ;
   
  }
  
  

	 ?> 


    
 
    <div class="form-group">
        <?= Html::submitButton( Yii::t('admin', 'Update FOR lang '.yii::$app->request->get('setlang','ru')), ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

