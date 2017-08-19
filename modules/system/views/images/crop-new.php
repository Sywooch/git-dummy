
<?
Yii::$app->view->registerJsFile( Yii::$app->params['sitehost'].'assets/admin/imgareaselect/jquery.imgareaselect.js',
					[ 
					'depends' => ['yii\web\YiiAsset',       'yii\bootstrap\BootstrapAsset',]
					]);



    use yii\helpers\Html;
    use yii\grid\GridView;

    $name = (new app\components\ImageComponent)->getname($data);

    $original_file=str_replace(".","-original.",$name);

    if( is_file( \Yii::$app->basePath.'/files/'.$original_file ) )
        $name = $original_file;

    $size = getimagesize ( \Yii::$app->basePath.'/files/'.$name );
    Yii::$app->view->registerJs("


    $(document).ready(function () {
    $('img#file').imgAreaSelect({
      /*  aspectRatio: '1:1',*/
        handles: true,
        fadeSpeed: 200,
        imageHeight:".$size[1].",
        imageWidth:".$size[0].",

        onSelectChange: preview
    });


});


 function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;

    var scaleX = ".$size[0]." / selection.width;
    var scaleY = ".$size[1]." / selection.height;

    $('#preview img').css({
        width: Math.round(scaleX * ".$size[0]."),
        height: Math.round(scaleY * ".$size[1]."),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });

    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);

    $('#frame').css('width',selection.width);
    $('#frame').css('height',selection.height);

    $('#preview').css('width',selection.width);
    $('#preview').css('height',selection.height);

}

");

    $size[0]=500;
    $size[1]=500;
?>
 <style>
     .imgareaselect-border1 {
         background: url(border-anim-v.gif) repeat-y left top;
     }

     .imgareaselect-border2 {
         background: url(border-anim-h.gif) repeat-x left top;
     }

     .imgareaselect-border3 {
         background: url(border-anim-v.gif) repeat-y right top;
     }

     .imgareaselect-border4 {
         background: url(border-anim-h.gif) repeat-x left bottom;
     }

     .imgareaselect-border1, .imgareaselect-border2,
     .imgareaselect-border3, .imgareaselect-border4 {
         opacity: 0.5;
         filter: alpha(opacity=50);
     }

     .imgareaselect-handle {
         background-color: #fff;
         border: solid 1px #000;
         opacity: 0.5;
         filter: alpha(opacity=50);
     }

     .imgareaselect-outer {
         background-color: #000;
         opacity: 0.5;
         filter: alpha(opacity=50);
     }

     .imgareaselect-selection {
     }
 </style>


<div style="float: left; width: 50%;">
    <p class="instructions">
        Click and drag on the image to select an area.
    </p>

    <div class="frame" style="margin: 0 0.3em; width: <?=$size[0]?>px; height: <?=$size[1]?>px;">
        <img src="<?='/files/'.$name?>" width="<?=$size[0]?>" id="file"  />
    </div>
</div>

<div style="float: left; width: 50%;">
    <p style="font-size: 110%; font-weight: bold; padding-left: 0.1em;">
        Selection Preview
    </p>
    <?php
    $result_w=200;
    $result_h=200;

    ?>
    <div class="frame" id="frame"
         style="margin: 0 1em; width: <?=$result_w?>px; height: <?=$result_h?>px;">
        <div id="preview" style="width: <?=$result_w?>px; height: <?=$result_h?>px; overflow: hidden;">
            <img src="<?='/files/'.$name?>"/>
        </div>
    </div>

    <table style="margin-top: 1em;">
        <thead>
        <tr>
            <th colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
                Coordinates
            </th>
            <th colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
                Dimensions
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 10%;"><b>X<sub>1</sub>:</b></td>
            <td style="width: 30%;"><input type="text" id="x1" value="-" /></td>
            <td style="width: 20%;"><b>Width:</b></td>
            <td><input type="text" value="-" id="w" /></td>
        </tr>
        <tr>
            <td><b>Y<sub>1</sub>:</b></td>
            <td><input type="text" id="y1" value="-" /></td>
            <td><b>Height:</b></td>
            <td><input type="text" id="h" value="-" /></td>
        </tr>
        <tr>
            <td><b>X<sub>2</sub>:</b></td>
            <td><input type="text" id="x2" value="-" /></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><b>Y<sub>2</sub>:</b></td>
            <td><input type="text" id="y2" value="-" /></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
