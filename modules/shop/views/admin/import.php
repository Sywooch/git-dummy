<?php
    /**
     * Created by PhpStorm.
     * User: User
     * Date: 21.05.2016
     * Time: 10:36
     */

?>


<h1>Импорт с моего склада</h1>
<form>
<Div class="row">

    <div class="col-md-4">
        <label>Товаров за запрос</label>
        <select name="limit" class="form-control">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
        </select>
    </div>


    <div class="col-md-4">
        <label>Начать с</label>
        <input type="text" class="form-control" name="offset">
    </div>

    <div class="col-md-4" style="padding-top: 23px;">
        <input type="submit" class="btn btn-warning" value="Импортировать">
    </div>

</Div>
</form>
<br><br>
<Div class="row">
    <div class="col-md-12">
        <?php if($msg!='Все товары загружены'):?>
            <?php if(\yii::$app->request->get('limit')): ?>
                <?=$msg?>
                <form>
                    <input type="hidden" value="<?=\yii::$app->request->get('limit')?>" name="limit">
                    <input type="hidden" value="<?=\yii::$app->request->get('offset')+\yii::$app->request->get('limit')?>" name="offset">
                    <input type="submit" value="Продолжить импорт c <?=\yii::$app->request->get('offset')+\yii::$app->request->get('limit')?>" class="btn btn-danger" />
                </form>
            <?php endif; ?>
        <?php else: ?>
        <?=$msg?>
        <?php endif; ?>
    </Div>
</Div>