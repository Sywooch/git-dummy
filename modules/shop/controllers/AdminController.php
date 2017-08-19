<?php


namespace app\modules\shop\controllers;

use app\components\access\RulesControl;
use app\modules\shop\models\Shop;
use app\modules\shop\models\ShopItem;
use app\modules\tickets\models\Tickets;
use trntv\filekit\actions\UploadAction;
use app\models\Auct;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\Controller;

class AdminController extends \yii\web\Controller
{

    public $layout = '@app/views/layouts/admin.php';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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


        $searchModel = new Shop();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $dataProvider->sort = [
            'defaultOrder' => ['shop_id' => SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('updated', \Yii::t('admin', 'Данные успешно созданы'));


            $lang = \Yii::$app->language;
            \Yii::$app->language = $model->user->lang;

            Tickets::sendEmail(yii::t('app', 'Изменился статус заказа'), $model->message, $model->user->email);
            //сообщение
            Tickets::add($model->items[0]->itemid,
                $model->message, 2, Tickets::MESSAGE, $model->userid, 0, 3);
            \Yii::$app->language = $lang;

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionCancel($id)
    {
        $money = 0;
        $bonus=0;
        $model = $this->findModel($id);

        foreach ($model->items as $item) {
            $item->item->catalog_count = $item->item->catalog_count + $item->count;
            $item->item->save();
            $money = $money + $item->price * $item->count;
            $bonus=$bonus+$item->item->catalog_bonus;
        }

        $user = \app\models\User::findOne($model->userid);
        if ($user) {
            //$user->balance = $user->balance + $money;
            $user->bonus = $user->bonus - $bonus;
            $user->save();
        }

        \yii::$app->language=$user->lang;
        \app\models\User::setBalance('+' .$money, $model->userid, 0, $comment = \yii::t('app', 'Отмена заказа'));

        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionCancelOne($id)
    {
        $money = 0;
        $model = $this->findModelItem($id);

        $model->item->catalog_count = $model->item->catalog_count + $model->count;
        $model->item->save();
        $money = $money + $model->price * $model->count;

        $user = \app\models\User::findOne($model->order->userid);
        if ($user) {
            //$user->balance = $user->balance + $money;
            $user->bonus = $user->bonus - $model->item->catalog_bonus;
            $user->save();
        }
        //$model->delete();
        \yii::$app->language=$user->lang;
        \app\models\User::setBalance('+' .$money, $model->order->userid, $model->item->catalog_id, $comment = \yii::t('app', 'Отмена товара'));

         Tickets::add($model->item->catalog_id,
             \app\modules\system\models\TextWidget::getTpl('return_order', ['link' => $model->item->catalog_url, 'item' => $model->getLangItem($user->lang)->catalog_name],$user->lang), 2, Tickets::MESSAGE, $model->order->userid, 0, 3);

        return $this->redirect(['index']);
    }



    public function actionChangestatusitem($id, $status)
    {
        $model = $this->findModelItem($id);
        $model->statusid = $status;
        $model->save();

        $this->changeStatusOrder($model);
    }

    public function changeStatusOrder($model)
    {

        $shop = $this->findModel($model->shopid);
        if (ShopItem::Qty() == ShopItem::QtyWithStatus($model->statusid)) {

            switch ($model->statusid) {
                case '156':
                    break;
                case '157':
                    break;
                case '158':
                    break;
                case '159':
                    $shop->shopcatid = 164;
                    break;
                case '160':
                    $shop->shopcatid = 165;
                    break;
            }
            /* 156     В обработке                                 161   В обработке
                       Временно отсутствует в продаже                    Проверьте статус товаров
                       Сделана замена                                    Готовятся к отправке
                       Отправлен                                         Отправлен
                       Доставлен                                         Успешно выполнен*/

        }
        switch ($model->statusid) {
            case '157':
                $shop->shopcatid = 164;
                break;
            case '158':
                $shop->shopcatid = 164;
                break;
        }

        $shop->save();
    }

    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionImport()
    {
        $msg = '';
        if (\yii::$app->request->get('limit', 0)) {

            $cat = new \app\components\mystoke\ImportCatalog();
            if ($cat->_list(\yii::$app->request->get('offset'), \yii::$app->request->get('limit')) === false)
                $msg = 'Все товары загружены';
            if ($cat->names)
                $msg = $cat->names;
        }


        return $this->render('import', [
            'msg' => $msg,
        ]);
    }


    public function actionCreate()
    {
        $model = new Shop();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('updated', \Yii::t('admin', 'Данные успешно созданы'));
            return $this->redirect(['index']);
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
        \Yii::$app->session->setFlash('updated', \Yii::t('admin', 'Данные успешно удалены'));
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelItem($id)
    {
        if (($model = ShopItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}