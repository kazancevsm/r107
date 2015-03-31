<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

if (USER==FALSE){
	if (IsSet($_POST['submit_insert'])){

//-----Определение переменных из формы -----//      

	$order_userid  =  $_POST['order_userid '];
	$profile_fname = $_POST['profile_fname'];
	$profile_lname = $_POST['profile_lname'];
	$order_org = $_POST['profile_org'];
	$order_address = $_POST['profile_address'];
	//$order_city = $_POST['order_city'];
	$order_status  = $_POST['order_status'];
	//$profile_country = $_POST['profile_country'];
	//$profile_index = $_POST['profile_index'];
	$order_user  = $_POST['order_user '];
	$order_email = $_POST['order_email'];
	$order_phone = $_POST['order_phone'];
	$order_icq = $_POST['order_icq'];
	//$profile_desc = $_POST['profile_desc'];
	$order_date=strftime('%d.%m.%y', NOW);
	$order_delivery = $_POST['order_delivery'];
	$profile_bonus = 'разовая';
//======check empty============//
	if ($profile_fname == '' || $order_city == ''|| $order_address == '' || $order_phone == '' || $order_email == '' || $profile_bonus == ''){
	$text = "<div id='vt_block'><font color=red>Пожалуйста, заполните все поля отмеченные знаком *</font></div>";
	}
//======insert=================//

	else {
	//$profile_id = USERID;
	//$profile_user = USERNAME;
	$vtsql = new db;
	$vtsql -> db_Insert("vt_order", "$order_id, '$order_date', '$order_userid', '$order_status',   '$order_user','$order_org', '$order_address', '$order_email','$order_icq', '$order_phone', '$order_delivery', '$order_amdel'");
		$caption = "Сообщение";
	$ns -> tablerender($caption, $text);
	}}
	$vtsql2 = new db;

      $vtsql2 -> db_Select("vt_order", "*", "");

      while($row = $vtsql2 -> db_Fetch()){

	$order_userid =  $row['order_userid'];
	  }
	  $order_id++;
	 //$order_username++;
$text .="<form method='post' enctype='multipart/form-data' name='form_add' id='form_add' style='border:0;float:top;' action='".e_PLUGIN."md_vtrade/vtrade.php?page=order'>



<div id='vt_block'><table><tr><td><img src='".e_PLUGIN."md_vtrade/theme/images/vuser.png' alt='Настройки профиля'><td valign=top><font size=2>- Заполните поожалуйста все необходимые поля отмеченные занаком *. Эти поля являются обязательными к заполнению! Остальные поля заполняются по вашему желанию.

<br></font></tr></table></div>";



	$text .="<div id='vt_block'><table width=90%>";
	$text .="<tr><td></td><td><input class='tbox' type='' name='order_userid' value='$order_userid' maxlength='200'/></td>";
	//$text .="<tr><td></td><td><input class='tbox' type='' name='profile_username' value='$profile_username' maxlength='200'/></td>";
	$text .="<tr><td>Ваша скидка на покупки</td><td>разовая</td><td>";	
	$text .="<tr><td>Ваше имя *</td><td><input class='tbox' type='text' name='order_user' onblur='checkname()' size='50' value='$order_user' maxlength='200'/><span id='check_name'></span></td>";
//	$text .="<tr><td>Ваша фамилия *</td><td><input class='tbox' type='text' name='profile_lname' size='50' value='$profile_lname' maxlength='200'/></td>";
	$text .="<tr><td>Название организации</td><td><input class='tbox' type='text' name='order_org' onblur='checkname()' size='50' value='$order_org' maxlength='200'/><span id='check_name'></span></td>";
	//$text .="<tr><td>Индекс</td><td><input class='tbox' type='text' name='profile_index' size='50' value='$profile_index' maxlength='200'/></td>";
	//$text .="<tr><td>Страна</td><td><input class='tbox' type='text' name='profile_country' onblur='checkcity()' size='50' value='$profile_country' maxlength='200'/><span id='check_city'></span></td>";
	$text .="<tr><td>Область</td><td><input class='tbox' type='text' name='order_status' onblur='checkcity()' size='50' value='$order_status' maxlength='200'/><span id='check_city'></span></td>";
	//$text .="<tr><td>Город *</td><td><input class='tbox' type='text' name='order_city' onblur='checkcity()' size='50' value='$order_city' maxlength='200'/><span id='check_city'></span></td>";
	$text .="<tr><td>Адрес *</td><td><input class='tbox' type='text' name='order_address' onblur='checkaddress()' size='50' value='$order_address' maxlength='200'/><span id='check_address'></span></td>";
	$text .="<tr><td>Электронный ящик *</td><td><input class='tbox' type='text' name='order_email' size='50' value='".USEREMAIL."' maxlength='200'/></td>";
	$text .="<tr><td>ICQ</td><td><input class='tbox' type='text' name='order_icq' size='50' value='$order_icq' maxlength='200'/></td>";
	$text .="<tr><td>Телефон *</td><td><input class='tbox' type='text' name='order_phone' onblur='phone()' size='50' value='$order_phone' maxlength='200'/><span id='check_phone'></span></td>";
	//$text .="<tr><td>Дополнительная информация</td><td><textarea cols=48 rows=10 class='tbox' type='text' name='profile_desc' maxlength='500'/>$profile_desc</textarea></td>";
	$text .= "<tr><td colspan=2 align=center><br>
	<input type='submit' class='button'  name='submit_insert' value='Сохранить'  onClick='f_submit_add()'>
	</td></tr></table></div>
</form>";


	}
