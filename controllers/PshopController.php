<?php

namespace app\controllers;

use app\modules\shop\models\Shop;
use app\modules\shop\models\ShopItem;
use app\models\User;
use yii\data\Pagination;
use Yii;
use yii\web\Response;
use app\modules\tickets\models\Tickets;

class PshopController extends BaseController
{


    public function getOrders($key)
    {

        $row = yii::$app->db->createCommand("
                select shopid from shop_item left join catalog on catalog_id = itemid WHERE catalog_title LIKE '%" . $key . "%'
                ")->queryAll();

        foreach ($row as $shops) {
            $in[] = $shops['shopid'];
        }
        if ($in)
            return implode(',', $in);
        else
            return 0;

    }

    public function ajax()
    {

        if (!yii::$app->user->getId())
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

        if (\yii::$app->request->isPost && $key = \yii::$app->request->post('key')) {


            $url['status'] = (yii::$app->request->get('status') == 'desc') ? ' asc' : ' desc';

            $query = Shop::find();

            $query->andWhere(' userid = ' . yii::$app->user->getId() . ' ');
            $query->andWhere(' shop_id IN (' . $this->getOrders($key) . ')');


            if (yii::$app->request->post('datefrom') && yii::$app->request->post('dateto')) {
                $datefrom = date("Y-m-d H:i:s", strtotime(yii::$app->request->post('datefrom')));
                $dateto = date("Y-m-d H:i:s", strtotime(yii::$app->request->post('dateto')) + 3600 * 24);
                $query->andWhere(' shop_date <= "' . $dateto . '" and shop_date >= "' . $datefrom . '"');
            } elseif (yii::$app->request->get('dateto')) {
                $dateto = date("Y-m-d H:i:s", strtotime(yii::$app->request->post('dateto')) + 3600 * 24);
                $query->andWhere(' shop_date <= "' . $dateto . '"');
            }
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 200]);

            $_GET['key'] = $key;

            $query->orderBy(' shop_id DESC, shopcatid  ' . $url['status']);

            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            echo $this->renderPartial('_ajax_history', ['models' => $models, 'pages' => $pages]);
            exit;
        }
    }

    public function actionHistory()
    {


        if (\yii::$app->request->isPost && $key = \yii::$app->request->post('key')) {
            $this->ajax();
        } else {

            if (!yii::$app->user->getId())
                throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

            $searchModel = Shop::find()->where(['userid' => yii::$app->user->id])->orderby('shop_date DESC');


            if (yii::$app->request->get('datefrom') && yii::$app->request->get('dateto')) {
                $datefrom = date("Y-m-d H:i:s", strtotime(yii::$app->request->get('datefrom')));
                $dateto = date("Y-m-d H:i:s", strtotime(yii::$app->request->get('dateto')) + 3600 * 24);
                $searchModel->andWhere(' shop_date <= "' . $dateto . '" and shop_date >= "' . $datefrom . '"');
            } elseif (yii::$app->request->get('dateto')) {
                $dateto = date("Y-m-d H:i:s", strtotime(yii::$app->request->get('dateto')) + 3600 * 24);
                $searchModel->andWhere(' shop_date <= "' . $dateto . '"');
            }


            $countQuery = clone $searchModel;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 15]);

            $models = $searchModel->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('history', [
                'models' => $models,
                'pages' => $pages,
            ]);
        }

        /*
        $shops = Shop::find()->where(['userid' => yii::$app->user->id])->all();

        return $this->render('history', ['shops' => $shops]);*/

    }

    public function actionAdd()
    {

         if (!yii::$app->user->getId()) {
             die('errpr');
         }
        $id = yii::$app->request->post('id');

        $catalog = \app\modules\catalog\models\Catalog::find()->where('catalog_id = ' . $id . ' or langid = ' . $id)->one();

        if ($catalog->catalog_count < 1) {
            die('error count');
        }
        $price = $catalog->catalog_price;

        $item = \app\modules\shop\models\ShopItem::find()->where(['ip' => $_SERVER['REMOTE_ADDR'], 'itemid' => $id])->one();
        if (!$item) {
            if ($catalog) {
                $new = new ShopItem;
                $new->ip = $_SERVER['REMOTE_ADDR'];
                $new->itemid = $id;
                $new->tablename = 'catalog';
                $new->count = 1;
                $new->price = $price;
                $new->mean = 0;
                $new->colorid = 0;
                $new->currency = \app\modules\system\models\Course::getCurrency();
                $new->currency_value = \app\modules\system\models\Course::getMoney();

                if (!$new->save())
                    print_r($new->getErrors());
            } else {
                echo 'no item;';
            }
        } else {
            $item->count++;
            $item->save();
        }


        echo $this->renderPartial('_basket');
        exit;

    }


    public function actionCheckout()
    {

        if (!ShopItem::Qty()) {
            $this->redirect('/');
        }

        $shop = new Shop;
        $shop->shopcatid = 197;
        if ($shop->load(Yii::$app->request->post())) {

            if (\yii::$app->user->getId()) {
                $shop->email = yii::$app->user->identity->email;
                $shop->fio = yii::$app->user->identity->name;
            }

            if ($shop->save()) {
                \Yii::$app->session->setFlash('updated', \Yii::t('admin', 'Заказ успешно оформлен'));

                if (\yii::$app->user->getId()) {
                    $user = \app\models\User::findOne(\yii::$app->user->getId());
                    if (!trim(yii::$app->user->identity->place)) {
                        $user->place = $shop->country;
                    }
                    if (!trim(yii::$app->user->identity->adres)) {
                        $user->adres = $shop->adres;
                    }

                    if (!trim(yii::$app->user->identity->index)) {
                        $user->index = $shop->index;
                    }

                    if (!trim(yii::$app->user->identity->phone)) {
                        $user->phone = $shop->phone;
                    }
                    if (!$user->save()) {
                        print_r($user->getErrors());
                    }
                }

                ShopItem::checkout($shop->shop_id,1);

                if (\yii::$app->user->getId()) {


                    $shopBonus = Shop::find()->where(['shop_id' => $shop->shop_id])->one();
                    if (\yii::$app->user->identity->balance >= $shopBonus->price->sum_price) {
                        $user = \app\models\User::findOne($shop->userid);
                        if ($user && $shopBonus) {

                            if (count($shopBonus->items)) {$i=1;
                                foreach ($shopBonus->items as $item) {
                                    $user->addBonus($item->item->catalog_bonus * $item->count);
                                    $price = $item->count * $item->price;
                                    User::setBalance('-' .$price, $shop->userid, $item->item->catalog_id, $comment = \yii::t('app', 'Покупка товара'));
                                    $msgItem[]="<span style='color:#000'>($i)</span> ".$item->item->catalog_title.' <b>x'.$item->count.'</b>';
                                    $i++;
                                }
                                $msgItem=implode(", ",$msgItem);
                            }


                        }
                        $shopBonus->payed = 1;
                        $shopBonus->save();
                        ShopItem::checkout($shop->shop_id,0);
                        $nourl = 1;

                        $email=$shopBonus->email;
                        $phone=$shopBonus->phone;
                        $adres=$shopBonus->adres;
                        $fio=$shopBonus->fio;

                        Tickets::sendEmail(
                            \yii::t('app', 'Приобрeтение товара на bountymart.com'),
\yii::t('app', 'Вы только что приобрели <span style="color:red">{item}</span>. Адрес доставки {adres}, {phone} на имя {name}. Срок доставки от 20 до 40 дней. В ближайшее время наш  менеджер начнет обработку вашего заказа. Состояние заказа вы можете отслеживать в личном кабинете. Спасибо за покупку!', ['phone' => $phone, 'name' => $fio, 'adres' => $adres, 'item' => $msgItem]),
                            $email);
                    }
                }


                if (\yii::$app->request->isAjax) {
                    \Yii::$app->response->format = Response::FORMAT_JSON;


                    return [
                        'url' => (($nourl)?'':'/pay?amount=' . \app\modules\system\models\Course::getPriceClear($shop->price->sum_price) . '&shopid=' . $shop->shop_id),
                        'status' => 'ok',
                        'text' => yii::t('app',
'Вы только что приобрели <span style="color:red">{item}</span>. Адрес доставки {adres}, {phone} на имя {name}. Срок доставки от 20 до 40 дней. В ближайшее время наш  менеджер начнет обработку вашего заказа. Состояние заказа вы можете отслеживать в личном кабинете. Спасибо за покупку!', ['phone' => $shop->phone, 'name' => $shop->fio, 'adres' => $shop->adres, 'item' => $msgItem ])];
                } else {
                    return $this->render('checkout_success', ['shop' => $shop]);
                }
            } else {
                if (\yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 'error',
                        'errors' => $shop->getErrors()];
                }
            }
        } else {

            if (\yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['status' => 'error',
                    'errors' => $shop->getErrors()];
            } else {

                $items = ShopItem::find()->where(['ip' => $_SERVER['REMOTE_ADDR']])->all();

                return $this->render('checkout', ['items' => $items, 'shop' => $shop]);
            }
        }


    }

    public function actionChange_item($id, $count)
    {
        if ($id && (int)$count) {
            $item = ShopItem::findOne($id);
            $item->count = (int)$count;
            $item->currency = \app\modules\system\models\Course::getCurrency();
            $item->currency_value = \app\modules\system\models\Course::getMoney();
            if (!$item->save())
                print_r($item->getErrors());
        }
    }

    public function actionUpdate($id)
    {

        if ($id) {
            $item = ShopItem::findOne($id);
            if ($item) {
                $item->count = (int)\yii::$app->request->post('count', 0);
                $item->mean = (int)\yii::$app->request->post('weight', 0);
                $item->colorid = (int)\yii::$app->request->post('color', 0);
                $item->save();
            }
        }
    }

    public function actionDelete_item($id)
    {
        if ($id){
            $item=ShopItem::findOne($id);
            if(!$item->mean)
                $item->delete();
        }


    }


}