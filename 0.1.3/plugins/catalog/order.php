<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

	$caption_section = "- <a href='".e_PLUGIN."md_vtrade/vtrade.php?page=order'>Текущий заказ</a>";
	$basket_id = $_POST['basket_id'];
	$basket_amount = $_POST['basket_amount'];
	$basket_user = $_POST['basket_user'];
	$basket_nom_name = $_POST['basket_nom_name'];
	$basket_nom_art = $_POST['basket_nom_art'];
	$basket_ordstat = "waiting";
	$basket_price = $_POST['basket_price'];
	$basket_bonus = $_POST['basket_bonus'];
	$order_desc = $_POST['order_desc'];
	$to_step1 = $_POST['to_step1'];
	$to_step2 = $_POST['to_step2'];
	$to_step3 = $_POST['to_step3'];
	$to_step4 = $_POST['to_step4'];
	$to_step5 = $_POST['to_step5'];
	
if (!isset($to_step1) && !isset($to_step2) && !isset($to_step3) && !isset($to_step4) && !isset($to_step5) && !isset($step)){
	$vis_step1 = 'block';
	$vis_step2 = 'none';
	$vis_step3 = 'none';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
}
if (isset($to_step1)){
	$vis_step1 = 'block';
	$vis_step2 = 'none';
	$vis_step3 = 'none';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
}

if (isset($to_step2)){
	$total = $_POST['total'];
	if ($total==0){
		$message = "<div id='vt_block'><font color=red>Заказ не может быть пустым</font></div>";
		$ns -> tablerender("Сообщение", $message);
	$vis_step1 = 'block';
	$vis_step2 = 'none';
	$vis_step3 = 'none';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
	} else {
	$vis_step1 = 'none';
	$vis_step2 = 'block';
	$vis_step3 = 'none';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
	}
}
if (isset($to_step3)){
	$order_fname =$_POST['order_fname'];
	$order_lname =$_POST['order_lname'];
	$order_org = $_POST['order_org'];
	$order_index = $_POST['order_index'];
	$order_state = $_POST['order_state'];
	$order_address = $_POST['order_address'];
	$order_email = $_POST['order_email'];
	$order_icq = $_POST['order_icq'];
	$order_phone = $_POST['order_phone'];
	$_SESSION['order'] = array(
		"fname" => $order_fname,
		"lname" => $order_lname,
		"org" => $order_org,
		"index" => $order_index,
		"state" => $order_state,
		"address" => $order_address,
		"email" => $order_email,
		"icq" => $order_icq,
		"phone" => $order_phone
	);
	if($order_fname=="" || $order_lname =="" || $order_address=="" || $order_email=="" || $order_phone==""){
		echo "заполните все поля под *";
	$vis_step1 = 'none';
	$vis_step2 = 'block';
	$vis_step3 = 'none';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
	} else {
	$vis_step1 = 'none';
	$vis_step2 = 'none';
	$vis_step3 = 'block';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
	}
}
if (isset($to_step4)){
	$order_group1 = $_POST['order_group1'];
	$order_group2 = $_POST['order_group2'];
	$_SESSION['order']['group1'] = $order_group1;
	$_SESSION['order']['group2'] = $order_group2;
	if($order_group1=="" || $order_group2=""){
	echo "заполните все поля под *";	
	$vis_step1 = 'none';
	$vis_step2 = 'none';
	$vis_step3 = 'block';
	$vis_step4 = 'none';
	$vis_step5 = 'none';
	}else{
	$vis_step1 = 'none';
	$vis_step2 = 'none';
	$vis_step3 = 'none';
	$vis_step4 = 'block';
	$vis_step5 = 'none';
	}
}

