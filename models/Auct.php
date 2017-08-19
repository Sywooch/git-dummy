<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use \app\modules\system\models\TextWidget;

class auct extends ActiveRecord
{

	 
	 
    public static function tableName()
    {
        return 'auct';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'datetime',
                'createdAtAttribute' => 'datetime',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             [ ['userid','catalogid','codeindex','status'], 'required', 'on' => ['default']],
             [ ['userid','catalogid','codeindex','status'], 'default',  'on' => ['search'] ],
             [ ['userid','catalogid','codeindex','status','isapprove','issend','ispost','tiraj'], 'integer'],

             [ ['course_price','course_name','comment'],'default']
         ];
     }

    public function setIs($field='isapprove'){
        if($this->{$field}==1)
            $this->{$field}=0;
        else
            $this->{$field}=1;
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'userid']);
    }

    public function getCatalog(){
        $item=\app\modules\catalog\models\Catalog::find()->andWhere(['catalog_id'=>$this->catalogid])->one();
        if($item)
            return $item;
        else
            return \app\modules\catalog\models\Catalog::find()->andWhere(['langid'=>$this->catalogid])->one();


        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id'=>'catalogid']);
    }

    public static function chechCloseTiraj($id,$tiraj=0){


        if($tiraj) {
            $sql = "SELECT id from  auct WHERE catalogid = $id and   tiraj =".$tiraj." LIMIT 1";
            $row =  \yii::$app->db->createCommand($sql)->queryOne();
        }



        return ($row)?$tiraj:false;

    }


    public static function drop($item){
        $id=$item->catalog_id;
        $uid=\yii::$app->user->getId();
        $row = self::find()->where(['catalogid'=>$id, 'userid'=>$uid])->andWhere(' tiraj IS NULL')->one();

        if($row){
            self::returnauct($row,$item,'return_auct',5);
            $row->delete();
        }
    }

    public static function returnauct($bit,$item,$message='end_time_catalog',$status=2){
        User::setBalance('+'.$bit->price,$bit->userid,$bit->catalogid,\yii::t('app', 'Возврат денег за ставку'));
        User::setBalance('+'.round($bit->price*(yii::$app->params['back']/100),2),$bit->userid,$bit->catalogid,\yii::t('app', 'Возврат комиссии  за ставку'));

        $user=User::find()->where('id ='.$bit->userid)->one();

        if($user){
            $user->bonus=$user->bonus-$item->catalog_bonus;
            $user->save();
        }


        if(!isset($users[$bit->userid])){
            \app\modules\tickets\models\Tickets::add($item->catalog_id,
                TextWidget::getTpl($message,['link'=>$item->catalog_url,'item'=>$item->catalog_name])
                ,$status,2,$bit->userid,0,
                TextWidget::get($message)->one()->statusid);
           /*
            * block messages
           \app\modules\tickets\models\Tickets::add($bit->catalogid,
                TextWidget::getTpl($message,['link'=>$item->catalog_url,'item'=>$item->catalog_name])
                ,2,1,$bit->userid,0,
                TextWidget::get($message)->one()->statusid);*/
            $users[$bit->userid]=1;
        }
    }
    public static function lastTiraj($id){

        $row =  \yii::$app->db->createCommand("SELECT   datetime  from  auct WHERE catalogid = $id ORDER BY tiraj DESC ")->queryOne();

        return $row['datetime'];
    }

    public static function checkEnough($item, $step){
        $id=$item->catalog_id;
        $row =  \yii::$app->db->createCommand("SELECT   count(userid) as user  from  auct WHERE catalogid = $id and tiraj is null ")->queryOne();
        $count = $row['user'];
        //проверка что меньше 100, и есть возможность сделать 1 ставку
        //echo ($item->catalog_price_step*($count+1)).' ';
        //echo ($item->catalog_price_step*$count+$item->catalog_price_step*$step);

        if(  $item->catalog_price_step*$count <100  && ($item->catalog_price_step*$count+$item->catalog_price_step*$step)  >100 ){
            if( ($item->catalog_price_step*($count+1))>=100  )                return 1;
            if( ($item->catalog_price_step*$count+$item->catalog_price_step*2)  >=100 )                return 2;
            if( ($item->catalog_price_step*$count+$item->catalog_price_step*3)  >=100 )                return 3;
        }elseif(  ($item->catalog_price_step*$count+$item->catalog_price_step*$step)  <=100 ){
            return 0; // не выводит сообщение
        }
        return false;
    }

    public static function checkauct($id){
//echo "SELECT   count(userid) as user  from  auct WHERE catalogid = $id and tiraj is null and userid = ".yii::$app->user->getId();
        $row =  \yii::$app->db->createCommand("SELECT   count(userid) as user  from  auct WHERE catalogid = $id and tiraj is null and userid = ".yii::$app->user->getId())->queryOne();

      //  echo $row['user'].' '.\yii::$app->request->get('step');

        if( \yii::$app->request->get('step') && ($row['user']+ \yii::$app->request->get('step')) >=4 )
            return false;
        elseif($row['user'] >= 3)
            return false;

        return true;
    }

    public static function countauct($id,$uid=''){

        if($uid == '' )
            $row =  \yii::$app->db->createCommand("SELECT   count(id) as user  from  auct WHERE catalogid = $id and tiraj is null ")->queryOne();
        else
            $row =  \yii::$app->db->createCommand("SELECT   count(id) as user  from  auct WHERE catalogid = $id and tiraj is null  and   userid = ".$uid)->queryOne();

        return $row['user'];
    }

    public static  function checkStatus($id,$auct)
    {
        $info = self::getInfo($id);


        $catalog = \app\modules\catalog\models\Catalog::find()->where('catalog_id = '.$id)->one();

        if($catalog === null){
            echo 'error  catalog1';
        }


        if( $info['persent'] >= 100){

            $winnerid = self::makeWinner($id);
            if($winnerid){
                \app\modules\tickets\models\Tickets::sendNotification($id, $winnerid );

                if($catalog !== null)
                {
                    $catalog->hot=0;
                    if( $catalog->catalog_count <= 1)
                    {
                        $catalog->catalog_public = 0;
                        $catalog->catalog_count=0;
                    }else{
                        $catalog->catalog_count--;
                        $catalog->catalog_dateend = date("Y-m-d H:i:s",mktime()+$catalog->timeend*24*3600);
                    }




                }else{
                    echo 'error decriment catalog2';
                }
                \app\models\User::checkAdres();
            }
            else {
                self::checkStatus($id,$auct);
                return;
            }

        }else{
            $catalog->hot=$info['persent'];
        }



        $catalog->ForLangSave([
            'catalog_public'=>$catalog->catalog_public,
            'catalog_count'=>$catalog->catalog_count,
            'hot'=>$catalog->hot,
            'catalog_dateend'=>$catalog->catalog_dateend],$catalog->catalog_id);


    }


    public static function getInfo($id){

        $auct=self::find()->where(['id'=>$id])->one();
        if($auct)
            return $auct;
        else
            return 0;
    }

    public static function setStatus($obj,$status){


        if($obj !==null){

            $tiraj = self::Tiraj($obj->catalogid);
            $obj->status = $status;
            $obj->codeindex = self::countauct($obj->catalogid,$obj->userid) ;
            $obj->tiraj=$tiraj;
            $obj->save();



           \yii::$app->db->createCommand()->update('auct',
                [
                    'status'=>2,
                    'tiraj'=>$tiraj
                ],
                [
                    'catalogid' =>$obj->catalogid,
                    'status'=>0,
                ])->execute();
        }
    }

    public function beforeValidate(){
        $m=['"',"'",':',';','%','#','$','^','&','?','!'];
        $this->comment=str_replace($m,'',$this->comment);
        return true;
    }

    public static function Tiraj($cid){
        $row =  \yii::$app->db->createCommand("SELECT   max(tiraj) as mtiraj  from  auct WHERE catalogid = $cid ")->queryOne();
        return $row['mtiraj']+1;
    }


    public static function getMembers($id, $where=''){
        return   self::find()->where(' status =0 and catalogid = '.$id.$where)->orderby('id desc')->all();
    }

    //Выигрыщ макс цена
    static function makeWinner($id){
        $row = self::find()->where('tiraj is NULL and catalogid = '.$id.' ORDER BY price DESC ')->one();
        return $row->id;
    }

    static function priceBuy($id){
        $row = self::find()->where('tiraj is NULL and catalogid = '.$id.' ORDER BY price DESC ')->one();
        return ($row->price)?$row->price:0;
    }

    public  function price(){

        return \app\modules\system\models\Course::getPrice($this->price);
    }



    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $data=$this->load($params);

        $query->andFilterWhere(['status' => yii::$app->request->get('status',0) ]);


        if (!($data && $this->validate()) ) {

            return $dataProvider;
        }else{
        }

        if($this->userid)
            $query->andFilterWhere(['userid' =>$this->userid ]);
        if($this->catalogid)
            $query->andFilterWhere(['catalogid' =>$this->catalogid ]);
        if($this->comment)
            $query->andWhere('comment LIKE "%'.$this->comment.'%"' );
        return $dataProvider;
    }

    /**
     * @param $id
     * @return int
     */
    public static  function checkWinnerNotPayed($id){
  $sql="SELECT * FROM auct
        left JOIN shop_item ON mean = auct.id
        LEFT JOIN shop ON shop_id = shopid
        WHERE  status = 1 and auct.userid = $id   ";
        $row = yii::$app->db->createCommand($sql)->queryOne();


        if(isset($row['payed']) && $row['payed'] == 0 ){
            return 1;
        }
        return 0;
    }

}
