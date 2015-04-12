<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================
	$vtsql = new db;
	$vtsql -> db_Select("catalog_nom", "*", "nom_id ='$id'");
                while($row = $vtsql -> db_Fetch()){
			$nom_id = $row['nom_id'];
			$nom_cat = $row['nom_cat'];
			$nom_desc = $row['nom_desc'];
			$nom_name = $row['nom_name'];
			$nom_pic = $row['nom_pic'];
			$nom_price = $row['nom_price'];
		}
	$text .="<table width=700px><tr>";
	if(!empty($nom_pic)) {
	$text .="<td width=100px height='100px'><img src='".e_PLUGIN."catalog/images/product_icons/$nom_pic' border='0'  height='100px'></td>";
	}
	/*if(empty($nom_pic)) {
	$text .="<td width=100px height='100px'><img src='".e_PLUGIN."catalog/theme/images/nom_empty.png' border='0' height='100px'></td>";
	}*/
	$parseBB = $tp->toHTML($nom_desc,true,'body');
	$text .="<td ><b><h3>";
	if (ADMIN == TRUE) {
	$text .="<a href='".e_PLUGIN."catalog/admin_config.php?nom.edit.$nom_id' style='cursor:pointer;' ><img src='".SITEURL."images/admin/edit_16.png'>&nbsp;</a>";
	}
 	$text .="$nom_name</h3></b>&nbsp;&nbsp;&nbsp;";
 	if (IsSet($nom_price) && !empty($nom_price)) {
	$text .= "<b>".number_format($nom_price,2)." руб.</b>";
	}
 	$text .= "<br><hr width=100% size=1/><br>$parseBB<br></td>";
		$text .= "<td ><b><font size=4></font></b></td></tr>";
	if ($nom_amount == ""){
		$nom_amount = 1;
	}
	$text .="</table>";
$cpsql = new db;
$cpsql -> db_Select("ct_cat", "*", "cat_id='$nom_cat'");
	while($row = $cpsql-> db_Fetch()){
	    
	    $cat_name = $row['cat_name'];
	}
	$caption_section = "- <a href= '".e_PLUGIN."catalog/catalog.php?page=list&cat=$nom_cat'>$cat_name</a> - $nom_name";
//======end desc=====================================
?>