<?php

namespace app\controllers;

use yii;
use yii\web\Response;
use yii\web\Controller;
use \app\models\Bits;
use \app\models\User;
use \app\modules\system\models\TextWidget;

class BitController extends BaseController
{
    public function actionWinner(){


        if(\yii::$app->request->isPost){
            if($cid = \yii::$app->request->post('product') && $bitid = \yii::$app->request->post('bitid') ){
                $bit = Bits::find()->where(' /*status = 1  and catalogid = '.$cid.' and */id = '.$bitid.' and userid = '.\yii::$app->user->getId())->one();

                if($bit !==null && $bit->status == 1){
                    if(strlen(\yii::$app->request->post('msg',''))>=55 ){
                        $bit->comment= \yii::$app->request->post('msg','');
                        $bit->comment_time= date("y-m-d H:i:s");
                        if(!$bit->save())
                        {
                            $bit->getErrors();
                        }
                    }else{
                        echo '< 70 ';
                    }
                }else{
                    echo 'bit not found';
                }
            }else{
                echo ' request ';
            }


        }else{
            echo ' not post ';
        }

    }
    public function actionGetouttime(){

        $users=[];

        $catalog = \app\modules\catalog\models\Catalog::find()->andWhere('catalog_public=1 and catalog_dateend < "'.date("Y-m-d H:i:s").'"')->all();

        if(is_array($catalog)){
            foreach($catalog as $item){
                $item->catalog_public=0;
                $item->save();
                if(is_array($item->bits))
                    foreach($item->bits as $bit) {
                        $bit->status=3;
                        $bit->save();
                        Bits::returnBits($bit,$item);
                    }
            }
        }
    }

    public function actionMakeoff($product)
    {


        if (!\yii::$app->request->isPut) {
            return ['status'  => 'error',
                    'title'   => \yii::t('app', 'Неверный запрос'),
                    'message' => \yii::t('app', 'Успехов'),];
        }

        if (!yii::$app->user->getId()) {
            return [

                'status'  => 'error',
                'title'   => \yii::t('app', 'Вы не авторизованы!'),
                'message' => \yii::t('app', '<a href="/user/registration">Зарегистрируйтесь</a> или <a href="/user/registration">авторизуйтесь</a>  чтобы делать ставки'),];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $product])->one();

