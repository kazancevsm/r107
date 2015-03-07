<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================
//======links====================//
$catsql -> db_Select("catalog_cat", "*", "cat_id='$cat'");
	while($row = $catsql-> db_Fetch()){
	    $cat_sub = $row['cat_sub'];
	    $cat_name = $row['cat_name'];
	    $cat_desc = $row['cat_desc'];
	}
if ($cat_sub =='0') {
	$caption_section = " - <a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$cat'>$cat_name</a>";
}
if ($cat_sub !=='0') {	
	$catsql -> db_Select("catalog_cat", "*", "cat_id='$cat_sub'");
		while($row = $catsql-> db_Fetch()){
		$catId = $row['cat_id'];
		$catName = $row['cat_name'];
		$catDesc = $row['cat_desc'];
		}
$caption_section = " - <a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$catId'>$catName</a> - <a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$cat'>$cat_name</a>";
	}
$parseBB = $tp->toHTML($cat_desc,true,'body');

if (!empty($cat_desc)) {
	$text ="$parseBB<br>";
	}
if (IsSet($cat) && $cat <> 0) $total_items = $catsql1 -> db_Select("catalog_nom", "*", "nom_cat='$cat'");
$from = ($_GET['num_page']) ? $_GET['num_page'] : 0;
if ($total_items>$conf_showrowsitems){
	$catsql2 -> db_Select("catalog_cat", "*", "cat_id='$cat'");
	while($row = $catsql2-> db_Fetch()){
	    $showcat = $row['cat_sub'];
	    $showcatname = $row['cat_name'];
	}
$parms = $total_items.",".$conf_showrowsitems.",".$from.",".e_SELF."?page=list&cat=".$cat."&num_page=[FROM]&showcat=".$showcat."";
$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");

}
//======numbers of pages===========//
$result_allitem = sql_allitem($from,$conf_catshowrowsitems);
// ======output nomenklature of category==========================================

//===============parametr of sorting=====
//expression ? true_value : false_value
	$sort = $_GET['sort'];
	if ($sort==1) $sorting = 'ORDER BY `nom_price` ASC';
	if ($sort==2) $sorting = 'ORDER BY `nom_price` DESC';
	if ($sort==3) $sorting = 'ORDER BY `nom_name` ASC';
	if ($sort==4) $sorting = 'ORDER BY `nom_name` DESC';

// ======output nomenklature and category==========================================
$text .="<table width=100%>";
if (IsSet($cat) && $cat == 0) {
	$catsql = new db;
	$catsql -> db_Select("catalog_cat", "*", "cat_sub='$cat'");
	while($row = $catsql -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_pic = $row['cat_pic'];
		$cat_desc = $row['cat_desc'];
		$text .= "<tr><td class='forumheader width=100px>";
		if ($cat_pic !== '') {
			$text.="<div style='background:#fff; overflow:hidden;'><a href=catalog.php?page=list&cat=$cat_id><img src='images/category/$cat_pic' alt='$cat_name'></a></div>";
		}
		$text.="</td>";
		$text .= "<td class='forumheader' width=auto><a href=catalog.php?page=list&cat=$cat_id><b><h3>$cat_name</h3></b></a>";
		$short_desc = f_short_desc($cat_desc,40);
		$parseBB = $tp->toHTML($short_desc,true,'body');
		if (!empty($cat_desc)) {
			 $text .="<br>$parseBB";
		}
		$text .= "</td></tr>";
	}
}
if (IsSet($cat) && $cat <> 0) {
	$catsql = new db;
	$catsql -> db_Select("catalog_cat", "*", "cat_sub='$cat'");
	while($row = $catsql -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_pic = $row['cat_pic'];
		$cat_desc = $row['cat_desc'];
		$text .= "<tr><td class='forumheader width=100px>";
		if ($cat_pic !== '') {
			$text.="<div style='background:#fff; overflow:hidden;'><a href=catalog.php?page=list&cat=$cat_id><img src='images/category/$cat_pic' height='100px' alt='$cat_name'></a></div>";
		}
		$text.="</td>";
		$text .= "<td class='forumheader' width=auto><a href=catalog.php?page=list&cat=$cat_id><b><h3>$cat_name</h3></b></a>";
		
		$short_desc = f_short_desc($cat_desc,30);
		$parseBB = $tp->toHTML($short_desc,true,'body');
		if (!empty($cat_desc)) {
			 $text .="<br>$parseBB";
		}
		$text .= "</td><td width=140px></td></tr>";
	}
}
// ======output nomenklature================================================
//	$catsql -> db_Select("catalog_nom", "*", "WHERE nom_cat='$cat' $sort LIMIT $from,$conf_showrowsitems", "no-where");
	$catsql -> db_Select("catalog_nom", "*", "nom_cat='$cat'");
	while($row = $catsql -> db_Fetch()){
		$nom_id = $row['nom_id'];
		$nom_cat = $row['nom_cat'];
		$nom_art = $row['nom_art'];
		$nom_name = $row['nom_name'];
		$nom_desc = $row['nom_desc'];
		$nom_pic = $row['nom_pic'];
		$nom_price = $row['nom_price'];
		$desc_short = substr ($nom_desc, 0, 100);
	$text .= "<tr><td class='forumheader' width=100px>";

	/*
	if ($nom_pic == '') {
		$text .="<img src='".e_PLUGIN."catalog/theme/images/nom_empty.png' height=100px></div>";
	}
	*/
	if ($nom_pic <> '') {
		$text .="<div style=' background:#fff; overflow:hidden;'><a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$nom_id'><img src='images/product_icons/$nom_pic' height=100px></a></div>";
	}
	$text .= "</td>";	
	$text .= "<td class='forumheader' width=500px><a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$nom_id'><font size=2><b>$nom_name</b></font></a><br>";
	$short_desc = f_short_desc($nom_desc,30);
	
	$parseBB = $tp->toHTML($short_desc,true,'body');
	$text .= "$parseBB...<a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$nom_id'>Подробное описание >>></a>";
	
	$text .= "</td><td class='forumheader' width=140px>";
	if (IsSet($nom_price) && !empty($nom_price)) {

	$text .= "<b>".number_format($nom_price,2)." руб.</b>";
	}
	if ($nom_amount == ""){
		$nom_amount = 1;
	}
	$text .="</td></tr>";
	}
 $text .="</table>";



//======numbers of pages===========//
if (IsSet($cat) && $cat <> 0) $total_items = $catsql1 -> db_Select("catalog_nom", "*", "nom_cat='$cat'");
$from = ($_GET['num_page']) ? $_GET['num_page'] : 0;
if ($total_items>$conf_showrowsitems){
	$catsql2 -> db_Select("catalog_cat", "*", "cat_id='$cat'");
	while($row = $catsql2-> db_Fetch()){
	    $showcat = $row['cat_sub'];
	    $showcatname = $row['cat_name'];
	}
 $parms = $total_items.",".$conf_showrowsitems.",".$from.",".e_SELF."?page=list&cat=".$cat."&num_page=[FROM]&showcat=".$showcat."";
 $text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
 }

?>