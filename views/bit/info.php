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
        <input type="radio" checked name="rd1" id="rdd1" data-id="auction"
               data-price-common="<?= str_replace(\app\modules\system\models\Course::getName(), '', $item->priceStep()) ?>"
               data-price="<?= $item->priceStep() ?>"
        >
        <span class="st-img1"><span><img src="/img/q1.png" alt=""></span></span>
                           <span class="st-text1">
                               <span><?= yii::t('app', 'Принять участие') ?></span>
                               <p><?= \app\modules\system\models\TextWidget::getTpl('member_of_auction'); ?></p>
                           </span>
        <label for="rdd1"></label>
    </div>
    <div class="item1">
        <input type="radio" name="rd1" id="rdd2" data-id="buy"
               data-price-common="<?= str_replace(\app\modules\system\models\Course::getCurrency(), '', $item->priceBuy()) ?>"
               data-price="<?= $item->priceBuy() ?>">
        <span class="st-img1"><span><img src="/img/q2.png" alt=""></span></span>
                           <span class="st-text1">
                               <span><?= yii::t('app', 'Купить сейчас') ?></span>
                               <p><?= \app\modules\system\models\TextWidget::getTpl('buy_now'); ?></p>
                           </span>
        <label for="rdd2"></label>
    </div>
</div>
<div class="bt-rr1">
    <!-- <button class="add_list_btn active">Добавить в список</button>
     <button class="add_cart_btn">Добавить в корзину</button>-->
    <div>
        <span><?= yii::t('app', 'Ваша ставка:') ?></span>
        <input type="text" id="price-info" value="<?= $item->priceStep() ?>">
        <input type="submit" class="agree" value="<?= yii::t('app', 'перейти к оплате') ?>">
    </div>
</div>


<script>

    $('.item1').click(function () {
        $('.item1').removeClass('active');
        $(this).addClass('active');
        console.log($(this).find('input').data('price') + ' ' + $('#price').val());
        $('#price-info').val($(this).find('input').data('price'));
    });
    $('.agree').click(function () {
        var el = $(this);
        $(this).html('<?=yii::t('app','Ожидайте ответа')?>, <img src="/img/bx_loader.gif" style="margin-top:7px;" />').attr('disabled', 'disabled');
        if ($('.item1.active').find('input').data('id') == 'auction') {
            $.ajax({
                url: '/add-bit?product=<?=$item->catalog_id?>&price=' + $('#price-info').val(),
                headers: {"X-CSRF-Token": $('meta[name=csrf-token]').attr("content")},
                type: 'PUT',

                success: function (data) {
                    $('.st-text1').children('span').html(data.title);
                    $('.st-text1').children('p').html(data.message);

                    $('.item1').hide();
                    $('.item1').removeClass('active');

                    $('.item_for_circles').addClass('active').fadeIn();

                    if (data.status == 'ok') {
                        setTimeout(function () {
                            $('.modal').add('.dm-overlay').fadeOut();
                            setTimeout(function () {
                                $('body').removeClass('body-active');
                            }, 400);
                        }, 2000);
                    } else {
                        if (data.move) {
                            window.location = data.move;
                        }
                    }
                    el.remove();
                }
            });

        } else {
            alert('basket');
        }
        return false;
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