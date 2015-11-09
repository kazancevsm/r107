<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

$frontpage = $_GET['frontpage'];
$search = $_GET['search'];
$basket = $_GET['basket'];

(int)$multi = $_GET['multi'];
(int)$cat = $_GET['cat'];
(int)$sub = $_GET['sub'];
(int)$id = $_GET['id'];

$text ="<link rel='stylesheet' href='".e_PLUGIN."vtrade/theme/menu_type2.css' type='text/css'/>";
//=====================Output All Category======================
/*
	$text ="<div id='vt_cat_menu'>";
	$vtsql1 = new db;
	$vtsql1 -> db_Select("vt_cat", "*", "cat_sub='2'");
	while($row = $vtsql1 -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_sub = $row['cat_sub'];
		$cat_img = $row['cat_img'];
		$vtsql2 = new db;
		$catcount = $vtsql2 -> db_Count("vt_cat", "(*)", "WHERE cat_sub='".$cat_id."'");
		$vtsql3 = new db;
		$catcount_nom = $vtsql3 -> db_Count("vt_index", "(*)", "WHERE index_catid='".$cat_id."'");
		$text .= "<div id='vt_cat2_menu'><img src='".e_PLUGIN."vtrade/theme/bullet1.png'><b><a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id'>&nbsp;$cat_name&nbsp;&nbsp;($catcount_nom)</a></b></div>";
		
		
		if ($catcount>0){
		    $vtsql4 = new db;
		    $vtsql4 -> db_Select("vt_cat", "*", "cat_sub='".$cat_id."'");
		    while($row = $vtsql4 -> db_Fetch()){
			$cat_name = $row['cat_name'];
			$cat_id = $row['cat_id'];
			$cat_sub = $row['cat_sub'];
			$cat_img = $row['cat_img'];
			$vtsql5 = new db;
			$catcount_nom1 = $vtsql5 -> db_Count("vt_index", "(*)", "WHERE index_catid='".$cat_id."'");
			$text .= "<div id='vt_cat2_menu'>&nbsp; <img src='".e_PLUGIN."vtrade/theme/bullet2.png'><a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id'>&nbsp;$cat_name&nbsp;&nbsp;($catcount_nom1)</a></div>";
		    }
		
		}
	}
	$text .="</div>";
*/
	$text .="<div id='menu_container'><ul id='nav'>";
	$vtsql1 = new db;
	$vtsql1 -> db_Select("vt_cat", "*", "cat_sub='2' AND cat_vis='".VT_YES."' ORDER BY `cat_name` ASC");
	while($row = $vtsql1 -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_sub = $row['cat_sub'];
		$cat_img = $row['cat_img'];
		$vtsql2 = new db;
		$catcount = $vtsql2 -> db_Count("vt_cat", "(*)", "WHERE cat_sub='".$cat_id."'");
		$vtsql3 = new db;
		$catcount_nom = $vtsql3 -> db_Count("vt_index", "(*)", "WHERE index_catid='".$cat_id."'");
		$text .= "<li>";
		$text .= "<a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id'>$cat_name </a>";
		if ($catcount>0){
		$text .= "<a class='sub' tabindex='1'></a>";
		}
//		$text .= "<div id='vt_cat2_menu_count'>$catcount_nom</div>";($catcount_nom)
//		if ($catcount>0) {
//		    $text .= "<a href=# onmouseover=\"document.getElementById('vt_cat2_submenu').style.display='block'; return false;\"><div id='vt_cat2_menu_plus'>+</div></a>";
		
//		}
//		$text .= "<div id='vt_cat2_menu_minus'>-</div>";
		
		if ($catcount>0){
		$text .= "<ul>";
		    $vtsql4 = new db;
		    $vtsql4 -> db_Select("vt_cat", "*", "cat_sub='".$cat_id."'");
		    while($row = $vtsql4 -> db_Fetch()){
			$cat_name = $row['cat_name'];
			$cat_id = $row['cat_id'];
			$cat_sub = $row['cat_sub'];
			$cat_img = $row['cat_img'];
			$vtsql5 = new db;
			$catcount_nom1 = $vtsql5 -> db_Count("vt_index", "(*)", "WHERE index_catid='".$cat_id."'");
			$text .= "<li><a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id'><img src='".e_PLUGIN."vtrade/theme/bullet1.png'>  $cat_name&nbsp;&nbsp;($catcount_nom1)</a></li>";
		    }
		$text .= "</ul>";
		}
	$text .= "</li>";
	}
	$text .="</ul></div>";
$caption = "Категория";
$ns -> tablerender($caption, $text);
?>