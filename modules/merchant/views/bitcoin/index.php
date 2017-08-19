
<div id="perfect-money-checkout">
        <?php if($error):?>
<p>  ОШИБКА  -       <?= $error ?></p>
        <?php endif; ?>
    <p>
        Пополнение внутреннего счета на <?= $amount ?> $
    </p>
    <form id="perfect-money-checkout-form" action="/merchant/bitcoin/pay" method="POST">
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <input type="submit" value="Оплать через bitcoin" />
    </form>
</div>