<?php
namespace app\modules\user\models;

use app\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'ValidateEmail' ],
        ];
    }


    public function  ValidateEmail($attribute)
    {
        $query = new \yii\db\Query;

        $row = $query->select('*')->from('user')->where(
            [
                'email' => $this->$attribute,
            ])->one();


        if(!$row)
            $this->addError($attribute, 'Неправильный email');

    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            $user->generatePasswordResetToken();

            if ($user->save()) {
                return \Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    ->setFrom('noreply@bountymart.com'/*[\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot']*/)
                    ->setTo($this->email)
                    ->setSubject(\yii::t('app','Password reset for bountymart.com') /*. \Yii::$app->name*/)
                    ->send();
            }
        }

        return false;
    }
}
