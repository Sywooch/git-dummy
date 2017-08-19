<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = Yii::t('app', 'Профиль');
    $this->params['breadcrumbs'][] = ['url'=>'/user/profile', 'label'=>yii::t('app','Мой аккаунт')];
$this->params['breadcrumbs'][] = $this->title;


?>

<script src="/assets/plupload/js/plupload.full.min.js"></script>
<script src="/assets/plupload/js/plupload_app_one.js"></script>
<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> $this->params['breadcrumbs'] ] ); ?>







<div class="profile-box m-b-50">
    <div class="center-content clearfix">
        <?    echo $this->render('@app/views/usermenu',['title'=>Yii::t('app', 'Профайл') ]); ?>
        <div class="profile-right">


            <?php if(Yii::$app->session->hasFlash('registration')): ?>
                <div class="notification_text_stock">
                   <?= \app\modules\system\models\TextWidget::getTpl('message_after_registration')?>
                </div>
            <?php endif; ?>


            <?php if(Yii::$app->session->hasFlash('email')): ?>
                <div class="notification_text_stock">
                    <?= Yii::$app->session->getFlash('email') ?>
                </div>
            <?php endif; ?>






                <? $text=\app\modules\system\models\Notice::emptyAdres(1);
                if($text):?>
                <div class="notification_text_stock"><?=$text?></div>
                <?php endif;?>

                <?  $text=\app\modules\system\models\Notice::approveEmail(1);
                if($text):?>
                    <div class="notification_text_stock"><?=$text?></div>
                <?php endif;?>


            <div style="display: none" id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>








            <pre  style="display: none"  id="console"></pre>



            <div class="profile-options clearfix ">



                <div class="profile-user-avatar">
                    <?php    $img = app\modules\system\models\Pictures::getImages('user',$model->id); ?>
                    <?php    $file=(new app\components\ImageComponent)->crop($img[0],240,240);  ?>


                    <div  id="container">
                        <a id="pickfiles" href="javascript:;"  >
                            <span><?=Yii::t('app', 'Изменить аватар');?></span>
                        </a>
                        <!-- <a id="uploadfiles" href="javascript:;">[Upload files]</a>-->
                    </div>

                    <img src="<?=($file != 'no thound file' )?$file:'/verst/img/userprofile.png'?>" alt="" />
                    <?php
                        use app\components\widgets\plupload\PluploadOneWidget;
                        echo  PluploadOneWidget::widget(['tableName' => $model->tableName(), 'id'=>$model->id ]);
                    ?>


                </div>
                <div class="profile-user-settings">


                    <?php


                        $form = ActiveForm::begin(['id' => 'login-form']);?>
                        <div class="profile-user-settings-row clearfix jNice">
                            <div class="profile-user-settings-row-name">
                                <?=Yii::t('app', 'Имя');?>:
                            </div>
                            <div class="profile-user-settings-row-value text ">
                                <span><?=$model->name?></span> <a class="pus-value-red" href="javascript:void()"></a>
                            </div>

                                <?= $form->field($model, 'name',
                                      [ 'options'=>['class'=>'profile-user-settings-row-value input'],
                                        'template' => "{input}"]
                                )->textInput(['class'=>'password','value'=>$model->name]); ?>

                            <div class="clearfix erorr_autorization for-profile-error" >
                                <div class="col-md-12"><p><?=$errors['place'][0]?></p></div>
                                <a href="#" class="close_error"></a>
                            </div>

                        </div>
                        <div class="profile-user-settings-row clearfix">
                            <div class="profile-user-settings-row-name text">
                                <?=Yii::t('app', 'Логин');?>:
                            </div>
                            <div class="profile-user-settings-row-value">
                                <span><?=$model->username?></span>
                            </div>
                        </div>
                        <div class="profile-user-settings-row clearfix jNice">
                            <div class="profile-user-settings-row-name">
                                <?=Yii::t('app', 'Пароль');?>:
                            </div>
                            <div class="profile-user-settings-row-value  ok-icon-input">
                                <input type="password"  name="password"  class="password" id="password" value="password" />
                            </div>

                            <div class="clearfix erorr_autorization for-profile-error"  id="password-div">
                            <div class="col-md-12"><p>{error}</p></div>

                            </div>


                        </div>
                        <div class="profile-user-settings-row clearfix jNice">
                            <div class="profile-user-settings-row-name ">
                                <?=Yii::t('app', 'Повторите пароль');?>:
                            </div>
                            <div class="profile-user-settings-row-value ok-icon-input">
                                <input type="password" name="repassword" class="repassword jNice-error "   value="password"  id="repassword" />

                            </div>

                            <div class="clearfix erorr_autorization for-profile-error" id="repassword-div">
                            <div class="col-md-12"><p>{error}</p></div>
                            <a href="#" class="close_error"></a>
                            </div>

                        </div>
                        <div class="profile-user-settings-row clearfix">
                            <div class="profile-user-settings-row-name ">
                                E-mail:
                            </div>
                            <div class="profile-user-settings-row-value">
                                <span><?=$model->email?></span>
                            </div>
                        </div>
                        <div class="profile-user-settings-row clearfix jNice">
                            <div class="profile-user-settings-row-name ">
                                <?=Yii::t('app', 'Местоположение');?>:
                            </div>
                            <div class="profile-user-settings-row-value text">
                                <span><?=($model->place)?$model->place:Yii::t('app', 'Местоположение')?></span><a class="pus-value-red" href="javascript:void()"></a>
                            </div>

                            <?= $form->field($model, 'place',
                                [ 'options'=>['class'=>'profile-user-settings-row-value input'],
                                  'template' => "{input}"] )->textInput(['class'=>'password','value'=>$model->place]); ?>

                            <div class="clearfix erorr_autorization for-profile-error" >
                                <div class="col-md-12"><p><?=$errors['place'][0]?></p></div>
                                <a href="#" class="close_error"></a>
                            </div>

                        </div>
                        <div class="profile-user-settings-row clearfix jNice">
                            <div class="profile-user-settings-row-name ">
                                <?=Yii::t('app', 'Адрес доставки');?>:
                            </div>
                            <div class="profile-user-settings-row-value text width-all">
                                <span><?=$model->adres?></span> <a class="pus-value-red" href="javascript:void()"></a>
                            </div>

                            <div class="profile-user-settings-row-value text width640">
                                <span><?=$model->adres?$model->adres:Yii::t('app', 'Укажите адрес доставки')?></span> <a class="pus-value-red" href="javascript:void()"></a>
                            </div>

                            <?= $form->field($model, 'adres',
                                [ 'options'=>['class'=>'profile-user-settings-row-value input'],
                                  'template' => "{input}"] )->textInput(['class'=>'password','value'=>$model->adres]); ?>

                            <div class="clearfix erorr_autorization for-profile-error" >
                                <div class="col-md-12"><p><?=$errors['place'][0]?></p></div>
                                <a href="#" class="close_error"></a>
                            </div>
                        </div>

                    <div class="profile-user-settings-row clearfix jNice">
                        <div class="profile-user-settings-row-name ">
                            <?=Yii::t('app', 'Почтовый индекс');?>:
                        </div>
                        <div class="profile-user-settings-row-value text width-all">
                            <span><?=$model->index?></span> <a class="pus-value-red" href="javascript:void()"></a>
                        </div>

                        <div class="profile-user-settings-row-value text width640">
                            <span><?=$model->index?$model->index:Yii::t('app', 'Почтовый индекс')?></span> <a class="pus-value-red" href="javascript:void()"></a>
                        </div>

                        <?= $form->field($model, 'index',
                            [ 'options'=>['class'=>'profile-user-settings-row-value input'],
                                'template' => "{input}"] )->textInput(['class'=>'password','value'=>$model->index]); ?>

                        <div class="clearfix erorr_autorization for-profile-error" >
                            <div class="col-md-12"><p><?=$errors['place'][0]?></p></div>
                            <a href="#" class="close_error"></a>
                        </div>
                    </div>

                        <div class="profile-user-settings-row clearfix jNice">
                            <div class="profile-user-settings-row-name ">
                                <?=Yii::t('app', 'Телефон');?>:
                            </div>
                            <div class="profile-user-settings-row-value text width-all">
                                <span><?=$model->phone?></span><a class="pus-value-red" href="javascript:void()"></a>
                            </div>

                            <div class="profile-user-settings-row-value  text  width640">
                                <span><?=$model->phone?$model->phone:Yii::t('app', 'Укажите телефон')?></span><a class="pus-value-red" href="javascript:void()"></a>
                            </div>

                            <?= $form->field($model, 'phone',
                                [ 'options'=>['class'=>'profile-user-settings-row-value input'],
                                  'template' => "{input}"] )->textInput(['class'=>'password','value'=>$model->phone]); ?>

                            <div class="clearfix erorr_autorization for-profile-error" >
                                <div class="col-md-12"><p><?=$errors['place'][0]?></p></div>
                                <a href="#" class="close_error"></a>
                            </div>

                        </div>
                        <div class="profile-user-settings-save">
                            <button class="button button-green"><?=Yii::t('app', 'Сохранить изменения');?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .input{ display: none}
    .erorr_autorization{ display: none}
