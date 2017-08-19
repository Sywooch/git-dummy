<?php

namespace app\modules\tickets\models;

use Yii;
use yii\data\ActiveDataProvider;

class Tickets extends \yii\db\ActiveRecord
{
    /* '1'=>'Победа',
             '2'=>'Важное сообщение',
             '3'=>'Текущее уведомление',*/

    /*2=>[
    '1'=>Yii::t('app', 'активно'),
    '2'=>Yii::t('app', 'просрочено'),
    '3'=>Yii::t('app', 'проигрыш'),
    '4'=>Yii::t('app', 'победа'),
    ],
    1=>[
    '1'=>Yii::t('app', 'важные'),
    '2'=>Yii::t('app', 'системные'),
    '3'=>Yii::t('app', 'критические'),
    ],*/


    const ACTIVITY = 2;
    const MESSAGE = 1;

    public $status = [
        2 => [
            '1' => 'активно',
            '2' => 'анулировано',//'просрочено',
            '3' => 'проигрыш',
            '4' => 'победа',
            '5' => 'отменено',
        ],
        1 => [
            '1' => 'важные',
            '2' => 'системные',
            '3' => 'критические',
        ],
    ];

    public function getStatus($part, $status = 0)
    {
        return $status != 0 ? $this->status[$part][$status] : $this->status[$part];
    }

    public function getStatusText($part)
    {
        return \Yii::t('app', $this->status[$part][$this->statusid]);
    }

    public static function tableName()
    {
        return 'tickets';
    }


    public static function urlPrefix()
    {
        return '/';
    }

    public function behaviors()
    {
        return [
            /*	[
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'date_modified',
                'createdAtAttribute' => 'date_modified',
                'value' => new Expression('NOW()'),
                ]*/

        ];
    }


    public function attributeLabels()
    {
        return
            [
                'id' => Yii::t('admin', 'Номер'),
                'message' => Yii::t('admin', 'сообщение'),
                'userid' => Yii::t('admin', 'Пользователь'),
                'tcatid' => Yii::t('admin', 'Тема'),
                'date_modified' => Yii::t('admin', 'Дата'),
                'statusid' => Yii::t('admin', 'Статус'),
                'textstatusid' => Yii::t('admin', 'иконка'),


            ];
    }


    public function getCatalog()
    {
        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id' => 'itemid']);
    }

    public function rules()
    {

        return [


            [['message',/* 'userid'*/], 'default', 'on' => ['default']],

            [['userid'], 'default', 'value' => yii::$app->user->getId()],
            [['tcatid', 'statusid', 'itemid', 'complite'], 'default'],
            [['complite', 'itemid', 'isread', 'textstatusid', 'tiraj'], 'default', 'value' => 0],

        ];
    }

    public function getTerms()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'statusid']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }

    public function search($params)
    {

        $query = Tickets::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        return $dataProvider;
    }

    public function add($cid, $message, $status, $tcatid = 2, $uid = 0, $aid = 0, $textstatus = 0)
    {
        $model = new self;
        $model->tcatid = $tcatid;
        $model->userid = $uid;//) ? $uid : yii::$app->user->getId();
        $model->itemid = $cid;
        $model->message = $message;
        $model->statusid = $status;
        /* if(is_array($complite)){
             $model->complite = $complite['persent'];
             $model->tiraj = $complite['tiraj'];
         }else {
             $model->complite = $complite;
         }*/
        $model->complite = $aid;

        $model->date_modified = date("Y-m-d H:i:s");

        $model->textstatusid = $textstatus;
        if (!$model->save())
            print_r($model->getErrors());

    }

    public function message($params)
    {
        $query = Tickets::find();
        $query->andWhere('tcatid = 1');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->statusid)
            $query->andWhere('statusid = ' . $this->statusid);
        if ($this->userid)
            $query->andWhere('userid = ' . $this->userid);
        if ($this->message)

            $query->andWhere('message  LIKE "%' . $this->message . '%" ');
        return $dataProvider;
    }

    public function activity($params)
    {
        $query = Tickets::find();
        $query->andWhere('tcatid = 2');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->statusid)
            $query->andWhere('statusid = ' . $this->statusid);
        if ($this->userid)
            $query->andWhere('userid = ' . $this->userid);
        if ($this->message)

            $query->andWhere('message  LIKE "%' . $this->message . '%" ');
        return $dataProvider;
    }

    public static function sendEmail($title, $body, $to)
    {

        Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom(yii::$app->params['adminEmail'])
            ->setSubject($title)
            ->setHtmlBody($body)
            ->send();

    }

    public static function sendNotification($id, $winner)
    {


        if ($winner) {
            if ($winner->catalogid)

                \app\models\Bits::setStatus($winner, 1);
            $items = \app\models\Bits::getMembers($id);



            $mes = \app\modules\system\models\TextWidget::get('bit_loose')->one();

            if (is_array($items))
                foreach ($items as $item) {
                    if ($winner->userid != $item->userid) {
                        self::add($winner->catalogid,
                            \app\modules\system\models\TextWidget::getTpl('bit_loose', ['link' => $winner->catalog->catalog_url, 'item' => $winner->catalog->catalog_name])
                            , 3, self::ACTIVITY, $item->userid, 0, $mes['statusid']);
                    }
                }

            // последний чтобы был сверху.

            self::sendEmail(yii::t('app', 'Вы выиграли товар'), \app\modules\system\models\TextWidget::getTpl('win-email'), $winner->user->email);

            $mes = \app\modules\system\models\TextWidget::get('bit_win')->one();
            //активность
            self::add($winner->catalogid,
                \app\modules\system\models\TextWidget::getTpl('bit_win', ['link' => $winner->catalog->catalog_url, 'item' => $winner->catalog->catalog_name]), 4, self::ACTIVITY, $winner->userid, 0, $mes['statusid']);
            //сообщение
            self::add($winner->catalogid,
                \app\modules\system\models\TextWidget::getTpl('bit_win', ['link' => $winner->catalog->catalog_url, 'item' => $winner->catalog->catalog_name]), 2, self::MESSAGE, $winner->userid, 0, 3);
        } else {
            echo 'нету объекта';
        }
    }

    public static function checkUnread($uid, $tcatid, $statusid)
    {
        $row = yii::$app->db->createCommand("select id from tickets where userid = $uid and tcatid = $tcatid and statusid = $statusid and isread = 0")->queryOne();
        if ($row)
            return true;
        return false;
    }

    public static function sendAll($cid, $uid, $msg,$title)
    {
        $lang=\Yii::$app->language;
        $items = \app\models\Auct::getMembers($cid);
        if (is_array($items))
            foreach ($items as $item) {
                if ($item->userid != $uid) {
                    \Yii::$app->language = $item->user->lang;
                    self::sendEmail( Yii::t('app',$title), $msg, $item->user->email);
                }
            }
        \Yii::$app->language = $lang;
    }


}