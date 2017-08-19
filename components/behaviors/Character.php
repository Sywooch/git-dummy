<?php

namespace app\components\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

class Character extends Behavior
{

    public $tables;
    public $key = 'id';

    public function events()
    {
        return [
            
			ActiveRecord::EVENT_AFTER_INSERT   => 'HasMany',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'HasMany',
            ActiveRecord::EVENT_BEFORE_DELETE  => 'DelHasMany',
          //  ActiveRecord::EVENT_AFTER_FIND     => 'GetHasMany'
        ];
    }	
	
	public function HasMany()
	{
        \yii::$app->language='ru';
        if(yii::$app->request->isPost)
	        $this->DelHasMany();



        $lang=$this->owner->lang;
        if(!$lang){
            $data=yii::$app->request->post('Character');
        }else{
            $data=yii::$app->request->post($lang);
            $data=$data['Character'];
        }

        for($i=0;$i<count($data['name']);$i++){
            if($data['name'][$i] && $data['attribute'][$i])
                (new \yii\db\Query)->createCommand()->insert('character',
                    [
                        'tablename'=>$this->tables,
                        'itemid' => $this->owner->{$this->key},
                        'name' => $data['name'][$i],
                        'orders' => $data['orders'][$i],
                        'attribute' => $data['attribute'][$i],
                    ])->execute();
        }

        \yii::$app->language='en';

	}

    public function DelHasMany(  )
    {
             (new \yii\db\Query)->createCommand()->delete('character',['tablename'=>$this->tables, 'itemid' => $this->owner->{$this->key} ])->execute();

    }


	

}