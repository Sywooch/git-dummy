<?php
 
namespace app\components;
use Yii;
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;
 use yii\web\Controller;
 
class Sitemap  extends \yii\web\Controller
{

	
public static function index()
{
	
	$url = substr(yii::$app->params['sitehost'],0,strlen(yii::$app->params['sitehost'])-1);
	
	$data='<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		 
	$modules = ['static_page','news','catalog'];
	
	foreach($modules as $table)
	{
		 $rows = (new \yii\db\Query()) ->select(' date_modified, '.$table.'_url as URL ' )->from($table)->all();	
		 
		if($rows) 
		 foreach($rows as $row){
		 	$data.='<url>
						<loc>'.$url.$row['URL'].'</loc>
						<lastmod>'.date('d.m.Y',strtotime($row['date_modified'])).'</lastmod>
						<changefreq>week</changefreq>
						<priority>0.5</priority>
					</url>';
			}
		
	}
	
		 
	 $rows = (new \yii\db\Query()) ->select(' date_modified, terms_url as URL ' )->from('terms')->where(['termscatid'=>[1,6] ])->all();	
		 
		if($rows) 
		 foreach($rows as $row){
		 	$data.='<url>
						<loc>'.$url.$row['URL'].'</loc>
						<lastmod>'.date('d.m.Y',strtotime($row['date_modified'])).'</lastmod>
						<changefreq>week</changefreq>
						<priority>0.5</priority>
					</url>';
			}

	
 echo  $data.'</urlset>' ;
}
  
}