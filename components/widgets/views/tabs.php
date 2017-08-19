<?php



?>


<ul class="nav nav-tabs">
<?php foreach($langs as $lang):?>
    <li class="<?=($active == $lang)?'active':''?>">
        <a href="#<?=$lang?>" data-toggle="tab" aria-expanded="true">
            <?=$lang?>
        </a>
    </li>
<?php endforeach; ?>
</ul>