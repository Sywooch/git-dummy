<?php
namespace app\modules\user\models;

use app\models\User;
use app\models\UserProfile;
use yii\base\Model;
use Yii;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass'=>'\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass'=> '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['status'], 'boolean'],
            [['role'], 'in', 'range'=>array_keys(User::getRoles())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('admin', 'Username'),
            'email' => Yii::t('admin', 'Email'),
            'password' => Yii::t('admin', 'Password'),
            'role' => Yii::t('admin', 'Role')
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->role = $this->role;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            $user->afterSignup();
            return $user;
        }

        return null;
    }
}