// -----removal procedure--------------------------------------------------------
if (IsSet($_GET['del'])){
	$nom_id = $_GET['basket_id'];
	$del = $_GET['del'];
	$vtsql2 = new db;
	$vtsql2 -> db_Delete("vt_basket", "basket_id='$del'");
	unset($_SESSION['basket'][$del]);
}
// -----updating procedure--------------------------------------------------------
if (isset($_POST['submit_update'])){
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	$result=array_combine($id, $qty);
	if(isset($result)){
	$_SESSION['basket']=$result;
	foreach($_SESSION['basket'] as $id => $result){
		if($_POST[$id] == '0'){
		$message = "<div id='vt_block'><font color=red>Сумма покупки обновлена.</font></div>";
		$ns -> tablerender("Сообщение", $message);
		} else {
//			$_SESSION['basket'][$id] = $_POST[$id];
		//	echo "Ключ: $id; Значение: $qty- ".$id.", ".$result."<br /> \n";
		}
        } 
	}
}

//===============================================================================
//======FORM OF STEP1
if (USER==TRUE){
	$profile_bonus_inbd = $_POST['profile_bonus_inbd'];
	if (isset($_POST['submit_discount_change'])){
		$vtsql = new db;
		$vtsql -> db_Update("vt_profile", "profile_bonus='$profile_bonus_inbd' WHERE profile_id='".USERID."'");
	}
	$vtsql -> db_Select("vt_profile", "*", "profile_id='".USERID."'");
	while($row = $vtsql -> db_Fetch()){
		$profile_id =  $row['profile_id'];
		$profile_fname = $row['profile_fname'];
		$profile_lname = $row['profile_lname'];
		$profile_org = $row['profile_org'];
		$profile_address = $row['profile_address'];
		$profile_city = $row['profile_city'];
		$profile_state = $row['profile_state'];
		$profile_country = $row['profile_country'];
		$profile_index = $row['profile_index'];
		$profile_username = $row['profile_username'];
		$profile_email = $row['profile_email'];
		$profile_phone = $row['profile_phone'];
		$profile_icq = $row['profile_icq'];
		$profile_desc = $row['profile_desc'];
		$profile_bonus = $row['profile_bonus'];
	}
	$discount_change = "<form enctype='multipart/form-data'  name='discount_change' method='post' action='".$PHP_SELF."'>";
	$discount_change .= "<select class='tbox' name='profile_bonus_inbd'>";
	if ($profile_bonus <> '') {
		$discount_change .="<option value='$profile_bonus'>$profile_bonus</option>";
		$discount_change .="<option value=''></option>";
		$discount_change .="<option value='Разовая'>Разовая</option>";
		$discount_change .="<option value='Накопительная'>Накопительная</option>";
	}else {
		$discount_change .="<option value=''>Выберите пожалуйста тип вашей скидки</option>";
		$discount_change .="<option value='Разовая'>Разовая</option>";
		$discount_change .="<option value='Накопительная'>Накопительная</option>";
	}
	$discount_change .="</select>";
	$discount_change .="<input type='submit' size='2' value='".LAN_BUT_AGR."' name='submit_discount_change'>";
	$discount_change .="</form>";
	$count = $vtsql -> db_Count("vt_basket", "(*)", "WHERE basket_userid='".USERID."' AND basket_ordstat='waiting'");
}
if (USER==FALSE){
	$profile_bonus = "Разовая";
	$discount_change = LAN_MES_DISCOUNT;
}
$text .="<div id='block_step1' style='display:$vis_step1'>";
$text .="<img src='theme/images/step_1.png'><br><br>";
$text .="Ваш тип скидки для текущего заказа:<font size=3 color=green><b>$profile_bonus</b> </font>";
$text .="<a href=# onclick=\"document.getElementById('vt_discount_change').style.display='block'; return false;\"><b> [Сменить тип скидки]</b></a>";
$text .="<div id='vt_discount_change'>";
$text .=$discount_change;
$text .="<a href=# onclick=\"document.getElementById('vt_discount_change').style.display='none'; return false;\"><b> [Закрыть опцию]</b></a>";
$text .="</div>";

