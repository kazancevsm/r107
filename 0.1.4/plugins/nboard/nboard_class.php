<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

//description of variables
	(int)$num_page = ($_GET['num_page']) ? $_GET['num_page'] : 0;
	$page = $_GET['page'];
	$month = date("m");
	$day = date("d");
	$year = date("y");
	$today = mktime(0,0,0,$month,$day,$year);
	$i=0;
	$cat = (int)$_GET['cat'];
	$scat = (int)$_GET['scat'];
	$id = (int)$_GET['id'];
	$action = $_GET['action'];
	$crit = $_POST["crit"];
	$stext = $_POST["stext"];
	if ($cat == '') $cat = 0;
	if ($scat == '') $scat = 0;
	
//======the text to an identical look=====//	
	$conf_showcols = $pref["nb_showcols"];
	$conf_showrows = (int)$pref["nb_showrows"];
	$conf_dateformat = $pref["nb_dateformat"];
	$conf_comments = $pref['nb_comments'];
	$conf_sizepicsmall = $pref['nb_sizepicsmall'];
	$conf_prolong = $pref['nb_prolong'];
	
	$table = "".MPREFIX."nb_gnl";
	$result_all = notice_all($conf_showrows, $num_page, $table);
	$result_cat = notice_cat($conf_showrows, $num_page, $cat, $table);
	$result_scat = notice_scat($conf_showrows, $num_page, $scat, $table);
	$result_search = notice_search($conf_showrows, $num_page, $crit, $stext, $table);
	$nbsql = new db;
	$nbsql1 = new db;
	$nbsql2 = new db;
	$nbfsql = new db;
	
//description of functions
function page(){
	if(empty($_GET["page"])){
		$page = 0;
	} else {
		if(!is_numeric($_GET["page"])) die("".NB_MES_09."");
        	$page = $_GET["page"];
	}
	return $page;
}
//================= selecting of all notices ==========================//
function notice_all($conf_showrows, $num_page, $table){
	$nbfsql = "SELECT * FROM ".$table." ORDER BY gnl_date_start DESC LIMIT ".$num_page.", ".$conf_showrows;
//	while ($row= mysql_fetch_array($sql)){
//		$gnl_date_end= $row['gnl_date_end'];
//	}
//	mysql_query ("DELETE FROM ".MPREFIX."nb_gnl WHERE gnl_date_end='$today'");
	$result_all = mysql_query($nbfsql) or die(mysql_error());
	return $result_all;
}
//================= selecting of cat notices ==========================//
function notice_cat($conf_showrows, $num_page, $cat, $table){
	$nbfsql = "SELECT * FROM ".$table." WHERE gnl_scatid in (select cat_id from ".MPREFIX."nb_cat where cat_sub_id='$cat') ORDER BY gnl_date_start DESC LIMIT ".$num_page.",".$conf_showrows."";
	$result_cat = mysql_query($nbfsql) or die(mysql_error());
	return $result_cat;
}
//================= selecting of subcat notices ==========================//
function notice_scat($conf_showrows, $num_page, $scat, $table){
	$nbfsql = "SELECT * FROM ".$table." WHERE gnl_scatid='$scat' ORDER BY gnl_date_start DESC LIMIT ".$num_page.", ".$conf_showrows;
	$result_scat = mysql_query($nbfsql) or die(mysql_error());
	return $result_scat;
}

//================= selecting of searching notices ==========================//
function notice_search($conf_showrows, $num_page, $crit, $stext, $table){
	$nbfsql = "SELECT * FROM ".$table." ORDER BY gnl_date_start DESC LIMIT ".$num_page.", ".$conf_showrows." ";
//	while ($row= mysql_fetch_array($sql)){
//		$gnl_date_end= $row['gnl_date_end'];
//	}
	mysql_query ("DELETE FROM ".MPREFIX."nb_gnl WHERE gnl_date_end='$today'");
	$result_search = mysql_query($nbfsql) or die(mysql_error());
	return $result_search;
}
/*
function theme_head() {
 	return "<script type='text/javascript' src='".e_PLUGIN."nboard/js/add.js'></script>
	<script type='text/javascript' src='".e_PLUGIN."nboard/js/add_check.js'></script>\n";
}
*/
function image_getsize($fname){
	if($imginfo = getimagesize($fname)){
		return ":width={$imginfo[0]}&height={$imginfo[1]}";
	}
	else{
		return "";
	}
}
?>