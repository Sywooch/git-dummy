<?php
    use yii\helpers\Html;
    use app\modules\shop\models\ShopItem;

    use app\modules\shop\models\Shop;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;

if(\yii::$app->user->getId()){
    $uid=\yii::$app->user->getId();
}else{
    $uid=0;
}
if($uid)
    $items = ShopItem::find()->where(' ip="'.$_SERVER['REMOTE_ADDR'].'" or ip = '.$uid  )->all();
else
    $items = ShopItem::find()->where(' ip="'.$_SERVER['REMOTE_ADDR'].'"' )->all();
?>


<?  echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>\yii::t('app','Корзина') ]] )?>



<div class="line-sep"></div>
<div id="content" class="content-page-cart">      <h2>  <?=Yii::t('app','Корзина')?>        </h2>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td class="text-center"><?=Yii::t('app','Фото')?></td>
                    <td class="text-left"><?=Yii::t('app','Продукт')?></td>

                    <td class="text-left"><?=Yii::t('app','Кол-во')?></td>
                    <td class="text-right"><?=Yii::t('app','Цена')?></td>
                    <td class="text-right"><?=Yii::t('app','Сумма')?></td>
                </tr>
                </thead>
                <tbody>

                <?php
                                                $weight = $sum = 0;
                                                if (is_array($items)): ?>
                <?php foreach($items as $item):

                                        $img = app\modules\system\models\Pictures::getImages('catalog',$item->item->catalog_id);
                                        $sum= $item->count * $item->price +$sum;
                                        $weight = $item->count * $item->mean +$weight;
                                                        $img = app\modules\system\models\Pictures::getImages('catalog',$item->item->catalog_id);
                                        ?>


                <tr data-id="<?=$item->shop_item_id?>">
                    <td class="text-center">

                        <a href="<?=$item->item->catalog_url?>">
                            <img width="80" src="<?=(new app\components\ImageComponent)->crop($img[0],70,50);  ?>" class="img-thumbnail"></a>
                    </td>

                    <td class="text-left"><?=$item->item->catalog_name?></td>
                    <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                            <input type="number" value="<?=$item->count?>" size="1" class="form-control">
                        <span class="input-group-btn">
                        <button type="button" data-id="<?=$item->shop_item_id?>" data-toggle="tooltip" title="" class="change-count btn button-green" data-original-title="Update"><i class="fa fa-refresh"></i></button>
                        <?php if(!$item->mean): ?>
                            <button type="button" data-toggle="tooltip" title="" class="del-btn btn btn-danger" data-original-title="Remove"><i class="fa fa-times-circle"></i></button></span>
                        <?php endif; ?>
                        </div></td>
                    <td class="text-right"><?=\app\modules\system\models\Course::getPrice($item->price)?></td>
                    <td class="text-right"><?=\app\modules\system\models\Course::getPrice($item->count*$item->price)?></td>
                </tr>




                <?php endforeach; ?>
                <?php endif; ?>


                </tbody>
            </table>
        </div>

    <div><h2><?=Yii::t('app','Что бы вы хотели еще?')?></h2></div>
    <p><?=Yii::t('app','Если у вас есть купон  на скидку или дополнительные баллы , которые Вы хотели бы использовать , то вы можете ввести их в дополнительных полях ниже.')?></p>
    <ul class="panel_group panel-page-cart">

        <li class="panel ">
            <div class="panel_heading">
                <h4 class="panel-title"><?=Yii::t('app','Использовать код купона')?> <a href="#" class="faq-list-toggle"></a></h4>
            </div>
            <div  class="panel_body">
                <label class="col-sm-2 control-label" for="input-coupon"><?=Yii::t('app','Введите код купона')?></label>
                <div class="input-group">
                    <input data-place="" name="coupon" value="" placeholder="<?=Yii::t('app','Введите код купона')?>" id="input-coupon" class="form-control" type="text">
                    <span class="input-group-btn">
                    <input value="<?=mb_strtoupper(Yii::t('app','Использовать купон'),'UTF-8')?>" id="button-coupon" data-loading-text="Loading..." class="button button-green" type="button">
                    </span></div>
                <div class="clear"></div>
            </div>
        </li>
        <li class="panel">
            <div class="panel_heading">
                <h4 class="panel-title"><?=Yii::t('app','Использовать код подарочного сертификата')?> <a href="#" class="faq-list-toggle"></a></h4>
            </div>
            <div class="panel_body">
                <label class="col-sm-2 control-label" for="input-voucher"><?=Yii::t('app','Введите код сертификата')?></label>
                <div class="input-group">
                    <input data-place="" name="voucher" value="" placeholder="<?=Yii::t('app','Введите код сертификата')?>" id="input-voucher" class="form-control" type="text">
                <span class="input-group-btn">
                <input value="<?=mb_strtoupper(Yii::t('app','Использовать код'),'UTF-8')?>" id="button-voucher" data-loading-text="Loading..." class="btn button-green" type="submit">
                </span> </div>
                <div class="clear"></div>
            </div>

        </li>

        <li class="panel panel-default opened form">
            <div class="panel_heading">
                <h4 class="panel-title"><?=yii::t('app','Адрес доставки')?><a href="#" class="faq-list-toggle"></a></h4>
            </div>
            <div class="panel_body">
                <p><?=yii::t('app','Введите ваш адрес доставки и контактные данные')?></p>
                    <?php $form = ActiveForm::begin([
                                     'options' => ['class'=>'form-horizontal','method' => 'POST'],
                        ]); ?>
                    <div class="form-group required">
                        <?= $form->errorSummary($shop); ?>