if (USER==TRUE){
//-----запрос к таблице vt_profile на предмет наличия записи-----*/
  $vtsql1 = new db;
  $catcount = $vtsql1 -> db_Count("vt_profile", "(*)", "WHERE profile_id='".USERID."'");

  if ($catcount == 0) {
      $unvis = "yes";
      $vis = "none";
      }
  if ($catcount == 1) {
      $unvis = "none";
      $vis = "yes";

//-----Определение переменных для формы -----//

      $vtsql2 = new db;
      $vtsql2 -> db_Select("vt_profile", "*", "profile_id='".USERID."'");
      while($row = $vtsql2 -> db_Fetch()){
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
   }

//======Insert_notes======//

if (IsSet($_POST['submit_insert'])){
//-----Определение переменных из формы -----//      
	$profile_id =  $_POST['profile_id'];
	$profile_fname = $_POST['profile_fname'];
	$profile_lname = $_POST['profile_lname'];
	$profile_org = $_POST['profile_org'];
	$profile_address = $_POST['profile_address'];
	$profile_city = $_POST['profile_city'];
	$profile_state = $_POST['profile_state'];
	$profile_country = $_POST['profile_country'];
	$profile_index = $_POST['profile_index'];
	$profile_username = $_POST['profile_username'];
	$profile_email = $_POST['profile_email'];
	$profile_phone = $_POST['profile_phone'];
	$profile_icq = $_POST['profile_icq'];
	$profile_desc = $_POST['profile_desc'];
	$profile_bonus = $_POST['profile_bonus'];
//======check empty============//
	if ($profile_fname == '' || $profile_city == ''|| $profile_address == '' || $profile_phone == '' || $profile_email == '' || $profile_bonus == ''){
	$text = "<div id='vt_block'><font color=red>Пожалуйста, заполните все поля отмеченные знаком *</font></div>";
	}
//======insert=================//
	else {
	$profile_id = USERID;
	$profile_user = USERNAME;
	$vtsql = new db;
	$vtsql -> db_Insert("vt_profile", "$profile_id, '$profile_fname', '$profile_lname', '$profile_org', '$profile_address', '$profile_city','$profile_state','$profile_country','$profile_index','$profile_username','$profile_email','$profile_phone','$profile_icq','$profile_desc','$profile_bonus'");
	$text = "<div id='vt_block'><font color=green>Ваши данные успешно сохранены! Теперь вы сможете оформлять заказы. Впрочем, в любой момент вы сможете изменить ваши данные.</font></div>";

	//header ("Location: ".e_PLUGIN."abook/abook.php?add");
	//exit;
	$unvis = "yes";
	$vis = "none";
	}
	$caption = "Сообщение";
	$ns -> tablerender($caption, $text);
}

//======Update_notes======//

if (isset($_POST['submit_update'])){
//-----Определение переменных из формы -----//      
	$profile_id =  $_POST['profile_id'];
	$profile_fname = $_POST['profile_fname'];
	$profile_lname = $_POST['profile_lname'];
	$profile_org = $_POST['profile_org'];
	$profile_address = $_POST['profile_address'];
	$profile_city = $_POST['profile_city'];
	$profile_state = $_POST['profile_state'];
	$profile_country = $_POST['profile_country'];
	$profile_index = $_POST['profile_index'];
	$profile_username = $_POST['profile_username'];
	$profile_email = $_POST['profile_email'];
	$profile_phone = $_POST['profile_phone'];
	$profile_icq = $_POST['profile_icq'];
	$profile_desc = $_POST['profile_desc'];
	$profile_bonus = $_POST['profile_bonus'];
//======check empty============//

	if ($profile_fname == '' || $profile_city == '' || $profile_address =='' || $profile_phone == '' || $profile_email == '' || $profile_bonus == ''){
	$text = "<div id='vt_block'><font color=red>Пожалуйста, заполните все поля отмеченные знаком *</font></div>";
	}
	else {
	$sql -> db_Update("vt_profile", "profile_fname='$profile_fname', profile_lname='$profile_lname', profile_org='$profile_org', profile_address='$profile_address', profile_city='$profile_city',  profile_state='$profile_state', profile_country='$profile_country', profile_index='$profile_index', profile_username='$profile_username', profile_email='$profile_email', profile_phone='$profile_phone', profile_icq='$profile_icq', profile_desc='$profile_desc', profile_bonus='$profile_bonus' WHERE profile_id='".USERID."'");
	$text = "<div id='vt_block'><font color=green>Ваши данные обновлены</font></div>";
	}
	$caption = "Сообщение";
	$ns -> tablerender($caption, $text);
}

//==========================Form_add=============================
$text .="<form method='post' enctype='multipart/form-data' name='form_add' id='form_add' style='border:0;float:top;' action=''>
<div id='vt_block'><table><tr><td><img src='".e_PLUGIN."md_vtrade/theme/images/vuser.png' alt='Настройки профиля'><td valign=top><font size=2>- Заполните поожалуйста все необходимые поля отмеченные занаком *. Эти поля являются обязательными к заполнению! Остальные поля заполняются по вашему желанию.

<br>- Если вам необходимо исправить адрес электронной почты или сменить пароль пройдите по<a href='".e_HTTP."usersettings.php'> этой ссылке.</font></tr></table></div>";

	$text .="<div id='vt_block'><table width=90%>";
	$text .="<tr><td></td><td><input class='tbox' type='hidden' name='profile_id' value='$profile_id' maxlength='200'/></td>";
	$text .="<tr><td></td><td><input class='tbox' type='hidden' name='profile_username' value='$profile_username' maxlength='200'/></td>";
	$text .="<tr><td>Ваша скидка на покупки *</td><td>
		<select class='tbox' name='profile_bonus'>";
		if ($profile_bonus <> '') {
			$text .="<option value='$profile_bonus'>$profile_bonus</option>";
			$text .="<option value=''></option>";
			$text .="<option value='Разовая'>Разовая</option>";
			$text .="<option value='Накопительная'>Накопительная</option>";
		}
		else {

			$text .="<option value=''>Выберите пожалуйста тип вашей скидки.</option>";
			$text .="<option value='Разовая'>Разовая</option>";
			$text .="<option value='Накопительная'>Накопительная</option>";
		}
	$text .="</select> <span id='check_devision'></span></td>";
	$text .="<tr><td>Ваше имя *</td><td><input class='tbox' type='text' name='profile_fname' onblur='checkname()' size='50' value='$profile_fname' maxlength='200'/><span id='check_name'></span></td>";
	$text .="<tr><td>Ваша фамилия *</td><td><input class='tbox' type='text' name='profile_lname' size='50' value='$profile_lname' maxlength='200'/></td>";
	$text .="<tr><td>Название организации</td><td><input class='tbox' type='text' name='profile_org' onblur='checkname()' size='50' value='$profile_org' maxlength='200'/><span id='check_name'></span></td>";
	$text .="<tr><td>Индекс</td><td><input class='tbox' type='text' name='profile_index' size='50' value='$profile_index' maxlength='200'/></td>";
	$text .="<tr><td>Страна</td><td><input class='tbox' type='text' name='profile_country' onblur='checkcity()' size='50' value='$profile_country' maxlength='200'/><span id='check_city'></span></td>";
	$text .="<tr><td>Область</td><td><input class='tbox' type='text' name='profile_state' onblur='checkcity()' size='50' value='$profile_state' maxlength='200'/><span id='check_city'></span></td>";
	$text .="<tr><td>Город *</td><td><input class='tbox' type='text' name='profile_city' onblur='checkcity()' size='50' value='$profile_city' maxlength='200'/><span id='check_city'></span></td>";
	$text .="<tr><td>Адрес *</td><td><input class='tbox' type='text' name='profile_address' onblur='checkaddress()' size='50' value='$profile_address' maxlength='200'/><span id='check_address'></span></td>";
	$text .="<tr><td>Электронный ящик *</td><td><input class='tbox' type='text' name='profile_email' size='50' value='".USEREMAIL."' maxlength='200'/></td>";
	$text .="<tr><td>ICQ</td><td><input class='tbox' type='text' name='profile_icq' size='50' value='$profile_icq' maxlength='200'/></td>";
	$text .="<tr><td>Телефон *</td><td><input class='tbox' type='text' name='profile_phone' onblur='phone()' size='50' value='$profile_phone' maxlength='200'/><span id='check_phone'></span></td>";

	$text .="<tr><td>Дополнительная информация</td><td><textarea cols=48 rows=10 class='tbox' type='text' name='profile_desc' maxlength='500'/>$profile_desc</textarea></td>";

	$text .= "<tr><td colspan=2 align=center><br>
	<input type='submit' class='button' style='cursor:pointer;display:$unvis;' name='submit_insert' value='Сохранить'  onClick='f_submit_add()'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis;' name='submit_update' value='Обновить' onClick='f_submit_add()'>
	</td></tr></table></div>
</form>";
}

$caption_section = "- <a href='".e_PLUGIN."md_vtrade/vtrade.php?profile'>Настройки профиля</a>";
?>