<?php

namespace app\controllers;

use app\components\libwebtopay\WebToPay;
use app\models\Webtopay as Pay;
use app\modules\catalog\models\Catalog;
use app\modules\shop\models\Shop;
use app\modules\shop\models\ShopItem;
use app\modules\terms\models\Terms;
use app\modules\tickets\models\Tickets;


class PayController extends BaseController
{

    public function actionIndex($amount, $shopid = 0)
    {

        $amount = floatval(str_replace(',','.',$amount));
        $amount = $amount * 100;
        if ($shopid) {
            $shop = Shop::find()->where(['shop_id' => $shopid])->one();
            $email = (($shop->email) ? $shop->email : '');
            $hash = $shop->hash;
            if (!$hash) {
                echo 'no hash';
                exit;
            }
        }
        if (\yii::$app->user->getId()) {
            $email = \yii::$app->user->identity->email;
        }
        $pay = new Pay();
        $pay->userid = (\yii::$app->user->getId()) ? \yii::$app->user->getId() : 0;
        $pay->shopid = $shopid;
        $pay->approve = 0;
        $pay->save();


        $orderid = isset($data['orderid']) ? $data['orderid'] + 1 : 1;
        $cur = strtoupper(\yii::$app->session->get('currency', 'USD'));
        if ($cur == 'EURO') {
            $cur = 'EUR';
        }
        $order = array(
            'amount' => $amount,
            'currency' => $cur,
            'orderid' => $pay->id,
            'p_email' => $email,
            'hash' => ($hash) ? $hash : 0,
        );

        $post = [];


// this method builds request and sends Location header for redirecting to payment site
// as an alternative, you can use WebToPay::buildRequest and make auto-post form
        WebToPay::redirectToPayment(array_merge(
            $post,
            $this->config,
            $order
        ));
        exit;
    }


    public function actionAccept()
    {


        try {
            $response = WebToPay::validateAndParseData(\yii::$app->request->get(), $this->config['projectid'], $this->config['sign_password']);
            if ($response['status'] == 1 || $response['status'] == 2) {

                $usd = \app\modules\system\models\Course::find()->where(['alias' => 'USD'])->one();


                $response = $this->Convert($response);


                // You can start providing services when you get confirmation with accept url
                // Be sure to check if this order is not yet confirmed - user can refresh page anytime
                // status 2 means that payment has been got but it's not yet confirmed
                // @todo: get order by $response['orderid'], validate test (!), amount and currency
                $title = '';//'Your payment has been got successfuly, it will be confirmed shortly<br />';
                $pay = Pay::find()->where(['id' => $response['orderid']])->one();
                if ($pay->shopid) {
                    $shop = Shop::find()->where(['shop_id' => $pay->shopid])->one();
                    ShopItem::checkout($shop->shop_id, 0);
                }


                if ($pay & $pay->approve != 1) {

                    if ($pay->userid && $pay->shopid == 0) { //пополнение баланса

                        if ($balance = \app\models\User::setBalance($response['amount'] / 100)) {
                            $pay->approve = 1;
                            $title .= \yii::t('app', 'Платеж успешно завершен');
                        } else {
                            $pay->approve = 999;
                            $title .= \yii::t('app', 'Возникла ошибка свяжитесь с администратором');
                        }
                        $shop = '';
                        $msg = \yii::t('app', "Ваш баланс успешно пополнен!");
                        $this->redirect('/balance');

                        return $this->render('success', ['title' => $title, 'shop' => $shop, 'msg' => $msg]);
                    } elseif ($pay->shopid > 0) {
                        $pay->approve = 1;
                        $pay->save();
                        ShopItem::checkout($pay->shopid, 0);
                        $this->userSave($pay);

                        $title .= \yii::t('app', 'Платеж успешно завершен');
                        $email = $shop->email;
                        $phone = $shop->phone;
                        $adres = $shop->adres;
                        $fio = $shop->fio;
                        $item = $shop->items[0]->item->catalog_title;

                        $i=1;
                        foreach($shop->items as $sItem){
                            $msgItem[]="($i)".$sItem->item->catalog_title.'<b> x '.$sItem->count.'</b>';
                            $i++;
                        }

                        if ($pay->userid)
                            $msg = \yii::t('app', 'Вы только что приобрели <span style="">{item}</span>. Адрес доставки {adres}, {phone} на имя {name}. Срок доставки от 20 до 40 дней. В ближайшее время наш  менеджер начнет обработку вашего заказа. Состояние заказа вы можете отслеживать в личном кабинете. Спасибо за покупку!',
                                ['phone' => $phone, 'name' => $fio, 'adres' => $adres, 'item' => @implode(', ',$msgItem)]);
                        else
                            $msg = \yii::t('app', 'Вы только что приобрели <span style="">{item}</span>. Адрес доставки {adres}, {phone} на имя {name}. Срок доставки от 20 до 40 дней. В ближайшее время наш  менеджер начнет обработку вашего заказа. Состояние заказа вы можете отслеживать в личном кабинете. Спасибо за покупку!',
                                ['phone' => $phone, 'name' => $fio, 'adres' => $adres, 'item' => @implode(', ',$msgItem)]);

                        Tickets::sendEmail(
                            \yii::t('app', 'Приобрeтение товара на bountymart.com'),
                            $msg,
                            $email);


                    }

                    return $this->render('success', ['title' => $title, 'shop' => $shop, 'msg' => $msg]);
                } elseif ($pay->approve == 1) {
                    $title .= \yii::t('app', 'Платеж успешно завершен');

                    if ($pay->userid && $pay->shopid == 0) {
                        $this->redirect('/balance');
                        $msg = \yii::t('app', "Ваш баланс успешно пополнен!");
                    } else {

                        $email = $shop->email;
                        $phone = $shop->phone;
                        $adres = $shop->adres;
                        $fio = $shop->fio;

                        if(\yii::$app->session->get('orderBonus',0)!=$pay->shopid){
                            $this->userSave($pay);
                            \yii::$app->session->set('orderBonus',$pay->shopid);
                        }

                        $i=1;
                        foreach($shop->items as $sItem){
                            $msgItem[]="($i)".$sItem->item->catalog_title.'<b> x '.$sItem->count.'</b>';
                            $i++;
                        }

                        if ($pay->userid)
                            $msg = \yii::t('app', 'Вы только что приобрели <span style="">{item}</span>. Адрес доставки {adres}, {phone} на имя {name}. Срок доставки от 20 до 40 дней. В ближайшее время наш  менеджер начнет обработку вашего заказа. Состояние заказа вы можете отслеживать в личном кабинете. Спасибо за покупку!',
                                ['phone' => $phone, 'name' => $fio, 'adres' => $adres, 'item' => @implode(', ',$msgItem)]);
                        else
                            $msg = \yii::t('app', 'Вы только что приобрели <span style="">{item}</span>. Адрес доставки {adres}, {phone} на имя {name}. Срок доставки от 20 до 40 дней. В ближайшее время наш  менеджер начнет обработку вашего заказа. Состояние заказа вы можете отслеживать в личном кабинете. Спасибо за покупку!',
                                ['phone' => $phone, 'name' => $fio, 'adres' => $adres, 'item' => @implode(', ',$msgItem)]);

                    }

                    return $this->render('success', ['title' => $title, 'shop' => $shop, 'msg' => $msg]);
                }
            }
        } catch (Exception $e) {
            $title .= \yii::t('app', 'Ваш платеж еще не завершен!');
        }
        $title .= \yii::t('app', 'Возникла ошибка свяжитесь с администратором, сервер банка вернул неправильные данные');

        return $this->render('success', compact('title'));
    }


