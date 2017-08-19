<?php

 
namespace app\modules\system\controllers;

use app\components\access\RulesControl;
use app\modules\system\models\ConfigForm;
use app\modules\system\models\CalcForm;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class ConfigController extends \yii\web\Controller
{
	 public $layout='@app/views/layouts/admin.php';
	 public $file='params_change';
	 public $path='/var/www/html/config';
	 public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'allow' => RulesControl::callback('Administrator'),
						'roles' => ['@'],
                    ]
					 
                ],
            ],
        ];
		
    }
	
    public function init()
	{
		#chmod(Yii::$app->basePath .'/config/', '0777');	
		#chmod(Yii::$app->basePath .'/config/params_change.php', '666');	
	}
	
    public function actionIndex()
    {
	 	$model=new ConfigForm();

		if(yii::$app->request->get('setlang','ru')!='ru'){
			if(is_file($this->path . '/params_change_'.yii::$app->request->get('setlang','ru').'.php')) {

				\yii::$app->params = require_once($this->path . '/params_change_' . yii::$app->request->get('setlang', 'ru') . '.php');

			}else{
				$myfile = fopen($this->path . '/params_change_' . yii::$app->request->get('setlang', 'ru') . '.php', "w+");
				fclose($myfile);
			}
			$this->file='params_change_' . yii::$app->request->get('setlang', 'ru') ;
		}
		
		if ($model->load(Yii::$app->request->post()) && $model->validate()) 
		{
            $this->make_param(Yii::$app->request->post(),$this->file);
			# var_dump($_POST);
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно изменены'));
			 return $this->redirect(['index']);
		}
		$model->params(); 
        return $this->render('index', ['model' =>$model] );
    }






	public function make_param($arr,$file='params'){
			if(isset( $arr['ConfigForm'] ))
			{

			$path=Yii::$app->basePath .'/config/'.$file.'.php';

			$F=fopen($path,"w") or die("ERROR CREAT FILE");

			$text=' ';

			foreach($arr['ConfigForm'] as $Z=>$V){
				  $text.=" '$Z' => '$V', ";
				}





			$text = '<?php return ['.$text.' ];';

			fwrite($F,$text,strlen($text));

			fclose($F);
			}

		}
}
