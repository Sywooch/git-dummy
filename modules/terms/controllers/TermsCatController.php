<?php



namespace app\modules\terms\controllers;

use app\components\access\RulesControl;
use app\modules\terms\models\Terms_cat;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class TermscatController extends \yii\web\Controller
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
		
	 
	
	
	 public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно изменены'));
            return $this->redirect(['default/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	 
	 
	
	public function actionCreate()
    {
        $model = new Terms_cat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно добавлены'));
            return $this->redirect(['default/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	 

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	 
	 public function actionDelete($id)
     {
        $this->findModel($id)->delete();

		$query = new Query;
		
		$query->createCommand()->insert('terms',[ 'termscatid' => $id])->execute();
		
		\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно удалены'));
		
        return $this->redirect(['default/index']);
     }
	
	
	protected function findModel($id)
    {
        if (($model = Terms_cat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}