<?php if (!\yii::$app->user->getId()):?>
                        <div class="form-group">
                            <label class="col-md-2 col-sm-12 control-label" for="input-postcode"><?=yii::t('app','Ваше имя')?></label>
                            <div class="col-md-10 col-sm-12">
                                <?= $form->field($shop, 'fio')->textInput(['maxlength' => 255, 'class'=>'form-control'])->label(false); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 col-sm-12 control-label" for="input-postcode"><?=yii::t('app','Email')?></label>
                            <div class="col-md-10 col-sm-12">
                                <?= $form->field($shop, 'email')->textInput(['maxlength' => 255, 'class'=>'form-control'])->label(false); ?>
                            </div>
                        </div>



<?php endif; ?>
                        <div class="form-group">
                            <label class="col-md-2 col-sm-12 control-label" for="input-postcode"><?=yii::t('app','Почтовый индекс')?></label>
                            <div class="col-md-10 col-sm-12">
                                <?= $form->field($shop, 'index')->textInput(['maxlength' => 255, 'class'=>'form-control','value'=>yii::$app->user->identity->index])->label(false); ?>
                            </div>
                        </div>


                        <?php  if( !$model->place ){
                            $geo = new \app\components\sypexgeo\Sypexgeo();

                            // get by remote IP
                            $geo->get();                // also returned geo data as array
                            if( $geo->getCountry(\Yii::$app->session->get('language')) && $geo->getCity(\Yii::$app->session->get('language')) )
                                $place =  $geo->getCountry(\Yii::$app->session->get('language')).', '.$geo->getCity(\Yii::$app->session->get('language'));
                            else
                                $place='';
                        }
                        ?>


                        <div class="form-group">
                            <label class="col-md-2 col-sm-12 control-label" for="input-postcode"><?=yii::t('app','Местоположение')?></label>
                            <div class="col-md-10 col-sm-12">
                                <?= $form->field($shop, 'country')->textInput(['maxlength' => 255, 'class'=>'form-control','value'=>($place)?$place:yii::$app->user->identity->place])->label(false); ?>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="col-md-2 col-sm-12 control-label" for="input-postcode"><?=yii::t('app','Адрес доставки')?></label>
                        <div class="col-md-10 col-sm-12">
                            <?= $form->field($shop, 'adres')->textInput(['maxlength' => 255, 'class'=>'form-control','value'=>yii::$app->user->identity->adres])->label(false); ?>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-md-2 col-sm-12 control-label" for="input-postcode"><?=yii::t('app','Телефон')?></label>
                            <div class="col-md-10 col-sm-12">
                                <?= $form->field($shop, 'phone')->textInput(['maxlength' => 255, 'class'=>'form-control','value'=>yii::$app->user->identity->phone])->label(false); ?>
                            </div>
                        </div>
                <?php ActiveForm::end(); ?>
                <div class="clear"></div>
            </div>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-8 no-padding">
            <table class="table table-bordered">
                <tbody><!--<tr>
                    <td class="text-right"><strong>Sub-Total:</strong></td>
                    <td class="text-right">$200.00</td>
                </tr>-->
                <tr>
                    <td class="text-right"><strong><?=Yii::t('app','Сумма')?>:</strong></td>
                    <td class="text-right"><?=\app\modules\system\models\Course::getPrice($sum)?></td>
                </tr>
                </tbody></table>
        </div>
    </div>
    <div class="buttons">
        <div class="pull-left"><a href="/" class="btn btn-default"><?=mb_strtoupper(Yii::t('app','Продолжить покупки'),'UTF-8')?></a></div>
        <div class="or"></div>
        <div class="pull-right"><a href="#" class="btn button-green modal-basket"><?=mb_strtoupper(Yii::t('app','Оформить заказ'),'UTF-8')?></a></div>
    </div>
    <div class="clear"></div>
