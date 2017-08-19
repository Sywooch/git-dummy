<?php

namespace app\controllers;

use app\models\Auct;
use app\models\User;
use app\modules\catalog\models\Balance;
use app\modules\shop\models\Shop;
use app\modules\shop\models\ShopItem;
use app\modules\system\models\TextWidget;
use app\modules\tickets\models\Tickets;
use yii;
use yii\web\Response;

class AuctController extends BaseController
{

    public function actionWinner()
    {


        if (\yii::$app->request->isPost) {
            if ($cid = \yii::$app->request->post('product') && $bitid = \yii::$app->request->post('bitid')) {
                $bit = Auct::find()->where(' /*status = 1  and catalogid = ' . $cid . ' and */id = ' . $bitid . ' and userid = ' . \yii::$app->user->getId())->one();

                if ($bit !== null && $bit->status == 1) {
                    if (strlen(\yii::$app->request->post('msg', '')) >= 55) {
                        $bit->comment = \yii::$app->request->post('msg', '');
                        $bit->comment_time = date("y-m-d H:i:s");
                        if (!$bit->save()) {
                            $bit->getErrors();
                        } else {
                            ;
                        }
                    } else {
                        echo '< 70 ';
                    }
                } else {
                    echo 'bit not found';
                }
            } else {
                echo ' request ';
            }


        } else {
            echo ' not post ';
        }

    }

    public function actionGetouttime()
    {
        $users = [];
        $catalog = \app\modules\catalog\models\Catalog::find()->andWhere('catalog_public=1 and catalog_dateend < "' . date("Y-m-d H:i:s") . '"')->all();
        if (is_array($catalog)) {
            foreach ($catalog as $item) {
               $wasPayed = 0;

               $winner = Auct::find()->where(['catalogid' => $item->catalog_id, 'status' => 0])->orderby('price DESC')->one();
                if ($winner) {
                    Auct::setStatus($winner, 1);

                  // Balance::setUnHold($item->catalog_id, $winner->userid);
//echo $winner->user->balance.' '.$winner->course_price;
                    if ($winner->user->balance >= $winner->course_price) {
                        $result = User::setBalance('-' . \app\modules\system\models\Course::getDefaultPrice($winner->course_price), $winner->userid, $winner->catalogid, $comment = \yii::t('app', 'Покупка выигранного товара!'));
                        $wasPayed = 1;
                        $item->decriment();
                    }

                    yii::$app->language=$winner->user->lang;
                    Tickets::sendEmail(yii::t('app', 'Вы выиграли товар'), \app\modules\system\models\TextWidget::getTpl('win-email',[],$winner->user->lang), $winner->user->email);

                    $mes = \app\modules\system\models\TextWidget::get('bit_win')->one();
                    //активность
                    Tickets::add($winner->catalogid,
                        \app\modules\system\models\TextWidget::getTpl('bit_win', ['link' => $item->catalog_url, 'item' => $item->catalog_name],$winner->user->lang), 4, Tickets::ACTIVITY, $winner->userid, 0, $mes['statusid']);
                    //сообщение
                    // Tickets::add($winner->catalogid,
                    //     \app\modules\system\models\TextWidget::getTpl('bit_win', ['link' => $item->catalog_url, 'item' => $item->catalog_name]), 2, Tickets::MESSAGE, $winner->userid, 0, 3);

                    $user = $winner->user;
                    //make item

                    $user->addBonus($item->catalog_bonus);
                    $new = new ShopItem;
                    $new->ip = ($wasPayed) ? ''  : $winner->userid;
                    $new->itemid = $winner->catalogid;
                    $new->tablename = 'catalog';
                    $new->count = 1;
                    $new->price = $winner->price;
                    $new->mean = $winner->id;
                    $new->colorid = 0;
                    $new->currency = $winner->course_name;
                    $new->currency_value = $winner->course_price;
                    if ($new->save() && $wasPayed == 1) {
                        //make order
                        $shop = new Shop;
                        $shop->userid = $winner->userid;
                        $shop->shopcatid = 197;
                        $shop->adres = $user->adres;
                        $shop->country = $user->place;
                        $shop->email = $user->email;
                        $shop->fio = $user->name;
                        $shop->phone = ($user->phone)?$user->phone:'+11111';
                        $shop->index = ($user->index)?$user->index:' ';
                        $shop->payed = 1;
                        if ($shop->save()) {
                            //addint items to order
                            $new->shopid = $shop->shop_id;
                            if (!$new->save()) {
                                print_r($new->getErrors());
                                echo 3;
                            }
                        } else {
                            echo 2;
                            print_r($shop->getErrors());
                        }
                    } else {
                        echo 1;
                        print_r($new->getErrors());
                    }

                }
                $item->nextDateEnd();
            }
        }



        $catalog = \app\modules\catalog\models\Catalog::find()->Where('catalog_public=1  and langid = 0')->all();
        foreach($catalog as $item){
            $item->savePersent();
        }
    }


