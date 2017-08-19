<?
$stepPrice = str_replace($name = \app\modules\system\models\Course::getName(), '', str_replace(',', '.', $item->priceStep()));
$count = \app\models\Bits::countBits($item->catalog_id);
/*  print_r($item);*/
?>


<div class="ov-rd1">


    <div class="item1  item_for_circles" style="display: none">
        <span class="st-img1"><span><img src="/img/q1.png" alt=""></span></span>
                                    <span class="st-text1">
                                        <span></span>
                                        <p></p>
                                    </span>
    </div>


    <div class="item1 active">
        <div style="-moz-user-select: none; display: inline-block; position: relative;" unselectable="on"
             id="rdd1-styler" class="jq-radio checked">
            <input style="position: absolute; z-index: -1; opacity: 0; margin: 0px; padding: 0px;" checked="" name="rd1"
                   class="round"
                   id="rdd1"
                   data-id="auction"
                   data-name="<?= $item->catalog_id ?>"
                   data-price-common="<?= str_replace(\app\modules\system\models\Course::getName(), '', $item->getPriceOne()) ?>"
                   data-price="<?= \app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>"
                   data-comment="<?= yii::t('app', 'Сделать ставку,') ?><?= \app\modules\system\models\Course::getName() ?>"
                   data-button="<?=yii::t('app','сделать ставку')?>"

                   type="radio">

            <div class="jq-radio__div"></div>
        </div>
        <span class="st-img1"><span><img src="/img/q1.png" alt=""></span></span>
                           <span class="st-text1">
                                <span><?= yii::t('app', 'Принять участие') ?></span>
                               <p><?= \app\modules\system\models\TextWidget::getTpl('member_of_auction', ['item' => $title]); ?></p>
                           </span>
        <label for="rdd1"></label>
    </div>
    <div class="item1">
        <div style="-moz-user-select: none; display: inline-block; position: relative;" unselectable="on"
             id="rdd2-styler" class="jq-radio">
            <input style="position: absolute; z-index: -1; opacity: 0; margin: 0px; padding: 0px;" name="rd1" id="rdd2"
                   class="round"
                   data-id="buy"
                   data-name="<?= $item->catalog_id ?>"
                   data-price-common="<?= str_replace(\app\modules\system\models\Course::getCurrency(), '', $item->priceBuy()) ?>"
                   data-price="<?= \app\modules\system\models\Course::getPriceClear($item->catalog_price) ?>"
                   data-comment="<?= yii::t('app', 'Купить за,') ?><?= \app\modules\system\models\Course::getName() ?>"
                   data-button="<?= yii::t('app', 'перейти к оплате') ?>"
                   type="radio">

            <div class="jq-radio__div"></div>
        </div>
        <span class="st-img1"><span><img src="/img/q2.png" alt=""></span></span>
                           <span class="st-text1">
                                 <span><?= yii::t('app', 'Купить сейчас') ?></span>
                               <p><?= \app\modules\system\models\TextWidget::getTpl('buy_now', ['item' => $title]); ?></p>
                           </span>
        <label for="rdd2"></label>
    </div>


    <div class="bt-rr1">
        <!-- <button class="add_list_btn active">Добавить в список</button>
         <button class="add_cart_btn">Добавить в корзину</button>-->
        <div>
        <span
            class="span-comment"><?= yii::t('app', 'Ваша ставка:') ?><?= \app\modules\system\models\Course::getName() ?></span>
            <input type="text" id="price-info" style="border: 2px solid #2dc16b"
                   value="<?= \app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>">
            <input type="submit" class="agree agree-button" value="<?=yii::t('app','сделать ставку')?>">
        </div>
        <p class="elaboration_red notice"></p>

        <p class="elaboration_red"><?= yii::t('app', '* - Делая ставку, вы берете на себя обязательство купить этот товар, если вы выиграете аукцион.') ?></p>
    </div>
</div>


<script>
    $.jradio = '';
    $('.jq-radio').click(function () {
        $.jradio = $(this).find('input').attr('data-id');

        if ($.jradio == 'buy') {
            $('#price-info').attr('readonly', 'readonly');
            $('.elaboration_red').fadeOut();
        }
        else {
            $('#price-info').removeAttr('readonly');
            $('.elaboration_red').fadeIn();
        }
    });
    $('#price-info').focus(function () {


        if ($.jradio == 'buy') {
            $(this).css('border', '2px solid #2dc16b');
        } else {
            if ($(this).val() >=<?=\app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>) {
                $(this).css('border', '2px solid #2dc16b');
            } else {
                $(this).css('border', '2px solid red');
            }
        }
    });


    $('#price-info').keyup(function () {
      //  $(this).val($(this).val().replace(/[^0-9\.]/gim, ''));


        if ($.jradio == 'buy') {
            $(this).css('border', '2px solid #2dc16b');
        } else {
            if ($(this).val() < "<?=\app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>".replace(",",".")*1) {
                $(this).css('border', '2px solid red');
            } else {
                $(this).css('border', '2px solid #2dc16b');
            }
        }



    });


    $('.close-button').click(function () {
        $('.modal').add('.dm-overlay').fadeOut();
        setTimeout(function () {
            $('body').removeClass('body-active');
        }, 400);
    });
    $('.close').click(function () {
        $('.modal').add('.dm-overlay').fadeOut();
        setTimeout(function () {
            $('body').removeClass('body-active');
        }, 400);
    });

</script>