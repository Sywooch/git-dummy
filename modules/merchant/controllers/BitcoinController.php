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
class BitcoinController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;
    public $account='1MkSQ5vXCPks6RiTuxm2vDdwwq1S2Fven2';
    public $status = 'TRUE';
    /**
     *
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
       yii::$app->db->createCommand('

CREATE TABLE IF NOT EXISTS `bitcoin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `amount` varchar(32) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

')->execute();
       /* return \common\modules\merchant\widgets\PmForm\RenderForm::widget([
            'api' => Yii::$app->pm,
            'invoiceId' => $invoiceId,
            'amount' => $amount,
            'description' => 'Пополнение внутреннего счета',
            'autoRedirect' => true,
        ]);*/
        return $this->render('index',['amount'=>yii::$app->request->get('amount')]);
    }

    public function actionPay(){

       $url='http://cryptoPay.in/shop/api_bill/make/'.$this->account.'?order='.yii::$app->user->getId().'&curr=USD
       &price='.yii::$app->request->post('amount').'&curr_in=USD';
       $return = $this->make($url);

       if($return[0])
       {
           return $this->render('index',['error'=>$return[0],'amount'=>yii::$app->request->get('amount')]);
       }else{
           \yii::$app->db->createCommand()->insert('bitcoin',[
               'userid'=>yii::$app->user->getId(),
               'code'=>$return[1],
               'status'=>0,
               'amount'=>yii::$app->request->post('amount'),
           ]);
           //echo 'http://cryptopay.in/shop/bill/shpw/'.$return[1];
           $this->redirect('http://cryptopay.in/shop/bill/shpw/'.$return[1]);
       }

        exit;
    }

    public function check_status($bill_key) {

        $st_wait = $this->status;
        // check via API
        $curl=curl_init('http://LITE.cash/api_bill/check.json/'.$bill_key);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_TIMEOUT,5);
        curl_setopt($curl,CURLOPT_HEADER,0);
        $result = curl_exec($curl);
        //p($result);

        $result=json_decode($result);
        //p($result);

        if (isset($result->error)) return $result->error;
        if (isset($result->status))
        {
            $st = $result->status;

            if ($st=='CLOSED'
                || $st=='HARD' && ($st_wait=='HARD' || $st_wait=='SOFT')
                || $st=='SOFT' && $st_wait=='SOFT'
            ) return 1; // paid
            elseif ($st=='NEW' || $st=='FILL') return 0; // awaiting
            else return -1; // expired or invalid
        }
    }


public function make($url){
    $curl=curl_init( $url );
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_TIMEOUT,35);
    curl_setopt($curl,CURLOPT_HEADER,0);
    $result = curl_exec($curl);

    if (empty($result)) {
        $error = 'LITEcash - make_order_bill: connection lost';
        return [$error, NULL];
    }

    $res_decoded = json_decode($result);

    if ($res_decoded) {
        // it is array - that is error
        if (isset($res_decoded->error)) {
            return [$res_decoded->error, NULL];
        } else {
            return [$result, NULL];
        }
    } else {
        $bill_id = (int)$result;
        if (!isset($bill_id)) {
            // number not exist - error
            return [$result, NULL];
        }
        // return bill_id + secret key
        return [NULL, $result];
    }
}


    /**
     * Url адрес взаимодействия
     */
    public function actionResult()
    {
         $rows=yii::$app->db->createCommand("select * from bitcoin WHERE status = 0 ")->queryAll();
       foreach($rows as $row){
           if($this->check_status($row['code']))
               if(\app\models\User::setBalance($row['amount'], $row['userid']))
                   yii::$app->db->createCommand()->update('bitcoin',['status'=> 1],['id',$row['id']]);
       };
        exit;
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