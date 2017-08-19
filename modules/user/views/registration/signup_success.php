<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>


<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>$this->title ]] )?>
<div class="row ">
    <div class="loader_page">

        <div id="center_column" class="center_column span9 clearfix" style="padding-left: 25px;">



                Регистрация завершена успешно можете авторизоваться.

            <div class="clear"></div>
        </div>
    </div>
</div>
