<?php

namespace app\modules\catalog\components\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

class MorePrice extends Behavior
{

    public $key = 'catalog_id';

    public function events()
    {
        return [
			ActiveRecord::EVENT_AFTER_INSERT    => 'HasPrice',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'HasPrice'
        ];
    }	
	
	public function HasPrice()
	{
	    $this->DelPrice();

        $obj=yii::$app->request->post('MorePrice');

        $mean = $obj['mean'];
        $price = $obj['price'];



        if( is_array($mean) )
        {

            for($i=0;$i<count($mean);$i++)
            {
                 if( $price[$i] && $mean[$i])
                      (new \yii\db\Query)->createCommand()->insert('more_price',
                            [
                                'catalogid'=>$this->owner->catalog_id,
                                'price' => $price[$i],
                                'mean' => $mean[$i],
                            ])->execute();

            }
        }

	}

    public function DelPrice(  )
    {
      (new \yii\db\Query)->createCommand()->delete('more_price',[ 'catalogid' => $this->owner->catalog_id ])->execute();
    }


	

}