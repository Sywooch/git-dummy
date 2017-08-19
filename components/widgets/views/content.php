<?php


$model=$data['model'];
?>


<div class="tab-content">
<?php foreach($langs as $lang):?>


        <div class="tab-pane fade <?=($active == $lang)?'active in':''?>" id="<?=$lang?>">
           <?php if($lang=='ru'):
                   echo $this->render($view,$data);
               else:
                   echo str_replace($model->formName(),$lang.'['.$model->formName().']',
                       $this->render($view,['form'=>$data['form'],'lang'=>$lang, 'model'=>app\components\widgets\Language::getModel($data['model'],$lang) ])
               );?>
           <?php endif; ?>
        </div>





<?php endforeach; ?>
</div>