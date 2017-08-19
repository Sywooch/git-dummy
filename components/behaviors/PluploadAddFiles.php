<?php

namespace app\components\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class PluploadAddFiles extends Behavior
{
    public $in_attribute = '';

    public function events()
    {
        return [
            
			ActiveRecord::EVENT_AFTER_INSERT  => 'getFiles',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'getFiles'
        ];
    }	
	
	public function getFiles( $event )
	{
     
	 
		if( is_array($_POST['Pictures']) )
		{
			
			foreach($_POST['Pictures'] as $id =>$hash)
			{
				(new \yii\db\Query())->createCommand()->update('image', 
							[
								'NotActive' => 0,
								'name' => $this->owner->tableName() , 
								'tableid' => $this->owner->{$this->in_attribute},

							], 
							[
								'id' 		=> $id,
								'hash_code' => $hash
							]
							)->execute();
                unset($_POST['Pictures'][$id]);
			}
			
		}
	}


}