<?php


class Viewseo extends CWidget
{
  
  	public $url='';
 	 	
 
	
	public function run()
	{
		
	
	 
	
	$L=yii::app()->db->createCommand()
 
    ->from('seo')
    
    ->where('seo_url=:url', array(':url'=>$this->url))
	
	->queryAll();
	
	
		$this->render('view',array('data'=>$L));
			
	}
	
	 
}