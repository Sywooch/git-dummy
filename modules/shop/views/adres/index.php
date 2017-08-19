<?php

use yii\helpers\Html;
use yii\grid\GridView;
    use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 
?>



<div class="categories">
    <div class="container">
        <div class="block_title">
            <h2>Личный кабинет</h2>
            <div class="clearfix"></div>
        </div>
        <hr>
        <div class="account">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class=""><a href="/user/profile" aria-controls="contacts" >Контактная информация</a></li>
                <li role="presentation" class="active"><a href="/shop-delivery/index" aria-controls="delivery" >Адреса доставки</a></li>
                <li role="presentation"><a href="/wishlist" aria-controls="wishes"  >Список желаний</a></li>
                <li role="presentation" class=""><a href="/basket-history" aria-controls="history"  >История заказов</a></li>
                <li><a href="/user/logout">Выход</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">


                    <div role="tabpanel" class="tab-pane " id="contacts">
                </div>


                <div role="tabpanel" class="tab-pane active" id="delivery">




                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'class'=>'form-horizontal',
                        'action'=> ($model->shop_adres_id)?'/shop-delivery/update?id='.$model->shop_adres_id:'/shop-delivery/create'
                    ]); ?>
                        <div class="col-sm-4">

                            <?php $adreses = $dataProvider->query->all();
                            if(count($adreses)):
                                foreach($adreses as $adres):?>
                                    <div class="form-group">
                                        <div class="radio"> <label>
                                                <input type="radio" class="radio" data-id="<?=$adres->shop_adres_id?>" <?=$adres->isselect?'checked':''?> name="blankRadio" id="blankRadio1" value="option1" >
                                                <span class="name"><?=$adres->name?></span>
                                                <p ><?=$adres->country?>, <?=$adres->oblast?> г. <?=$adres->town?>, <?=$adres->street?> <?=$adres->house?>
                                                    <?=$adres->flat?>
                                                    <?=$adres->post_index?></p>
                                                <p >тел. <?=$adres->phone?></p>
                                            </label> <br/> <a href="?id=<?=$adres->shop_adres_id?>" class="link">Редактировать</a> </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-8 col-sx-12">
                            <p><?=($model->shop_adres_id)?'Редактирование адреса':'Добавление нового адреса'?></p>
                            <div class="col-sm-12 col-md-6 col-xs-12">
                                <?= $form->field($model, 'name') ?>
                                <?= $form->field($model, 'country') ?>
                                <?= $form->field($model, 'town') ?>


                                <div class="form-group" style="margin-left: -15px; margin-right: -15px;">
                                    <div class="col-sm-4 col-xs-12">
                                        <?= $form->field($model, 'house') ?>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <?= $form->field($model, 'flat') ?>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <?= $form->field($model, 'post_index') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xs-12">
                                <?= $form->field($model, 'phone') ?>
                                <?= $form->field($model, 'oblast') ?>
                                <?= $form->field($model, 'street') ?>
                                <div class="form-group"> <button class="btn btn-default" type="submit">сохранить</button> </div>
                            </div>
                        </div>
                    </form>


                    <div class="clearfix"></div>
                </div>

                <div role="tabpanel" class="tab-pane" id="wishes">3...</div>
                <div role="tabpanel" class="tab-pane  " id="history">

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>





 
