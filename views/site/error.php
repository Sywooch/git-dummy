<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error  center-content" style="height:600px;">
<p>&nbsp;</p><p>&nbsp;</p>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
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