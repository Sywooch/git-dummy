<?php

namespace app\modules\user\controllers;

use app\modules\user\models\AccountForm;

use app\modules\user\models\UserForm;
use app\modules\user\models\PasswordForm;
use app\modules\user\models\Auser;
use app\models\User;

use app\modules\user\models\UserSearch;
use app\components\access\RulesControl;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class AdminController extends Controller
{
    /*public function actions(){
        return [
            'avatar-upload'=>[
                'class'=>UploadAction::className(),
                'fileProcessing'=>function($file){
                    Image::thumbnail($file->path, 215,215)
                        ->save($file->path);
                }
            ]
        ];
    }*/

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
                    ],
					 [
                        'allow' => false,
						'roles' => ['?'],
                    ],
                ],
            ],
        ];
		
    }

   /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
	 
	  public function actionNewpsw($id)
    {
		$model = new PasswordForm();
		
		if( $model->load(Yii::$app->request->post()) && $model->validate() )
		{
			$password = Yii::$app->getSecurity()->generatePasswordHash($model->password);			 
			
			(new \yii\db\Query())->createCommand()->update('user', ['password_hash' =>$password ], 'id = '.$id )->execute();
			
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Пароль изменен'));
			
			return $this->redirect(['index']);
		}
        return $this->render('newpsw', [            'model' =>  $model        ]);
    }
	
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

   public function actionCreate()
    {
        $model = new UserForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
		 
        $user = $this->findModel($id);
		
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $user,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
   
}
