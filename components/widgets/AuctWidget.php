<?php
namespace app\components\widgets;
 
use app\models\Auct;
use yii;
use yii\base\Component;
use yii\base\Widget;

class AuctWidget extends Widget
{

    public $productid='';

    public  $tpl='list_member_auction';


    public function run()
    {

        $data = $this->get(  );

        return   $this->render( '@app/views/widgets/'.$this->tpl,
            [
                'data' =>$data
            ]
        );
    }

    public function get()
    {

        return Auct::find()->andWhere([
            'catalogid'=>$this->productid,
            'status'=>0,
           // 'tiraj'=>NULL,
        ])->orderby('datetime asc')->all();
    }
}