$text .="<h2>Текущий заказ</h2><hr>";
$text .="<form enctype='multipart/form-data' name='form_order' id='div_form' style='display:block' method='post' action='".$PHP_SELF."'>";
	$text .="<table width=98% border=1><tr>";
	$text .="<td class='fcaption' width=5%>№</td>";
	$text .="<td class='fcaption' width=50%>Наименование</td>";
	$text .="<td class='fcaption' width=10%>Цена</td>";
	$text .="<td class='fcaption' width=10%>Кол-во</td>";
	$text .="<td class='fcaption' width=15%>Сумма</td>";
	$text .="<td class='fcaption' width=10%>Опции</td>";
	$num = 1;
	$chet = 1;
	$basket_count = 1;
	$i = 1;
	if ($_SESSION['basket'] !='0'){
		foreach($_SESSION['basket'] as $nom_id => $nom_amount):
		$product = get_product($nom_id);
		$nom_id =$product['nom_id'];
		$nom_name = $product['nom_name'];
		$nom_price1 = $product['nom_price1'];
		if ($chet == 1) {    
			$text .="<tr style='background-color:#eee'>";
		}
		if ($chet == 2) {    
			$text .= "<tr style='background-color:#ddd'>";
			$chet = 0;
		}
		$text .="<td>$num</td>";
		$text .="<td><input type='hidden' name='id[]' value='$nom_id'><a href='".e_PLUGIN."md_vtrade/vtrade.php?page=det&id=$nom_id'>$nom_name</a></td>";
		$text .="<td>$nom_price1</td>";
		$text .="<td><input id='tbox' type='text' size='3' name='qty[]' value='$nom_amount'></td>";
		$sum = $nom_amount * $nom_price1;
		$text .="<td>".number_format($sum,2)."</td>";
		$text .="<td><a href='".e_PLUGIN."md_vtrade/vtrade.php?page=order&del=$nom_id'>удалить</a></td>";
		$total = $total + $sum;
		$num ++;
		$chet ++;
		$i ++;
	endforeach;
	}
	include('discount.php');
	$text .="<tr><td colspan=6 align=right>Всего:<b><font size=2> ".number_format($total,2)." руб </b></font><br><input style='cursor:pointer' type='submit' value='пересчитать' name='submit_update'></td></tr>";
	$text .="</table>";
	$text .="Скидка составила: <font size=2 color=green><b>".number_format($discount,2)." руб</b></font><br>";
	$text .="что бы скидка составила ".$sd1." нужно заказать еще на <font size=2 color=green><b> ".number_format($skd,2)." руб.</b></font><br>";
	$text .="Промежуточный итог: <font size=3 color=green><b>".number_format($total-$discount,2)." руб</b></font><br>";
	$text .="<input class='tbox' type='hidden' name='total' value='$total'/>";
	$text .="<input class='tbox' type='hidden' name='discount' value='$discount'/>";
	$text .="<br><center><input style='cursor:pointer' type='submit' value='Оформить заказ' name='to_step2'></center>";
	$text .="</form></div>";
	
//===============================================================================
//======FORM OF STEP2
//$_SESSION['order_org'][$_POST['order_org']]=+1;

//$_SESSION['order'][$_POST['order_org']]=+$_POST['order_user'];

if (USER==TRUE){
      $vtsql = new db;
      $vtsql -> db_Select("vt_profile", "*", "profile_id='".USERID."'");
      while($row = $vtsql -> db_Fetch()){
	$profile_id = $row['profile_id'];
	$profile_fname = $row['profile_fname'];
	$profile_lname = $row['profile_lname'];
	$profile_org = $row['profile_org'];
	$profile_address = $row['profile_address'];
	$profile_city = $row['profile_city'];
	$profile_state = $row['profile_state'];
	$profile_country = $row['profile_country'];
	$profile_index = $row['profile_index'];
	$profile_username = $row['profile_username'];
	$profile_email = $row['profile_email'];
	$profile_phone = $row['profile_phone'];
	$profile_icq = $row['profile_icq'];
	$profile_desc = $row['profile_desc'];
	$profile_bonus = $row['profile_bonus'];
	}
}
$text .="<div id='block_step2' style='display:$vis_step2'>";
$text .="<img src='theme/images/step_2.png'><br><br>";
$text .="<h2>Данные о покупателе</h2><hr>";
$text .="<form enctype='multipart/form-data' name='form_profile' method='post' action='".$PHP_SELF."'>";
$text .="<table width=100%>";
$text .="<tr><td class='forumheader3'>Ваше Имя *</td><td class='forumheader3'><input class='tbox' type='text' name='order_fname' onblur='checkname()' size='40' value='$profile_fname' maxlength='200'/><span id='check_name'></span></td>";
$text .="<tr><td class='forumheader2'>Ваша Фамилия *</td><td class='forumheader2'><input class='tbox' type='text' name='order_lname' size='40' value='$profile_lname' maxlength='200'/></td>";

