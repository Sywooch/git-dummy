<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Contact';
$breadcrumbs[] =['label'=> $this->title];
?>




<?   // echo $this->render('../site/breadcrumbs',['breadcrumbs'=> $breadcrumbs] )?>



<style>
    .form-group{padding-bottom: 0px; margin-bottom: 0px; height: 85px; }
</style>
<div class="rt-grid-8 ">
    <div class="rt-block">
        <div id="rt-mainbody">
            <div class="component-content">
                <!-- Start K2 Item Layout -->
                <span id="startOfPageId82"></span>
                <div id="k2Container" class="itemView">
                    <!-- Plugins: BeforeDisplay -->
                    <!-- K2 Plugins: K2BeforeDisplay -->
                    <!-- Item Header START -->
                    <div class="itemHeader">
                        <!-- Item title -->
                        <h2 class="itemTitle">
                           <?/*=\yii::t('app','Контакты')*/?> <?=$data->static_page_name?>
                        </h2>
                        <!-- Item Rating -->
                        <!-- Item Author -->
                        <!-- Item category -->
                        <!-- Date created -->
                        <!-- Anchor link to comments below - if enabled -->
                    </div>
                    <!-- Item Header END -->
                    <!-- Plugins: AfterDisplayTitle -->
                    <!-- K2 Plugins: K2AfterDisplayTitle -->
                    <!-- Item Body START-->
                    <div class="itemBody">
                        <!-- Plugins: BeforeDisplayContent -->
                        <!-- K2 Plugins: K2BeforeDisplayContent -->
                        <!-- Item Image -->
                        <!-- Item introtext -->


                        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                            <div class="alert alert-success">
                                <?=\yii::t('app','Благодарим за ваше  сообщение!  Вам ответят в ближайшие дни.')?>
                            </div>


                        <?php else: ?>


                            <?php $form = ActiveForm::begin(['id' => 'form']); ?>
                            <?=$page->static_page_text?>



                            <!--<fieldset id="contactUsForm">
                                <legend> <?/*=\yii::t('app','Написать нам')*/?></legend>


                                <?/*= $form->field($model, 'name',[
                                    'inputOptions' => [
                                        'placeholder' => $model->getAttributeLabel('name'),
                                    ],
                                ] ) */?>
                                <?/*= $form->field($model, 'email',[
                                    'inputOptions' => [
                                        'placeholder' => $model->getAttributeLabel('email'),
                                    ],
                                    //'template' => "{input}\n{hint}\n{error}"
                                ] ) */?>

                                <?/*= $form->field($model, 'subject',[
                                    'inputOptions' => [
                                        'placeholder' => $model->getAttributeLabel('subject'),
                                    ],
                                    //'template' => "{input}\n{hint}\n{error}"
                                ] ) */?>


                                <?/*= $form->field($model, 'body',[
                                    'inputOptions' => [
                                        'placeholder' => $model->getAttributeLabel('body'),
                                        'style'=>'width:100%',
                                    ],
                                    //'template' => "<label class='name'>{input}\n{hint}\n{error}</label>"
                                ] )->textArea(['rows' => 4]) */?>


                            </fieldset>
                            <div class="clr"></div>

                            <button type="submit" title="<?/*=\yii::t('app','Написать нам')*/?>" style="margin-top: 90px;" class="button btn-cart"><span><span><?/*=\yii::t('app','Отправить сообщение')*/?></span></span></button>
                            --><?php /*ActiveForm::end(); */?>

                        <?php endif; ?>
                        <div class="clr"></div>
                        <!-- Item extra fields -->
                        <!-- Plugins: AfterDisplayContent -->
                        <!-- K2 Plugins: K2AfterDisplayContent -->
                        <div class="clr"></div>
                    </div>
                    <!-- Item Body END-->
                    <!-- Item Social Buttons -->
                    <!-- Social sharing -->
                    <div class="clr"></div>
                    <!-- Plugins: AfterDisplay -->
                    <!-- K2 Plugins: K2AfterDisplay -->
                    <!--<div class="itemBackToTop">
                        <a class="k2Anchor" href="/joomla_45309/index.php/for-items/item/82-how-it-works#startOfPageId82">
                            back to top			</a>
                    </div>
                    <div class="clr"></div>-->
                </div>
                <!-- End K2 Item Layout -->
                <!-- JoomlaWorks "K2" (v2.6.6) | Learn more about K2 at http://getk2.org -->
            </div>
        </div>
    </div>
</div>






    
    