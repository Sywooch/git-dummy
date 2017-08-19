<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\Url;


    $this->title = Yii::t('app', 'Авторизоваться');
$this->params['breadcrumbs'][] = $this->title;
?>



<?    echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>$this->title ]] );
$error_class="";

?>



<div class="profile-box m-b-50">
    <div class="center-content clearfix">
        <div class="row">
            <div class="menu-name tacenter">
                <?=Yii::t('app', 'Авторизация')?>                                </div>


        

                <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class'=>"authorisation-form"] ]);
                if($model->getErrors()){
                    $error_class="input-error";
                }?>
                <div class="col-md-5 col-md-offset-4">
                    <div class="col-md-10">

                    </div>
                    <div class="grey-box1 clearfix">




                        <div class="autorisation-row clearfix row col-md-12">
                            <div class="col-md-1">
                                <div class="autorisation-label">

                                </div>
                            </div>
                            <?= $form->field($model, 'identity',
                                ['validateOnBlur'=>true,
                                 'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input ".$error_class." \">{input}</div>
                                                    </div>"])
                                ->textInput(['placeholder'=>\yii::t('app','Логин:'), 'value'=>Yii::$app->request->cookies->getValue('name')   ]);?>

                        </div>





                        <div class="autorisation-row clearfix row col-md-12">
                            <div class="col-md-0">
                                <div class="autorisation-label ">

                                </div>
                            </div>
                            <?= $form->field($model, 'password',
                                ['validateOnBlur'=>true,
                                 'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input-pswd  pass-holder main-type-input ".$error_class." \">

                                                            {input}
                                                        <span class=\"pass-holder-button forgotten_password\">".yii::t('app','Забыли?')."</span>
                                                        </div>

                                                    </div>"])
                                ->passwordInput(['placeholder'=>\yii::t('app','Пароль:')]);?>

                        </div>

                        <?php if($model->hasErrors()):?>
                        <div class="row">
                            <div class="clearfix col-md-12 erorr_autorization" style="display: block; margin-left: 0px; margin-right: 0px;">
                                <div class="col-md-12" style="margin-left:0px;">
                                    <p class=""><?=\yii::t('app','Неправильно введен «Логин» или «Пароль»!')?></p>
                                    <a href="#" class="close_error"></a>
                                </div>
                            </div>
                        </div>



                        <?php endif; ?>




                        <div class="row">
                            <div class="clearfix row col-md-12 button-100">
                                <div class="col-md-12">
                                    <button class="button-green button ls-2">
                                        <?=Yii::t('app', 'Авторизация')?>
                                    </button>
                                </div>

                            </div>
                            <div class="m-b-15 m-b-need">
                                <div class="clearfix row col-md-12 pad-none">
                                    <label class="check func-links">
                                        <input id="loginform-remember" type="checkbox"  name="LoginForm[rememberMe]" value="1">
                                        <?=\yii::t('app','Запомнить меня на этом компьютере')?>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m-b-15 m-b-my">
                                    <div class=" orbox <?=(\yii::$app->language=='en')?'orbox_en':''?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tacenter func-links">
                                    <?=Yii::t('app', 'У Вас нет аккаунта?')?> <a class="red-text" href="/user/registration"> <?=Yii::t('app', 'Зарегистрируйтесь')?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form></div>

    </div>
</div>


<div class="modal m2">
    <div class="bg-modal"></div>
    <div class="modal-tb">

        <div class="modal-con">
            <div class="close"></div>
            <form action="#" id="result">
                <p ><?=\yii::t('app','Введите емейл для восстановления пароля и система автоматически отправит его Вам на почту. Благодарим за использование нашего сервиса.')?></p>
                <div class="line_form">
                    <label for="for_popup_email">Email:</label><input type="email" name="email" id="for_popup_email" placeholder='mail@examle.com'>
                </div>
                <input type="submit" class="email-submit" value="<?=\yii::t('app','Отправить')?>">
            </form>
        </div>
    </div>
</div>
<script>
    $('.email-submit').click(function(){

        jQuery.ajax({
            url: "<?=Url::to( ['/user/forgot'])?>",
            type: "POST",
            headers :{ "X-CSRF-Token": $('meta[name=csrf-token]').attr("content") },
            data:{'PasswordResetRequestForm[email]':$("#for_popup_email").val()},
            success: function(data) {

                $('#result').css('color','red').html('<div class="popup-error_forgot_password">'+data+'</div>'+'<input type="submit" class="email-submit close-button" value="OK">');

                $('.close-button').click(function(){
                    $('.modal').add('.dm-overlay').fadeOut();
                    setTimeout(function() {
                        $('body').removeClass('body-active');
                    }, 400);
                    return false;
                })
            }
        });

        return false;

    });

   $('input[type=text]').keyup(function(){
        if($(this).val())
            $(this).parent('div').addClass('input-succes');
        else
            $(this).parent('div').removeClass('input-succes');
    });
    $('input[type=password]').keyup(function(){
        if($(this).val())
            $(this).parent('div').addClass('input-succes');
        else
            $(this).parent('div').removeClass('input-succes');
    });

    $('#loginform-identity').keyup(function(){
        if($('#loginform-remember').prop('checked'))
            $.cookie("name", $(this).val(), { expires : 10 });
    });



    $('#loginform-remember').click(function(){

        if($('#loginform-remember').prop('checked') ){
            $.cookie("remeber", 1, { expires : 10 });
            $.cookie("name", $('#loginform-identity').val(), { expires : 10 });
        } else {
            $.cookie("name",null, { expires: -1 });
            $.cookie("remeber",null, { expires: -1 });
        }

    });

    $( document ).ready(function() {
        if ($.cookie("name"))
            $('#loginform-identity').val($.cookie("name"));
        if ($.cookie("remeber")) {
            $('#loginform-remember').prop('checked', true);
        }
    });

    <?php if($_GET['reset']==1):?>
    $.cookie("name",null, { expires: -1 });
    $.cookie("remeber",null, { expires: -1 });
    <?php endif; ?>


</script>
<style>
    .form-group{margin-bottom: 0px;}
</style>