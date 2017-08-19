<?php
namespace app\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

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
class Auser extends ActiveRecord 
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_USER = 1;
    const ROLE_MANAGER = 5;
    const ROLE_ADMINISTRATOR = 10;
 

    /**
     * @inheritdoc
     */
	 
	 
    public static function tableName()
    {
        return '{{%user}}';
    }

   

    /**
     


    /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             [['username', 'email'], 'unique'],
             ['status', 'default', 'value' => self::STATUS_ACTIVE],
             ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

             ['role', 'default', 'value' => self::ROLE_USER],
             ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_MANAGER, self::ROLE_ADMINISTRATOR]],
             [ ['isemail'], 'integer'],
             [ ['isemail'], 'default'],
         ];
     }

    public function getProfile(){
        return $this->hasOne(UserProfile::className(), ['user_id'=>'id']);
    }

    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Returns user roles list
     * @param bool $role
     * @return array|mixed
     */
    public static function getRoles($role = false){
        $roles = [
            self::ROLE_USER=>Yii::t('app', 'User'),
            self::ROLE_MANAGER=>Yii::t('app', 'Manager'),
            self::ROLE_ADMINISTRATOR=>Yii::t('app', 'Administrator'),
        ];
        return $role ? ArrayHelper::getValue($roles, $role) : $roles;
    }


    /**
     * Returns user statuses list
     * @param bool $status
     * @return array|mixed
     */
    public static function getStatuses($status = false){
        $statuses = [
            self::STATUS_ACTIVE=>Yii::t('app', 'Active'),
            self::STATUS_DELETED=>Yii::t('app', 'Deleted')
        ];
        return $status ? ArrayHelper::getValue($statuses, $status) : $statuses;
    }

  

}
