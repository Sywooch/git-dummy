<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class Catalog extends AR
{

    const STATUS_CREATED = 23;
    const STATUS_ACSEPT = 24;
    const STATUS_DONE = 112;
    const STATUS_ERROR = 113;
    const STATUS_COMMENT = 114;
    const STATUS_DONECONFRIME = 115;
    const STATUS_NONE = 116;

	public $tarifs;
    public $colorid;
    public $usedCid;

    public static function tableName()
    {
        return 'catalog';
    }




	public static function urlPrefix()
    {
        return '/product/';
    }
	
	  public function behaviors()
    {
      return [
					[
					'class' => TimestampBehavior::className(),
					'updatedAtAttribute' => 'date_modified',
					'createdAtAttribute' => 'date_modified',
					'value' => new Expression('NOW()'),
					],
         /* [
          'class' => TimestampBehavior::className(),
          'updatedAtAttribute' => 'catalog_date',
          'createdAtAttribute' => 'catalog_date',
          'value' => function(){ return date("Y-m-d H:i:s",strtotime($this->catalog_date)); } ,
          ],*/
          [
              'class' => 'app\components\behaviors\PluploadAddFiles',
              'in_attribute' => self::tableName().'_id',
          ],
         /* [
          'class' => 'app\modules\menu\behaviors\ControlUrl',
          'in_attribute' => $this->tableName().'_url',

          ] ,*/
                     'MorePrice' => [
                      'class' => 'app\modules\catalog\components\behaviors\MorePrice',
                      'key'  => 'catalog_id',
                    ],
                     'hasMany' => [
                         'class' => 'app\components\behaviors\HasMany',
                         'fields' => ['tarifs'],
                         'tables' => ['terms'],
                         'key'  => 'catalog_id',
                     ],
          [
              'class' => 'app\components\behaviors\Language',
              'table' => 'catalog',
              'index' => 'catalog_id',
              'fields' =>['iszoomer','catalog_public','catalog_url','catalog_date','catalog_dateend','catalog_bonus', 'catalogcatid', 'catalog_price', 'catalog_price_step','timeend','catalog_count' ]
          ],
                     'Character' => [
                         'class' => 'app\components\behaviors\Character',
                         'tables' => 'catalog',
                         'key'  => 'catalog_id',
                     ],
					
        ];
    }


    public function beforeValidate(){

        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            ' ' =>'-',"'"=>'',"."=>'',":"=>'','"'>'','?'>'','!'>'',','>'','&'>'','%'=>'','$'=>'','('=>'',')'=>'',
        );



        if(!$this->langid){
            $this->catalog_url='/product/'.strtr( $this->getName(40), $converter).'.html';

            /*$date=date("Y-m-d H:i:s",mktime()+$this->timeend*24*3600);
            if($date>$this->catalog_dateend)
              $this->catalog_dateend=$date;*/

        }
        $this->catalog_shortpreview=strip_tags($this->catalog_shortpreview);
        return true;
    }
	public function attributeLabels()
	{
		return 
		[
			 'catalog_id' => Yii::t('admin', '#'),

             'catalog_date' => Yii::t('admin', 'Дата'),
			 
 			 'catalog_text' => Yii::t('admin', 'Большое описание'),
             'catalog_preview' => Yii::t('admin', 'Краткое описание'),
             'catalog_params' => Yii::t('admin', 'Характеристики'),

             'catalog_bonus' => Yii::t('admin', 'Бонус'),

			 'catalogcatid' => Yii::t('admin', 'Раздел'),

             'catalog_public' => Yii::t('admin', 'Опубликовано'),

             'date_modified'=> Yii::t('admin', 'Дата'),

             'hot'=> Yii::t('admin', 'HOT'),
             'popular'=> Yii::t('admin', 'Популярное'),
             'catalog_url'=>'Url',
             'statusid'=> Yii::t('admin', 'Статус'),

             'catalog_title' => Yii::t('admin', 'Seo Title'),
             'catalog_meta'=> Yii::t('admin', 'Seo description'),
             'catalog_keys'=> Yii::t('admin', 'Seo keys'),
             'catalog_name'=>Yii::t('admin', 'название'),
             'catalog_shortpreview'=>Yii::t('admin', 'Очень краткое описание'),

             'catalog_price' => Yii::t('admin', 'Стоимость товара $'),
             'catalog_price_step' => Yii::t('admin', 'Стоимость мин шага %'),
             'catalog_count' => Yii::t('admin', 'Доступное кол-во'),
             'catalog_bids' => Yii::t('admin', 'Сумма мин.  продажи на аукционе $'),
 
             'timeend' => Yii::t('admin', 'Срок размещения товара, дни'),
             'iszoomer'=>'Использовать шаблон с зумом',
		];
	}
	
	 
	   public function rules()
    {
		 
        return [

            [['catalog_name','catalog_price_step','catalog_text','catalog_bids', /*'catalog_preview',*/'catalog_shortpreview','catalogcatid','catalog_count'], 'required', 'on' => ['default'] ],
            [['catalog_title','statusid'], 'default',  'on' => ['search']],


            [['catalog_bonus','catalog_price','timeend','catalog_count'], 'integer'],
            [[ 'catalog_meta','catalog_keys','catalog_title','catalog_url'], 'default'],
            [['catalog_url'], 'ValidateUrl' ],
            [['catalog_date','catalog_dateend'], 'ValidateDate' ],

          /*  ['catalog_url',  'match', 'pattern' => '/^\/product\/[a-z0-9\-\_]+\.html$/i', 'on' => ['default'],
                                      'message'=>Yii::t('admin', 'Адрес должен быть "/product/sometext.html"' ), ],*/

            ['catalog_date',  'default'],

            ['catalog_name','string', 'max'=>128 ],

            ['catalog_shortpreview','string','min'=>270],
            /*['catalog_shortpreview','string','min'=>200],*/

            //['catalog_preview','string','max'=>1810],

            ['catalog_dateend',  'default' ],



			[['statusid', 'popular', 'hot','iszoomer'], 'default', 'value'=>0],
            [['catalog_public'], 'default', 'value'=>1],

            [['langid','lang'], 'default'],
            [['langid'], 'default','value'=>0],
        ];
    }

    public function ValidateUrl($attribute){

            $query = new \yii\db\Query;


            $row = $query->select('*')->from('catalog')->where(
                [
                    'catalog_url' => $this->$attribute,
                    'langid'=>0

                ])->one();



            if($row && $this->lang=='' && $this->isNewRecord)
                $this->addError($attribute, yii::t('app','Такой Url уже существует '));


    }

    public function ValidateDate($attribute){

        if(mktime()> strtotime( $this->$attribute)){
            if( $this->lang=='' && !$this->isNewRecord)
                $this->addError($attribute, yii::t('app','Нельзя указать дату , раньше текущей'));
        }


    }
    public function getCharacter()
    {
         $this->usedCid=$this->catalog_id;

        if(yii::$app->controller->id == 'admin')
        {
            return $this->hasMany(\app\modules\catalog\models\Character::className(), ['itemid' => 'catalog_id'])
                ->andWhere('tablename = "catalog" ')
                ->orderby('orders ASC');
        }else{

            if(\yii::$app->session->get('language','ru') == 'ru' || \yii::$app->session->get('language') == '' ){
                return $this->hasMany(\app\modules\catalog\models\Character::className(), ['itemid' => 'usedCid'])
                    ->andWhere('tablename = "catalog" ')
                    ->orderby('orders ASC');
                }
                else{
                    $this->usedCid =  $this->getOld('catalog_id');
                   /*$translate = self::find()->where('lang = "'.\yii::$app->session->get('language').'" and langid = '.$this->catalog_id)->one();

                       $this->usedCid=$translate->catalog_id;*/

                    return $this->hasMany(\app\modules\catalog\models\Character::className(), ['itemid' => 'usedCid'])
                       ->andWhere('tablename = "catalog"')
                        ->orderby('orders ASC');
                }
            }
    }

    public function getOld($name){
        $arr = $this->getOldAttributes();
        return $arr[$name];
    }
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }

    public function getBits()
    {
        return $this->hasMany(\app\models\Bits::className(), ['catalogid' => 'catalog_id'])->where('status=0');
    }
    public function getAucts()
    {
        return $this->hasMany(\app\models\Auct::className(), ['catalogid' => 'catalog_id'])->where('status=0');
    }

    public function getComments()
    {
        return $this->hasMany(\app\models\Bits::className(), ['catalogid' => 'catalog_id'])->where('/*isapprove = 1 and*/ status=1 and comment IS NOT NULL')->orderBy('comment_time DESC');
    }

    public function getTerms()
    {
        if(\yii::$app->session->get('language','ru') == 'ru' || \yii::$app->session->get('language') == '' )
            return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'catalogcatid'])->where('lang is NULL');
        else
            return $this->hasOne(\app\modules\terms\models\Terms::className(), ['langid' => 'catalogcatid'])->where('lang = "'.\yii::$app->session->get('language').'"');
    }




