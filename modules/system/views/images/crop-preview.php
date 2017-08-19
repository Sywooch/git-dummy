
<?php

    if($cat['iszoomer']):?>
                scaled to 320px × 355px - горячие товары<br>
                <img src="<?=(new app\components\ImageComponent)->crop($data,320,355).'?'.mktime();  ?>" /><br>
               <!-- scaled to 90px × 55px - превью для слайдеров<br>
                <img src="<?/*=(new app\components\ImageComponent)->adaptive($data,90,55).'?'.mktime();  */?>"   /><br>-->
                scaled to 321px × 221px - популярные товары<br>
                <img src="<?=(new app\components\ImageComponent)->crop($data,321,221).'?'.mktime();  ?>" /><br>
                scaled to 316px × 256px - окно победителя<br>
                <img src="<?=(new app\components\ImageComponent)->crop($data,316,256).'?'.mktime();  ?>" /><br>
                scaled to 270px × 236px - похожие товары<br>
                <img src="<?=(new app\components\ImageComponent)->crop($data,270,236).'?'.mktime();  ?>" /><br>
                scaled to 350px × 350px - Слайд<br>
                <img src="<?=(new app\components\ImageComponent)->crop($data,350,350).'?'.mktime();  ?>" /><br>

        scaled to 1000px × 1000px -  зум, слайдер зума<br>
        <img src="<?=(new app\components\ImageComponent)->crop($data,470,450).'?'.mktime();  ?>" /><br>

                scaled to 1920px × 667px - слайдер товары<br>
                <img width="300" src="<?=(new app\components\ImageComponent)->adaptive($data,1920,667).'?'.mktime();  ?>" /><br>
<?php else: ?>
    scaled to 320px × 355px - горячие товары<br>
    <img src="<?=(new app\components\ImageComponent)->adaptive($data,320,355).'?'.mktime();  ?>" /><br>
    <!-- scaled to 90px × 55px - превью для слайдеров<br>
                <img src="<?/*=(new app\components\ImageComponent)->adaptive($data,90,55).'?'.mktime();  */?>"   /><br>-->
    scaled to 321px × 221px - популярные товары<br>
    <img src="<?=(new app\components\ImageComponent)->adaptive($data,321,221).'?'.mktime();  ?>" /><br>
    scaled to 316px × 256px - окно победителя<br>
    <img src="<?=(new app\components\ImageComponent)->adaptive($data,316,256).'?'.mktime();  ?>" /><br>
    scaled to 270px × 236px - похожие товары<br>
    <img src="<?=(new app\components\ImageComponent)->adaptive($data,270,236).'?'.mktime();  ?>" /><br>
    scaled to 350px × 350px - Зум<br>
    <img src="<?=(new app\components\ImageComponent)->crop($data,350,350).'?'.mktime();  ?>" /><br>
    scaled to 1920px × 667px - слайдер товары<br>
    <img width="300" src="<?=(new app\components\ImageComponent)->adaptive($data,1920,667).'?'.mktime();  ?>" /><br>
<?php endif; ?>