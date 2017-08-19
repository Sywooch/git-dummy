 Сео страницы<?
 
  if($data)	
	 foreach($data as $L)
	 {
 	
	?>
<div><a href="/seo/default/edit/id/<?=$L[seo_id]?>" target="_blank"><?=$L[seo_url].'?'.$L['seo_page']?> - <?=$L[seo_title]?></a></div>	
	<?
 
 	 }
 ?>
 
  
   