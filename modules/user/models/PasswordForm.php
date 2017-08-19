<?php
namespace app\modules\user\models;
 
use yii\base\Model;
use Yii;

/**
 * Create user form
 */
class PasswordForm extends Model
{
    public $password;
    public $repassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		 	
		 
            ['password', 'required'],
            ['password', 'string', 'min' => 4],
			
			['repassword', 'required'],
            ['repassword', 'string', 'min' => 4],

			[['repassword'], 'compare', 'compareAttribute'=>'password', ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          # $2y$13$roOcxmZqDUiCwvykRL8Ka.LNqESR/h6kB97IM/JVsUsE8MtPFeERW
            'password' => Yii::t('admin', 'Пароль'),
            'repassword' => Yii::t('admin', 'Повторите пароль'),
        ];
    }

     
}
