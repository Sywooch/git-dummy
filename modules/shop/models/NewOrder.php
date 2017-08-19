<?php

namespace app\modules\shop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class NewOrder extends Model
{
    public $typeCheckout;

    public $username;
    public $Rname;
    public $email;
    public $password;
    public $Rrepassword;

    public $Astreet;
    public $Ahouse;
    public $Aflat;
    public $Aindex;
    public $Aname;
    public $Aoblast;
    public $Atown;
    public $Acounty;
    public $Aphone;
    public $Rsurname;


    public function rules()
    {

        if($_POST['type']==1)
            return [
                [['username', 'Rname', 'password', 'Rrepassword'], 'required'],
                [[
                  'Astreet', 'Ahouse',
                  'Aoblast', 'Atown',  'Acounty', 'Aphone',], 'required'],
                ['email', 'email'],

                [ ['Aflat','Aindex'],'default'],

                ['username', 'filter', 'filter' => 'trim'],
                ['username', 'required'],
                //['username', 'unique', 'targetClass'=>'\app\models\User', 'message' => 'Такой логин уже занят'],
                ['username', 'string', 'min' => 2, 'max' => 255],

                ['email', 'filter', 'filter' => 'trim'],
                ['email', 'required'],
                ['email', 'email'],
                ['email', 'unique', 'targetClass'=> '\app\models\User', 'message' => 'Такой email уже занят'],

                ['Aphone', 'match', 'pattern' => '/^[0-9\ \-\+]+$/i', 'message'=>yii::t('app','Необходимо указывать только цифры')],

                ['password', 'required'],
                ['password', 'string', 'min' => 6],

            ];
        else
            return [
                ['Aindex','default'],
                ['Aphone', 'match', 'pattern' => '/^[0-9\ \-\+]+$/i', 'message'=>yii::t('app','Необходимо указывать только цифры')],
                [['Aflat',  'username', 'password', 'Rrepassword'], 'default'],
                [[
                    'Rname',  'Astreet', 'Ahouse',
                    'Aoblast', 'email','Atown',  'Acounty', 'Aphone'], 'required'],
                ['email', 'email'],

            ];
    }

    public function attributeLabels()
    {
        return [

            'username' => Yii::t('admin', 'Фамилия'),
            'Rname' => Yii::t('admin', 'Имя'),
            'password' => Yii::t('admin', 'Пароль'),
            'Rrepassword' => Yii::t('admin', 'Повторите пароль'),
            'email' => Yii::t('admin', 'Email'),

            'Astreet' => Yii::t('admin', 'Улица'),
            'Ahouse' => Yii::t('admin', 'Дом'),
            'Aflat' => Yii::t('admin', 'Квартира'),
            'Aindex' => Yii::t('admin', 'Почтовый индекс'),
            'Aoblast' => Yii::t('admin', 'Область'),
            'Atown' => Yii::t('admin', 'Город'),
            'Acounty' => Yii::t('admin', 'Страна'),
            'Aphone' => Yii::t('admin', 'Телефон'),
        ];
    }


    public function signup()
    {


            $user = new \app\models\User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->role = 1;
            $user->utype = 1;
            $user->status = 1;
            $user->setPassword($this->password);

            $user->name = $this->Rname;
            $user->phone = $this->Aphone;
            $user->generateAuthKey();


            $adres = new \app\modules\shop\models\ShopAdres();
            $adres->userid = 1;
            $adres->name = $this->Rname;
            $adres->country = $this->Acounty;
            $adres->phone = $this->Aphone;
            $adres->oblast = $this->Aoblast;
            $adres->town = $this->Atown;
            $adres->street = $this->Astreet;
            $adres->house = $this->Ahouse;
            $adres->flat = $this->Aflat;
            $adres->post_index = $this->Aindex;
            $adres->isselect=1;



            if($user->validate() && $adres->validate()){
                $user->save();
                $adres->userid = $user->id;
                $adres->save();
                Yii::$app->getSession()->get('__id',$user->id);

                if($user  && $user->validatePassword($this->password)){
                    Yii::$app->user->login($user,0);
                    \Yii::$app->session->setFlash('registration',1);
                }
            }else{

                print_r($user->getErrors());
                print_r($adres->getErrors());
            }


            Yii::$app->mailer->compose()
                ->setFrom('noreply@bountymart.com')
                ->setTo($this->email)
                ->setSubject(yii::t('app','Регистрация на сайте '))
                ->setHtmlBody( \app\modules\system\models\TextWidget::getTpl('registartion_success_email',
                    ['link'=>'<a href="'.yii::$app->request->getHostInfo().'/user/registration/approveemail?code='.$user->auth_key.'">'.yii::t('app','Подтвержить email').'</a>' ])               )
                ->send();

            return $user;

    }
}