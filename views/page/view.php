<?php
use yii\helpers\Html;




?>
<?    echo $this->render('../site/breadcrumbs',['breadcrumbs'=> $breadcrumbs] )?>
                        <!--    --><?/*=$data->static_page_name*/?>


<?=str_replace('center-content content-page','center-content content-page '.$index,$data->static_page_text);?>
