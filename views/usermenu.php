<div class="profile-left">
    <div class="profile-left-inner">
        <div class="menu-name">
            <?=\yii::t('app',$title)?>
        </div>
        <div class="profile-menu">
            <ul class="clearfix">
                <li class="<?=(yii::$app->controller->id == 'message')?'active':''?>">
                    <a class="profile-menu-icon1 pmi<?=\app\modules\system\models\Notice::Activity(1)?>" href="/message"><?=\yii::t('app','Сообщения')?></a>
                </li>
                
                <li class="<?=(yii::$app->controller->id == 'activity')?'active':''?>">
                    <a class="profile-menu-icon2 pmi<?=\app\modules\system\models\Notice::Activity(2)?>" href="/activity"><?=\yii::t('app','Активность')?></a>
                </li>
                <li class="<?=(yii::$app->controller->id == 'balance')?'active':''?>">
                    <a class="profile-menu-icon3 pmi<?=\app\modules\system\models\Notice::LowBalance(0)?>" href="/balance"><?=\yii::t('app','Баланс')?></a>
                </li>
                <li class="<?=(yii::$app->controller->id == 'profile')?'active':''?>">
                    <a class="profile-menu-icon4 pmi<?=\app\modules\system\models\Notice::emptyAdres(0)?>" href="/user/profile"><?=\yii::t('app','Профиль')?></a>
                </li>
                <li class="<?=(yii::$app->controller->id == 'pshop')?'active':''?>">
                    <a class="profile-menu-icon6 pmi<?=\app\modules\system\models\Notice::newOrder(0)?>" href="/basket-history"><?=\yii::t('app','<span class="hidden-sm hidden-xs">Мои</span> <span class="letter_big">з</span>аказы')?></a>
                </li>
                <li class="hidden-xs hidden-sm">
                    <a class="profile-menu-icon5" href="/user/logout"><?=\yii::t('app','Выход')?></a>
                </li>
            </ul>
        </div>
    </div>
</div>