        $errors = [];
        if ($item !== null) {
                Bits::drop($item);

        }else{
            return [
                'status'  => 'error',
                'message'=>'not found item'
            ];
        }

    }
    public function actionInfo($product)
    {


        if (!\yii::$app->request->isPut) {
            return ['status'  => 'error',
                    'title'   => \yii::t('app', 'Неверный запрос'),
                    'message' => \yii::t('app', 'Успехов'),];
        }

        if (!yii::$app->user->getId()) {
            return [

                    'status'  => 'error',
                    'title'   => \yii::t('app', 'Вы не авторизованы!'),
                    'message' => \yii::t('app', '<a href="/user/registration">Зарегистрируйтесь</a> или <a href="/user/registration">авторизуйтесь</a>  чтобы делать ставки'),];
        }






        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id' => $product])->one();

        $errors = [];
        if (yii::$app->user->getId() && $item !== null) {

            $bits = \app\models\Bits::getInfo($product);

            $countsBits = \app\models\Bits::countBits($item->catalog_id,yii::$app->user->getId());
            if( $countsBits >= 1) { //\yii::$app->request->get('step', 1) > $item->catalog_bids-$countsBits){
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Вы уже учасвствуете в розыгрыше товара'), ];//'Вы не можете купить больше долей чем доступно'
            }


        //Проверка на возможность ставки
         $step=\app\models\Bits::checkEnough($item, \yii::$app->request->get('step', 1));

        if ($step && $step!=0)
            return ['status'  => 'error',
                    'title'   => \yii::t('app', 'Ошибка!'),
                    'message' => \yii::t('app', 'Вы не можете сделать ставку на ') . \yii::$app->request->get('step', 1) . \yii::t('app', ' доли'),
                    'can'     => \yii::t('app', 'Вы можете сделать ставку на  ' ). $step .\yii::t('app',  ' доли'),
                    'step'    => $step,
                    'persent'=>$bits['persent']
            ];
            return ['status'  => 'success',
                    'persent'=>$bits['persent'],
                    'message'=>$this->renderAjax('info',['bits'=>$bits, 'item'=>$item ])
            ];

        }else{
            return [
                    'status'  => 'success',
                    'message'=>$this->renderAjax('info',['bits'=>0, 'item'=>$item ])
                   ];
        }

    }
    public function actionAddbit($product)
    {
        $_GET['step']=1;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if(!\yii::$app->request->get('step')) {
            return ['status'=>'error',
                    'title'=> \yii::t('app', 'Ошибка'),
                    'message' => \yii::t('app', 'Не указано кол-во долей'), ];
        }



        if(!yii::$app->user->getId()){
            return ['status'=>'error',
                    'title'=> \yii::t('app', 'Вы не авторизованы!'),
                    'message' => \yii::t('app', '<a href="/user/registration">Зарегистрируйтесь</a> или <a href="/user/registration">авторизуйтесь</a>  чтобы делать ставки'), ];
        }


        $user=\app\models\User::find()->where('id='.yii::$app->user->identity->id)->one();

        if ( $user  && $user->isemail!=1) {
            return ['status'  => 'error',
                    'move'=>'/user/profile',
                    'title'   => \yii::t('app', 'Подтвердите email!'),
                    'message' => \yii::t('app', 'Вы не подтвердили email делать ставки нелья'),];
        }

        $item = \app\modules\catalog\models\Catalog::find()->where(['catalog_id'=>$product])->one();

        $errors=[];
        if(yii::$app->user->getId() && $item!==null){

            $priceBit = $item->getBitsPrice()*\yii::$app->request->get('step',1);
            $back=round($priceBit*\yii::$app->request->get('step',1)*(yii::$app->params['back']/100),2);

            //Проверка баланса
            if(!$item->catalog_count)
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Закончился товар'), ];
            if(strtotime($item->catalog_dateend) < mktime())
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Вы не можете делать ставки на просроченный товар'), ];

            //Проверка на возможность ставки
            $stepBit=\app\models\Bits::checkEnough($item, \yii::$app->request->get('step', 1));
            if ($stepBit === false)
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Вы не можете сделать ставку на ').\yii::$app->request->get('step',1).\yii::t('app', ' доли'),
                       ];

            //Проверка баланса

            if(!User::checkBalance($back+$priceBit))
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'move'=>'/balance',
                        'message' => \yii::t('app', 'На вашем счету недостаточно средств'), ];

            //Проверка на лимит ставок для товара
            /*if(!\app\models\Bits::checkBits($item->catalog_id))
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Максимум 3 ставки!'), ];*/



            $countsBits = \app\models\Bits::countBits($item->catalog_id,yii::$app->user->getId());
            if( $countsBits >= 1) { //\yii::$app->request->get('step', 1) > $item->catalog_bids-$countsBits){
                return ['status'=>'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Вы не можете купить больше долей чем доступно'), ];
            }

            if($this->addBitTimes($item))
               $errors = $this->afterBits($item);
            else
                $errors = ['status' => 'error',
                           'title'=> \yii::t('app', 'Ошибка!'),
                           'message' => \yii::t('app', 'Не удалось сделать ставку,  попробуйте позже!')];

                /*if(yii::$app->request->get('step',1) == 1)
                    return $this->addBit($item);
                else
                    for($i=0;$i < yii::$app->request->get('step',1);$i++){
                        $error=$this->addBit($item);
                        $errors['title']=$error['title'];
                        $errors['message'].=yii::t('app','Ставка номер ').($i+1).' - '.$error['title'].'<br>'.$error['message'].'<br><br>';
                    }*/

        }
        return $errors;

    }

    public function addBitTimes($item){

        $uid = yii::$app->user->getId();
        $cid = yii::$app->request->get('product');;
        $tt=\app\models\Bits::countBits($cid,$uid);
        if($tt == 0){
            $user=User::find()->where('id ='.$uid)->one();

            $user->bonus=$user->bonus+$item->catalog_bonus;
            if( $user->bonus >= yii::$app->params['bonus']){
                $user->bonus=$user->bonus-yii::$app->params['bonus'];
                User::setBalance('+'.\yii::$app->params['bonustomoney'],$uid,0,$comment=\yii::t('app', 'Начисление за бонусы'));
            }
            $user->save();
        }


        for($i=0;$i < yii::$app->request->get('step',1);$i++){
            $model=new Bits;
            $model->userid = yii::$app->user->getId();
            $model->catalogid = $cid;
            $model->price=$item->getBitsPrice();
            $model->persent=$item->catalog_price_step;
            $model->codeindex=0;
            $model->status=0;
            if(!$model->save()) {
               // print_r($model->getErrors());
                return false;
            }
        }

    return true;
    }

    public function afterBits($item){

        $price = $item->getBitsPrice()*\yii::$app->request->get('step',1);
        $back=round($price*(yii::$app->params['back']/100),2);

        $uid = yii::$app->user->getId();
        $cid = yii::$app->request->get('product');

        $result = User::setBalance('-'.$price,$uid,$cid,$comment=\yii::t('app','Оплата за ставку') );
        if(!$result['error'])
            $result =  User::setBalance('-'.$back ,$uid,$cid,$comment=\yii::t('app','Оплата комиссии за ставку'),'holdstat');

        if(!$result['error']){

            $bits = \app\models\Bits::getInfo($cid);

            \app\modules\tickets\models\Tickets::add($cid,
                TextWidget::getTpl('bit',['link'=>$item->catalog_url,'item'=>$item->catalog_name,'bits'=> yii::$app->request->get('step',1) ])
                ,1,2,$uid,$bits,
                TextWidget::get('bit')->one()->statusid);


            Bits::checkStatus($cid,$bits);



            return ['status'=>'ok',
                    'title'=> \yii::t('app', 'Поздравляем!'),
                    'message' => \yii::t('app', 'Ваша ставка принята!'),
                    'data'=>[
                        'price'=>$item->getPrice(),
                        'step'=>$item->priceStep(),
                        'persent'=>$bits['persent'],
                    ]];
        }else{


            return ['status'=>'error',
                    'title'=> \yii::t('app', 'Ошибка!'),
                    'message' => $result['error'] ];
        }

    }

