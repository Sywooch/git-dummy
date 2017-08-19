



<?php 


use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use \app\modules\catalog\models\Catalog;
    ?>

  <h3>Товар</h3>



    <?= $form->field($model, 'catalog_name')->textInput(['maxlength' => 255]) ?>


<?
    if(!$model->catalog_text){
       $model->catalog_text=' <div class="post1">
                <div class="ft-img1"><img src="/img/f1.png" alt=""></div>
                <div class="ov-t2">
                    <div>
                        <h2>Больше. Во всех смыслах.</h2>
                        <p>iPhone 6 не просто больше. Он лучше во всех отношениях. Больше, но при этом значительно тоньше. Мощнее, но при этом исключительно экономичный. Его гладкая металлическая поверхность плавно переходит в стекло нового HD-﻿дисплея Retina, образуя цельный, законченный дизайн. Его аппаратная часть идеально работает с программным обеспечением. Это новое поколение iPhone, улучшенное во всём.</p>
                    </div>
                </div>
            </div>
            <div class="post1 post11">
                <div class="ft-img1"><img src="/img/f2.png" alt=""></div>
                <div class="ov-t2">
                    <div>
                        <h2>Самый тонкий iPhone.</h2>
                        <p>Чтобы разработать iPhone с таким большим и инновационным дисплеем, нам пришлось переосмыслить свои подходы к дизайну. Создавая iPhone 6, мы тщательно продумывали каждую деталь и все материалы. Так родилась его цельная чистая форма. Взяв iPhone 6 в руку, вы сразу почувствуете, насколько удобно его держать. Стекло экрана закругляется по бокам и плавно переходит в корпус из анодированного алюминия, образуя исключительный в своей простоте дизайн. Нет никаких видимых границ. Никаких зазоров. Это безупречное сопряжение стекла и металла, которое кажется единой непрерывной поверхностью. Как известно, большой результат складывается из тысячи мелких деталей. Поэтому, хотя iPhone 6 и больше по размеру, он идеально лежит в руке.</p>
                    </div>
                </div>
            </div>
            <div class="post1">
                <div class="ft-img1"><img src="/img/f3.png" alt=""></div>
                <div class="ov-t2">
                    <div>
                        <h2>Этот дисплей не просто больше. Он лучше.</h2>
                        <p>Одно дело увеличить размер экрана. Совсем другое — сделать так, чтобы дисплей Multi‑Touch не просто стал больше, но и сохранил яркие цвета и повышенную контрастность при ещё более широком угле просмотра. Именно этого нам и удалось добиться с новым HD-дисплеем Retina.</p>
                    </div>
                </div>
            </div>
            <div class="post1 post11">
                <div class="ft-img1"><img src="/img/f4.png" alt=""></div>
                <div class="ov-t2">
                    <div>
                        <h2>Сопроцессор движения М8</h2>
                        <p>Новый процессор A8 с 64-разрядной архитектурой уровня настольного компьютера обеспечивает больше мощности, даже несмотря на то, что передаёт изображение на экран большего размера. А поскольку A8 эффективнее расходует энергию, его производительность ещё более возрастает. В частности, это означает, что вы сможете играть в игры со сложной графикой и смотреть более долгие фильмы.</p>
                    </div>
                </div>
            </div>';
    }
    echo $form->field($model, 'catalog_text')->widget(letyii\tinymce\Tinymce::className(), [
        'options' => [        'id' => 'catalog_text',   ],

        'configs' => [

            'plugins'=>	[	"link image preview hr ", " fullscreen ",]

        ],
    ]);

?>



<?
   echo $form->field($model, 'catalog_shortpreview')->widget(letyii\tinymce\Tinymce::className(), [
        'options' => [        'id' => 'catalog_shortpreview',    ],
        'configs' => [
            'plugins'=>	[	"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",]

        ],
    ]);

?>


<?= $form->field($model, 'catalog_title')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'catalog_meta')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'catalog_keys')->textInput(['maxlength' => 255]) ?>

<h2>Характеристики </h2>

<div class="alert alert-warning">
    (четные значения идут в левый столбик нечетные в правый)
</div>
<?php
if($lang){
    $name= $lang.'[Character][name][]';
    $character= $lang.'[Character][attribute][]';
    $order= $lang.'[Character][orders][]';

    }
    else{
        $name= 'Character[name][]';
        $character= 'Character[attribute][]';
        $order= 'Character[orders][]';
    }
$i=1;
if(count( $model->character ))
    foreach($model->character as $char):

        ?>
        <div class="row form-group">
            <div class="col-md-4">
                <input name="<?=$name?>" class="form-control" value="<?=$char->name?>" placeholder="Название характеристики">
            </div>
            <div class="col-md-4">
                <input name="<?=$character?>"  class="form-control" value="<?=$char->attribute?>" placeholder="Значение характеристики">
            </div>
            <div class="col-md-2">
                <input name="<?=$order?>"  class="form-control order-class" value="<?=($char->orders)?$char->orders:$i?>" placeholder="Порядок следования" >
            </div>
            <div class="col-md-2">
                <span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; cursor:pointer;"></span>
            </div>

        </div>

    <?php $i++;
 endforeach; ?>

<div id="fields_tempalte-<?=$lang?>" style="display: none">
    <div class="row form-group">
        <div class="col-md-4">
            <input name="<?=$name?>" class="form-control" placeholder="Название характеристики">
        </div>
        <div class="col-md-4">
            <input name="<?=$character?>"  class="form-control" placeholder="Значение характеристики">
        </div>
        <div class="col-md-2">
            <input name="<?=$order?>"  class="form-control order-class" placeholder="Порядок следования">
        </div>
        <div class="col-md-2">
            <span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; cursor:pointer;"></span>
        </div>

    </div>
</div>

<button type="button" class="add-character-<?=$lang?>"  >Добавить характеристику</button>
<?php
    Yii::$app->view->registerJs('
    var index='.$i.';
        $(".add-character-'.$lang.'").click(function(){
        var el=$("#fields_tempalte-'.$lang.'").children("div").clone();
        (el).insertBefore( "#fields_tempalte-'.$lang.'" )

        el.find(".order-class").val( index );
         index++;
         $(".glyphicon-remove-circle").click(function(){
            $(this).parent("div").parent("div").remove();
        });

        });
        $(".glyphicon-remove-circle").click(function(){
            $(this).parent("div").parent("div").remove();
        });
    ');
 ?>








