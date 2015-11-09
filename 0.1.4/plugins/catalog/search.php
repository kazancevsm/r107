<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

$text .="<div id='vt_navi_box' width=574px><center><table><tr><td>";
$text .="<form enctype='multipart/form-data' name='form_search' method='post' placeholder='Наименование товара...' action='". $PHP_SELF ."'>";
$text .="<tr><td><input type='text' class='tbox' style='margin:5px;' value='' name='search' size='40'><input type='submit' value='Найти' class='button' name='submit_search'>";
$text .="</form></td></tr></table>";
$text .="</center></div>";



if (IsSet($_POST['submit_search']) && !empty($_POST['search'])){
	$search = $_POST['search'];
	$search = trim($search); 
	$search = stripslashes($search);
	$csql = new db;
	$csql -> db_Select("catalog_nom", "*", "nom_name LIKE '%".strtoupper($search)."%' OR nom_name LIKE '%".strtoupper($search)."%'");
$text .="Найдены слеующие товары по запросу <b>".$_POST['search']."</b> :";
$text .="<table>";
	if($csql){

		while($row = $csql -> db_Fetch(MYSQL_ASSOC)){
		$nom_id = $row['nom_id'];
		$nom_cat = $row['nom_cat'];
		$nom_art = $row['nom_art'];
		$nom_name = $row['nom_name'];
		$nom_desc = $row['nom_desc'];
		$nom_pic = $row['nom_pic'];
		$nom_price = $row['nom_price'];
		$desc_short = substr ($nom_desc, 0, 100);




$text .="<form enctype='multipart/form-data' name='form_result' method='post' action='".$PHP_SELF."'>";
$text .= "<tr><td class='r_header1' width=100px>";
	/*
	if ($nom_pic == '') {
		$text .="<img src='".e_PLUGIN."catalog/theme/images/nom_empty.png' height=100px></div>";
	}
	*/
	if ($nom_pic <> '') {
		$text .="<div style=' background:#fff; overflow:hidden;'><a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$nom_id'><img src='images/product_icons/$nom_pic' height=100px></a></div>";
	}
	$text .= "</td>";	
	$text .= "<td class='r_header1' width=500px><a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$nom_id'><font size=2><b>$nom_name</b></font></a><br>";
$short_desc = explode(" ", $nom_desc);
//берем первые 6 элементов
$arr = array_slice($short_desc, 0, 70);
//превращаем в строку
$nom_short_desc = implode(" ", $arr);
 
// Если необходимо добавить многоточие
if (count($arr_str) > 70) {
   $nom_short_desc .= "...";
}
	
	$parseBB = $tp->toHTML($nom_short_desc,true,'body');
	$text .= "$parseBB...<a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$nom_id'>Подробное описание >>></a>";
	
	$text .= "</td><td class='r_header1' width=140px>";
	if (IsSet($nom_price) && !empty($nom_price)) {

	$text .= "<b>".number_format($nom_price,2)." руб.</b>";
	}
	if ($nom_amount == ""){
		$nom_amount = 1;
	}
	$text .="</td></tr>";
	}
$text .="</form></td></tr></table>";

		}
	else {
		$text .= "По вашему запросу ничего не найдено.";
	}
}
	
if (empty($_POST['search'])) {
		$text .= "Вы ввели пустой запрос. ";
}


?>