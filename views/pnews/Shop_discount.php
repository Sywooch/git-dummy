<?php

class Shop_discount extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_lookup':
	 * @var integer $id
	 * @var string $object_type
	 * @var integer $code
	 * @var string $name_en
	 * @var string $name_fr
	 * @var integer $sequence
	 * @var integer $status
	 */

	private static $_items=array();

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

 
	
	public function rules()
        {
                return array(
					    
					   
					   
					   array('shop_discount_about,shop_discount_price, shop_discount_url','default'),
                	   					   
					   array('shop_discount_text', 'required'),
					 
                      
					   
                );
        }
		
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shop_discount';
	}

	 
	private static function loadItems($type)
	{
		self::$_items[$type]=array();
		$models=self::model()->findAll();
		foreach($models as $model)
			self::$_items[$type][$model->shop_discount_id]=$model->shop_discount_text;
	}
	
	public function get_data($id=0){
		
		$data=Yii::app()->db->createCommand("SELECT * FROM shop_discount where shop_discount_parent = $id ORDER BY  shop_discount_order ASC ")->queryAll();
		 		
		return $data;
		
		}



    public static function getDiscount($price=0){
        if($price==0){
            if(yii::app()->user->getId())
                $sum=Yii::app()->db->createCommand("SELECT sum(shop_count*shop_price) as price FROM shop
      left join catalog on catalog_id = itemid
        where catid NOT IN(79,80,81,82,83,84,85,94) and shop.userid = ".yii::app()->user->getId()."  ")->queryRow();

            $sum2=Yii::app()->db->createCommand("SELECT sum(shop_count*shop_price) as price FROM shop
        left join catalog on catalog_id = itemid
        where catid NOT IN(79,80,81,82,83,84,85,94) and   shop_session = '".$_SERVER['REMOTE_ADDR']."'   ")->queryRow();

            $price = $sum['price']+$sum2['price'];
        }

        $data=Yii::app()->db->createCommand("SELECT * FROM shop_discount where  shop_discount_price <= $price ORDER BY  shop_discount_price DESC LIMIT 1 ")->queryRow();

        if($_GET['test'])
    echo "SELECT * FROM shop_discount where  shop_discount_price <= $price ORDER BY  shop_discount_price ASC LIMIT 1 ";//rint_r($data);

        return $data['shop_discount_text']/100;

    }

	
	public function dropDown($out=array(),$id = 0,$step=''){
		
			$data = Yii::app()->db->createCommand()
						 
						->from('shop_discount')
						 
						->where('shop_discount_parent=:id', array(':id'=>$id))
						->queryAll();
		 
		 	
			foreach($data as $L){
				
				$out[$L[shop_discount_id]]=$step.$L[shop_discount_text];
				
				//$out=$this->dropDown($out,$L[shop_discount_id],$step.'-');
				
				}
		 	
			
		return $out;
		}	
		
}