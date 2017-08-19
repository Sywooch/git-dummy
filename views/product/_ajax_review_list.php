<?php
use yii\helpers\Html;
?>
<?php $comments = $model->comments;




    $bit_step=$model->catalog_price*($model->catalog_price_step/100);

if(count($comments)):?>

<?php for($i=($max-2);$i<$max;$i++):        ?>

        <?php  if(isset($comments[$i]))
            echo $this->render('_ajax_reviews',['com'=>$comments[$i],'bit_step'=>$bit_step]); ?>
<?php  endfor; ?>


<?php endif; ?>