<?php



namespace app\modules\catalog\controllers;

use app\components\access\RulesControl;
use app\models\Bits;
use app\models\Todeliver;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

class InfoController extends \yii\web\Controller
{
	
 public $layout='@app/views/layouts/admin.php';
	 
 public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'allow' => RulesControl::callback('Administrator'),
						'roles' => ['@'],
                    ]
					 
                ],
            ]
			 
          
        ];
		
    }


    public function actionApprove($id)
    {

        $model = Bits::findOne($id);

        if($model){
            $model->setIs();
            $model->save();
        }

exit;

    }

    public function actionArchive($id)
    {

        $model = Bits::findOne($id);

        if($model){
            $model->setIs('isarchive');
            $model->save();
        }

        exit;

    }

    public function actionUpdatemsg($id)
    {

        $model = Bits::findOne($id);

        if($model && yii::$app->request->post('msg')){
            $model->comment=yii::$app->request->post('msg');
            $model->save();
        }

        exit;

    }

    public function actionSend($id)
    {

        $model = Bits::findOne($id);

        if($model){

            if(!Todeliver::find()->where('statusid = 0 and catalogid='.$model->catalogid.' and userid= '.$model->userid)->one()){
            $del = new Todeliver;
            $del->catalogid = $model->catalogid;
            $del->userid = $model->userid;
            $del->info = $model->user->name.'<br>'.$model->user->place.','.$model->user->adres;
            $del->statusid = 0;
                if($del->save()){
                    $model->setIs('ispost');
                    $model->save();
                    }
             }
        }
        exit;

    }
	public function actionIndex()
    {

        $today = yii::$app->db->createCommand("select
                  count(bits.id) as users,
                  sum(price) as prices,
                         (
                            select count(id)
                            from bits
                            WHERE status = 1 and
                                  comment_time < '" . date("Y-m-d", mktime() + 24 * 3600) . " 00:00:00' and
                                  comment_time > '" . date("Y-m-d", mktime()) . " 00:00:00'
                          ) as winner,
                          (
                            select count(id)
                            from bits
                            WHERE status <> 1 and
                                  comment_time < '" . date("Y-m-d", mktime() + 24 * 3600) . " 00:00:00' and
                                  comment_time > '" . date("Y-m-d", mktime()) . " 00:00:00'
                          ) as looser
                          ,(
                          select sum(moneychange)*-1 from balance_history WHERE holdstat = 1 and `date` < '" . date("Y-m-d", mktime() + 24 * 3600) . " 00:00:00' and
                                  `date` > '" . date("Y-m-d", mktime()) . " 00:00:00'
                         ) as services
                 /*sum(moneychange) as services*/
                from bits
                left join balance_history on balance_history.catalogid = bits.catalogid and holdstat=1 and bits.userid=balance_history.userid
                WHERE
                    comment_time < '" . date("Y-m-d", mktime() + 24 * 3600) . " 00:00:00' and
                    comment_time > '" . date("Y-m-d", mktime()) . " 00:00:00'
                     ")->queryOne();


        $sql = "
            select
                  count(bits.id) as users,
                  sum(price) as prices,
                          (
                            select count(id)
                            from bits
                            WHERE status = 1
                          ) as winner,
                           (
                            select count(id)
                            from bits
                            WHERE status <> 1
                           ) as looser
                         ,(
                          select sum(moneychange)*-1 from balance_history WHERE holdstat = 1
                         ) as services
                from bits
             /*   left join balance_history on balance_history.catalogid = bits.catalogid and holdstat=1 and bits.userid=balance_history.userid*/

                     ";
        $all = yii::$app->db->createCommand($sql)->queryOne();

        return $this->render('index', [
            'today' => $today,
            'all'   => $all,
        ]);
    }


        public function actionWinner($type){
            $all=\app\models\Bits::find()->where('status = 1');

            if($type == 'today')
                $all->andWhere($this->todatay('comment_time'));

            $all=$all->groupby('userid')->all();

        echo $this->renderPartial('winner', [
            'all'=>$all,
        ]);
            exit;
        }


        public function todatay($date){
            return  $date.' < "'.date("Y-m-d",mktime()+24*3600).' 00:00:00" and '.$date.' > "'.date("Y-m-d",mktime()).' 00:00:00"';
        }

	
}