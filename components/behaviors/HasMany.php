<?php

namespace app\components\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

class HasMany extends Behavior
{
    public $fields;
    public $tables;
    public $key = 'orders_id';

    public function events()
    {
        return [
            
			ActiveRecord::EVENT_AFTER_INSERT   => 'HasMany',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'HasMany',
            ActiveRecord::EVENT_BEFORE_DELETE  => 'DelHasMany',
            ActiveRecord::EVENT_AFTER_FIND     => 'GetHasMany'
        ];
    }	
	
	public function HasMany()
	{

	    $this->DelHasMany();

        if( is_array($this->fields) )
        {
            #print_r($this->fields);
            $i=0;
            foreach($this->fields as $field)
            {

                if(is_array($this->owner->$field))
                {

                    foreach($this->owner->$field as $val)
                    {
                        (new \yii\db\Query)->createCommand()->insert('one_to_many',
                            [
                                'table_name'=>$this->tables[$i],
                                'orderid' => $this->owner->{$this->key},
                                'itemid' => $val,
                            ])->execute();
                    }
                }
            $i++;
            }
        }

	}

    public function DelHasMany(  )
    {
        if( is_array($this->tables))
            foreach($this->tables as $table)
                (new \yii\db\Query)->createCommand()->delete('one_to_many',['table_name'=>$table, 'orderid' => $this->owner->{$this->key} ])->execute();

    }

    public function GetHasMany(  )
    {
        if( is_array($this->fields))
        {
            $i=0;
            foreach($this->fields as $field)
            {

                $rows =  \Yii::$app->db->createCommand("select * from one_to_many WHERE orderid = ".$this->owner->{$this->key}." AND table_name = '".$this->tables[$i]."' ")->queryAll();

                   if( is_array($rows))
                    {

                        foreach($rows as $row)
                        {
                            $this->owner->{$field}[]=$row['itemid'];
                        }
                    }
            $i++;
            }

        }


    }
	

}