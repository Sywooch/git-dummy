<?php
namespace app\modules\user\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    const ROLE_USER = 1;
    const ROLE_MANAGER = 5;
    const ROLE_ADMINISTRATOR = 10;

    public $role;
    public $name;
    public $place;
    public $email_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username','place'], 'required'],
            ['username', 'unique', 'targetClass'=>'\app\models\User', 'message' =>  Yii::t('app', 'Этот логин уже занят.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['email_repeat', 'email'], function($value){
                return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
            }],

            ['place','string'],

            ['place','match', 'pattern' => '/^[A-Za-zАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯабвгдеёжзийклмнопрстуфхцчшщьыъэюя\ \,\.\-\/]+$/i', 'message'=>yii::t('app','Необходимо указывать только буквы')],
            ['name','match', 'pattern' => '/^[A-Za-z0-9АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯабвгдеёжзийклмнопрстуфхцчшщьыъэюя\ ]+$/i', 'message'=>yii::t('app','Необходимо указывать только буквы')],

            //[['email','email_repeat'],'match', 'pattern' => '/^[\ ]+$/i', 'message'=>yii::t('app','Пробелы в Email недопустимо')],

            [['email_repeat','email'], 'filter', 'filter' => 'trim'],
            [['email'], 'required', 'message' =>  Yii::t('app', 'Необходимо заполнить «E-mail».')],
            [['email_repeat'], 'required', 'message' =>  Yii::t('app', 'Необходимо заполнить  «Подтверждение E-mail».')],
            [['email_repeat','email'], 'email'],

            //[['email'], 'ValidateEmail' ],
            ['email', 'unique', 'targetClass'=>'\app\models\User', 'message' =>  Yii::t('app', 'Этот «E-mail» уже занят.')],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_MANAGER, self::ROLE_ADMINISTRATOR]],

            [ ['password','password_repeat'], 'required'],
            [ ['password','password_repeat'], 'string', 'min' => 8],

            [['password'], 'compare', 'compareAttribute'=>'password_repeat', 'operator'=>'==', 'skipOnEmpty'=>false],
            [['email'], 'compare', 'compareAttribute'=>'email_repeat', 'operator'=>'==', 'skipOnEmpty'=>false],

        ];
    }

    public function  ValidateEmail($attribute)
    {
        $query = new \yii\db\Query;

        $row = $query->select('*')->from('user')->where(
            [
                'email' => $this->$attribute,
            ])->one();



        if($row)
            $this->addError($attribute, yii::t('app','Неправильный email'));

    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Логин'),
            'email' => Yii::t('app', 'Email'),
            'email_repeat' => Yii::t('app', 'Повторите email'),
            'password' => Yii::t('app', 'Пароль'),
            'password_repeat' => Yii::t('app', 'Повторите пароль'),
            'name' => Yii::t('app', 'Имя'),
            'place' => Yii::t('app', 'Месторасположение'),


        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {

            yii::$app->db->createCommand("DELETE FROM `user`
WHERE
`user`.`isemail` IS NULL
            AND
            TO_DAYS(NOW()) - TO_DAYS(from_unixtime(created_at,'%Y-%m-%d')) > 2")->execute();
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->role = $this->role;
            $user->status = 1;
            $user->isemail = 0;
            $user->setPassword($this->password);

            $user->name = $this->name;
            $user->place = $this->place;

            $user->generateAuthKey();
            if($user->save()){
                Yii::$app->getSession()->get('__id',$user->id);

            }
                /*\Yii::$app->user->login($this,0);
            else{
                print_r($user->getErrors());
                exit;
            }*/
           // $user->afterSignup();



/*
            \app\modules\tickets\models\Tickets::sendEmail(
                yii::t('app','Регистрация на сайте bountymart.com ') ,
                \app\modules\system\models\TextWidget::getTpl('registration-email'),
                $user->email );*/


            Yii::$app->mailer->compose()
                ->setFrom('noreply@bountymart.com')
                ->setTo($this->email)
                ->setSubject(yii::t('app','Регистрация на сайте bountymart.com'))
                ->setHtmlBody( \app\modules\system\models\TextWidget::getTpl('registartion_success_email',
                    ['link'=>'<a href="'.yii::$app->request->getHostInfo().'/user/registration/approveemail?code='.$user->auth_key.'">'.yii::t('app','Подтвердить этот email').'</a>' ])               )
                ->send();

            return $user;
        }


        return null;
    }


}
