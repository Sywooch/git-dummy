<?php

 
 

namespace app\modules\system\models;

use Yii;
use yii\base\Model;


class CalcForm extends Model
{
  	
	public $field1='';
	public $field2='';
	public $field3='';
	public $field4='';
	public $field5='';
	public $field6='';
	public $field7='';
	public $field8='';
	public $field9='';
	public $field10='';
	public $field11='';
	public $field12='';
	public $field13='';
	public $field14='';
	public $field15='';
	
	

	
	
	
	
	 public function attributeLabels()
	{
		return 
		[
			'field1' => Yii::t('admin', 'Полотно'),
			'field15' => Yii::t('admin', 'Полотно ПГ'),
			'field12' => Yii::t('admin', 'Полотно ПЧ (без стеклом)'),
			'field11' => Yii::t('admin', 'Полотно ПЧ (со стеклом)'),
			'field13' => Yii::t('admin', 'Полотно ПО (без стеклом)'),
			'field14' => Yii::t('admin', 'Полотно ПО (со стеклом)'),
			'field2' => Yii::t('admin', 'Стойка дверной коробки (2,1 м)'),
			'field3' => Yii::t('admin', 'Наличник (2,2 м)'),
			'field4' => Yii::t('admin', 'Добор 10см. (2,1 м)'),
			'field5' => Yii::t('admin', 'Добор 15см. (2,1 м)'),
			'field6' =>  Yii::t('admin', 'Добор 20см. (2,1 м)'),
			'field7' =>  Yii::t('admin', 'Притворная планка (2,0 м)'),
			'field8' => Yii::t('admin', 'Нестандарт'),
			'field9' => Yii::t('admin', 'Черное стекло'),
			'field10' => Yii::t('admin', 'Доплата за полотно 90см.'),
		
		];
	}
	
	
	public function params()
	{
		 
		foreach( $this->attributeLabels() as $field => $m)
		{
			 
			
			if( isset(Yii::$app->params[$field]) )	
			{

				$this->{$field} = Yii::$app->params[$field];	
			}
		}
		  
	}
	   
	 
  
	 
}