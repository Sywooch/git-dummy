<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/resetpassword', 'token' => $user->password_reset_token]);
?>

    <?=\yii::t('app','Здравствуйте')?> <?= Html::encode($user->username) ?>,

<?=\yii::t('app','Перейдите по ссылке чтобы сбросить пароль:')?>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>