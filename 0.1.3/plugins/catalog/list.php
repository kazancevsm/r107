<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================

//==== OUTPUT links & category description
if (IsSet($cat) && $cat<>0) {
		$catsql -> db_Select("catalog_cat", "*", "cat_sub='$cat'");
		while($row = $catsql-> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$catDesc = $row['cat_desc'];
		}
		$catsql -> db_Select("catalog_cat", "*", "cat_id='$cat'");
		while($row = $catsql-> db_Fetch()){
			$cat_sub = $row['cat_sub'];
			$cat_name = $row['cat_name'];
			$cat_desc = $row['cat_desc'];
		}
		$CAT_DESC = $tp->toHTML($cat_desc,true,'body');
		if (!empty($cat_desc)) {
			$text .= "{$CAT_DESC}<br>";
		}
		if ($cat_sub !=='0'){
//	
	$caption_section = " - <a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$catId'>$catName</a> - <a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$cat'>$cat_name</a>";
	} else {
	$caption_section = "- <a href='".e_PLUGIN."catalog/catalog.php?page=list&cat=$cat'>$cat_name</a>";
	}
}


/*
if (isset($cat)) {
//if (isset($cat_sub) && $cat_sub !=='0') {	
	



$result_allitem = sql_allitem($from,$conf_catshowrowsitems);
}
*/

//===============parametr of sorting
//expression ? true_value : false_value
	$sort = $_GET['sort'];
	if ($sort==1) $sorting = 'ORDER BY `nom_price` ASC';
	if ($sort==2) $sorting = 'ORDER BY `nom_price` DESC';
	if ($sort==3) $sorting = 'ORDER BY `nom_name` ASC';
	if ($sort==4) $sorting = 'ORDER BY `nom_name` DESC';

	$text .="<table width=100%>";
	
//=====	OUTPUT category where cat_sub=0
if (!IsSet($cat) || empty($cat)) {
$caption_section = "";
	$catsql = new db;
	$catsql -> db_Select("catalog_cat", "*", "cat_sub='0'");
	while($row = $catsql -> db_Fetch()){
		$CAT_NAME = $row['cat_name'];
		$CAT_ID = $row['cat_id'];
		$cat_pic = $row['cat_pic'];
		if ($cat_pic !== '') {
			$CAT_PIC ="<img src='images/category/$cat_pic' alt='$cat_name'>";
		} else {
			$CAT_PIC ="<img src='images/img_empty.png' alt='$cat_name'>";
		}
		$CAT_DESC = $row['cat_desc'];
		
		//short decription
		$short_desc = explode(" ", $CAT_DESC);
		//first 6 elements
		$arr = array_slice($short_desc, 0, 70);
		//string type
		$cat_short_desc = implode(" ", $arr);
		// end point
		if (count($arr_str) > 70) {
			$cat_short_desc .= "...";
		}
		//parser
		
		if (!empty($CAT_DESC)) {
			 $CAT_SHORT_DESC = $tp->toHTML($cat_short_desc,true,'body');
		}
		include('catalog_template.php');
		$text .= $LIST_CAT_GENERAL;
	}
}
//=====	OUTPUT category where cat_sub<>0
if (IsSet($cat) && $cat <> 0) {
$catsql -> db_Select("catalog_cat", "*", "cat_sub='$cat'");
while($row = $catsql -> db_Fetch()){
	$CAT_NAME = $row['cat_name'];
	$CAT_ID = $row['cat_id'];
	$cat_pic = $row['cat_pic'];
	if ($cat_pic !== '') {
		$CAT_PIC ="<img src='images/category/$cat_pic' alt='$cat_name'>";
	} else {
		$CAT_PIC ="<img src='images/img_empty.png' alt='$cat_name'>";
	}
	$CAT_DESC = $row['cat_desc'];
	//short decription
	$short_desc = explode(" ", $CAT_DESC);
	//first 6 elements
	$arr = array_slice($short_desc, 0, 70);
	//string type
	$cat_short_desc = implode(" ", $arr);
	// end point
	if (count($arr_str) > 70) {
		$cat_short_desc .= "...";
	}
	//parser	
	if (!empty($CAT_DESC)) {
		 $CAT_SHORT_DESC = $tp->toHTML($cat_short_desc,true,'body');
	}
	include('catalog_template.php');
	$text .= $LIST_CAT_SUB;
}
	



//=====	OUTPUT nomenklature

//=====	numbers of pages
$total_items = $catsql -> db_Select("catalog_nom", "*", "nom_cat='$cat'");
$text .= "<div class='nextprev'>";
$from = ($_GET['num_page']) ? $_GET['num_page'] : 0;
$parms = $total_items.",".$conf_catshowrowsitems.",".$from.",".e_SELF."?page=list&cat=".$cat."&num_page=[FROM]&showcat=".$showcat."";
$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
$text .= "</div>";
//=====end namber pages

	$catsql -> db_Select("catalog_nom", "*", "WHERE nom_cat='$cat' $sort LIMIT $from,$conf_catshowrowsitems", "no-where");
	while($row = $catsql -> db_Fetch()){
		$NOM_ID = $row['nom_id'];
		$NOM_CAT = $row['nom_cat'];
		$NOM_ART = $row['nom_art'];
		$NOM_NAME = $row['nom_name'];
		
		$nom_pic = $row['nom_pic'];
		$nom_desc = $row['nom_desc'];
		$nom_price = $row['nom_price'];

		if ($nom_pic !=='') {
			$NOM_PIC = "<img src='images/product_icons/$nom_pic' height=100px>";
		} else {
			$NOM_PIC ="<img src='images/img_empty.png' alt='$cat_name' height=100px>";
		}
		$short_desc = explode(" ", $nom_desc);
		//берем первые 6 элементов
		$arr = array_slice($short_desc, 0, 70);
		//превращаем в строку
		$nom_short_desc = implode(" ", $arr);
		// Если необходимо добавить многоточие
		if (count($arr_str) > 70) {
			$nom_short_desc .= "...";
		}
		$NOM_SHORT_DESC = $tp->toHTML($nom_short_desc,true,'body');
		if (IsSet($nom_price) && !empty($nom_price)) {
			$NOM_PRICE = number_format($nom_price,2)." руб.";
		}
		if ($nom_amount == ""){
			$nom_amount = 1;
		}
	include('catalog_template.php');
	$text .= $LIST_NOMENCLATURE;
}


}




//$result_allitem = sql_allitem($from,$conf_catshowrowsitems);

$text .="</table>";
//=====	numbers of pages
$text .= "<div class='nextprev'>";
$from = ($_GET['num_page']) ? $_GET['num_page'] : 0;
$parms = $total_items.",".$conf_catshowrowsitems.",".$from.",".e_SELF."?page=list&cat=".$cat."&num_page=[FROM]&showcat=".$showcat."";
$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
$text .= "</div>";
//=====end namber pages
?>