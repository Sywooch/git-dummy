<?php

namespace app\modules\terms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class Terms extends AR
{
  
	
     public static function tableName(){
		 return 'terms';
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
          [
              'class' => 'app\components\behaviors\Language',
              'table' => 'terms',
              'index' => 'terms_id',
          ],
        ];
    }
	
	
	public function attributeLabels()
	{
		return 
		[
			'terms_text' => Yii::t('admin', 'Название'),
			'terms_url' =>  Yii::t('admin', 'Адрес'),
			'terms_title' =>Yii::t('admin', 'Title'),
			'terms_meta' => Yii::t('admin', 'Desc'),
			'terms_keys' => Yii::t('admin', 'KeyWords'),

			'terms_parentid' => '',
			'termscatid' =>  Yii::t('admin', 'Термин'),
			'terms_about' => Yii::t('admin', 'Описание'),
			'terms_public'=>'',
			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			[['terms_text', 'terms_parent', 'terms_code', 'terms_url'], 'default',  'on' => ['search'] ],
			
			[['terms_text',   'termscatid' , 'terms_url'], 'required', 'on' => ['default'] ],
			
			[['terms_about', 'termscatid','terms_meta','terms_keys','terms_title'], 'default'],
           
		    ['terms_parent', 'default', 'value' => 0],
			['terms_public', 'default', 'value' => 1],
			
			[['terms_keys','terms_title','terms_meta','terms_about'], 'default', 'value' => ''],
            [['langid','lang'], 'default'],
			
            
        ];
    }
    public function getParent()
    {
        return $this->hasOne(self::className(), ['terms_id' => 'terms_parent']);
    }
 	public static function getId($url,$id)
	{
		$data =	Terms::find()->andWhere(['termscatid' => $id,'terms_url' => $url ])->one()	;
		return $data;
	}

    public static function getParentId($url,$id)
    {
        $data =	Terms::find()->andWhere(['termscatid' => $id,'terms_url' => $url ])->one()	;
        return $data;
    }
	
	public static function getbyId($id)
	{
		$data =	Terms::find()->andWhere(['terms_id' => $id ])->one()	;
		return $data;
	}
	
	public static function getIdcat($id)
	{
		$data =	Terms::find()->andWhere(['terms_id' => $id])->one()	;
		return $data;
	}
	
	public static function getTree($data,$prefix='',$lvl2=true)
	{
		//$data =	Terms::find()->where(['terms_id' => $data->terms_id ])->one()	;
		
		 
		$data2 =	Terms::find()->andWhere(['terms_id' => $data->terms_parent ])->one()	;
		 
		if($data2)
		{
		$level2 =  [
            	 'label' => $data2->terms_text,
            	 'url'   => $prefix.$data2->terms_url,
        		 ];
				  
				 
		}
		 
		if($data)
		{
		$level1 =  [
            	 'label' => $data->terms_text,
            	 'url'   => $prefix.$data->terms_url,
        		 ];
		}
		
		
		
		if($level1 && $level2)
            if($lvl2)
			    return [$level2,$level1];
            else
                return [$level2];
		else	
			return [$level1];
		
	}
	
	
	static function dropDown_simple($termscatid,$parentid=0,$out='',$offset='')
	{
		$data =	Terms::find()->andWhere(['termscatid' => $termscatid,'terms_parent' => $parentid ])->all()	;
		if(is_array($data))
		{
			 
			foreach($data as $row)
			{
				$out[$row->terms_id]=$row->terms_text;	
			}
		}
		
		return $out;
		
		
	}
	
	static function dropDown($termscatid,$parentid=0,$out='',$offset='')
	{
		$data =	Terms::find()->andWhere([  'termscatid' => $termscatid,'terms_parent' => $parentid ])->all()	;
		if(is_array($data))
		{
			 
			foreach($data as $row)
			{
				if($row->terms_parent == 0)
				{
					$out[$row->terms_text]=self::dropDown_children($termscatid,$row->terms_id);
					if(  $out[$row->terms_text]  == '')
						unset( $out[$row->terms_text] );
				}
				
				if( !isset($out[$row->terms_text]) )
					$out[$row->terms_id]=$row->terms_text;	
			}
		}
		
		return ($out)?$out:[];
		
		
	}
	
	
	static function dropDown_children($termscatid,$parentid=0,$out='')
	{
		$data =	Terms::find()->andWhere(['termscatid' => $termscatid,'terms_parent' => $parentid ])->all()	;
		if(is_array($data))
		{
			foreach($data as $row)
			{
				$out[$row->terms_id]=$row->terms_text;
			}
		}
		return $out;
	}
	
	static function getTreeIn($termscatid,$parentid,$array=0)
	{
		$data =	Terms::find()->andWhere(['termscatid' => $termscatid,  'terms_parent' => $parentid ])->all()	;
		$in[]=$parentid;
		if(is_array($data))
		{
			foreach($data as $row)
			{
				$in[]=$row->terms_id;	
			}
		}
		if($array == 0)
			return implode(',',$in);
		else	
			return $in;
	}
	
	public function search($params)
    {

        $query = Terms::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['terms_id' => $this->terms_id, ])
			  ->andFilterWhere(['terms_parentid' => $this->terms_parentid, ]);
		
        $query->andFilterWhere(['like', 'terms_text', $this->terms_text])
          	  ->andFilterWhere(['like', 'terms_url', $this->terms_url])
			  ->andFilterWhere(['like', 'terms_code', $this->terms_code]);

        return $dataProvider;
    }
	
	 
}