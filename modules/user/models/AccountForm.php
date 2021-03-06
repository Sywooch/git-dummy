<?php
namespace app\modules\user\models;

use yii\base\Model;
use Yii;

/**
 * Account form
 */
class AccountForm extends Model
{
    public $username;
    public $password;
    public $password_confirm;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass'=>'app\models\User',
                'message' => \Yii::t('app', 'This username has already been taken.'),
                'filter'=>function($query){
                    $query->andWhere(['not', ['id'=>Yii::$app->user->id]]);
                }
            ],
            ['username', 'string', 'min' => 1, 'max' => 255],

            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],

        ];
    }
}
