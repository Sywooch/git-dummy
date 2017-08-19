<?php


	namespace app\components\access;
	use app\models\User;

	use yii;
	use yii\base\Component;
	use yii\base\Action;
	use yii\web\Request;
	use yii\base\Controller;

	class RulesControl
	{
		static function callback($type = '')
		{
			if( $type )
			{
				if( is_array($type) && in_array( User::getRoles( Yii::$app->user->identity->role ),$type ) )
					return true;
				elseif( $type ==   User::getRoles( Yii::$app->user->identity->role ) )
					return true;

			}

			return false;
		}

	}
