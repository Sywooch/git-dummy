<?php

 
namespace app\modules\system\controllers;

use app\components\access\RulesControl;
use app\modules\system\models\Pictures;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\components\ImageComponent ;
use yii\data\ActiveDataProvider;
use yii\web\Response;

class UmagesController extends \yii\web\Controller
{
	 public $layout='@app/views/layouts/admin.php';
	 

    public function actionUploadtouser()
    {


        if (empty($_FILES) || $_FILES["file"]["error"]) {
            die('{"OK": 0}');
        }

        if(!yii::$app->user->getId()){
            die('{"OK": error auth}');
        }

        $ext=explode('.',$_FILES["file"]["name"]);


        $fileName = $_FILES["file"]["name"];

        $image= new Pictures();



        if($_FILES["file"]["size"]/1000 > 200){
            echo 'error size';
            exit;
        }

        if($ext[1]!='png' && $ext[1]!='jpg' && $ext[1]!='JPG' && $ext[1]!='gif' ){
            echo 'error type';
            exit;
        }

        $data = (new \yii\db\Query())->from('image')->where([ 'tableid' => yii::$app->user->getId(),'name'=>'user' ])->all();
        if(is_array($data))
        {
            foreach($data as $data_r){
                $this->actionDelete($data_r['id']);
            }
        }


        $image->filename = $_FILES["file"]["name"];
        $image->byteSize = $_FILES["file"]["size"];
        $image->mimeType = $_FILES["file"]["type"];
        $image->NotActive = 0;
        $image->extension = $ext[1];
        $image->name      = 'user';//$ext[0];
        $image->tableid   = yii::$app->user->getId();
        $image->order     = 1;
        $image->alt       = $_FILES["file"]["name"];
        $image->title     = $_FILES["file"]["name"];
        $image->hash_code = hash('md5',$_FILES["file"]["name"].'.'.$_FILES["file"]["size"].'.'.$_FILES["file"]["type"]);

        $pid = $image->save();

        move_uploaded_file($_FILES["file"]["tmp_name"], Yii::$app->BasePath."/files/".$image->id.'-'.$image->hash_code.'.'.$image->extension);

        $img = \app\modules\system\models\Pictures::getImages('user',$image->tableid);
        $file=(new \app\components\ImageComponent)->crop($img[0],240,240);

        die('{"OK": 1, "hash_code":"'.$image->hash_code.'", "pid":"'.$image->id.'", "image":"'.$file.'" }');

    }

    public function actionDelete($id=0)
    {
        if(!$id)
            $id=intval($_GET['id']);

        if($id)
        {
            $data = (new \yii\db\Query())->from('image')->where([ 'id' => $id ])->one();

            (new \app\components\ImageComponent)->delete_files($data);

            $pic=$this->findModel($id)->delete();

        }
    }
	protected function findModel($id)
    {
        if (($model = Pictures::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
