<?php
use yii\helpers\Html;
 ?>


<?php 

 if($data)
 	for($i=0;$i<count($data);$i++)
	{
        $row = $data[$i];
        $img = app\modules\system\models\Pictures::getImages('terms',$row['terms_id']);

        $cats[$i]='    <li class="col-xs-4">
                            <a href="'.$urlPrefix.$row['terms_url'].'">
                                <img src="'.(new app\components\ImageComponent)->adaptive($img[0],270,270).'" alt=""/>
                                <div class="banner-block-content">
                                    <h1>'.$row['terms_text'].'</h1>
                                </div>
                            </a>
                        </li>';

    }

    for($i=0;$i<count($cats);$i=$i+3){
        ?>

        <ul class="banner-block row">
            <? for($k=0;$k<3;$k++) echo $cats[$i+$k]; ?>
        </ul>

<?php
    }
?>
 
 
             	
			