<?php

namespace app\modules\seo;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class Module extends \yii\base\Module
{
	 
 
	 public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
	 
	 
	public function get_seo()
	{

if(preg_match("/^[0-9a-zA-Z\/\-\_\.]+$/i", $_SERVER['REDIRECT_URL'] )) {

	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL'];
	
	 
	
	$L=yii::$app->db->createCommand()
 
    ->from('seo')
    
    ->where('seo_url=:url', array(':url'=>$url))
	
	->queryAll();
	
}

	/*
	[REDIRECT_QUERY_STRING] => vid=big&Catalog_page=3
    [REDIRECT_URL] => /product/cat/id/1
    [GATEWAY_INTERFACE] => CGI/1.1
    [SERVER_PROTOCOL] => HTTP/1.0
    [REQUEST_METHOD] => GET
    [QUERY_STRING] => vid=big&Catalog_page=3
    [REQUEST_URI] => /product/cat/id/1?vid=big&Catalog_page=3
	*/
	
 
	
	
		if(count($L)==1  && ($L[0]['seo_page'] && strstr($_SERVER[QUERY_STRING],$L[0]['seo_page']) ))
		{
		 
		yii::$app->params[seo_title]=$L[0][seo_title];
		yii::$app->params[seo_keywords]=$L[0][seo_key];
		yii::$app->params[text]=$L[0][seo_text];
		yii::$app->params[seo_description]=$L[0][seo_desc];
		if($L[0][seo_canonical])
						yii::$app->params[canonical]=$L[0][seo_url];
		}
		elseif(count($L)>1)
		{
		
		 foreach($L as $row)
		 	{
				// echo  $row['seo_page'].'=='.$_SERVER[QUERY_STRING].'<br />';
			if($row['seo_page'] && $row['seo_page']==$_SERVER[QUERY_STRING] )
				{
					yii::$app->params[seo_title]=$row[seo_title];
					yii::$app->params[seo_keywords]=$row[seo_key];
					yii::$app->params[text]=$row[seo_text];
				    yii::$app->params[seo_description]=$row[seo_desc];					
					if($row[seo_canonical])
						yii::$app->params[canonical]=$row[seo_url];
						
					return ;
				}
			 /*elseif($row['seo_page'] && strstr($_SERVER[QUERY_STRING],$row['seo_page']))
			 	{
					yii::$app->params[seo_title]=$row[seo_title];
					yii::$app->params[seo_keywords]=$row[seo_key];
					yii::$app->params[text]=$row[seo_text];
					if($row[seo_canonical])
						yii::$app->params[canonical]=$row[seo_url];
						
					return ;
				}*/
				
			}
		}
 
 if(empty($L)){
 	 
 	if(  strstr($_SERVER[REDIRECT_URL],'/product/cat/id/') )			
				yii::$app->params[canonical]=$_SERVER[REDIRECT_URL];
 }
 	
	} 
}