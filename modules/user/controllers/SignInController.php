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
 
class SignInController extends Controller
{

 

       public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'reset-password', 'oauth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'reset-password', 'oauth'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback'=>function()
						{
							if( User::ROLE_ADMINISTRATOR == Yii::$app->user->identity->role   )
								 return Yii::$app->controller->redirect(['/system/config/index']);
							else	 
								 return Yii::$app->controller->redirect(['/user/default/profile']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                ],
            ],
           /* 'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    } 

    public function actionLogin()
    {
       
	    $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			   if( User::ROLE_ADMINISTRATOR == Yii::$app->user->identity->role   )
			   		 
					$this->redirect([Yii::$app->params['redirectAuth']]);
			   else
			   		return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        } 
    }

   public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
					return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

     
    public function successOAuthCallback($client)
    {
        // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
        $attributes = $client->getUserAttributes();
        $user = User::find()->where(['oauth_client'=>$client->getName(), 'oauth_client_user_id'=>ArrayHelper::getValue($attributes, 'id')])->one();
        if(!$user){
            $user = new User();
            $user->scenario = 'oauth_create';
            $user->username = sprintf('%s_%s', ArrayHelper::getValue($attributes, 'login', $client->getName()), time());
            $user->email = ArrayHelper::getValue($attributes, 'email');
            $user->oauth_client = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $password = Yii::$app->security->generateRandomString(8);
            $user->generateAuthKey();
            $user->setPassword($password);
            if($user->save()){
                $user->afterSignup();
                $sentSuccess = Yii::$app->mailer->compose('oauth_welcome', ['user'=>$user, 'password'=>$password])
                    ->setSubject(Yii::t('frontend', '{app-name} | Your login information', [
                        'app-name'=>Yii::$app->name
                    ]))
                    ->setTo($user->email)
                    ->send();
                if($sentSuccess){
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options'=>['class'=>'alert-success'],
                            'body'=>Yii::t('frontend', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                'app-name'=>Yii::$app->name
                            ])
                        ]
                    );
                }

            } else {
                // We already have a user with this email. Do what you want in such case
                if(User::find()->where(['email'=>$user->email])->count()){
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options'=>['class'=>'alert-danger'],
                            'body'=>Yii::t('frontend', 'We already have a user with email {email}', [
                                'email'=>$user->email
                            ])
                        ]
                    );
                } else {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options'=>['class'=>'alert-danger'],
                            'body'=>Yii::t('frontend', 'Error while oauth process. You\'ve probably already ')
                        ]
                    );
                }

            };
        }
        if(Yii::$app->user->login($user, 3600 * 24 * 30)){
            return true;
        } else {
            throw new Exception('OAuth error');
        }
    }
 

}
