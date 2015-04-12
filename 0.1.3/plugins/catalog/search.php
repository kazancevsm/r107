<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

if (IsSet($_POST['submit_search'])){
$search = $_POST['search'];
$search = trim($search); 
$search = stripslashes($search);
//$sql = "SELECT nom_id, nom_name, nom_price1 FROM mf_vt_nom WHERE nom_name LIKE '%".strtoupper($search)."%' OR nom_name LIKE '%".strtoupper($search)."%' LIMIT 30"; 
//$query = mysql_query($sql);
$vtsql = new db;
$vtsql -> db_Select("vt_nom", "*", "nom_name LIKE '%".strtoupper($search)."%' OR nom_name LIKE '%".strtoupper($search)."%'");


if($vtsql){
//   while($row = mysql_fetch_assoc($query)){
	while($row = $vtsql -> db_Fetch(MYSQL_ASSOC)){
	      $nom_id = $row['nom_id'];
	      $nom_name = $row['nom_name'];
	      $nom_price1 = $row['nom_price1'];
$text .="<div id='vt_nom_item'><table width=98%><tr><td>";
$text .="<form enctype='multipart/form-data' name='form_result' method='post' action='".$PHP_SELF."'>";
$text .="<tr><td width=80%><a href ='".e_PLUGIN."md_vtrade/vtrade.php?page=det&id=$nom_id'>$nom_name</a></td>";
$text .="<td width=18%>$nom_price1 руб.</td>"; 
$text .="</form></td></tr></table>";
$text .="</div>";
}

}
	//}
//}
else $text .= "По вашему запросу ничего не найдено.";

}
/*
$text .="<div id='vt_navi_box' width=574px><center><table><tr><td>";
$text .="<form enctype='multipart/form-data' name='form_search' method='post' action='". $PHP_SELF ."'>";
$text .="<tr><td><input type='text' value='' name='search' size='40'><input type='submit' style='cursor:pointer;' value='поиск' name='submit_search'>";
$text .="</form></td></tr></table>";
$text .="</center></div>";
*/
?>