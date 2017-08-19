<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('app', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>






<?   echo $this->render('@app/views/site/breadcrumbs',['breadcrumbs'=> ['label'=>$this->title ]] );

?>


<div class="profile-box m-b-50">
    <div class="center-content clearfix">
        <div class="row">
            <div class="col-md-5 col-md-offset-4">
                <div class="">
                    <div class="menu-name tacenter">
                        <?=Yii::t('app', 'Регистрация')?>
                    </div>
                </div>




                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <? //= $form->errorSummary($model); ?>
                <div class="grey-box1 clearfix">



                    <div class="autorisation-row clearfix row col-md-12">
                            <?= $form->field($model, 'name',
                            ['validateOnBlur'=>true,
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>
                                                        <div class=\"clearfix erorr_autorization for-registration-error\">
                                                            <div class=\"col-md-12\">{error}</div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                                                        </div>
                                                    </div>"])
                            ->textInput(['placeholder'=>yii::t('app','Имя:')]);?>

                    </div>
                    <div class="autorisation-row clearfix row col-md-12">
                        <div class="col-md-1">
                            <div class="autorisation-label">

                            </div>
                        </div>
                                <?= $form->field($model, 'username',
                                    ['validateOnBlur'=>true,
                                     'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>
                                                        <div class=\"clearfix erorr_autorization for-registration-error\">
                                                            <div class=\"col-md-12\">{error}</div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                                                        </div>
                                                    </div>"])
                                    ->textInput(['placeholder'=>yii::t('app','Логин:')]);?>

                    </div>
                    <div class="autorisation-row clearfix row col-md-12">
                        <div class="col-md-1">
                            <div class="autorisation-label ">

                            </div>
                        </div>

                        <?= $form->field($model, 'password',
                            ['validateOnBlur'=>true,
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>
                                                        <div class=\"clearfix erorr_autorization for-registration-error\">
                                                            <div class=\"col-md-12\">{error}</div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                                                        </div>
                                                    </div>"])
                            ->passwordInput(['placeholder'=>yii::t('app','Пароль:')]);?>

                    </div>
                    <div class="autorisation-row clearfix row col-md-12">
                        <div class="col-md-1">
                            <div class="autorisation-label  ">

                            </div>
                        </div>

                        <?= $form->field($model, 'password_repeat',
                            ['validateOnBlur'=>true,
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>
                                                        <div class=\"clearfix erorr_autorization for-registration-error \">
                                                            <div class=\"col-md-12\">{error}</div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                                                        </div>
                                                    </div>"])
                            ->passwordInput(['placeholder'=>yii::t('app','Повторите пароль:')]);?>

                    </div>
                    <div class="autorisation-row clearfix row col-md-12">
                        <div class="col-md-1">
                            <div class="autorisation-label ">

                            </div>
                        </div>

                        <?= $form->field($model, 'email',
                            ['validateOnBlur'=>true,
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>
                                                        <div class=\"clearfix erorr_autorization for-registration-error \">
                                                            <div class=\"col-md-12\">{error}</div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                                                        </div>
                                                    </div>"])
                            ->textInput(['placeholder'=>'E-mail:']);?>

                    </div>
                    <div class="autorisation-row clearfix row col-md-12">
                        <div class="col-md-1">
                            <div class="autorisation-label ">

                            </div>
                        </div>
                        <?= $form->field($model, 'email_repeat',
                            ['validateOnBlur'=>true,
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>
                                                        <div class=\"clearfix erorr_autorization for-registration-error \">
                                                            <div class=\"col-md-12\">{error}</div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                                                        </div>
                                                    </div>"])
                            ->textInput(['placeholder'=>yii::t('app','Подтверждение E-mail:')]);?>
                    </div>
                    <div class="autorisation-row clearfix row col-md-12" style="border-bottom: 1px solid #F2F1F1;">
                        <div class="col-md-1">
                            <div class="autorisation-label ">

                            </div>
                        </div>
<?php  if( !$model->place ){
    $geo = new \app\components\sypexgeo\Sypexgeo();

    // get by remote IP
    $geo->get();                // also returned geo data as array
if( $geo->getCountry(\Yii::$app->session->get('language')) && $geo->getCity(\Yii::$app->session->get('language')) )
    $model->place =  $geo->getCountry(\Yii::$app->session->get('language')).', '.$geo->getCity(\Yii::$app->session->get('language'));
else
    $model->place='';
}
   ?>
                        <?= $form->field($model, 'place',
                            [
                             'template' => "<div class=\"col-md-12\">
                                                        <div class=\"autorisation-input main-type-input  \">{input}</div>


                    <div style=\"display: none;\" class=\"clearfix erorr_autorization for-registration-error \">
                         <div class=\"col-md-12\"><div class=\"help-block\">".yii::t('app','Укажите свое месторасположение')."</div></div>
                                                            <a href=\"#\" class=\"close_error\"></a>
                        </div>

 </div>
                                                  "])
                            ->textInput(['placeholder'=>yii::t('app','Местоположение:')]);?>



                    </div>





                    <div class="row ">

                        <div class="clearfix row col-md-12 button-100">
                            <div class="col-md-12">
                                <button id="singup" type="submit" class="button-green button ls-2">
                                    <?=Yii::t('app', 'Зарегистрироваться')?>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="m-b-15 m-b-need">
                            <div class="clearfix row col-md-12 pad-none">
                                <label class="check func-links">
                                    <input type="checkbox" id="agree" />  <?=Yii::t('app', 'Я соглашаюсь с <a class="red-text" href="/terms_of_use.html">правилами сайта</a>, с <a class="red-text " href="/privacy_policy.html">политикой конфиденциальности</a> и  с <a class="red-text "  href="/cookie.html">политикой безопасности cookie</a>')?>

                                </label>
                            </div>

                            <div class="clearfix erorr_autorization  col-md-12 " id="reg-agree" style="display: none; margin-left: 0px; margin-right: 0px;">
                                <div class="col-md-12">
                                    <p class=""><?=yii::t('app','Вы не согласились с условиями пользовательского соглашения')?></p>
                                    <a href="#" class="close_error"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="m-b-15">
                                <div class=" orbox <?=(\yii::$app->language=='en')?'orbox_en':''?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tacenter func-links">
                                <?=Yii::t('app', 'У Вас уже есть аккаунт?')?>  <a class="red-text" href="/user/login"> <?=Yii::t('app', 'Авторизируйтесь')?></a>
                            </div>
                        </div>

                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>



            <!--BOF normal login-->


             <!--   <fieldset class="company">
                    <legend>Данные для входа</legend>
                    <?/*= $form->field($model, 'username') */?>
                    <?/*= $form->field($model, 'email') */?>
                    <?/*= $form->field($model, 'password')->passwordInput() */?>
                    <?/*= $form->field($model, 'password_repeat')->passwordInput() */?>

                </fieldset>



                    <p class="submit">
                        <input type="submit" id="SubmitCreate" name="SubmitCreate" class="button_large" value="Зарегистрироваться как клиент" />

                    </p>



            </form>

-->
            <!--EOF normal login-->
            <div class="clear"></div>
        </div>
    </div>

        </div></div>
<!--<div class="site-signup">
    <h1><?/*= Html::encode($this->title) */?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php /*$form = ActiveForm::begin(['id' => 'form-signup']); */?>
                <?/*= $form->field($model, 'username') */?>
                <?/*= $form->field($model, 'email') */?>
                <?/*= $form->field($model, 'password')->passwordInput() */?>
                <div class="form-group">
                    <?/*= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) */?>
                </div>
                 

        </div>
    </div>
</div>-->
<!--

/*
*/
-->
<?php Yii::$app->view->registerJs('


jQuery(document).ready(function () {
$("#registrationform-place").focusout(function(){

var Main = $(this).parent("div").parent("div").parent("div");
var Div = $(this).parent("div");
var Elem = $(this);

if(!Elem.val()){
Div.addClass("input-error");
Main.find("div.erorr_autorization").css("display","block");

}
else{
Div.removeClass("input-error").addClass("input-succes");
Main.find("div.erorr_autorization").css("display","none");


}

});

$("input").focusout(function(){
var Main = $(this).parent("div").parent("div").parent("div");
var Div = $(this).parent("div");
var Elem = $(this);


setTimeout(
function()
{
if(Main.hasClass("has-error")){
Div.addClass("input-error");
Main.find("div.erorr_autorization").css("display","block");
if(Elem.attr("id")=="registrationform-password" ||
Elem.attr("id")=="registrationform-password_repeat" ||
Elem.attr("id") == "registrationform-email" ||
Elem.attr("id") == "registrationform-email_repeat")
Div.addClass("ok-icon-input ok-false");
}
else
if(Main.hasClass("has-success")){
Div.removeClass("input-error").addClass("input-succes");
Main.find("div.erorr_autorization").css("display","none");
if(Main.hasClass("has-success")){
Main.find("div.erorr_autorization").css("display","none");
if(Elem.attr("id")=="registrationform-password" ||
Elem.attr("id")=="registrationform-password_repeat" ||
Elem.attr("id") == "registrationform-email" ||
Elem.attr("id") == "registrationform-email_repeat")
Div.addClass("ok-icon-input ok-true");
}

}

if(Elem.attr("id")=="registrationform-password" || Elem.attr("id")=="registrationform-password_repeat" )
checkPsw();

if(Elem.attr("id")=="registrationform-email" || Elem.attr("id")=="registrationform-email_repeat" )
checkEmail();
},500);
});

$("input").each(function(){
var Main = $(this).parent("div").parent("div").parent("div");
var Div = $(this).parent("div");
var Elem = $(this);

if(Main.hasClass("has-error")){
Main.find("div.erorr_autorization").css("display","block");
if(Elem.attr("id")=="registrationform-password" ||
Elem.attr("id")=="registrationform-password_repeat" ||
Elem.attr("id") == "registrationform-email" ||
Elem.attr("id") == "registrationform-email_repeat")
Div.addClass("ok-icon-input ok-false").addClass("input-error");
}
else
if(Main.hasClass("has-success")){
Main.find("div.erorr_autorization").css("display","none");
if(Elem.attr("id")=="registrationform-password" ||
Elem.attr("id")=="registrationform-password_repeat" ||
Elem.attr("id") == "registrationform-email" ||
Elem.attr("id") == "registrationform-email_repeat")
Div.addClass("ok-icon-input ok-true").addClass("input-success");
}



});

$("#singup").click(function(){

console.log(" before agree ");
    if( $("#agree").prop("checked") === false) {
        $("#reg-agree").toggle("show");
        return false;
    }
console.log(" before place ");
    if(!$("#registrationform-place").val()){

       $("#registrationform-place").trigger("focusout");
        return false;
    }
console.log(" before ajax ");
    var prefix="#registrationform-";
           $.ajax({
                 url: "/user/registration/validate",
                 type:"POST",
                 data:$("#login-form").serialize(),
                success: function(data) {
                    $(".erorr_autorization").css("display","none");
                    $.each(data,function(el,index){
                        $(prefix+el).parent("div").addClass("input-error").parent("div").children(".erorr_autorization").css("display","block")
                        .children("div").children("div").html(index);
                    });
                    console.log(" before data ");
                    if(data.length==0){
                        jQuery("#login-form").submit();
                        $("#login-form").submit();
                        console.log(" after submit ");
                        }
                }
        })


return true;
});

    $("#agree").click(function(){
        if( $("#agree").prop("checked")) {
            $("#reg-agree").css("display","none");
        }
    })  ;

    $("input[type=text]").keyup(function(){

           var prefix="#registrationform-";
           $.ajax({
                 url: "/user/registration/validate",
                 type:"POST",
                 data:$("#login-form").serialize(),
                success: function(data) {
                    $(".erorr_autorization").css("display","none");
                    $.each(data,function(el,index){
                        $(prefix+el).parent("div").addClass("input-error").parent("div").children(".erorr_autorization").css("display","block")
                        .children("div").children("div").html(index);
                    });
                }
        })
    });

  /*  $("input[type=password]").keyup(function(){
        if($(this).val())
            $(this).parent("div").addClass("input-succes");
        else
            $(this).parent("div").removeClass("input-succes");
    });*/


function checkPsw(){

    if($("#registrationform-password").val()!= "" &&
        $("#registrationform-password").val() == $("#registrationform-password_repeat").val() &&
        $("#registrationform-password").val().length>=8 &&  $("#registrationform-password_repeat").val().length>=8
        ){

        $("#registrationform-password").parent("div").removeClass("ok-false").addClass("ok-true");
        $("#registrationform-password_repeat").parent("div").removeClass("ok-false").addClass("ok-true");
        //input
        $("#registrationform-password").parent("div").removeClass("input-error").addClass("input-succes");
        $("#registrationform-password_repeat").parent("div").removeClass("input-error").addClass("input-succes");
        //error message
        $("#registrationform-password").parent("div").parent("div").find(".erorr_autorization").css("diplay","none");
        $("#registrationform-password_repeat").parent("div").parent("div").find(".erorr_autorization").css("diplay","none");
       }else{
            $("#registrationform-password").parent("div").removeClass("ok-true").addClass("ok-false");
            $("#registrationform-password_repeat").parent("div").removeClass("ok-true").addClass("ok-false");

            $("#registrationform-password").parent("div").removeClass("input-error").addClass("input-error");
            $("#registrationform-password_repeat").parent("div").removeClass("input-error").addClass("input-error");
       }
       if( $("#registrationform-password").parent("div").parent("div").find(".erorr_autorization").css("display") == "block"
        &&  $("#registrationform-password").parent("div").hasClass("ok-true") ){

         $("#registrationform-password").parent("div").parent("div").find(".erorr_autorization").css("display","none");
         $("#registrationform-password_repeat").parent("div").parent("div").find(".erorr_autorization").css("display","none");
         }
}


    function checkEmail(){


$("#registrationform-email").val( $.trim($("#registrationform-email").val()) );
$("#registrationform-email_repeat").val( $.trim($("#registrationform-email_repeat").val()) );

        if($("#registrationform-email").val()!= "" && $("#registrationform-email").val() == $("#registrationform-email_repeat").val()){

            $("#registrationform-email").parent("div").removeClass("ok-false").addClass("ok-true");
            $("#registrationform-email_repeat").parent("div").removeClass("ok-false").addClass("ok-true");
            //input
            $("#registrationform-email").parent("div").removeClass("input-error").addClass("input-succes");
            $("#registrationform-email_repeat").parent("div").removeClass("input-error").addClass("input-succes");
            //error message
            $("#registrationform-email").parent("div").parent("div").find(".erorr_autorization").css("diplay","none");
            $("#registrationform-email_repeat").parent("div").parent("div").find(".erorr_autorization").css("diplay","none");
        }else{
            $("#registrationform-email").parent("div").removeClass("ok-true").addClass("ok-false");
            $("#registrationform-email_repeat").parent("div").removeClass("ok-true").addClass("ok-false");

             $("#registrationform-email").parent("div").removeClass("input-error").addClass("input-error");
            $("#registrationform-email_repeat").parent("div").removeClass("input-error").addClass("input-error");
        }

       if($("#registrationform-email").val()!= "" && $("#registrationform-email").val() == $("#registrationform-email_repeat").val()){

         $("#registrationform-email").parent("div").parent("div").find(".erorr_autorization").css("display","none");
         $("#registrationform-email_repeat").parent("div").parent("div").find(".erorr_autorization").css("display","none");
         }
    }

    });
    ')?>
<style>
    .form-group{margin-bottom: 0px;}
</style>