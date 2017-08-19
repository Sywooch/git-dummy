<?php



namespace app\modules\catalog\controllers;

use app\components\access\RulesControl;
use app\modules\catalog\models\Balance;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

class BalancehistoryController extends \yii\web\Controller
{
	
 public $layout='@app/views/layouts/admin.php';
	 
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
            ]
			 
          
        ];
		
    }
 
 	
 
   	
	public function actionIndex()
	{
		
		
	   $searchModel = new Balance();
	  // $searchModel->scenario = 'all';
	   $dataProvider = $searchModel->searchAdmin(Yii::$app->request->queryParams);


        $this->make_param();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$searchModel,
        ]);
		 
	 
		
	}


    public function make_param(){

        if(yii::$app->request->get('lowbalance') && yii::$app->request->get('bonus') && yii::$app->request->get('bonustomoney')){
            $path=Yii::$app->basePath .'/config/params_change.php';

            $F=fopen($path,"w") or die("ERROR CREAT FILE");

            $text=' ';
            $arr=yii::$app->params;
             unset($arr['redirectAuth'],$arr['sitehost'],$arr['imagePath'],$arr['availableLocales']);

        yii::$app->params['lowbalance']= $arr['lowbalance']=yii::$app->request->get('lowbalance');
        yii::$app->params['bonus']=$arr['bonus']=yii::$app->request->get('bonus');
        yii::$app->params['bonustomoney']=$arr['bonustomoney']=yii::$app->request->get('bonustomoney');


            foreach($arr as $Z=>$V){
                $text.=" '$Z' => '$V', ";
            }





            $text = '<?php return ['.$text.' ];';

            fwrite($F,$text,strlen($text));

            fclose($F);
        }
    }


	
	 
	
}