public function getBonus(){
    switch($this->catalog_bonus){
        case 10: return 'bonus blue_bg'; break;
        case 20: return 'bonus green_bg';  break;
        case 30: return 'bonus red_bg';  break;
    }
}
    public function allPrice(){
        $st=10;

        if(count($this->options) && is_array($this->options)){
            foreach($this->options as $row){
                $st+=$row->terms->terms_url;
            }
        }else{
            if(count($_POST['Catalog']['tarifs']) && is_array($_POST['Catalog']['tarifs']))
                foreach($_POST['Catalog']['tarifs'] as $i=>$id) {
                     $row =\app\modules\terms\models\Terms::find()->where('terms_id = '.$id)->one();
                    $st+=$row->terms_url;
                }
        }

        return $st;
    }



	public function search($params)
    {
        $query = Catalog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->andFilterWhere(['langid' => 0 ]);


        if (!($this->load($params) && $this->validate()) ) {
            return $dataProvider;
        }

        if($this->catalog_name)
            $query->andFilterWhere(['like', 'catalog_name', $this->catalog_name]);

        if($this->statusid)
            $query->andWhere('statusid = '.$this->statusid);

        return $dataProvider;
    }

    public function access($action){

        if( ($action == 'delete' or $action == 'update') && ($this->statusid ==  Catalog::STATUS_CREATED  || $this->statusid == Catalog::STATUS_NONE  || $this->statusid == Catalog::STATUS_ERROR ) )
            return true;


        if( ($action == 'update') && ($this->statusid ==  Catalog::STATUS_COMMENT) )
            return true;

        return false;
    }



    public function ForLangSave($update,$id=0){

       /* if(!$id)$id=$this->catalog_id;
        $catalog = \app\modules\catalog\models\Catalog::find('catalog_id = '.$id)->one();
        print_r($catalog);
        if($catalog){

            $update['catalog_look']=$catalog->catalog_look;
            $update['hot']=$catalog->hot;

           echo $update['catalog_count']=$catalog->catalog_count;
            $update['catalog_public']=$catalog->catalog_public;*/

            \yii::$app->db->createCommand()->update(self::tableName(),$update,'catalog_id = '.$id.' or langid = '.$id )->execute();

    }

    public function priceBuy(){
        return $this->getPrice(  $this->catalog_bids );
    }
    public function getPriceOne(){
        $priceAuct=\app\models\Auct::priceBuy($this->catalog_id);
        if($priceAuct)
            return $priceAuct+$this->catalog_bids*$this->catalog_price_step/100;
        else
            return $this->catalog_bids;
    }
    public function priceStep(){
        return $this->getPrice(  $this->getPriceOne() );
    }
    public function getShortPreview(){
        $shortpreview=strip_tags($this->catalog_shortpreview);

         $num = strlen($shortpreview);
        if($this->checkLongWordds($shortpreview))
            $positon=270;//@mb_strpos(trim($this->catalog_shortpreview),' ', $num,'UTF-8') ;
        else
            $positon=280;
        if($positon < $num)
             return mb_substr(trim($shortpreview),0, (int)$positon,'UTF-8').'...';
        else
            return $shortpreview;
    }
    public function checkLongWordds($str){
        $words = explode(" ",$str);
        foreach($words as $word){
            if(strlen($word)>15)
                return true;
        }
        return false;
    }

    public function getName($position=200){

        $num = strlen($this->catalog_name);

        if($position < $num)
            return mb_substr(trim($this->catalog_name),0, (int)$position,'UTF-8');
        else
            return $this->catalog_name;
    }

    public function getPrice($price=''){

        if(!$price){
            $price=$this->catalog_price;
            return \app\modules\system\models\Course::getPrice($price);
        }else{

            return \app\modules\system\models\Course::getPrice($price);
        }
    }

    public function persentToEnd(){
        $end=strtotime($this->catalog_dateend);
        $now=strtotime(date('Y-m-d H:i:s'));
        $start=strtotime($this->catalog_date);
        if($now< $start){
            return 0;
        }
        $all=$end-$start;
        $partEnd=$end-$now;
        $result=(100*$partEnd)/$all;
        if($result > 0)
            return str_replace('.',',',floor (100-round($result ,2,PHP_ROUND_HALF_DOWN)));
        else
            return 100;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $images = \app\modules\system\models\Pictures::getImages('catalog',$this->catalog_id);

                if(is_array($images))
                    foreach($images as $img)
                    {
                    $data = (new \yii\db\Query())->from('image')->where([ 'id' => $img['id'] ])->one();

                    (new \app\components\ImageComponent)->delete_files($img);

                    \app\modules\system\models\Pictures::findOne($img['id'])->delete();

                    }


            return true;
        } else {
            return false;
        }
    }
}