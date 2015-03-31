<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================

	$catsql = new db;
	$catsql1 = new db;
	$catsql2 = new db;
	$catsql3 = new db;
	$catsql4 = new db;
	$catsql5 = new db;
	
	$table_cat = "".MPREFIX."catalog_cat";
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
	$conf_catshowcolscat = $pref['conf_catshowcolscat'];
	$conf_catshowrowscat = $pref['conf_catshowrowscat'];
	$conf_catshowcolsitems = $pref['conf_catshowcolsitems'];
	$conf_catshowrowsitems = $pref['conf_catshowrowsitems'];
	$conf_cathead = $pref['conf_cathead'];
	
//-----процедура добавления товара в корзину-----//
//if (IsSet($_GET['action']) && $_GET['action'] == 'add'){
if (IsSet($_POST['add'])){
	$nom_id = $_POST['nom_id'];
	$nom_amount = $_POST['nom_amount'];
	$ctsql2 -> db_Select("vt_nom", "*", "nom_id='$nom_id'");
		while($row = $ctsql2 -> db_Fetch()){
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
	$ctsql2 -> db_Delete("vt_basket", "basket_id='$del'");
//	$message = "<div id='vt_block'><font color=red>Товар был удален из корзины.</font></div>";
//	$ns -> tablerender("Сообщение", $message);
	unset($_SESSION['basket'][$del]);
//	<meta http-equiv="refresh" content="0; url=http://newdomain.com">
	//exit;
}
//------function add in basket--------
function discount_change($profile_bonus){
	$ctsql2 -> db_Update("vt_profile", "profile_fname='$profile_fname', profile_lname='$profile_lname', profile_org='$profile_org', profile_address='$profile_address', profile_city='$profile_city',  profile_state='$profile_state', profile_country='$profile_country', profile_index='$profile_index', profile_username='$profile_username', profile_email='$profile_email', profile_phone='$profile_phone', profile_icq='$profile_icq', profile_desc='$profile_desc', profile_bonus='$profile_bonus' WHERE profile_id='".USERID."'");
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
	      $ctsql2 -> db_Select("vt_basket", "*", "basket_userid='".USERID."' AND basket_ordstat='ready' AND basket_bonus='Накопительная'");
		while($row = $ctsql2 -> db_Fetch()){
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
	//-----функции для вывода обезанного текста-----//
function short_cat_desc($cat_desc) {
	$counttext = 30;
	$sep = ' ';
	$words = split($sep, $cat_desc);
	if ( count($words) > $counttext ){
		$cat_desc = join($sep, array_slice($words, 0, $counttext));
	}
	return $cat_desc;
}
function f_short_desc($desc,$counttext) {
	$sep = ' ';
	$words = split ($sep, $desc);
	if ( count($words) > $counttext ){
		$short_desc = join($sep, array_slice($words, 0, $counttext));
        }
    return $short_desc;
}
?>