$text .="<tr><td class='forumheader3'>Название организации</td><td class='forumheader3'><input class='tbox' type='text' name='order_org' onblur='checkname()' size='40' value='$profile_org'  maxlength='200'/><span id='check_name'></span></td>";

$text .="<tr><td class='forumheader2'>Индекс</td><td class='forumheader2'><input class='tbox' type='text' name='order_index' size='40' value='$profile_index' maxlength='200'/></td>";

//$text .="<tr><td class='forumheader2'>Страна</td><td class='forumheader2'><input class='tbox' type='text' name='profile_country' onblur='checkcity()' size='40' value='$profile_country' maxlength='200'/><span id='check_city'></span></td>";

$text .="<tr><td class='forumheader3'>Область</td><td class='forumheader3'><input class='tbox' type='text' name='order_state' onblur='checkcity()' size='40' value='$profile_state' maxlength='200'/><span id='check_city'></span></td>";

$text .="<tr><td class='forumheader2'>Адрес *</td><td class='forumheader2'><input class='tbox' type='text' name='order_address' onblur='checkaddress()' size='40' value='$profile_address' maxlength='200'/><span id='check_address'></span></td>";

$text .="<tr><td class='forumheader3'>Электронный ящик *</td><td class='forumheader3'><input class='tbox' type='text' name='order_email' size='40' value='$profile_email' maxlength='200'/></td>";

$text .="<tr><td class='forumheader2'>ICQ</td><td class='forumheader2'><input class='tbox' type='text' name='order_icq' size='40' value='$profile_icq' maxlength='200'/></td>";

$text .="<tr><td class='forumheader3'>Телефон *</td><td class='forumheader3'><input class='tbox' type='text' name='order_phone' onblur='phone()' size='40' value='$profile_phone' maxlength='200'/><span id='check_phone'></span></td>";
$text .="</tr></table>";
$text .="<br><center><input style='cursor:pointer' type='submit' value='Назад' name='to_step1'>";
$text .="<input style='cursor:pointer' type='submit' value='Далее' name='to_step3'></center>";
$text .="</form></div>";

//===============================================================================
//======FORM OF STEP3

if (($total-$discount) <= 2000){
	$del_poekb = 170;
	$del_zaekb = 350;
	$del_sam = 0;
}
if (($total-$discount) > 2000){
	$del_poekb = 0;
	$del_zaekb = 0;
	$del_sam = 0;
}
$text .="<div id='block_step3' style='display:$vis_step3'>";
$text .= $s_order['fname'];
$text .="<img src='theme/images/step_3.png'><br><br>";
$text .="<h2>Доставка</h2><hr>";
$text .="<form enctype='multipart/form-data' name='form_delivery'  id='div_form1' method='post' action='".$PHP_SELF."'>";
$text .="<table>";
$text .="<tr><td class='fcaption'>Место доставки</td>";
$text .="<td class='fcaption'>Стоимость доставки</td>";
$text .="<td class='fcaption'>Выбор</td>";
$text .="<tr><td class='forumheader2'>по Екатеринбургу, курьером</td><td class='forumheader2'>".number_format($del_poekb,2)." руб</td><td class='forumheader2'><input type='radio' name='order_group1' value='$del_poekb'></td>";
$text .="<tr><td class='forumheader3'>Березовский, Сысерть, Дегтярск, Верхняя Пышма, Арамиль, Первоуральск, Полевской</td><td class='forumheader3'>".number_format($del_zaekb,2)." руб</td><td class='forumheader3'><input type='radio' name='order_group1' value='$del_zaekb'></td></tr>";
$text .="<tr><td class='forumheader2'>Самовывоз</td><td class='forumheader2'>".number_format($del_sam,2)." руб</td><td class='forumheader2'><input type='radio' name='order_group1' value='$del_sam'></td>";
//$text .="<tr><td class='forumheader3'>Почта России</td><td class='forumheader3'></td><td class='forumheader3'><input type='radio' name='group1' value='Почта'></td>";