</style>


<script>
    if($( window ).width() > 640){
        $(".width640").remove();
    }else{
        $(".width-all").remove();
    }



    var prefix="#user-";
    $("input[type=text]").keyup(function(){


        $.ajax({
            url: "/user/profile/validate",
            type:"POST",
            data:$("#login-form").serialize(),
            success: function(data) {
                $(".erorr_autorization").css("display","none");
                $.each(data,function(el,index){
                    $(prefix+el).parent("div").parent("div").children(".erorr_autorization").css("display","block")
                        .children("div").children("p").html(index);
                });
            }
        })
    });
    $.ajax({
        url: "/user/profile/validate",
        type:"POST",
        data:$("#login-form").serialize(),
        success: function(data) {
            $(".erorr_autorization").css("display","none");
            $.each(data,function(el,index){
                $(prefix+el).parent("div").parent("div").children(".erorr_autorization").css("display","block")
                    .children("div").children("p").html(index);
            });
        }
    })


    $(".pus-value-red").click(function(){
        var Text=$(this).parent("div"),
            Input=Text.parent("div").find(".input");
        Text.toggle("hide");
        Input.toggle("show");
        if(Text.find('span').html()!='<?=Yii::t('app', 'Укажите телефон')?>'
            && Text.find('span').html()!='<?=Yii::t('app', 'Укажите адрес доставки')?>'
            && Text.find('span').html()!='<?=Yii::t('app', 'Местоположение')?>'  )
        Input.children("input").val(Text.find('span').html());
        //Input.children("input").focus();

    });
    $(".input input").focusout(function(){
        var val=$(this).val(),
            Input=$(this).parent("div"),
            Text=Input.parent("div").find(".text");

        //alert(Text.attr('class'));
        Input.toggle("hide");
        Text.toggle("show");
        if(val)
            Text.children("span").html(val);
    });


    /*<div class="clearfix erorr_autorization for-profile-error">
    <div class="col-md-12">{error}</div>
    <a href="#" class="close_error"></a>
    </div>*/





    $('#password').keyup(function(){
        var Error=$('#password-div'),
            password=$('#password').val(),
            repassword=$('#repassword').val();
          checkpsw(password,repassword,Error);
    });

    $('#repassword').keyup(function(){
        var Error=$('#repassword-div'),
            password=$('#password').val(),
            repassword=$('#repassword').val();

        checkpsw(password,repassword,Error);
    });

    function checkpsw(password,repassword,Error){

        if( password.length<8)
            error= ('<p><?=yii::t('app','Пароль должен быть больше 8 символов')?></p>');
        else
            if( password != repassword){
                error = ('<p><?=yii::t('app','Пароли не совпадают')?></p>');
                $('#repassword-div').children('div').html(error);
                $('#password-div').children('div').html(error);

                $('#password').parent('div').removeClass('ok-true').addClass('ok-false')
                    .removeClass('input-succes').addClass('input-error');
                $('#repassword').parent('div').removeClass('ok-true').addClass('ok-false')
                    .removeClass('input-succes').addClass('input-error');

                if ( $('#password-div').css('display') == 'none')
                    $('#password-div').toggle('show');
                if ($('#repassword-div').css('display') == 'none')
                    $('#repassword-div').toggle('show');
            }



        if(error){

            $('#password').parent('div').removeClass('ok-true').addClass('ok-false')
                .removeClass('input-succes').addClass('input-error');
            $('#repassword').parent('div').removeClass('ok-true').addClass('ok-false')
                .removeClass('input-succes').addClass('input-error');


            if(Error.css('display')=='none'){
                Error.toggle('show').parent('div').find('.profile-user-settings-row-value').
                    removeClass('ok-true').addClass('ok-false').
                    removeClass('input-succes').addClass('input-error');
            }
            Error.children('div').html(error);
        } else {
                if (Error.css('display') == 'block') {
                    Error.toggle('hide');
                    Error.toggle('show').parent('div').find('.profile-user-settings-row-value').
                        removeClass('ok-true').addClass('ok-false').
                        removeClass('input-succes').addClass('input-error');
                }
        }

        if( password == repassword){
            $('#password-div').css('display','none');
            $('#repassword-div').css('display','none');
            $('#password').parent('div').addClass('ok-true').removeClass('ok-false')
                .addClass('input-succes').removeClass('input-error');
            $('#repassword').parent('div').addClass('ok-true').removeClass('ok-false')
                .addClass('input-succes').removeClass('input-error');
        }

    }






</script>
<?php Yii::$app->view->registerJs('

');?>


