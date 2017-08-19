<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Balance_out extends \yii\db\ActiveRecord
{
    const STATUS_IN = 0;
    const STATUS_OUT = 1;
    const STATUS_BAD = 2;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'date',
                'createdAtAttribute' => 'date',
                'value' => new Expression('NOW()'),
            ],



        ];
    }
	
    public static function tableName()
    {
        return 'balance_out';
    }

    public function attributeLabels()
    {
        return
            [
                'money' => Yii::t('admin', 'Сумма'),
                'paymenttype'    => Yii::t('admin', 'Способ оплаты'),
                'comment' => Yii::t('admin', 'Коммент'),
                'status' => Yii::t('admin', 'Коммент'),
                'date' => Yii::t('admin', 'Дата'),
            ];
    }

	   public function rules()
    {
        return [
            [[ 'money','moneychange'], 'default',  'on' => ['search']],
			[['userid', 'money' , 'paymenttype'], 'required'],
            [['comment','status' ,'historyid'], 'default'],
        ];
    }
	 
  public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }



    public function search($params)
    {


        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         if (!($this->load($params) && $this->validate()) ) {
            return $dataProvider;
        }




        return $dataProvider;
    }


    public static function getStatus($role = false){
        $roles = [
            self::STATUS_IN=>Yii::t('app', 'Заявка на вывод поступила'),
            self::STATUS_OUT=>Yii::t('app', 'Деньги выведены'),
            self::STATUS_BAD=>Yii::t('app', 'Отменен админом'),

        ];
        return $role!==false ? ArrayHelper::getValue($roles, $role) : $roles;
    }


    public static function addOut(){

        $money = yii::$app->request->post('amount');
        $type = yii::$app->request->post('type');
        if(!$money)
            return 'Впишите сумму';

        if(!$type)
            return 'Выберите способ оплаты';

        if(yii::$app->user->identity->balance < $money){
            return 'Указанная сумма больше допустимой';
        }

        if($money && $type){
            $bal=new self;
            $bal->userid = yii::$app->user->getId();
            $bal->money = $money;
            $bal->paymenttype = $type;
            $bal->comment = '';
            $bal->status = 0;
            if($bal->save() && $id=\app\models\User::setBalanceOut('-'.$bal->money,$bal->userid,0,'Заявка на вывод средств (резервирование)','hold')){

                $bal->historyid = $id;
                $bal->save();
                return 'success';
            }else{
                return 'Не удалось добавить заявку на вывод, обратитесь к администрации';
            }


        }


    }


}