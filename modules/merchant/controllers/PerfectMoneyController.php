<?php

namespace app\modules\merchant\controllers;

use yii\web\HttpException;
use yii\web\Controller;
use Yii;
use app\components\access\RulesControl;
use yii\filters\AccessControl;
/**
 * PerfectMoney Controller
 */
class PerfectMoneyController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'allow' => '*',//RulesControl::callback('Administrator'),
                        'roles' => ['@'],
                    ]

                ],
            ]


        ];

    }


    public function actionIndex(){
       /* return \common\modules\merchant\widgets\PmForm\RenderForm::widget([
            'api' => Yii::$app->pm,
            'invoiceId' => $invoiceId,
            'amount' => $amount,
            'description' => 'Пополнение внутреннего счета',
            'autoRedirect' => true,
        ]);*/
        return $this->render('index');
    }
    /**
     * Url адрес взаимодействия
     */
    public function actionResult()
    {
        if (!Yii::$app->request->post()) {
            return $this->goBack();
        }

        $post = '';
        foreach (Yii::$app->request->post() as $key => $_post) {
            $post .= $key . ': ' . $_post . PHP_EOL;
        }

        if ($this->verify(Yii::$app->request->post())) {
            $log = 'SUCCESS PAYMENT INVOICE №' . Yii::$app->request->post('PAYMENT_ID') . PHP_EOL . $post;
            Yii::info($log, 'merchant');
        } else {
            $log = 'FAIL PAYMENT INVOICE №' . Yii::$app->request->post('PAYMENT_ID') . PHP_EOL . $post;
            Yii::error($log, 'merchant');
        }
        file_put_contents('file.txt',$log);
    }

    /**
     * Успешный платеж
     */
    public function actionSuccess()
    {
        if (!Yii::$app->request->post()) {
            return $this->goBack();
        }

        if ($this->verify(Yii::$app->request->post())) {
            $amount = Yii::$app->formatter->asCurrency(Yii::$app->request->post('PAYMENT_AMOUNT'));
            Yii::$app->session->setFlash('success', 'Ваш счет пополнен на ' . $amount . ' через платежную систему Perfect Money');
            return $this->redirect(['/balance']);
        } else {
            Yii::$app->session->setFlash('danger', 'Возникла критическая ошибка');
            return $this->redirect(['/fail']);
        }


    }

    /**
     * Ошибка платежа
     */
    public function actionFailure()
    {
        if (!Yii::$app->request->post()) {
            return $this->goBack();
        }

        Yii::$app->session->setFlash('danger', 'Оплата платежа отменена');

        return $this->redirect(['/fail']);
    }

    /**
     * Верификация платежа
     */
    protected function verify($data)
    {

        if (Yii::$app->pm->checkHash($data)) {

            if(\app\models\User::setBalance($data['PAYMENT_AMOUNT'], $data['PAYMENT_ID'])){

                return true;}
            else
            {
                return false;
            }

            return true;
        }


        return false;
    }

}