$text .="</td></tr></table>";
$text .="<h2>Оплата</h2><hr>";
$text .="<table>";
$text .="<tr><td class='forumheader3'><img src='theme/images/money_ym_small.jpg'><br>YandexMoney<input type='radio' name='order_group2' value='YM'></td>";
$text .="<td class='forumheader3'><img src='theme/images/money_wm_small.jpg'><br>WebMoney <input type='radio' name='order_group2' value='WM'></td>";
$text .="<td class='forumheader3'><img src='theme/images/money_rc_small.jpg'><br>RoboCassa <input type='radio' name='order_group2' value='RC'></td>";
$text .="<tr><td class='forumheader2'><img src='theme/images/money_nal_small.jpg'><br>Наличный платеж<input type='radio' name='order_group2' value='NP'></td>";
$text .="<td class='forumheader2'><img src='theme/images/money_bank_small.jpg'><br>Счет для организаций<input type='radio' name='order_group2' value='NP'></td>";
$text .="<td class='forumheader2'><img src='theme/images/money_kvit_small.jpg'><br>Перевод для физ.лиц<input type='radio' name='order_group2' value='NP'></td>";
$text .="</table>";
$text .="<br><center><input style='cursor:pointer' type='submit' value='Назад' name='to_step2'>";
$text .="<input style='cursor:pointer' type='submit' value='Далее' name='to_step4'></center>";
$text .="</form></div>";

//===============================================================================
//======FORM OF STEP4
//print_r($_SESSION['order']);
$text .="<div id='block_step4' style='display:$vis_step4'>";
$text .="<img src='theme/images/step_4.png'><br><br>";
$text .="<h2>Проверка всех данных о заказе</h2><hr>";
$text .="<form enctype='multipart/form-data' name='form_check'  id='div_form1' method='post' action='".$PHP_SELF."'>";
include('discount.php');
	$text .="Промежуточный итог: <font size=2 color=grey><b>".number_format($total-$discount,2)." руб</b></font><br>";
	$text .="Скидка составила: <font size=2 color=grey><b>".number_format($discount,2)." руб</b></font><br>";
	$text .="Стоимость доставки: <font size=2 color=grey><b>".number_format($order_group1,2)." руб</b></font><br>";
	$text .="Итог: <font size=3 color=green><b>".number_format($total-$discount+$order_group1,2)." руб</b></font><br>";
	$text .="<input class='tbox' type='hidden' name='total' value='$total'/>";
	$text .="<input class='tbox' type='hidden' name='discount' value='$discount'/>";
