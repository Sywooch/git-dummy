<?php
namespace app\models;

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
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_USER = 1;
    const ROLE_MANAGER = 5;
    const ROLE_ADMINISTRATOR = 10;

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * @inheritdoc
     */
	 
	 
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    public function attributeLabels()
    {
        return [
            'sexid' => Yii::t('app', 'Пол'),
        ];
    }




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


             [[ 'email'], function($value){
                 return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
             }],


             ['place','match', 'pattern' => '/^[A-Za-zАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯабвгдеёжзийклмнопрстуфхцчшщьыъэюя\ \,\.]+$/i', 'message'=>yii::t('app','Необходимо указывать только буквы')],
             ['adres', 'match', 'pattern' => '/^[A-Za-zАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯабвгдеёжзийклмнопрстуфхцчшщьыъэюя0-9\ \,\.]+$/i','message'=>yii::t('app','Необходимо указывать только буквы и цифры')],
             ['phone', 'match', 'pattern' => '/^[0-9\ \-\+]+$/i', 'message'=>yii::t('app','Необходимо указывать только цифры')],
             ['name','match', 'pattern' => '/^[A-Za-z0-9АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯабвгдеёжзийклмнопрстуфхцчшщьыъэюя\ ]+$/i', 'message'=>yii::t('app','Необходимо указывать только буквы')],
             ['index', 'match', 'pattern' => '/^[0-9]+$/i', 'on' => ['default']],

             [ ['persent','bonus','isemail'], 'integer'],
             [ ['balance','isemail','lang'], 'default'],
         ];
     }

    public function getProfile(){
        return $this->hasOne(UserProfile::className(), ['user_id'=>'id']);
    }
    public function getBits(){
        return $this->hasMany(Bits::className(), ['userid'=>'id'])->andWhere('status = 1')->orderby('id desc');
    }

    public function getBitsnonarchive(){
        return $this->hasMany(Bits::className(), ['userid'=>'id'])->andWhere('status = 1 and (isarchive IS NULL or isarchive<>1)')->orderby('id desc');
    }

    public function getLoose(){
        return $this->hasMany(Bits::className(), ['userid'=>'id'])->andWhere('status IN (2,3)')->orderby('id desc');
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return  static::findOne(['password_reset_token' => $token]);

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = 7200;// Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);

        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
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
    public static function getBalance()
    {
        return self::findOne(yii::$app->user->getId())->balance;
    }

    public static function setBalance($price,$uid=0,$callsid=0,$comment='Ввод средств',$status='')
    {

        if($uid==0){
            $uid=yii::$app->user->getId();
            $lang=yii::$app->user->identity->lang;
        }else{
            $lang=self::findOne($uid)->lang;
        }


        if($lang != 'ru'){
            $l=\yii::$app->language;
            \yii::$app->language=$lang;
            $comment=\yii::t('app',$comment);
            \yii::$app->language=$l;
        }

        //$price = self::getDiscount($price,$uid);
        $model = self::findOne($uid);
        $model->balance=$model->balance+$price;
        //echo $price.' '.$comment.'<br>';

        $error=\app\modules\catalog\models\Balance::add($callsid,$model->balance,$price,$comment,$uid,$status);
        if(  !$error['error'] && $model->save())
            return [
                    'balance'=>$model->balance,
                    'newId'=>$error,

                    ];
        else{
            print_r($model->getErrors());
            return $error;
        }
        return ['error'=>\yii::t('app','Не хватает денег на счете')];
    }

    public static function setBalanceOut($price,$uid=0,$callsid=0,$comment='Ввод средств',$status='')
    {
        $comment=\yii::t('app',$comment);
        if($uid==0)$uid=yii::$app->user->getId();
        $model = self::findOne($uid);
        $model->balance=$model->balance+$price;

        if($model->save() &&  $id=\app\modules\catalog\models\Balance::add($callsid,$model->balance,$price,$comment,$uid,$status))
            return $id;
        else{
            echo 'error add balance';
        }
        return false;
    }
    public static function checkBalance($money){
        $uid=yii::$app->user->getId();
        $model = self::findOne($uid);

        if(  \app\modules\system\models\Course::getPriceClear($model->balance) < $money)
            return false;
        return  true;
    }


    public function addBonus($bonus,$userid=''){
        if($uid=yii::$app->user->getId()){
            \yii::$app->user->identity->bonus=\yii::$app->user->identity->bonus+$bonus;
            if( \yii::$app->user->identity->bonus >= yii::$app->params['bonus']){
                \yii::$app->user->identity->bonus=\yii::$app->user->identity->bonus-yii::$app->params['bonus'];
                User::setBalance('+'.\yii::$app->params['bonustomoney'],$uid,0,$comment=\yii::t('app', 'Начисление за бонусы'));
            }
            \yii::$app->user->identity->save();
        }elseif($userid){
            $user=self::findOne($userid);
            $user->bonus=$user->bonus+$bonus;
            if( $user->bonus >= yii::$app->params['bonus']){
                $user->bonus=$user->bonus-yii::$app->params['bonus'];
                User::setBalance('+'.\yii::$app->params['bonustomoney'],$uid,0,$comment=\yii::t('app', 'Начисление за бонусы'));
            }
            $user->save();
        }
    }
    public static function checkAdres(){
        if(!\yii::$app->user->identity->adres){
            \app\modules\tickets\models\Tickets::add(0,
                \app\modules\system\models\TextWidget::getTpl('error_profile_adres') ,2,3,\yii::$app->user->identity->id,
            0,
            \app\modules\system\models\TextWidget::get('error_profile_adres')->one()->statusid);
        }
    }

    public static function getDiscount($money,$uid){
        $model = self::findOne($uid);
        if(intval($model->persent)==0 and 5 == $model->role)$model->persent=20;

        if(5 == $model->role)
            $discount = $model->persent/100;
        else
            $discount = 1-$model->persent/100;

        return   $money*$discount;

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

    public function afterSignup(){
      
        $profile = new UserProfile();
        $this->link('profile', $profile);
      
    }

    public function afterLogin(){
       /* if(yii::$app->user->getId()){
            $model = $this->findOne(yii::$app->user->getId());
            $model->update_at=time();
            $model->save();
        }*/

    }


    public function beforeValidate(){

        $m=['"',"'",':',';','%','#','$','^','&','?','!'];

        $this->name=str_replace($m,'',$this->name);
        $this->username=str_replace($m,'',$this->username);
        $this->phone=str_replace($m,'',$this->phone);
        $this->adres=str_replace($m,'',$this->adres);
        $this->place=str_replace($m,'',$this->place);

        return true;
    }

    public function getPublicIdentity()
    {
        if($this->profile && $this->profile->getFullname()){
            return $this->profile->getFullname();
        }
        if($this->username){
            return $this->username;
        }
        return $this->email;
    }


    public static function getName()
    {
       $user =  static::findOne([
            'id' =>  yii::$app->user->id,
            'status' => self::STATUS_ACTIVE,
        ]);

        if($user->username){
            return $user->username;
        }
        return $user->email;

    }

    public  function isClient()
    {

        return $this->role == 1;
    }

    public static function Online(){

        $sql="select count(id) from user WHERE role=5 and  updated_at >= ".(time()-300)." ";
        $rows =  \Yii::$app->db->createCommand($sql)->queryOne();

        return intval($rows['count(id)']);
    }
}
