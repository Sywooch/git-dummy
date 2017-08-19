<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Todeliver extends ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_PROGRESS = 1;
    const STATUS_CLOSE = 2;
	 
    public static function tableName()
    {
        return 'todeliver';
    }


    public function attributeLabels()
    {
        return [
            'userid' => Yii::t('app', 'Пользователь'),
            'catalogid' => Yii::t('app', 'Товар'),
            'info' => Yii::t('app', 'Адрес доставки'),
            'statusid' => Yii::t('app', 'Статус'),
        ];
    }


    public static function getStatus($id = false){
        $roles = [
            self::STATUS_NEW=>Yii::t('app', 'Новый'),
            self::STATUS_PROGRESS=>Yii::t('app', 'Доставляется'),
            self::STATUS_CLOSE=>Yii::t('app', 'Закрыт'),
        ];

        if($id !== false)
            return $roles[$id];
        else
            return $roles;
    }

    /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             [ ['userid','catalogid','info','statusid'], 'required'],
         ];
     }

    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'userid']);
    }
    public function getCatalog(){
        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id'=>'catalogid']);
    }


    public function search($params)
    {


        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params)/* && $this->validate()*/) ) {
            return $dataProvider;
        }

        if($this->userid)
            $query->andWhere('userid = '.$this->userid);
        if($this->catalogid)
            $query->andWhere('catalogid = '.$this->catalogid);

        if($this->statusid ){
            $query->andWhere('statusid = '.$this->statusid);
        }


        return $dataProvider;
    }



}