    public function actionInfo($product)
    {


        if (!\yii::$app->request->isPut) {
            return ['status' => 'error',
                'title' => \yii::t('app', 'Неверный запрос'),
                'message' => \yii::t('app', 'Успехов'),];
        }

         if (!yii::$app->user->getId()) {
             return [
                 'status' => 'error',
                 'move' => '/user/registartion',
                 'title' => \yii::t('app', 'Вы не авторизованы!'),
                 'message' => \yii::t('app', '<a href="/user/registration">Зарегистрируйтесь</a> или <a href="/user/registration">авторизуйтесь</a>  чтобы делать ставки'),];
         }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $product])->one();
        if (\yii::$app->language == 'en') {
            $item2 = \app\modules\catalog\models\Catalog::find()->where(['langid' => $product])->one();
        }

        $errors = [];
        if (/*\yii::$app->user->getId() &&*/
            $item !== null
        ) {

            return ['status' => 'success',
                'price' => $item->priceStep(),
                'message' => $this->renderAjax('info', ['item' => $item, 'title' => (($item2) ? $item2->catalog_title : $item->catalog_title)])
            ];
        } else {
            return [
                'status' => 'success',
                'message' => $this->renderAjax('info', ['item' => $item])
            ];
        }

    }

    public function actionAddbit($product)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $price = str_replace([\app\modules\system\models\Course::getName(), ' '], '', yii::$app->request->get('price'));
        $price = str_replace(',', '.', $price);


        if (is_numeric($price)) {
            $price = (float)$price;
        } else {
            return ['status' => 'error',
                'title' => \yii::t('app', 'Ошибка'),
                'message' => \yii::t('app', 'В ставке содержатся недопустимые символы'),];
        }


        //echo 'price - ' . $price . '<br>';


        if (!yii::$app->user->getId()) {
            return ['status' => 'error',
                'title' => \yii::t('app', 'Вы не авторизованы!'),
                'message' => \yii::t('app', '<a href="/user/registration">Зарегистрируйтесь</a> или <a href="/user/registration">авторизуйтесь</a>  чтобы делать ставки'),];
        }

        $user = \app\models\User::find()->where('id=' . yii::$app->user->identity->id)->one();

        if ($user && $user->isemail != 1) {
            return ['status' => 'error',
                'move' => '/user/profile',
                'title' => \yii::t('app', 'Подтвердите email!'),
                'message' => \yii::t('app', 'Вы не подтвердили email делать ставки нельзя'),];
        }


        if ($user && $user->balance < 1) {
            return ['status' => 'error',
                'move' => '/balance',
                'title' => \yii::t('app', 'Пополните баланс!'),
                'message' => \yii::t('app', 'Чтобы делать ставки, пополните баланс на любую сумму!'),];
        }

        if ($user && (!trim($user->adres) || !trim($user->phone) || !trim($user->place))) {
            return ['status' => 'error',
                'move' => '/user/profile',
                'title' => \yii::t('app', 'Заполните Ваш профайл'),
                'message' => \yii::t('app', 'У вас не заполнен профайл.'),];
        }
        $checkid=\app\models\Auct::checkWinnerNotPayed($user->id);

        if ($checkid) {
            return ['status' => 'error',
                'title' => \yii::t('app', 'Ошибка!'),
                'message' => \yii::t('app', 'Вы не можете делать ставку пока не оплатите товар'),];
        }
         if (\app\modules\catalog\models\Balance::checkHold($product, $user->id)) {
             return ['status' => 'error',
                 'title' => \yii::t('app', 'Ваша ставка еще активна!'),
                 'message' => \yii::t('app', 'Вы не можете перебивать свою ставку'),];
         }


        $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $product])->one();

        $errors = [];
        if (yii::$app->user->getId() && $item !== null) {

            $priceBit = str_replace([\app\modules\system\models\Course::getName(), ''], '', $item->priceStep());
            $priceBit = str_replace(',', '.', $priceBit);

            //  echo '$priceBit - ' . $priceBit . '<br>';

            //Проверка баланса
            if (!$item->catalog_count)
                return ['status' => 'error',
                    'title' => \yii::t('app', 'Ошибка!'),
                    'message' => \yii::t('app', 'Закончился товар'),];


            if ($price < $priceBit)
                return ['status' => 'error',
                    'title' => \yii::t('app', 'Ошибка!'),
                    'message' => \yii::t('app', 'Цена должна быть равна или больше ') . $priceBit,];


            if (strtotime($item->catalog_dateend) < mktime())
                return ['status' => 'error',
                    'title' => \yii::t('app', 'Ошибка!'),
                    'message' => \yii::t('app', 'Вы не можете делать ставки на просроченный товар'),];

            //Проверка баланса
            /*if (!User::checkBalance($price))
                return ['status' => 'error',
                    'title' => \yii::t('app', 'Ошибка!'),
                    'move' => '/balance',
                    'message' => \yii::t('app', 'На вашем счету недостаточно средств'),];*/


            if ($this->addBitTimes($item, $price))
                $errors = ['status' => 'ok',
                    'title' => \yii::t('app', 'Поздравляем!'),
                    'message' => \yii::t('app', 'Ваша ставка принята!'),
                ];
            else
                $errors = ['status' => 'error',
                    'title' => \yii::t('app', 'Ошибка!'),
                    'message' => \yii::t('app', 'Не удалось сделать ставку,  попробуйте позже!')];
        }
        return $errors;

    }

    public function addBitTimes($item, $price)
    {

        $uid = yii::$app->user->getId();
        $cid = yii::$app->request->get('product');;


        for ($i = 0; $i < 1; $i++) {
            if (!Auct::find()->where([
                'userid' => yii::$app->user->getId(),
                'catalogid' => \app\modules\system\models\Course::getDefaultPrice($price),
                'status' => 0
            ])->one()
            ) {
                $model = new Auct;
                $model->userid = yii::$app->user->getId();
                $model->catalogid = $cid;
                $model->price = \app\modules\system\models\Course::getDefaultPrice($price);
                $model->codeindex = 0;
                $model->status = 0;
                $model->course_price = $price;
                $model->course_name = \app\modules\system\models\Course::getCurrency();

                if (!$model->save()) {
                    // print_r($model->getErrors());
                    return false;
                }
            }
        }

        $count = Auct::find()->where(['catalogid' => $cid, 'status' => 0])->all();

        $item2 = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $cid])->one();
        if (\yii::$app->language == 'en') {
            $item2 = \app\modules\catalog\models\Catalog::find()->where(['langid' => $cid])->one();
        }


        \app\modules\tickets\models\Tickets::add($cid,
            TextWidget::getTpl('bit', ['link' => $item->catalog_url, 'item' => $item2->catalog_name, 'bits' => count($count)],\yii::$app->user->identity->lang)
            , 1, 2, $uid, $model->id,
            TextWidget::get('bit')->one()->statusid);

        $this->sendAll($cid, $uid, $item2, $count);

        Tickets::sendEmail(yii::t('app', 'Вы сделали ставку на товар'),
            \app\modules\system\models\TextWidget::getTpl('bit', [
            'link' => $item->catalog_url,
            'item' => $item2->catalog_name,
            'bits' => count($count),
            'price' => yii::$app->request->get('price')],
            \yii::$app->user->identity->lang),
            \yii::$app->user->identity->email);


        //$unhold = \app\modules\catalog\models\Balance::unHold($cid);
       // $result = User::setBalance('-' . \app\modules\system\models\Course::getDefaultPrice($price), $uid, $cid, $comment = \yii::t('app', 'Удержание средств за ставку'), 'hold');


        /*  if ($unhold) {
              $unhold->hide = 1;
              $unhold->save();

              $unhold = \app\modules\catalog\models\Balance::find()->where('moneychange LIKE "%'.$unhold->moneychange.'%"')
                  ->andwhere([
                  'hide' => 0,
                  'userid' => $unhold->userid])->one();
              if ($unhold) {
                  $unhold->hide = 1;
                  $unhold->save();
              }
          }*/
        if (isset($result['error'])) {
            return $result;
        }

        return true;
    }

    public function sendAll($cid, $uid, $item2, $count)
    {
        $lang = \Yii::$app->language;
        $items = \app\models\Auct::getMembers($cid);



        if (is_array($items))
            foreach ($items as $item) {

                if ($item->userid != $uid) {
                    \Yii::$app->language = $item->user->lang;

                    $item2 = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $cid])->one();
                    if ($item->user->lang == 'en') {
                        $item2 = \app\modules\catalog\models\Catalog::find()->where(['langid' => $cid])->one();
                    }

                    $msg = TextWidget::getTpl('return_money_for_bit', [
                        'link' => $item2->catalog_url,
                        'bits' => count($count),
                        'item' => $item2->catalog_name], \Yii::$app->language);


                    \app\modules\tickets\models\Tickets::add($cid,$msg, 1,  \app\modules\tickets\models\Tickets::ACTIVITY, $item->userid, $item->id,
                        TextWidget::get('return_money_for_bit')->one()->statusid);

                    Tickets::sendEmail(Yii::t('app', 'Вашу ставку перебили'), $msg, $item->user->email);
                    break;
                }


            }
        \Yii::$app->language = $lang;
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id) {
            $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $id])->one();
            return [
                'price' => \app\modules\system\models\Course::getPriceClear($item->getPriceOne()),
                'text' => \app\components\widgets\AuctWidget::widget(['productid' => $id])];
        }
    }

    public function actionMembers($product)
    {


        if (!yii::$app->user->getId()) {
            return [
                'move' => '/user/registartion',
                'status' => 'error',
                'title' => \yii::t('app', 'Вы не авторизованы!'),
                'message' => \yii::t('app', '<a href="/user/registration">Зарегистрируйтесь</a> или <a href="/user/registration">авторизуйтесь</a>  чтобы видеть аукцион'),];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $product])->one();

        $item2 = $item;
        if (\yii::$app->language == 'en') {
            $item2 = \app\modules\catalog\models\Catalog::find()->where(['langid' => $product])->one();
        }


        $errors = [];
        if (\yii::$app->user->getId() && $item !== null) {

            return ['status' => 'success',
                'price' => \app\modules\system\models\Course::getPriceClear($item->getPriceOne()),
                'message' => $this->renderAjax('list_members', ['item' => $item, 'item2' => $item2])
            ];
        } else {
            return [
                'status' => 'success',
                'message' => $this->renderAjax('list_members', ['item' => $item, 'item2' => $item2])
            ];
        }

    }


}
