<?php

namespace app\modules\user\controllers;
 
use app\modules\user\models\LoginForm;
use app\modules\user\models\SignupForm;
use app\models\User;
use yii\web\Controller;
 
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
 
class ProfileController extends \app\controllers\BaseController//extends Controller
{

 

        public function actionIndex()
        {
            $user =User::findOne(yii::$app->user->getID());


            if($user === null)  throw new BadRequestHttpException(\Yii::t('app', 'Попробуйте авторизоваться еще раз'),'404');


            if ($user->load(Yii::$app->request->post()) && $user->save()) {
                if(\yii::$app->request->post('password') && \yii::$app->request->post('repassword') && \yii::$app->request->post('password') != 'password' ){
                    $password = Yii::$app->getSecurity()->generatePasswordHash(\yii::$app->request->post('password'));
                    (new \yii\db\Query())->createCommand()->update('user', ['password_hash' =>$password ], 'id = '.$user->id )->execute();
                }

                \Yii::$app->session->setFlash('updated',\Yii::t('app', 'Данные успешно сохранены'));
            }



            return $this->render('index',[ 'model'=>$user ]);
        }

    public function actionValidate(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new User();
        $model->load(Yii::$app->request->post());
        $model->validate();
        return $model->getErrors();
    }

}
