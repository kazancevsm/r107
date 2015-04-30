<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

	$vtsql = new db;
	$vtsql -> db_Select("vt_nom", "*", "nom_id ='$id'");
                while($row = $vtsql -> db_Fetch()){
			$nom_desc_all = $row['nom_desc_all'];
			$nom_name = $row['nom_name'];
			$nom_pic = $row['nom_pic'];
			$nom_price1 = $row['nom_price1'];
			$nom_price2 = $row['nom_price2'];
		}
	$text .="<form name='nom' method='post' action='".$PHP_SELF."'><div id='vt_cat_desc'><table width=98%><tr>";
	$text .="<td rowspan=2><img src='".e_PLUGIN."vtrade/vt_pictures/product_icons/$nom_pic' border='0' width=100px></td>";
	$text .="<td colspan=2><font size=3>$nom_name</font></td></tr>";
	
	if ($nom_price2 <> '' AND $nom_price2 <> '0'){
		$text .= "<tr><td width=20%><b><font size=4 color=red>$nom_price2</font></b></td>";
		$text .= "<b><strike> $nom_price1</strike></b>";
		$basket_price = $nom_price2;
	}
	else {
		$text .= "<tr><td width=20%><b><font size=4>$nom_price1</font></b></td>";
		$basket_price = $nom_price1;
	}
	if ($nom_amount == ""){
		$nom_amount = 1;
	}
	$text .="<td>";
	$text .="<input type='hidden' name='nom_id' value='$id'>";
	$text .="<input type='hidden' name='nom_name' value='$nom_name'>";
	$text .="<input type='hidden' name='nom_art' value='$nom_art'>";
	$text .="<input type='hidden' name='basket_price' value='$basket_price'>";
	$text .="<input id='tbox' type='text' size='3' name='nom_amount' value='$nom_amount'>";
	$text .="<input id='button' style='cursor:pointer' type='submit' value='".VT_BUT_ADDBASK."' name='add'></td></tr>";
	$parseBB = $tp->toHTML($nom_desc_all,true,'body');
	$text .="<tr><td colspan=3>$parseBB<br></td></tr>";
	$text .="</table></div></form>";
$caption_section = " - <a href='".e_PLUGIN."vtrade/vtrade.php?page=item&id=$nom_id'>".VT_VT_DESC."</a>";

//======end desc=====================================
?>