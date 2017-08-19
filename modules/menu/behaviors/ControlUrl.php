<?php

namespace app\modules\menu\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ControlUrl extends Behavior
{
    public $in_attribute = '';

    public function events()
    {
        return [
            
           ActiveRecord::EVENT_AFTER_INSERT  => 'getUrls',
           ActiveRecord::EVENT_BEFORE_UPDATE => 'getUrls'
			
        ];
    }	
	
	public function getUrls( $event )
	{
     
		  $query = new yii\db\Query;
							
							$menu = $query->select('*')->from('menu')->where(
											[
											 'tablename' => $this->owner->tableName(), 
											 'tableid' => $this->owner->{$this->owner->tableName().'_id'} 
											 ])->one();
											 
							if( $menu['menu_url'] !=  $this->owner->{$this->owner->tableName().'_url'} )
							{
								$query->createCommand()->update( 'menu',
											[
												'menu_url' => $this->owner->{$this->owner->tableName().'_url'}, 
												 
											],
											[
											'menu_id' => $menu['menu_id']
											] 
											)->execute ();
							}
							
		 return $this->owner->{$this->owner->tableName().'_url'}; 
	 
	}


}