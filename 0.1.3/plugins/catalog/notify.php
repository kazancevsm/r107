<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

$mes_nologin = $_GET['mes_nologin'];
$mes_sending = $_GET['mes_sending'];

if (IsSet($mes_nologin)){
$text .= "<div id='vt_block'>Сообщение.</div><div id='vt_block'>	Вы должны быть зарегестрированным пользователем, чтобы воспользоваться услугами магазина. Вы сможете накапливать скидку на весь товар, чем больше вы купите - тем больше будет скидка.<br><br>Регистрация очень проста и не займет у вас много времени.<br><a href=".e_HTTP."signup.php>Перейти к процедуре регистации?</a></div>";
}
if (IsSet($mes_sending)){
	$text .= "<div id='vt_block'>";
	$text .= "<b>Благодарим вас за то, что вы воспользовались услугами нашего магазина!</b><br><br>Ваш заказ принят. Наши менеджеры свяжутся с вами в ближайшее время.<br>";
	$text .= "<a href='".e_PLUGIN."md_vtrade/vtrade.php'>[Продолжить работу в магазине]</a>";
	$text .= "</div>";
}

$caption = "<a href='".e_PLUGIN."md_vtrade/vtrade.php?frontpage'>$conf_vthead</a> $caption_section";
?>