$text .="<br>";
$text .="<table width=100%><tr>";
$text .="<td width=40% class='forumheader2'>Покупатель</td><td width=60% class='forumheader2'>".$_SESSION['order']['fname']." ".$_SESSION['order']['lname']."</td>";
$text .="<tr><td class='forumheader3'>Название организации</td><td class='forumheader3'>".$_SESSION['order']['org']."</td>";
$text .="<tr><td class='forumheader2'>Адрес доставки</td><td class='forumheader2'>".$_SESSION['order']['index']." ".$_SESSION['order']['state']." ".$_SESSION['order']['address']."</td>";
$text .="<tr><td class='forumheader3'>Электронный ящик</td><td class='forumheader3'>".$_SESSION['order']['email']."</td>";
$text .="<tr><td class='forumheader2'>ICQ</td><td class='forumheader2'>".$_SESSION['order']['icq']."</td>";
$text .="<tr><td class='forumheader3'>Телефон</td><td class='forumheader3'>".$_SESSION['order']['phone']."</td></tr>";
$text .="<tr><td class='forumheader2'>Доставка</td><td class='forumheader2'>".$_SESSION['order']['group1']."</td></tr>";
$text .="<tr><td class='forumheader3'>Оплата</td><td class='forumheader3'>".$_SESSION['order']['group2']."</td></tr>
</table>";
$text .="<br>";
$text .="Дополнительная информация к заказу<br><textarea cols=48 rows=10 class='tbox' type='text' name='order_desc' maxlength='500'/>$profile_desc</textarea>";
$text .="<br><br><center><input style='cursor:pointer' type='submit' value='Назад' name='to_step3'> ";
$text .=" <input style='cursor:pointer' type='submit' value='Подтверждение заказа' name='to_step5'></center>";
$text .="</form></div>";

