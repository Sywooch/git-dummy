<?php



namespace app\modules\menu\controllers;

use app\components\access\RulesControl;
use app\modules\menu\models\Menu;
use app\modules\staticpage\models\Staticpage;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class DefaultController extends \yii\web\Controller
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
            ],
        ];
		
    }
		
	public function actionIndex()
	{
        return $this->render('index');
	}
	
	
	 public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно изменены'));
			\Yii::$app->session->setFlash('termscatid',$model->alias);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	 public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	 
	
	public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно созданы'));
			\Yii::$app->session->setFlash('termscatid',$model->alias);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	 

	 public function actionAutocomplect()
     {
		 
		 $rows = (new \yii\db\Query()) ->select('static_page_id as ID, static_page_name as NAME, static_page_url as URL ' )->from('static_page')->where(['like', 'static_page_name', $_GET[term]])->all();
		 if($rows)
		 	foreach($rows as $row)
				{
				$out[]=[ 'name' => $row['NAME'], 'cat' => 'Статичные страницы', 'id' => $row['ID'], 'tb' => 'static_page','url'=>$row['URL'] ];	
				}
		
		$rows = (new \yii\db\Query()) ->select('news_id as ID, news_name as NAME, news_url as URL')->from('news')->where(['like', 'news_name', $_GET[term]])->all();
		 if($rows)
		 	foreach($rows as $row)
				{
				$out[]=[ 'name' => $row['NAME'], 'cat' => 'Новости', 'id' => $row['ID'], 'tb' => 'news','url'=>$row['URL'] ];	
				}		
  	 	
		$rows = (new \yii\db\Query()) ->select('catalog_id as ID, catalog_name as NAME, catalog_url as URL')->from('catalog')->where(['like', 'catalog_name', $_GET[term]])->all();
		 if($rows)
		 	foreach($rows as $row)
				{
				$out[]=[ 'name' => $row['NAME'], 'cat' => 'Каталог', 'id' => $row['ID'], 'tb' => 'catalog', 'url'=>$row['URL'] ];	
				}
				
		
		$rows = (new \yii\db\Query()) ->select('terms_id as ID, terms_text as NAME , terms_cat_text as CAT, terms_url as URL')->from('terms')
									 ->join('LEFT JOIN', 'terms_cat', 'terms.termscatid =terms_cat.terms_cat_id')  
									  ->where(['like', 'terms_text', $_GET[term]])->all();
		 if($rows)
		 	foreach($rows as $row)
				{
				$out[]=[ 'name' => $row['NAME'], 'cat' => $row['CAT'], 'id' => $row['ID'], 'tb' => 'terms','url'=>$row['URL'] ];	
				}		
  	 
		 
		 
		
		
		echo Json::encode($out);
		
     }


    public function actionAttrpublic($id)
    {
        $model=$this->findModel($id);
        if( $model->menu_public == 1 )
            $model->menu_public = 0;
        else
            $model->menu_public = 1;

        $model->save();
        die('ok');
    }


    public function actionOrder($id,$position)
     {

		 
        $model=$this->findModel($id);
		$model->menu_order = $position;
		$model->save();
        die('ok');
     }
	 
	 
	 public function actionDelete($id)
     {

		 
        $model=$this->findModel($id);
		\Yii::$app->session->setFlash('termscatid',$model->alias);
		$model->delete();
        return $this->redirect(['index']);
     }
	
	
	protected function findModel($id)
    {
		 
		
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}