</div>



<div class="modal-table dm-overlay" id="for_modal_table">
    <div class="dm-table">
        <div class="dm-cell">

            <div class="dm-bg-close"></div>
            <div class="dm-modal">
                <a href="<?=(\yii::$app->user->getId())?'/basket-history':'/'?>" class="close"></a>
                <div class="ov-rd1">
                    <div class="block-members">
                        <h2><?=yii::t('app','Ваш заказ оформлен')?></h2>
                        <p class="popap-info"></p>
                        <div class="bt-rr1">
                            <input type="submit"   class="agree" value="<?=yii::t('app','Переход')?> (10)">
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<input type="hidden" id="counter" value="10">
<script>
    $('.agree').click(function(){
       window.location='<?=(\yii::$app->user->getId())?'/basket-history':'/'?>';
    });

    $('.modal-basket').click(function(){

        $.ajax({
            type: "POST",
            url: '/checkout',
            data: $('#w0').serialize(),
            success: function(data){
                if(data.status=='ok'){
                    if(data.url)
                        window.location=data.url;
                    else{
                        $('#for_modal_table').addClass('active').fadeIn();
                        $('.popap-info').html(data.text);
                        setInterval(function(){
                            console.log(   $('#counter').val( ) );

                            $('#counter').val( $('#counter').val()*1-1 );
                            var count=$('#counter').val();
                            $('.agree').val("<?=yii::t('app','Переход')?> ("+count+")");

                            if($('#counter').val()==0){
                                window.location="/";
                            }

                        }, 1000);
                    }
                }
                else{
                    $('.required').removeClass('has-error');
                    $('.required').find('.help-block').hide()
                    $('.form').addClass('opened').find('.panel_body').show();
                    $.each(data.errors,function(name, value){
                        $('.field-shop-'+name).addClass('has-error');
                        $('.field-shop-'+name).find('.help-block').fadeIn().html(value[0]);
                    });

                }
            },
        });



        return false;
        // onclick="$('#w0').submit();"
    });


    $('.del-btn').click(function() {
        var
            item = $(this).parent('span').parent('div').parent('td').parent('tr');
        id = parseInt(item.attr('data-id'));
        if (id > 0) {
            $.ajax({
                url: '/delete-from-basket?id=' + id,
                headers: {"X-CSRF-Token": $('meta[name=csrf-token]').attr("content")},
                success: function (data) {
                    item.remove();
                    location.reload();
                }
            });
        }
    });


    $('.change-count').click(function(){


        var count=$(this).parent('span').parent('div').find('input').val();
        id = parseInt($(this).attr('data-id'));
        if (id > 0) {
            $.ajax({
                url: '/change-count-basket?id=' + id+'&count='+count,
                headers: {"X-CSRF-Token": $('meta[name=csrf-token]').attr("content")},
                success: function (data) {
                    location.reload();
                }
            });
        }

    })
</script>