<?php
if (IsSet($_POST['but_addbask'])){
//-----Определение переменных из формы -----//      
	$basket_id = $_POST['basket_id'];
	$basket_userid = USERID;
	$basket_user = USERNAME;
	$basket_nom_name = $_POST['nom_name'];
	$basket_nom_art = $_POST['nom_art'];
	$basket_amount = $_POST['nom_amount'];
	$basket_price = $_POST['basket_price'];
	$basket_ordstat = "waiting";
	$basket_bonus = $profile_bonus;
	
$text .= "<div id=\"vt_block\">$basket_id, $basket_userid, $basket_user, $basket_nom_name, $basket_nom_art,$basket_price,$basket_amount,$basket_ordstat, ".strftime('%d %b %Y',$basket_date).", $basket_bonus</div>";
//	$vtsql = new db;
//	$vtsql -> db_Insert("vt_basket", "0, '$profile_fname', '$profile_lname', '$profile_org', '$profile_address', '$profile_city','$profile_state','$profile_country','$profile_index','$profile_username','$profile_email','$profile_phone','$profile_icq','$profile_desc','$profile_bonus'");	
} 

?>