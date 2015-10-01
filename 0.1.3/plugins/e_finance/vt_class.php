<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

	$vtsql = new db;
	$vtsql1 = new db;
	$vtsql2 = new db;
	$vtsql3 = new db;
	$vtsql4 = new db;
	$vtsql5 = new db;
	
	session_start();
//	session_destroy();
	
$s_basket = $_SESSION['basket'];

if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
    $_SESSION['total_items'] = 0;
    $_SESSION['total_price'] = '0.00';
}

//=============params for action========
$page = $_GET['page'];
//=============params for sql query=====
$cat = (int)$_GET['cat'];
$id = (int)$_GET['id'];
$showcat = (int)$_GET['showcat'];
$i=0;
/*
global $sorting;
$sorting = $_POST['sorting'];
if (!IsSet($sorting)) {
	$sorting = "ORDER BY `nom_price1` ASC";
}*/
//==============Date====================
	$month = date("m");
	$day = date("d");
	$year = date("y");
	$order_date = mktime(0,0,0,$month,$day,$year);
	$basket_date = mktime(0,0,0,$month,$day,$year); 
//==============options of vtrade=======
	$conf_showcolscat = $pref['conf_showcolscat'];
	$conf_showrowscat = $pref['conf_showrowscat'];
	$conf_showcolsitems = $pref['conf_showcolsitems'];
	$conf_showrowsitems = $pref['conf_showrowsitems'];
	$conf_vthead = $pref['conf_vthead'];
	
//-----процедура добавления товара в корзину-----//
//if (IsSet($_GET['action']) && $_GET['action'] == 'add'){
if (IsSet($_POST['add'])){
	$nom_id = $_POST['nom_id'];
	$nom_amount = $_POST['nom_amount'];
	$vtsql2 -> db_Select("vt_nom", "*", "nom_id='$nom_id'");
		while($row = $vtsql2 -> db_Fetch()){
		$nom_id = $row['nom_id'];
		$nom_cat = $row['nom_cat'];
		$nom_num = $row['nom_num'];
		$nom_art = $row['nom_art'];
		$nom_code = $row['nom_code'];
		$nom_name = $row['nom_name'];
		$nom_type = $row['nom_type'];
		$nom_unit = $row['nom_unit'];
		$nom_desc_mini = $row['nom_desc_mini'];
		$nom_desc_all = $row['nom_desc_all'];
		$nom_pic = $row['nom_pic'];
		$nom_price1 = $row['nom_price1'];
		$nom_price2 = $row['nom_price2'];
/*
		if(isset($_SESSION['basket'][$nom_id])) {
		      $_SESSION['basket'][$nom_id]++;
		      return true;
		}
		else{
		      $_SESSION['basket'][$nom_id] = 1;
		      return true;
		}
//		return false;
*/
		if(isset($_SESSION['basket'][$_POST['nom_id']])){
			 $_SESSION['basket'][$_POST['nom_id']]+= $nom_amount;
		}else{
			$_SESSION['basket'][$_POST['nom_id']] = $nom_amount;
		}
	
	}
}

// -----removal procedure--------------------------------------------------------

if (IsSet($_GET['del'])){
	$nom_id = $_GET['basket_id'];
	$del = $_GET['del'];
	$vtsql2 -> db_Delete("vt_basket", "basket_id='$del'");
//	$message = "<div id='vt_block'><font color=red>Товар был удален из корзины.</font></div>";
//	$ns -> tablerender("Сообщение", $message);
	unset($_SESSION['basket'][$del]);
//	<meta http-equiv="refresh" content="0; url=http://newdomain.com">
	//exit;
}
//------function add in basket--------
function discount_change($profile_bonus){
	$vtsql2 -> db_Update("vt_profile", "profile_fname='$profile_fname', profile_lname='$profile_lname', profile_org='$profile_org', profile_address='$profile_address', profile_city='$profile_city',  profile_state='$profile_state', profile_country='$profile_country', profile_index='$profile_index', profile_username='$profile_username', profile_email='$profile_email', profile_phone='$profile_phone', profile_icq='$profile_icq', profile_desc='$profile_desc', profile_bonus='$profile_bonus' WHERE profile_id='".USERID."'");
	return $result;
}
	
function get_product($nom_id){
        $query = ("SELECT * FROM ".MPREFIX."vt_nom WHERE nom_id='$nom_id' ");
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        return $row;
}
function get_discount($nom_id){
    if ($profile_bonus == 'Накопительная') {
	      $vtsql2 -> db_Select("vt_basket", "*", "basket_userid='".USERID."' AND basket_ordstat='ready' AND basket_bonus='Накопительная'");
		while($row = $vtsql2 -> db_Fetch()){
			$basket_price = $row['basket_price'];
			$basket_amount = $row['basket_amount'];
			$sum1 = $basket_amount * $basket_price;
			$total1 = $total1 + $sum1;
		}
		if ($total1 >= 1000 AND $total1 < 3000) {
		    $sd = 0.03;
		}
		if ($total1 >= 3000 AND $total1 < 7000) {
		    $sd = 0.05;
		}
		if ($total1 >= 7000 AND $total1 < 15000) {
		    $sd = 0.08;
		}
		if ($total1 >= 15000 AND $total1 < 30000) {
		    $sd = 0.1;
		}
		if ($total1 >= 30000) {
		    $sd = 0.15;
		}
//	$discount = $total - ($total*$ad);
	}
	
	if ($profile_bonus == 'Разовая' || USER==FALSE) {
		if ($total < 5000){
			 $skd = 5000 - $total;
			 $sd = 0.0;
			 $sd_text = '';
			 $sd1='5%';
		}
		if ($total >= 5000 AND $total < 10000){
			 $skd = 10000 - $total;
			 $sd = 0.05;
			 $sd_text = '(5%)';
			 $sd1='10%';
		}
		if ($total >= 10000 AND $total < 15000) {
			 $skd = 15000 - $total;
			 $sd = 0.1;
			 $sd_text = '(10%)';
			 $sd1='15%';
		}
		if ($total >= 15000) {
//			$skd = 15000 - $total;
			$sd = 0.15;
			$sd_text = '(15%)';
			$sd1='15%';
	      }
//	$discount = $total - ($total*$sd);
	}
	
	return $result;
	}
?>