    public function actionCancel()
    {
        return $this->render('cancel');
    }

    public function Convert($response)
    {
        if ($response['currency'] == 'EUR') {
            $cur = 'Euro';
            $usd = \app\modules\system\models\Course::find()->where(['alias' => $cur])->one();
            $response['amount'] = $response['amount'] / $usd->price;
        } else {
            $cur = $response['currency'];
            $usd = \app\modules\system\models\Course::find()->where(['alias' => $cur])->one();
            $response['amount'] = $response['amount'] / $usd->price;
        }

        return $response;
    }

    public function actionCallback()
    {


        try {
            $response = WebToPay::validateAndParseData(\yii::$app->request->get(), $this->config['projectid'], $this->config['sign_password']);

            if ($response['status'] == 1 || $response['status'] == 2) {
                $response = $this->Convert($response);
                // You can start providing services when you get confirmation with accept url
                // Be sure to check if this order is not yet confirmed - user can refresh page anytime
                // status 2 means that payment has been got but it's not yet confirmed
                // @todo: get order by $response['orderid'], validate test (!), amount and currency
                echo 'Your payment has been got successfuly, it will be confirmed shortly<br />';
                $pay = Pay::find()->where(['id' => $response['orderid']])->one();
                if ($pay/* && $pay->approve != 1*/) {
                    if ($pay->userid && $pay->shopid == 0) {
                        if ($balance = \app\models\User::setBalance($response['amount'] / 100, $pay->userid)) {
                            $pay->approve = 1;
                            echo 'Платеж успешно завершен';
                        } else {
                            $pay->approve = 999;
                            echo 'Возникла ошибка свяжитесь с администратором';
                        }
                        $pay->save();
                    } elseif ($pay->shopid > 0) {
                        $pay->approve = 1;
                        $pay->save();
                        ShopItem::checkout($pay->shopid, 0);
                        $this->userSave($pay);

                        if ($pay->shopid) {
                            $shop = Shop::find()->where(['shop_id' => $pay->shopid])->one();
                        }

                        if ($pay->userid) {
                            $l = \yii::$app->language;
                            \yii::$app->language = $pay->user->lang;
                            $comment = \yii::t('app', "Покупка товара");
                            \yii::$app->language = $l;

                            foreach($shop->items as $item){
                                    $er = \app\modules\catalog\models\Balance::add(0, $pay->user->balance, '-' . ($item->count*$item->price), $comment, $pay->userid, '');
                             //       $pay->user->addBonus($item->catalog_bonus,$pay->userid);
                            }

                        }
                        echo 'Платеж успешно завершен';
                    }
                    return '';
                }
            }
        } catch (Exception $e) {
            echo 'Your payment is not yet confirmed, system error<br />';
        }
        echo 'Возникла ошибка свяжитесь с администратором, сервер банка вернул неправильные данные';

    }

    function userSave($pay)
    {
        $user = \app\models\User::findOne($pay->userid);
        $shopBonus = Shop::find()->where(['shop_id' => $pay->shopid])->one();
        ShopItem::checkout($shopBonus->shop_id, 0);

        if ($user && $shopBonus) {

            if (count($shopBonus->items)) {
                foreach ($shopBonus->items as $item) {
                    $user->addBonus($item->item->catalog_bonus * $item->count);
                }
            }
        }
        $shopBonus->payed = 1;
        $shopBonus->save();

    }
}