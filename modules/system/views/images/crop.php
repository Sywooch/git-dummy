
<?
    $cat=\app\modules\catalog\models\Catalog::find()->where( [ 'catalog_id' => (int) $_GET['cid'] ] )->one();
   $width_sel=explode('x',yii::$app->request->get('select','320x355'));

#Yii::$app->view->registerJsFile( Yii::$app->params['sitehost'].'assets/jcrop/js/jquery.min.js');
Yii::$app->view->registerJsFile( Yii::$app->params['sitehost'].'assets/jcrop/js/jquery.Jcrop.min.js',
					[ 
					'depends' => ['yii\web\YiiAsset',       'yii\bootstrap\BootstrapAsset',]
					]);
/*    Yii::$app->view->registerJsFile( Yii::$app->params['sitehost'].'assets/admin/jpicker/jpicker-1.1.6.min.js',
        [
            'depends' => ['yii\web\YiiAsset',       'yii\bootstrap\BootstrapAsset',]
        ]);
					*/
Yii::$app->view->registerJs("  


 
var x1, y1, x2, y2;
var jcrop_api;

jQuery(function($){             

	$('#target_small').Jcrop({
		onChange:   showCoords,
		onSelect:   showCoords,

	},function(){		
		jcrop_api = this;

		  var wh = $('#size_lock').val().split('x');
        var screen=".yii::$app->request->get('width').";

       /* if(wh[0]=='960' && screen < wh[0]){
        console.log( $('#size_lock').val() );
        console.log( screen+' < '+ wh[0] );

          deviationPercentage = ((wh[0] - screen) / (0.01 * wh[0])) / 100;
          wh[0] = screen;
          wh[1] = wh[1] - (wh[1]  * deviationPercentage);
            console.log( wh[0]+'  -  '+ wh[1] );
        }*/
        if(wh[0]=='960')
        jcrop_api.setOptions( {setSelect:   [ 0, 0, wh[0],wh[1]/*".$width_sel[0].", ".$width_sel[1]."*/ ],aspectRatio: wh[0]/wh[1] });
        else
		jcrop_api.setOptions( {setSelect:   [ 0, 0, wh[0],wh[1]/*".$width_sel[0].", ".$width_sel[1]."*/ ],	});

		jcrop_api.focus();
	});




	// Ñíÿòü âûäåëåíèå	
    $('#release').click(function(e) {		
		release();
    });   
	// Ñîáëþäàòü ïðîïîðöèè
    $('#ar_lock').change(function(e) {
		jcrop_api.setOptions(this.checked?
			{ aspectRatio: 4/3 }: { aspectRatio: 0 });
		jcrop_api.focus();
    });
   // Óñòàíîâêà ìèíèìàëüíîé/ìàêñèìàëüíîé øèðèíû è âûñîòû

   $('#size_lock').change(function(e) {


        var wh = $(this).val().split('x');
        var screen=".yii::$app->request->get('width').";

       /* if( wh[0]=='960' && screen < wh[0]){
        console.log( $(this).val() );
        console.log( screen+' < '+ wh[0] );

          deviationPercentage = ((wh[0] - screen) / (0.01 * wh[0])) / 100;
          wh[0] = screen;
          wh[1] = wh[1] - (wh[1]  * deviationPercentage);
            console.log( wh[0]+'  -  '+ wh[1] );
        }*/
		jcrop_api.setOptions( {setSelect:   [ 0, 0, wh[0], wh[1] ],	});
		jcrop_api.focus();

    });
	// Èçìåíåíèå êîîðäèíàò
	function showCoords(c){
		x1 = c.x; $('#x1').val(c.x);		
		y1 = c.y; $('#y1').val(c.y);		
		x2 = c.x2; $('#x2').val(c.x2);		
		y2 = c.y2; $('#y2').val(c.y2);

		
		$('#w').val(c.w);
		$('#h').val(c.h);
		
		if(c.w > 0 && c.h > 0){
			$('#crop').show();
		}else{
			$('#crop').hide();
		}
		
	}

	 $('.tabs_a').click(function(){
            $('#type').val($(this).attr('data-type'));

            if($('#type').val()!='original')
            $('#target_small').Jcrop({
                onChange:   showCoords,
                onSelect:   showCoords,

            },function(){
                jcrop_api = this;
            });
             else
            $('#target').Jcrop({
                onChange:   showCoords,
                onSelect:   showCoords
            },function(){
                jcrop_api = this;
            });

    });

});



function release(){
	jcrop_api.release();
	$('#crop').hide();
}
// Îáðåçêà èçîáðàæåíèå è âûâîä ðåçóëüòàòà
jQuery(function($){
	$('#crop').click(function(e) {
	 
	 $.ajax({
		 url : '/system/images/make_crop?id=".$data['id']."',
		 type:'POST',
		 headers :{ 'X-CSRF-Token': yii.getCsrfToken() },
		 data:{'x1': x1, 'x2': x2, 'y1': y1, 'y2': y2, 'type': '".yii::$app->request->get('width',150).'x'.yii::$app->request->get('width',150)."','crop':$('#size_lock').val()/*$('#type').val()*/},
		  success:  function(file) {


			 /*switch($('#size_lock').val()){
			 case '320x355':text='scaled to 320px × 355px - горячие товары';break;
			 case '90x55':text='scaled to 90px × 55px - превью для слайдеров';break;
			 case '321x221':text='scaled to 321px × 221px - популярные товары';break;
			 case '270x236':text='scaled to 270px × 236px - похожие товары';break;
			 case '960x333':text='scaled to 1920px × 667px - слайдер товары';break;
			 }*/

			$('#cropresult').html('').html(file);//text+'<img src=\"'+file+'\" class=\"mini\">'
			release();
		  }
		});
		
		
		 
		
    });



});




");?>



<link rel="stylesheet" href="/assets/jcrop/css/jquery.Jcrop.css" type="text/css" />
<style type="text/css">
#crop{
	display:none;
}
#cropresult{
	border:2px solid #ddd;
}
.mini{
	margin:5px;
}
</style>




 <?
 use yii\helpers\Html;
