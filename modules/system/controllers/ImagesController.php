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

class ImagesController extends \yii\web\Controller
{
	 public $layout='@app/views/layouts/admin.php';
	 
	 public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'allow' => RulesControl::callback(['Administrator','Manager']),
						'roles' => ['@'],

                     /*   'allow' => RulesControl::callback('User'),
						'roles' => ['@'],
                        'action'=> 'Uploadtouser'*/
                    ]	,
                ],
            ],
        ];
		
    }
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


   
    public function actionUpload()
    {
		 
		if (empty($_FILES) || $_FILES["file"]["error"]) {
		  die('{"OK": 0}');
		}

        $ext=explode('.',$_FILES["file"]["name"]);
        $fileName=$ext[0].Pictures::EXT;




		
		
		//$fileName = $_FILES["file"]["name"];
		
		$image= new Pictures();
		
		
		
		$image->filename = $fileName;
		$image->byteSize = $_FILES["file"]["size"];
		$image->mimeType = $_FILES["file"]["type"];
		$image->NotActive = 1;
		$image->extension = Pictures::EXT;//$ext[1];
		$image->name      = $ext[0];
		$image->tableid   = 0;
		$image->order     = 1;
		$image->alt       = $fileName;
		$image->title     = $fileName;
		$image->hash_code = hash('md5',$fileName.'.'.$_FILES["file"]["size"].'.'.$_FILES["file"]["type"]);
		
		$pid = $image->save(); 
		
		//

        if(isset($_FILES))
        {
            if(exif_imagetype($_FILES['file']['tmp_name']) ==  IMAGETYPE_GIF)
            {
                imagejpeg(imagecreatefromgif($_FILES['file']['tmp_name']), Yii::$app->BasePath."/files/".$image->id.'-'.$image->hash_code.'.'.$image->extension,Pictures::EXT);
            }
            elseif(exif_imagetype($_FILES['file']['tmp_name']) ==  IMAGETYPE_JPEG)
            {
                //imagepng(imagecreatefromjpeg($_FILES['file']['tmp_name']), Yii::$app->BasePath."/files/".$image->id.'-'.$image->hash_code.'.'.$image->extension,60);
                move_uploaded_file($_FILES["file"]["tmp_name"], Yii::$app->BasePath."/files/".$image->id.'-'.$image->hash_code.'.'.Pictures::EXT);
            }else{
                imagejpeg(imagecreatefrompng($_FILES['file']['tmp_name']), Yii::$app->BasePath."/files/".$image->id.'-'.$image->hash_code.'.'.$image->extension,Pictures::EXT);
                //move_uploaded_file($_FILES["file"]["tmp_name"], Yii::$app->BasePath."/files/".$image->id.'-'.$image->hash_code.'.'.$image->extension);
            }

        }


		die('{"OK": 1, "hash_code":"'.$image->hash_code.'", "pid":"'.$image->id.'"}');
	 
    }
	
	
	
	 public function actionUpdate($id)
    {
       
	    $model = $this->findModel($id);

		if( Yii::$app->request->isAjax && Yii::$app->request->post())
		{
 			
			if($model->load(Yii::$app->request->post()) && $model->save() )
			{
				Yii::$app->response->format = Response::FORMAT_JSON;
				 return json_encode(['error'=>0, 'message' => \Yii::t('admin', 'Данные успешно обновлены') ], JSON_UNESCAPED_UNICODE);  
			}
			else
			{
				Yii::$app->response->format = Response::FORMAT_JSON;
				return json_encode(['error'=>1, 'message' => $this->renderAjax('_error', [ 'model' => $model ]) ], JSON_UNESCAPED_UNICODE);
			}

		#}
		#elseif ($model->load(Yii::$app->request->post()) && $model->save()) 
		#{
           
		   
		   
		   
        } else {
			 
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }
	
 
 
	
	public function actionIndex()
	{
		
	 
	   		 
			$dataProvider = new ActiveDataProvider([
				'query' => Pictures::find(),
				 
				'pagination' => [
					'pageSize' => 10,
				],
			]);

        $dataProvider->sort = [
            'defaultOrder'=>['id'=>SORT_DESC]
        ];
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
		 
	 
		
	}
	
	
	
	public function actionCrop()
	{
		
	  $id=intval($_GET['id']);	

	  if($id)
	  {

          if($_POST['posttype'])
              $this->Preview($id);


          $data = (new \yii\db\Query())->from('image')->where([ 'id' => $id ])->one();
	  
	  if( Yii::$app->request->isAjax )
        return $this->renderAjax('crop', [            'data' => $data,        ]);
	  else	
        return $this->render('crop', [            'data' => $data,        ]);
	  }
		 
	 
		
	}
	
	
	public function actionMake_crop()
	{

	  $id=intval($_GET['id']);	

	  if($id)
	  {


		$x1 = intval($_POST['x1']);
		$x2 = intval($_POST['x2']);
		$y1 = intval($_POST['y1']);
		$y2 = intval($_POST['y2']);

        $crop=explode('x',$_POST['crop']);

        $type = ($_POST['type']);
		$width=explode('x',$_POST['type']);
        $width=$width[0];

		$data = (new \yii\db\Query())->from('image')->where([ 'id' => $id ])->one();
        $cat=\app\modules\catalog\models\Catalog::find()->where([ 'catalog_id' => $data['tableid'] ])->one();

        if($cat['iszoomer']==1)
            $nameType='-preview-crop-';
        else
             $nameType='-preview-';

	    $name = (new \app\components\ImageComponent)->getname($data);


        if($type=='original') {
            $original_file = Yii::$app->basePath . '/files/' . str_replace(".", "-original.", $name);
            }
        else {

            if(yii::$app->request->post('crop')!='960x333'){

//echo $width.'<'.$crop[0].' || '.$width.'<'.$crop[1] ;
             // if( $width<$crop[0]     || $width<$crop[1]   )
                    $original_file=Yii::$app->basePath.'/files/preview/'.$_GET['id'].'-preview-w'.$width.'-h'.$width.'.'.Pictures::EXT;

              //elseif( $crop[0]==452 )
              //     $original_file = str_replace(yii::$app->request->getHostInfo(), Yii::$app->basePath, (new \app\components\ImageComponent)->cuntomResize($data, $width, $width));
              //else
               //     $original_file = str_replace(yii::$app->request->getHostInfo(), Yii::$app->basePath, (new \app\components\ImageComponent)->cuntomResize($data, $width, $width, true));

          //  echo $original_file;

            $name = '/files/preview/'.$id.$nameType.'w'.($crop[0]).'-h'.($crop[1]).'.'.$data['extension'] ;
            $file = Yii::$app->basePath.$name;
            }else{

                if( $width<$crop[0]     || $width<$crop[1]   )
                    $original_file=Yii::$app->basePath.'/files/preview/'.$_GET['id'].'-preview-w'.$width.'-h'.$width.'.'.Pictures::EXT;
                else
              //  $original_file = Yii::$app->basePath.'/files/preview/'.$id.'-preview-w960-h333.png' ;;
                $original_file = str_replace(yii::$app->request->getHostInfo(), Yii::$app->basePath, (new \app\components\ImageComponent)->cuntomResize/*adaptive*/($data, $width, $width, true));
                $name = '/files/preview/'.$id.'-preview-w1920-h667.png' ;
                @unlink(Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w90-h55.'.Pictures::EXT);
                @unlink(Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w58-h44.'.Pictures::EXT);
                $file = Yii::$app->basePath.$name;

            }
        }
		
		if( is_file( $original_file ) )
			$this->crop($original_file, $file, array($x1, $y1, $x2, $y2 ,0,0));
	  	else
			{
			if (copy($file, $original_file)) 
				$this->crop($original_file, $file, array($x1, $y1, $x2, $y2,0,0 ));
			else
				return 'Не удалось скопировать файл';
				 	
			}

          if($type=='original') {
              (new \app\components\ImageComponent)->delete_preview_files($data);
               echo $this->renderPartial('crop-preview',['data'=>$data,'cat'=>$cat]);// echo '/files/' . $name;
          }else{
              echo $this->renderPartial('crop-preview',['data'=>$data,'cat'=>$cat]);//echo yii::$app->request->getHostInfo().$name;
          }
	  }
        exit;
		
	}

    public function Preview($id)
    {
        $cat=\app\modules\catalog\models\Catalog::find()->where( [ 'catalog_id' => (int) $_GET['cid'] ] )->one();
        $data = (new \yii\db\Query())->from('image')->where([ 'id' => (int) $id ])->one();
        $size=explode('x',\yii::$app->request->post('posttype'));
        $h=$size[1];
        $w=$size[0];

        //print_r($_POST);
        //echo $w.' '.$h;
        $fileUnlink=Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w'.$w.'-h'.$h.'.';
        if($cat['iszoomer'] && ($w<1000 && $h<667) )//$w==350)
            $file=Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w'.$w.'-h'.$h.'.'.Pictures::EXT;
        else{
            $file=Yii::$app->BasePath."/files/preview/".$id.'-preview-w'.$w.'-h'.$h.'.'.Pictures::EXT;

           // print_r($_POST);
            if( ($w==1000 && $h==1000)  ){
                @move_uploaded_file($_FILES["file"]["tmp_name"],Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w470-h450.'.Pictures::EXT );
            }elseif($w==1920 && $h==667){
                echo 1920;
                @move_uploaded_file($_FILES["file"]["tmp_name"],Yii::$app->BasePath."/files/preview/".$id.'-preview-w1920-h667.'.Pictures::EXT );
            }
        }

       if(move_uploaded_file($_FILES["file"]["tmp_name"],$file )){
            if(is_file(Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w90-h55.'.Pictures::EXT)){
                @unlink(Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w90-h55.'.Pictures::EXT);
                @unlink(Yii::$app->BasePath."/files/preview/".$id.'-preview-crop-w58-h44.'.Pictures::EXT);
            }

            return true;
        }

        return false;
    }


	public function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Íåâîçìîæíî ïîëó÷èòü äëèíó è øèðèíó èçîáðàæåíèÿ';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Íåêîððåêòíûé ôîðìàò ôàéëà';
		return;
    }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	    $img_o = imagecreatetruecolor($w_o, $h_o);
        /*$img_o = imagecreatetruecolor($crop[4], $crop[5]);
        $white = imagecolorallocate($img_o, 255, 255, 255);

        imagefill($img_o, 0, 0, $white);*/
        imagecopy($img_o, $img, /*($crop[4]-$w_o)/2*/0, 0, $x_o, $y_o, $w_o, $h_o);

	if ($type == 2) {
		imagejpeg($img_o,$file_output,70);
		
	} else {
		$func = 'image'.$ext;
		$func($img_o,$file_output,60);
	}
	
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


    public function actionSlider($id=0)
    {
        if(!$id)
            $id=intval($_GET['id']);

        if($id)
        {
            $data = (new \yii\db\Query())->from('image')->where([ 'id' => $id ])->one();
            if($data['isslider'])
                    $slider=0;
            else
                $slider=1;
            (new \yii\db\Query())->createCommand()->update('image', ['isslider' => $slider ], 'id  = '.$id)        ->execute();

        }
    }
	 
	 
	 public function actionOrder()
     {
		 $order_seq = $_POST['order_seq'];
        
		if( $order_seq )
		{
			$data = explode(',',$order_seq);
			
			for($i=0; $i<count($data);$i++)
			{
				$id = intval($data[$i]);
				
				(new \yii\db\Query())->createCommand()->update('image', ['order' => ($i+1) ], 'id  = '.$id)        ->execute();
				
			}
			
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
