<?php

 
 

namespace app\modules\system\models;

use Yii;
use yii\base\Model;


class ConfigForm extends Model
{
  	
	public $adminEmail;
	public $copyright;
	public $phone1;
	public $phone2;
	public $title;
	public $desc;

    public $skype;
	public $keys;
	public $adres;
    public $work;


	public $text1;
	public $text2;
	public $text3;
	public $text4;
	public $text5;
	public $text6;
    public $back;
	public $lowbalance;
    public $bonus;
    public $bonustomoney;
	

	
	
	
	
	 public function attributeLabels()
	{
		return 
		[
			'adminEmail' => Yii::t('admin', 'Почтовый ящик админа'),
			
			'copyright' => Yii::t('admin', 'Copyright'),
			
			'phone1' => Yii::t('admin', 'phone'),
			'phone2' => Yii::t('admin', 'phone'),
			
			'title' => Yii::t('admin', 'Название сайта'),
			'desc' =>  Yii::t('admin', 'Описание сайта'),
			'keys' =>  Yii::t('admin', 'Ключевый слова сайта'),
			
			'adres' => Yii::t('admin', 'Адрес'),
			'work' => Yii::t('admin', 'Время работы'),
            'skype'=>Yii::t('admin', 'Skype'),
            'back'=>Yii::t('admin', 'Процент комиссии'),
            'lowbalance'=>Yii::t('admin', 'Проговое значение баланс, когда появялеяется уведомление'),
            'bonus'=>Yii::t('admin', 'Проговое значение для обмена'),
            'bonustomoney'=>Yii::t('admin', 'Сколько получит денег за пороговое значение'),

			/*'text1' => Yii::t('admin', 'Слоган'),
			'text2' => Yii::t('admin', 'Текс внизу на главной'),
			'text3' => Yii::t('admin', 'Двери МДФ'),
			'text4' => Yii::t('admin', 'Двери CPL'),
			'text5' => Yii::t('admin', 'Текст в центре слева'),
			'text6' => Yii::t('admin', 'Текст в центре справа'),*/
		
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