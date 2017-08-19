<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ZakazForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $body;
 #   public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'phone', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
          #  ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
			'name' => Yii::t('admin', 'Название'),
			'email' => Yii::t('admin', 'Email'),
			'phone' => Yii::t('admin', 'Номер телефона'),
			'body' => Yii::t('admin', 'Сообщение'),									
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject('Бронирование тура с сайта')
                ->setTextBody($this->body)
                ->send();

            return true;
        } else {
            return false;
        }
    }
}
