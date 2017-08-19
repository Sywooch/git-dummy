<?php
use yii\helpers\Html;
?>




<div class="site-error  center-content" style="height:600px;">
    <p>&nbsp;</p><p>&nbsp;</p>
    <h1><?=yii::t('app','Ошибка платежной системы')?></h1>


    <p>
        <?=yii::t('app','Платеж был отменен')?>
    </p>

    <br>
    <br>
    <br> <br>
    <br> <br>
    <br>  <br><br>
</div>

<script>
    /* function footerToBottom() {
     var browserHeight = $(window).height(),
     footerOuterHeight = $('.footer').outerHeight(true),
     preFooterOuterHeight = $('.prefooter').outerHeight(true),
     headerOuterHeight = $('header').outerHeight(true),
     mainHeightMarginPaddingBorder = $('.site-error.center-content').outerHeight(true) - $('.site-error.center-content').height();
     console.log( browserHeight+' - '+footerOuterHeight+' - '+mainHeightMarginPaddingBorder+' - '+headerOuterHeight+' - '+preFooterOuterHeight );
     $('.site-error.center-content').css({
     'min-height': browserHeight - footerOuterHeight*1  -   headerOuterHeight*1 - preFooterOuterHeight*1 -4
     });

     };

     footerToBottom();
     $(window).resize(function () {
     footerToBottom();
     });*/
</script>

