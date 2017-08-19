<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
    

  

    
    
     <div class="container" style="padding-bottom:30px;">
      <div class="row">
        <div class="grid_8">
          <h3><?=$page->static_page_name?></h3>
          <div class="map">
            <div class="row">
              
              <div class="grid_3">
              <?=$page->static_page_text?>
              
              
             </div>
            </div>
          </div>
        </div>
        <div class="grid_4">
          <h3>Бронирование </h3>
            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
               Благодарим за ваше  сообщение!  Вам ответят в ближайшие дни.
            </div>
        
           
            <?php else: ?>
            
				   <?php $form = ActiveForm::begin(['id' => 'form']); ?>
                         
                         
                        <?= $form->field($model, 'name',[
                                                        'inputOptions' => [        
                                                                         'placeholder' => $model->getAttributeLabel('name'),    
                                                                          ],
                                                        'template' => "<label class='name'>{input}\n{hint}\n{error}</label>"] ) ?>
                                                        
                        <?= $form->field($model, 'email',[
                                                        'inputOptions' => [        
                                                                         'placeholder' => $model->getAttributeLabel('email'),    
                                                                          ],
                                                        'template' => "<label class='name'>{input}\n{hint}\n{error}</label>"] ) ?>
                                                        
                        <?= $form->field($model, 'subject',[
                                                        'inputOptions' => [        
                                                                         'placeholder' => $model->getAttributeLabel('subject'),    
                                                                          ],
                                                        'template' => "<label class='name'>{input}\n{hint}\n{error}</label>"] ) ?>
                                                        
                        <?= $form->field($model, 'body',[
                                                        'inputOptions' => [        
                                                                         'placeholder' => $model->getAttributeLabel('body'),    
                                                                          ],
                                                        'template' => "<label class='name'>{input}\n{hint}\n{error}</label>"] )->textArea(['rows' => 6]) ?>
                        <? # $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                           # 'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                           #]) ?>
                          <div class="clear"></div>
                          <div class="btns">
                          <a href="#" data-type="submit" class="btn" onClick="$('#form').submit();">Send</a></div>
                          </div>
                    <?php ActiveForm::end(); ?>
          
            <?php endif; ?>
 
        </div>
      </div>
    </div>
    
    
    
 

   