use yii\grid\GridView;

$name = (new app\components\ImageComponent)->getname($data);

$original_file=str_replace(".","-original.",$name);

if( is_file( \Yii::$app->basePath.'/files/'.$original_file ) )
	$name = $original_file;
	
?>
<h2>Ручная загрузка превьюшки (<?=$data['extension']?>) </h2>
<p>Выберите размер в "Выберите вид превьюшки" и нажмите закачать</p>
<?= Html::beginForm(['/system/images/crop',
    'id' => yii::$app->request->get('id'),
    'cid'=>yii::$app->request->get('cid')], 'post', ['enctype' => 'multipart/form-data']) ?>
<div class="row">
    <div class="col-md-3">

        <select name="posttype" class="form-control">
            <option value="100x100" <?=yii::$app->request->get('select')=='100x100'?'selected':''?>>Выберите вид превьюхи</option>
            <option value="320x355" <?=yii::$app->request->get('select')=='320x355'?'selected':''?>>scaled to 320px × 355px - горячие товары</option>
            <option value="316x256" <?=yii::$app->request->get('select')=='316x256'?'selected':''?>>scaled to 316px × 256px - окно победителя</option>
            <option value="321x221" <?=yii::$app->request->get('select')=='321x221'?'selected':''?>>scaled to 321px × 221px - популярные товары</option>
            <option value="270x236" <?=yii::$app->request->get('select')=='270x236'?'selected':''?>>scaled to 270px × 236px - похожие товары</option>
            <option value="350x350" <?=yii::$app->request->get('select')=='350x350'?'selected':''?>>scaled to 350px × 350px - слайдер</option>
            <!--<option value="470x450" <?/*=yii::$app->request->get('select')=='470x450'?'selected':''*/?>>scaled to 470px × 450px - слайдер зум</option>-->
          <!--  <option value="orginal" <?/*=yii::$app->request->get('select')=='orginal'?'selected':''*/?>>Оригинальная</option>-->
            <option value="1000x1000" <?=yii::$app->request->get('select')=='1000x1000'?'selected':''?>>scaled to 1000px × 1000px -  зум, слайдер зума</option>
            <option value="1920x667" <?=yii::$app->request->get('select')=='1920x667'?'selected':''?>>scaled to 1920px × 667px - слайдер товары</option>
        </select>

</div> <div class="col-md-3">

<input type="file"   name="file">
    </div>
    <div class="col-md-3">
<input  class="btn btn-success" type="submit" value="Закачать превьюшку">
        </div>
</div>
</form>

