<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

//-----stylesheet------//
$text ="<link rel='stylesheet' href='".e_PLUGIN."vtrade/theme/menu_type1.css' type='text/css'/>";

(int)$multi = $_GET['multi'];
(int)$cat = $_GET['cat'];
(int)$sub = $_GET['sub'];
(int)$id = $_GET['id'];

//=====================Output All Category======================
	$text .="<table id='vt_cat1_menu' width=200px>";
	$vtsql1 = new db;
	$vtsql1 -> db_Select("vt_cat", "*", "cat_sub='1' AND cat_vis='".VT_YES."' ORDER BY `cat_name` ASC");
	while($row = $vtsql1 -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_multi = $row['cat_multi'];
		$cat_img = $row['cat_img'];
		
		$text .= "<tr><td id='vt_cat1_menu'><a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id'>$cat_name</a></td>";
		$text .= "<td id='vt_cat1_menu'><a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id'>
		<img src='".e_PLUGIN."vtrade/vt_pictures/category/$cat_img' height=47px></a></td></tr>";
	}
	$text .="</table>";

$caption = "Производитель";
$ns -> tablerender($caption, $text);
?>