<?php
    echo \app\modules\merchant\widgets\perfectmoney\RenderForm::widget([
        'api' => Yii::$app->pm,
        'invoiceId' => yii::$app->user->getId(),
        'amount' => $_GET['amount'],
        'description' => 'Пополнение внутреннего счета',
        'autoRedirect' => true,
    ]);

    ?>