//===============================================================================
//======FORM OF STEP5
if (isset($to_step5)){
	$total = $_POST['total'];
	if ($total==0){
		$message = "<div id='vt_block'><font color=red>Заказ не может быть пустым</font></div>";
		$ns -> tablerender("Сообщение", $message);
		$vis_step1 = 'none';
		$vis_step2 = 'none';
		$vis_step3 = 'none';
		$vis_step4 = 'block';
		$vis_step5 = 'none';
	} else {
		$vis_step1 = 'none';
		$vis_step2 = 'none';
		$vis_step3 = 'none';
		$vis_step4 = 'none';
		$vis_step5 = 'block';
	$text .="<div id='block_step5' style='display:$vis_step5'>";
		if(USER==true){
			$in_order_userid = USERID;
		}
		if(USER==false){
			$in_order_userid = 0;
		}
		$in_order_status = 'send';
		$in_order_user = $tp->toDB("".$_SESSION['order']['fname']." ".$_SESSION['order']['lname']."");
		$in_order_org = $tp->toDB($_SESSION['order']['org']);
		$in_order_address = $tp->toDB("".$_SESSION['order']['index']." ".$_SESSION['order']['state']." ".$_SESSION['order']['address']."");
		$in_order_email = $tp->toDB($_SESSION['order']['email']);
		$in_order_icq = $tp->toDB($_SESSION['order']['icq']);
		$in_order_phone = $tp->toDB($_SESSION['order']['phone']);
		$in_order_group1 = $tp->toDB($_SESSION['order']['group1']);
		$in_order_group2 = $tp->toDB($_SESSION['order']['group2']);
		$in_order_bonus = $tp->toDB($profile_bonus);
//	$text .="'$order_date', '$user_id', '$order_status', '$order_user', '$order_org', '$order_address', '$order_email', '$order_icq', '$order_phone', '$group1', '$group2'";
$vtsql -> db_Insert("vt_order", "0, '$order_date', '$in_order_userid', '$in_order_status', '$in_order_user', '$in_order_org', '$in_order_address', '$in_order_email', '$in_order_icq', '$in_order_phone', '$in_order_group1', '$in_order_group2', '$in_order_bonus'"); 
	
$vtsql -> db_Select("vt_order", "*", "order_status='send'");
	while($row = $vtsql -> db_Fetch()){
		$orderId = $row['order_id'];
		$orderDate = $row['order_date'];
	}
//	$conf_admail = 'sunout@mail.ru';//$pref['conf_admail'];
	$conf_admail = $pref['conf_admail'];
	$to_admin = $conf_admail;
	$to_user = $_SESSION['order']['email'];
	$subject = "Заказ № $orderId от ".strftime('%d.%m.%y',$orderDate)."";
	$message = "Заказ № $orderId от ".strftime('%d.%m.%y',$orderDate)."";
	$message .="<table width=98% border=0><tr>";
	$message .="<td bgcolor='#ccc' width=5%>№</td>";
	$message .="<td bgcolor='#ccc' width=50%>Наименование</td>";
	$message .="<td bgcolor='#ccc' width=10%>Цена</td>";
	$message .="<td bgcolor='#ccc' width=10%>Кол-во</td>";
	$message .="<td bgcolor='#ccc' width=15%>Сумма</td></tr>";
	$num = 1;
	$chet = 1;
	$basket_count = 1;
	$i = 1;
	$total = 0;
	if ($_SESSION['basket'] !='0'){
		foreach($_SESSION['basket'] as $nom_id => $nom_amount):
		$product = get_product($nom_id);
		$nom_id =$product['nom_id'];
		$nom_name = $product['nom_name'];
		$nom_price1 = $product['nom_price1'];
		if ($chet == 1) {    
			$message .="<tr style='background-color:#fff'>";
		}
		if ($chet == 2) {    
			$message .= "<tr style='background-color:#eee'>";
			$chet = 0;
		}
		$message .="<td>$num</td>";
		$message .="<td><input type='hidden' name='id[]' value='$nom_id'>$nom_name</td>";
		$message .="<td>$nom_price1</td>";
		$message .="<td>$nom_amount</td>";
		$sum = $nom_amount * $nom_price1;
		$message .="<td>".number_format($sum,2)."</td>";
		$total = $total + $sum;
		$num ++;
		$chet ++;
		$i ++;
		$vtsql -> db_Insert("vt_basket", "0, '$nom_name','$nom_art','$orderId','$nom_amount','$nom_price1'");
	endforeach;
	}
	include('discount.php');
	$message .="</tr><tr><td colspan=5><font size=2>Всего:".number_format($total,2)." руб</font></td>";
	$message .="</tr></table>";
	$message .="<br><br>Данный заказ сделан со скидкой: $profile_bonus";
	$message .="<br>Скидка составила: <font size=2 color=green><b>".number_format($discount,2)." руб</b></font>";
	$message .="<br>Доставка составила: <font size=2 color=green><b>".$_SESSION['order']['group1']." руб</b></font>";
	$message .="<br>Окончательный итог: <font size=3 color=green><b>".number_format($total-$discount+$_SESSION['order']['group1'],2)." руб</b></font>";
	$message .= "<br><br>";
	$message .= "Данный заказ сделал(а):".$_SESSION['order']['fname']." ".$_SESSION['order']['lname']."<br>";
	$message .= "Название организации:".$_SESSION['order']['org']."<br>";
	$message .= "Aдрес: ".$_SESSION['order']['index']." ".$_SESSION['order']['state']." ".$_SESSION['order']['address']."<br>";
	$message .= "Телефон(ы): ".$_SESSION['order']['phone']."<br>";
	$message .= "E-mail: ".$_SESSION['order']['email']."<br>";
	$message .= "ICQ: ".$_SESSION['order']['icq']."<br>";
	$message .= "Дополнительная информация: ".$order_desc."<br>";
	$headers  = "Content-type: text/html; charset=utf8 \r\n";
	$headers .= "From: Интернет магазин' \r\n";
	mail($to_admin, $subject, $message, $headers);
	mail($to_user, $subject, $message, $headers);
//	$text .="<script type='text/javascript'>alert ('Ваш заказ № $order_id от ".strftime('%d,%m,%y',$order_date)." отправлен администратору сайта. В ближайшее время с вами свяжутся наши менеджеры.');</script>";
	$text .="<div id='vt_block'>Ваш заказ № $order_id от ".strftime('%d,%m,%y',$order_date)." отправлен администратору сайта. В ближайшее время с вами свяжутся наши менеджеры.</div>";
	$text .="</div>";
	unset($_SESSION['basket']);
	unset($_SESSION['order']);
	header ("Location: ".e_PLUGIN."md_vtrade/vtrade.php?page=notify&mes_sending&$order_id&$order_date");
	exit;
	}
}
?> 