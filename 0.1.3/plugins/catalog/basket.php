<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

if (USER==FALSE){
    $text .= "<div id='vt_block'>".LAN_MES_NOLOGIN."</div>";
}
if (USER==TRUE){
	$basket_id = $_POST['basket_id'];
	$basket_user = $_POST['basket_user'];
	$basket_nom_name = $_POST['basket_nom_name'];
//	$basket_nom_art = $_POST['basket_nom_art'];
	$basket_ordstat = "waiting";
	$basket_qt = $_POST['basket_qt'];
	$basket_price = $_POST['basket_price'];
	$order_id = $_POST['orderId'];

// -----form for purchases in the status the 'send'---------------------------
$text .="<div id='vt_block'><form enctype='multipart/form-data' name='form_select_old' method='post' action='". $PHP_SELF ."'>";
$text .="<table height='50px'>";
$text .="<tr><td>Покупки находящиеся в статусе 'Отправлен'</td></tr>";
$text .="<tr><td>
	<select name='orderId'>
	<option value=''>Нажмите, чтобы выбрать</option>";
		$sql -> db_Select("vt_order", "*", "order_userid='".USERID."' AND order_status='send'");
                while($row = $sql -> db_Fetch()){
			$orderId = $row['order_id'];
			$order_date = $row['order_date'];
			$text .="<option value='$orderId'>Заказ № $orderId от ".strftime('%d.%m.%y',$order_date)."</option>";
			}
	$text .="</select> <input type='submit' style='cursor:pointer;' value='посмотреть заказ' name='submit_viewing'>
	</td></tr>";
	$text .="</table></form></div>";
// -----form for purchases in the status the 'ready'----------------------------	

$text .="<div id='vt_block'><form enctype='multipart/form-data' name='form_select_old' method='post' action='". $PHP_SELF ."'>";
$text .="<table height='50px'>";
$text .="<tr><td>Покупки находящиеся в статусе 'Обработан'</td>";
$text .="<tr><td>
	<select name='orderId'>
	<option value=''>Нажмите, чтобы выбрать</option>";
		$sql -> db_Select("vt_order", "*", "order_userid='".USERID."' AND order_status='ready'");
                while($row = $sql -> db_Fetch()){
			$orderId = $row['order_id'];
			$orderDate = $row['order_date'];
			$text .="<option value='$orderId'>Заказ № $orderId от ".strftime('%d.%m.%y',$orderDate)."</option>";
			}
	$text .="</select> <input type='submit' style='cursor:pointer;' value='посмотреть заказ' name='submit_viewing'>
	</td></tr>";
	$text .="</table></form></div>";

//-----form
if (IsSet($_POST['submit_viewing'])){
    $sql -> db_Select("vt_order", "*", "order_id='$order_id'");
                while($row = $sql -> db_Fetch()){
			$orderId = $row['order_id'];
			$orderDate = $row['order_date'];
			}
    $text .="<div id='vt_block'>Подробное описание заказа № $orderId от ".strftime('%d.%m.%y',$orderDate)."<hr><br>";
    $text .="<form enctype='multipart/form-data' name='form_order' method='post' action='".$PHP_SELF."'><table width=98% border=1>";
    $text .="<tr bgcolor=#999><td>№</td><td>Наименование</td><td>Цена</td><td>Количество</td><td>Сумма</td>";
    $number = 1;
    $vtsql1 = new db;
    $vtsql1 -> db_Select("vt_basket", "*", "basket_ordnumber='$order_id'");
	while($row = $vtsql1 -> db_Fetch()){
	    $basket_id = $row['basket_id'];
	    $basket_userid = $row['basket_userid'];
	    $basket_nom_name = $row['basket_nom_name'];
//	    $basket_nom_art = $row['basket_nom_art'];
	    $basket_date = $row['basket_date'];
	    $basket_amount = $row['basket_amount'];
	    $basket_price = $row['basket_price'];
	    $basket_bonus = $row['basket_bonus'];
    $sum = $basket_price*$basket_amount;
    $text .="<tr><td>$number</td><td>$basket_nom_name</td><td>$basket_price</td><td>$basket_amount</td><td>".number_format($sum,2)."</td>";
    }
    $text .="</table>";
    $text .="<br>Данный заказ сделан с типом скидки:  $basket_bonus";
    $text .="</form></div>";
  }
}
$caption_section = "- <a href='".e_PLUGIN."md_md_vtrade/vtrade.php?basket'>Предыдущие заказы</a>";
?>