<h1>Выделение нужной области изображения</h1>
<table><tr><td valign="top" style="padding-right: 10px;">


            <button id="release" class="btn btn-success">Убрать выделение</button>
            <button id="crop" class="btn btn-warning">Обрезать</button>

            <div class="optlist offset">
                <label style="display: none"><input type="checkbox" id="ar_lock" />Соблюдать пропорции (4:3)</label>
                <!--    <label><input type="checkbox" id="size_lock" checked />min/max размер (700x700/1500x1500)</label>-->
                <select
                    onchange="window.location='?cid=<?=yii::$app->request->get('cid')?>&id=<?=yii::$app->request->get('id')?>&width='+$('#widthdd').val()+'&select='+$(this).val()" id="size_lock" class="form-control">
                    <option value="100x100" <?=yii::$app->request->get('select')=='100x100'?'selected':''?>>Выберите вид превьюхи</option>
                    <option value="320x355" <?=yii::$app->request->get('select')=='320x355'?'selected':''?>>scaled to 320px × 355px - горячие товары</option>
                    <option value="316x256" <?=yii::$app->request->get('select')=='316x256'?'selected':''?>>scaled to 316px × 256px - окно победителя</option>
                    <option value="321x221" <?=yii::$app->request->get('select')=='321x221'?'selected':''?>>scaled to 321px × 221px - популярные товары</option>
                    <option value="270x236" <?=yii::$app->request->get('select')=='270x236'?'selected':''?>>scaled to 270px × 236px - похожие товары</option>
                    <option value="350x350" <?=yii::$app->request->get('select')=='350x350'?'selected':''?>>scaled to 350px × 350px - слайдер</option>
                    <option value="960x333" <?=yii::$app->request->get('select')=='960x333'?'selected':''?>>scaled to 1920px × 667px - слайдер товары</option>
                </select>
            </div>

            <div class="inline-labels" style="display: none">
                <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
                <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
                <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
                <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
                <label>W <input type="text" size="4" id="w" name="w" /></label>
                <label>H <input type="text" size="4" id="h" name="h" /></label>
                <label>Type <input type="text"   id="type" name="type" /></label>
            </div>

            <p>Результаты:</p>
            <div id="cropresult">
               <? echo $this->render('crop-preview',['data'=>$data,'cat'=>$cat]);?>

            </div></td><td valign="top">

            <div class="tabbable tabbable-custom">
                <ul class="nav nav-tabs">
                   <!-- <li <?/*=yii::$app->request->get('width')?'':'class="active"'*/?>>
                        <a href="#tab_1_1" data-toggle="tab" class="tabs_a" data-type="original" aria-expanded="false" >
                            Оригинально изображение </a>
                    </li>-->
                    <li <?=yii::$app->request->get('width',150)?'class="active"':''?>>
                        <a href="#tab_1_2" id="tab_1_2" data-toggle="tab" class="tabs_a" data-type="<?=yii::$app->request->get('width',1000)?>x<?=yii::$app->request->get('width',1000)?>" aria-expanded="false"  >
                            Изображения <?=yii::$app->request->get('width',1000)?>px шириной </a>
                    </li>
                    <li>
                        <select class="form-control" id="widthdd"  onchange="window.location='?cid=<?=yii::$app->request->get('cid')?>&id=<?=yii::$app->request->get('id')?>&width='+$(this).val()+'&select='+$('#size_lock').val()">
                        <!--  <option value="960x333" <?/* if(yii::$app->request->get('width')=='960x333') echo 'selected'; */?> >1920x667пк для слайдера</option>-->
                          <?php for($i=50;$i<=1100;$i+=50):?>
                            <option value="<?=$i?>" <? if(yii::$app->request->get('width')==$i) echo 'selected'; ?> ><?=$i?>пк</option>
                          <?php endfor; ?>
                            <!--<option value="750" <?/* if(yii::$app->request->get('width')==750) echo 'selected'; */?>>750пк</option>
                            <option value="500" <?/* if(yii::$app->request->get('width')==500) echo 'selected'; */?>>500пк</option>-->
                        </select>
                    </li>
                    <li>
                        <a class="btn btn-success" style="color: #fff" href="/catalog/admin/update?id=<?=yii::$app->request->get('cid')?>">Вернуться к товару</a>
                    </li>


                </ul>
                <div class="tab-content">
                 <!--   <div class="tab-pane <?/*=yii::$app->request->get('width')?'':'active'*/?>" id="tab_1_1">
                        <div style="width: 1000px; height: 800px; overflow: scroll ">
                            <img src="<?/*='/files/'.$name*/?>" id="target" data-text="original" alt="[Jcrop Example]" />
                        </div>
                    </div>-->
                    <div class="tab-pane <?=yii::$app->request->get('width',150)?'active':''?>" id="tab_1_2">


                        <div style="width: 1000px; height: 800px; overflow: scroll ">
                            <?php
                            $wi=yii::$app->request->get('width',150);
                            $hi=yii::$app->request->get('width',150);
                                $ar=explode('x',$wi);
                                $select=explode('x',yii::$app->request->get('select'));
                                if($ar[0]==960){
                                    $wi=$ar[0];
                                    $hi=$ar[1];
                                    $file=(new app\components\ImageComponent)->cuntomResize($data,$wi,$hi);
                                }else{

                                   // echo $wi.' < '.$select[0].' '.$hi.'<'.$select[1];
                                   if( $wi < $select[0] && ( yii::$app->request->get('select')!='960x333' || $hi<$select[1])  )
                                     $file=(new app\components\ImageComponent)->customResizeWithFill/*adaptive*/($data,$wi,$hi,$select[0],$select[1]);
                                   else
                                     $file=(new app\components\ImageComponent)->cuntomResize/*adaptive*/($data,$wi,$hi);
                                }
//echo $file;
                            ?>
                            <img src="<?=$file; ?>?<?=microtime()?>" id="target_small" data-text="<?=yii::$app->request->get('width',150)?>"  alt="[Jcrop Example]" />
                        </div>
                    </div>
                </div>



        </td></tr></table>




