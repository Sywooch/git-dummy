<?php

 
 

namespace app\modules\system\models;

use Yii;
use yii\base\Model;


class Notice
{
    public static function LowBalance($class=''){
        if(!$uid = \yii::$app->user->getId() ) return '';
        if(\yii::$app->user->identity->balance <= \yii::$app->params['lowbalance']){
            if($class){
                 return   \app\modules\system\models\TextWidget::getTpl('low_money');
            }else{
                $text=\app\modules\system\models\TextWidget::get('low_money')->one();
                if($text)
                    return $text->statusid;
            }
        }
    }

    public static function NullBalance($class=''){
        if(!$uid = \yii::$app->user->getId() ) return '';
        if(\yii::$app->user->identity->balance == 0){
            if($class){
                return   \app\modules\system\models\TextWidget::getTpl('null_money');
            }else{
                $text=\app\modules\system\models\TextWidget::get('null_money')->one();
                if($text)
                    return $text->statusid;
            }
        }
    }

    public static function emptyAdres($class=''){
        if(!$uid=\yii::$app->user->getId() ) return '';
        $user=\app\models\User::find()->where('id='.$uid)->one();
        if(!$user->adres || !$user->phone){
            if($class) {
                  return       \app\modules\system\models\TextWidget::getTpl('error_profile_adres');
            }else{
                $text=\app\modules\system\models\TextWidget::get('error_profile_adres')->one();
                if($text)
                    return $text->statusid;
            }
        }
    }



    public static function approveEmail($class=''){
        if(!$uid=\yii::$app->user->getId() ) return '';
        $user=\app\models\User::find()->where('id='.$uid)->one();
        if($user->isemail == 0){
             return       \app\modules\system\models\TextWidget::getTpl('activation_email_adres');
        }
    }

    public static function Activity($catid){
        if(!\yii::$app->user->getId()) return '';
                if($catid == 1){
                    $row =  \app\modules\tickets\models\Tickets::find()->where(' tcatid = '.$catid.' and userid = '.yii::$app->user->getId().' and isread=0
                     ORDER BY '.str_replace('status','textstatusid',\app\modules\system\models\TextWidget::$queryStatusOrder)
                    )->one();
                    return $row->textstatusid;
                }else{
                    $row =  \app\modules\tickets\models\Tickets::find()->where(' tcatid = '.$catid.' and userid = '.yii::$app->user->getId().'  and isread=0
                       ORDER BY '.str_replace('status','textstatusid',\app\modules\system\models\TextWidget::$queryStatusOrder))->one();
                    return $row->textstatusid;
                }
    }

    public static function ActivityCount($catid = 2){
        if(!\yii::$app->user->getId()) return '';
            $row =  \app\modules\tickets\models\Tickets::find()->where(' tcatid = '.$catid.' and userid = '.yii::$app->user->getId().' and statusid IN (4) and isread=0  ')->one();
            return count($row);
    }

    public static function MessageForWinner(){
        if(!$uid = \yii::$app->user->getId()) return '';
        $row =  \app\models\Auct::find()->where(' comment is NULL and userid ='.$uid.' and  status = 1  ')->one();
        if($row !== null)
        return $row;
    }

    public static function newOrder(){
        if(!$uid = \yii::$app->user->getId()) return '';
        $row =  \app\modules\shop\models\Shop::find()->where(' userid ='.$uid.' and  isread = 0  ')->one();
        if($row !== null)
            return 3;
    }
}