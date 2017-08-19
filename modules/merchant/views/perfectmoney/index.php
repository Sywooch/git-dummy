
<?php
    echo \app\modules\merchant\widgets\PmForm\RenderForm::widget([
        'api' => Yii::$app->pm,
        'invoiceId' => 1,
        'amount' => 100,
        'description' => 'Пополнение внутреннего счета',
        'autoRedirect' => true,
    ]);

    ?>