/*
    public function addBit($item){
        if(\yii::$app->request->isPut){



            $model=new Bits;
            $model->userid = yii::$app->user->getId();
            $model->catalogid = $item->catalog_id;
            $model->price=$item->getBitsPrice();
            $model->persent=$item->catalog_price_step;
            $model->codeindex=0;
            $model->status=0;

            $back=round($model->price*(yii::$app->params['back']/100),1);

            if($model->save()){

                $result = User::setBalance('-'.$model->price,$model->userid,$model->catalogid,$comment='Оплата за ставку');
                if(!$result['error'])
                    $result =  User::setBalance('-'.$back ,$model->userid,$model->catalogid,$comment='Оплата комиссии за ставку','holdstat');

                if(!$result['error']){
                    \yii::$app->user->identity->bonus=\yii::$app->user->identity->bonus+$item->catalog_bonus;
                    if( \yii::$app->user->identity->bonus >= yii::$app->params['bonus']){
                        \yii::$app->user->identity->bonus=\yii::$app->user->identity->bonus-yii::$app->params['bonus'];

                        User::setBalance('+'.\yii::$app->params['bonustomoney'],$model->userid,0,$comment='Начисление за бонусы');
                    }
                    \yii::$app->user->identity->save();

                    $bits = \app\models\Bits::getInfo($model->catalogid);
                    \app\modules\tickets\models\Tickets::add($model->catalogid,
                        TextWidget::getTpl('bit',['item'=>$item->catalog_name])
                        ,1,2,$model->userid,$bits['persent'],
                        TextWidget::get('bit')->one()->statusid);
                    Bits::checkStatus($model->catalogid,$bits);

                    return ['status'=>'ok',
                            'title'=> \yii::t('app', 'Поздравляем!'),
                            'message' => \yii::t('app', 'Ваша ставка принята!')];
                }else{
                    $model->delete();

                    return ['status'=>'error',
                            'title'=> \yii::t('app', 'Ошибка!'),
                            'message' => $result['error'] ];
                }

            } else {
                return ['status' => 'error',
                        'title'=> \yii::t('app', 'Ошибка!'),
                        'message' => \yii::t('app', 'Не удалось сделать ставку,  попробуйте позже!')];
            }
        }
    }*/
	
	
}
