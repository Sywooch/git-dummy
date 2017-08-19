<?php

namespace app\modules\shop\models;

use Yii;

class ShopItem extends \yii\db\ActiveRecord
{

    public $sum_price;
    public $sum_count;

    public static function tableName()
    {
        return 'shop_item';
    }


    public function attributeLabels()
    {
        return
            [
                'shopid' => Yii::t('admin', 'Заказ'),
                'itemid' => Yii::t('admin', 'Товар'),
                'tablename' => Yii::t('admin', 'Таблица'),
                'count' => Yii::t('admin', 'Кол-во'),
                'price' => Yii::t('admin', 'Цена товара'),
                'mean' => Yii::t('admin', 'Ед измерения'),
                'ip' => Yii::t('admin', 'Ip'),
            ];
    }


    public function rules()
    {

        return [

            [['count', 'price'], 'default', 'on' => ['search']],

            [['colorid', 'currency', 'currency_value', 'itemid', 'tablename', 'count', 'price', 'mean'], 'required', 'on' => ['default']],

            [['ip', 'statusid'], 'default'],
        ];
    }
public function getLangItem($lang){
    if ($lang == 'ru')
        return\app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $this->itemid])->one();
    else
        return \app\modules\catalog\models\Catalog::find()->where(['langid' => $this->itemid])->one();
}
    public function getItem()
    {
        $item = \app\modules\catalog\models\Catalog::find()->andWhere(['catalog_id' => $this->itemid])->one();
        if ($item)
            return $item;
        else
            return \app\modules\catalog\models\Catalog::find()->andWhere(['langid' => $this->itemid])->one();

        if (\yii::$app->user->getId() || \yii::$app->language == 'ru')
            return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id' => 'itemid']);
        else
            return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['langid' => 'itemid']);
    }

    public function getOrder()
    {
        return $this->hasOne(\app\modules\shop\models\Shop::className(), ['shop_id' => 'shopid']);
    }

    public function getSize()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'mean']);
    }

    public function getColor()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'colorid']);
    }

    public function getStatus()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'statusid']);
        /* if(\yii::$app->session->get('language','ru') == 'ru')
             return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'statusid']);
             else*/
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['langid' => 'statusid']);
    }


    public static function checkout($id, $hash)
    {


        if ($hash) {
            $hash=md5(mktime());
            (new \yii\db\Query)->createCommand()->update('shop_item',
                [
                    'shopid' => $id,
                    'hash' => $hash,
                ],
                [
                    'ip' => $_SERVER['REMOTE_ADDR']
                ])->execute();

            if($uid=\yii::$app->user->getId()){
                (new \yii\db\Query)->createCommand()->update('shop_item',
                    [
                        'shopid' => $id,
                        'hash' => $hash,
                    ],
                    [
                        'ip' => $uid
                    ])->execute();
            }

            $shop=Shop::find()->where(['shop_id'=>$id])->one();
            $shop->hash=$hash;
            $shop->save();
        } else {

            if(\yii::$app->user->getId()){
                $uid=\yii::$app->user->getId();
                $sql=" ip = '" . $_SERVER['REMOTE_ADDR'] . "' or ip=".$uid." ";

            }else{
                $sql=" ip = '" . $_SERVER['REMOTE_ADDR'] . "' ";
            }


            $rows = ShopItem::find()->where($sql)->all();
            foreach ($rows as $row) {
                $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => (($row->item->langid) ? $row->item->langid : $row->item->catalog_id)])->one();
                $item->catalog_count = $item->catalog_count - $row->count;
                $item->save();
               // if($item->catalog_count==0){
                    //\app\modules\catalog\models\Balance::unHold($item->catalog_id);
                //}
            }

            (new \yii\db\Query)->createCommand()->update('shop_item',
                [
                    'shopid' => $id,
                    'ip' => '',
                ],
                [
                    'ip' => $_SERVER['REMOTE_ADDR']
                ])->execute();
            if($uid=\yii::$app->user->getId()){
                (new \yii\db\Query)->createCommand()->update('shop_item',
                    [
                        'shopid' => $id,
                        'ip' => '',
                    ],
                    [
                        'ip' => $uid
                    ])->execute();
            }
        }
    }

    public static function Qty()
    {
        if(\yii::$app->user->getId()){
            $uid=\yii::$app->user->getId();
        }else{
            $uid=0;
        }
        if($uid)
          $sql="select sum(`count`) as sumcount from shop_item WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' or ip=".$uid." ";
        else
            $sql="select sum(`count`) as sumcount from shop_item WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' ";
        $row = \yii::$app->db->createCommand($sql)->queryOne();
        return $row['sumcount'];
    }

    public static function QtyWithStatus($status)
    {

        $row = \yii::$app->db->createCommand("select sum(`count`) as sumcount from shop_item WHERE  statusid = $status ")->queryOne();
        return $row['sumcount'];
    }

    public static function checkLimit($id)
    {

        $row = \yii::$app->db->createCommand("select sum(`count`) as sumcount from shop_item WHERE  ip= '" . $_SERVER['REMOTE_ADDR'] . "' and  itemid = $id ")->queryOne();
        return $row['sumcount'];
    }
}