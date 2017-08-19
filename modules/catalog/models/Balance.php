<?php

namespace app\modules\catalog\models;

use app\modules\system\models\TextWidget;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class Balance extends \yii\db\ActiveRecord
{

    public $date2;

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
        return 'balance_history';
    }

    public function attributeLabels()
    {
        return
            [
                'catalogid' => Yii::t('admin', 'Товар'),

                'money' => Yii::t('admin', 'Итог'),
                'moneychange' => Yii::t('admin', 'Сумма'),
                'comment' => Yii::t('admin', 'Коммент'),
                'date' => Yii::t('admin', 'Дата'),

                'outstat' => Yii::t('admin', 'Заявка на вывод'),
                'holdstat' => Yii::t('admin', 'резервирование|Снятие'),
                'hide'=>'Скрыть'

            ];
    }

    public function rules()
    {
        return [
            [['catalogid', 'money', 'moneychange'], 'default', 'on' => ['search']],
            [['userid', 'catalogid', 'money', 'moneychange', 'comment'], 'required'],
            [['holdstat', 'outstat','hide'], 'default', 'value' => 0],
            [['date', 'date2','hide'], 'default'],

        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }

    public function getCatalog()
    {
        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id' => 'catalogid']);
    }


    public static function resetHold($uid, $cid, $comment)
    {

        $balance = self::find()->where('catalogid = ' . $cid . ' and holdstat = 1 and userid = ' . $uid)->one();
        if ($balance !== null) {
            $balance->holdstat = 0;
            $balance->comment = $comment;
            $balance->save();
        }
    }

    public static function returnHold($model)
    {

        $balance = self::find()->where('catalogid = ' . $model->catalog_id . ' and holdstat = 1 and userid = ' . $model->userid)->one();
        if ($balance !== null) {
            $balance->user->balance += -$balance->moneychange;
            $balance->user->save();
            $balance->delete();

        }
        return $model;
    }

    public static function returnHoldById($id, $comment)
    {

        $balance = self::find()->where('id = ' . $id)->one();

        if ($balance !== null) {
            $balance->user->balance += -$balance->moneychange;
            $balance->user->save();
            $balance->comment = 'Отменено админом - ' . $comment . '';
            //$balance->delete();
            if ($balance->save())
                return true;
        }
        return false;
    }

    public static function add($catalogid, $money, $moneychange, $comment, $uid, $status)
    {


        $model = new self;
        $model->catalogid = $catalogid;
        $model->money = ($money==0)?"0.0":$money;
        $model->moneychange = $moneychange;
        $model->comment = $comment;
        $model->userid = $uid;

        if ($status == 'hold')
            $model->holdstat = 1;

        if ($status == 'outstat')
            $model->outstat = 1;

        if ($model->save()) {

            return $model->id;
        } else{
            print_R($model->getErrors());
            return ['error' => \yii::t('app', 'Не удалось сохранить баланс')];
        }
        return ['error' => 'unknow'];
    }


    public static function checkHold($cid, $uid)
    {
        $row = \yii::$app->db->createCommand("select * from auct WHERE catalogid = $cid and status = 0 and codeindex=0 ORDER BY id DESC")->queryOne();//self::find()->where(['catalogid' => $cid, 'userid' => $uid, 'holdstat' => 1])->one();
        if ($row['userid'] == $uid) {
            return true;
        }
        return false;
    }

    public static function setUnHold($cid, $uid)
    {
        $row = self::find()->where(['catalogid' => $cid, 'userid' => $uid, 'holdstat' => 1])->one();
        if ($row) {
            $row->holdstat = 0;
            $row->comment = Yii::t('app', 'Списание средств за победу в аукционе');
            $row->save();
        }
    }

    public static function unHold($cid,$textWidget='return_money_for_bit')
    {

        $row = self::find()->where(['catalogid' => $cid, 'holdstat' => 1])->one();
        if ($row) {


            //   $model = \app\models\User::findOne($row->userid);
            //   $model->balance=$model->balance+str_replace('-','',$row->moneychange);
            //   $model->save();
            $row->holdstat = 0;
            $row->save();



            if($row->user->lang == 'en'){
                $item2 = \app\modules\catalog\models\Catalog::find()->where(['langid' => $cid])->one();
            }else{
                $item2 = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $cid])->one();
            }


            \app\models\User::setBalance(str_replace('-', '', $row->moneychange), $row->userid, $cid, $comment =  'Возврат средств за ставку');

            \app\modules\tickets\models\Tickets::add($cid,
                TextWidget::getTpl($textWidget, [
                    'link' => $row->catalog->catalog_url,
                    'item' => $item2->catalog_name ], $row->user->lang)
                , 2, 2, $row->userid, 0,
                TextWidget::get($textWidget)->one()->statusid);


            return $row;
        }
    }

    public static function converBonus()
    {
        if (yii::$app->user->identity->bonus > yii::$app->params['bonus']) {
            yii::$app->user->identity->bonus -= yii::$app->params['bonus'];
            yii::$app->user->identity->balance += yii::$app->params['bonustomoney'];
            \app\modules\tickets\models\Tickets::add(0, \app\modules\system\models\TextWidget::getTpl('bonus_to_money'), 2, 2, yii::$app->user->identity->id);
        }
    }

    public function search($params)
    {


        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*if (!($this->load($params) && $this->validate()) ) {
            return $dataProvider;
        }*/


        $query->andWhere('userid = ' . yii::$app->user->getId());


        return $dataProvider;
    }


    public function searchAdmin($params)
    {


        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => array(
                'defaultOrder' => ['date' => SORT_DESC],
            ),
            'pagination' => [
                'pageSize' => 50,

            ],
        ]);

        if (!($this->load($params)/* && $this->validate()*/)) {
            return $dataProvider;
        }

        if ($this->userid)
            $query->andWhere('userid = ' . $this->userid);
        if ($this->catalogid)
            $query->andWhere('catalogid = ' . $this->catalogid);

        if ($this->date && $this->date2) {
            $query->andWhere('date > "' . $this->date . '" and date < "' . $this->date2 . '"');
        }


        return $dataProvider;
    }


}