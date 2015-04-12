<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================

//-----stylesheet------//
$text ="<link rel='stylesheet' href='".e_PLUGIN."catalog/theme/menu_type1.css' type='text/css'/>";

(int)$cat = $_GET['cat'];
(int)$sub = $_GET['sub'];
(int)$id = $_GET['id'];

//=====================Output All Category======================
	$text .="<table id='ct_cat1_menu' width=100%>";
	$catsql = new db;
	$catsql -> db_Select("catalogt_cat", "*", "cat_sub='0' ORDER BY `cat_name` ASC");
	while($row = $catsql -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_pic = $row['cat_pic'];
		
		$text .= "<tr><td id='ct_cat1_menu'><center><a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$cat_id'><img src='".e_PLUGIN."catalog/pictures/category/$cat_pic' height=100px></a>";
		$text .= "<br><a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$cat_id'>$cat_name</a>
		</center><hr></td></tr>";
	}
	$text .="</table>";

$caption = "Продукция";
$ns -> tablerender($caption, $text);
?>