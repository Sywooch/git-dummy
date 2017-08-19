<?php

$mail = "g8_2005@mail.ru";

include "mail.class.php";


	$m= new Mail('utf8');
	$m->To($mail);
	$m->Subject("Сообщение из сайта");
	$m->Body("<br/>
	".(!empty($_POST['theme'])?"<b>Тема</b>: ".$_POST['theme']."<br/>":"")."
	".(!empty($_POST['phone'])?"<b>Ваш E-mail или телефон</b>: ".$_POST['phone']."<br/>":"")."");
	$m->Send();
	echo '<h3>Заявка отправлена.</h3>';       



?>