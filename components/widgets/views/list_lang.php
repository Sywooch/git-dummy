<?php




?>


<div class="lang1">

    <div class="curr1" dt="0"><?=($Label[$active]['stext'])?$Label[$active]['stext']:'Рус'?></div>

    <ul>


        <?php for($i=0;$i<count($langs);$i++):
            $lang=$langs[$i];?>
        <li><a class="j<?=($i+1)?>" data-id="<?=$lang?>" href="?lang=<?=$lang?>"><?=$Label[$lang]['text']?></a></li>


        <?php endfor; ?>



    </ul>

</div>

<script>
    $('.lang1 a').click(function(){
                 $.cookie("langss", $(this).attr('data-id'), { expires : 10 });
    });

</script>
