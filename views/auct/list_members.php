<div class="dm-bg-close"></div>
<div class="dm-modal">
    <a href="#for_circles_modal" class="close"></a>
    <div class="ov-rd1">
        <div class="block-members">
            <h2><?=$item2->catalog_name?></h2>
            <p><?=\yii::t('app','Принимая участие в торгах вы получаете возможность покупки выбранного товара по более низкой оптовой цене. Если сделанная Вами ставка окажется максимальной на момент окончания торгов, то выбранный товар достанется Вам.')?></p>
            <div id="auction-members">
            <?     echo  \app\components\widgets\AuctWidget::widget(  [          'productid'=>$item->catalog_id       ]);        ?>

            </div>

            <div class="bt-rr1">
                <span class="span-comment">
                    <?=yii::t('app','Ваша ставка,')?>
                    <?=\app\modules\system\models\Course::getName()?>:
                </span>
                <input type="text" id="price-info-list-members"   value="<?=\app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>">
                <input type="submit"  data-action='auction' class="agree" value=" <?=yii::t('app','сделать ставку')?>">
            </div>
            <p class="elaboration_red notice" ></p>
            <p class="elaboration_red" ><?=yii::t('app','* - Делая ставку, вы берете на себя обязательство купить этот товар, если вы выиграете аукцион.')?></p>
        </div>
    </div>
</div>


<script>
    $('#price-info-list-members').focus(function(){

        if($(this).val()>=<?=\app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>){
            $(this).css('border','2px solid #2dc16b');
        }else{
            $(this).css('border','2px solid red');
        }
    });



    $('#price-info-list-members').keyup(function(){

       // $(this).val($(this).val().replace(/[^0-9\.]/gim,''));
        if($(this).val()< "<?=\app\modules\system\models\Course::getPriceClear($item->getPriceOne()) ?>".replace(",",".")*1){
            $(this).css('border','2px solid red');
        }else{
            $(this).css('border','2px solid #2dc16b');
        }
    });


   var Inerrval= setInterval(function(){
        $.ajax({
            url:  '/auct/update?id=<?=$item->catalog_id?>&time=<?=mktime()?>' ,
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            type:'PUT',
            success: function(data)
            {
                $('#auction-members').html(data.text);
                $('#step').html('<?=\app\modules\system\models\Course::getName()?>'+data.price);
                $('#price-info-list-members').val(data.price);


            }
        });
    }, 5000);

    $('.close').click(function () {
        $('.modal').add('.dm-overlay').fadeOut();
        setTimeout(function () {
            $('body').removeClass('body-active');
            clearInterval(Inerrval);
        }, 400);
    });
    $('.close').click(function () {
        $('.modal').add('.dm-overlay').fadeOut();
        setTimeout(function () {
            $('body').removeClass('body-active');
            clearInterval(Inerrval);
        }, 400);
    });

</script>