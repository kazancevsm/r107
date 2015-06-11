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
			$NOM_ID = $row['nom_id'];
			$NOM_CAT = $row['nom_cat'];
			$NOM_NAME = $row['nom_name'];
			$nom_price = $row['nom_price'];
			
			$nom_desc = $row['nom_desc'];
			$nom_pic = $row['nom_pic'];
			$nom_count = $row['nom_count'];
		
		$nom_count = $nom_count+1;
		$vtsql -> db_Update("catalog_nom", "nom_count='$nom_count' WHERE nom_id='$id'");
	if(!empty($nom_pic)) {
		$NOM_PIC_PRE = "<img src='".e_PLUGIN."catalog/images/product_icons/$nom_pic' width=200px>";
		$NOM_PIC = "<img src='".e_PLUGIN."catalog/images/product_icons/$nom_pic'>";
	} else {
		$NOM_PIC = "<img src='".e_PLUGIN."catalog/images/img_empty.png'>";
	}
	if (IsSet($nom_price) && !empty($nom_price)) {
		$NOM_PRICE = number_format($nom_price,2)." руб.";
	}
	if (ADMIN == TRUE) {
	$text .="<a href='".e_PLUGIN."catalog/admin_config.php?nom.edit.$NOM_ID' style='cursor:pointer;' ><img src='".SITEURL."images/admin/edit_16.png'>&nbsp;</a>";
	}
		$NOM_DESC = $tp->toHTML($nom_desc,true,'body');
	if ($nom_amount == ""){
		$nom_amount = 1;
	}
	include('catalog_template.php');
	$text .= $DETAIL_NOMENCLATURE;
	}
$cat_name_sql = new db;
$cat_name_sql -> db_Select("catalog_cat", "*", "cat_id='$NOM_CAT'");
	while($row = $cat_name_sql -> db_Fetch()){
		$cat_id = $row["cat_id"];
		$cat_name = $row['cat_name'];
	}
	$caption_section = "- <a href= '".e_PLUGIN."catalog/catalog.php?page=list&cat=$NOM_CAT'>$cat_name</a> - <span alt='$NOM_NAME'>$NOM_NAME</span>";
//======end desc=====================================
?>