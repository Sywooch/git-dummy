<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Userlist extends \yii\db\ActiveRecord
{

    const STATUS_GOOD = 0;
    const STATUS_BAD = 1;
  
	
    public static function tableName()
    {
        return 'userlist';
    }

	   public function rules()
    {
        return [
            
			[['userid', 'workerid','status' ], 'required'],
            [['status' ], 'default', 'value'=>0],
        ];
    }


    public function attributeLabels()
    {
        return
            [

                'workerid' => Yii::t('admin', 'Исполнитель'),

            ];
    }
	 
  public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }

    public function getWorker()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'workerid']);
    }

    public function getWorkergood()
    {
        return $this->hasMany(\app\models\User::className(), ['id' => 'workerid'])->where('status = '.self::STATUS_GOOD);
    }

    public function getWorkerbad()
    {
        return $this->hasMany(\app\models\User::className(), ['id' => 'workerid'])->where('status = '.self::STATUS_BAD);
    }


    public static function users()
    {
        $obj = self::find()->where('userid = ' . yii::$app->user->getId() . ' and status = ' . self::STATUS_GOOD)->all();
        if (count($obj))
            foreach ($obj as $row) {
                $out[ $row->workerid ] = 'client'.$row->worker->id;
            }
        else {
            $obj = self::find()->where('status = ' . self::STATUS_GOOD)->all();
            if (count($obj))
                foreach ($obj as $row) {
                    $out[ $row->workerid ] = 'client'.$row->worker->id;
                }
        }

        return $out;
    }

    public static function usersrand()
    {
        $obj = \app\models\User::find()->where('role = 5')->orderBy('  RAND() ')->one();
        if($obj)
        return $obj->id;
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

        $query->andWhere('userid = '.yii::$app->user->getId());


        return $dataProvider;
    }
    public static function getUserStatus($id){
    $model=self::find()->where(' userid = '.yii::$app->user->getId().' and workerid = '.$id)->one();
        if($model!==null)
            return ($model->status +1);
        return 0;
    }

    public static function getStatus($status = false){
        $roles = [
            self::STATUS_GOOD=>Yii::t('app', 'Белый список'),
            self::STATUS_BAD=>Yii::t('app', 'Черный список'),
        ];
        return $status ? ArrayHelper::getValue($roles, $status) : $roles;
    }

}