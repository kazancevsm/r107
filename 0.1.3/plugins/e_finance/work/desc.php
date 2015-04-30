<?php
/*===========The Virtual Trade Plugin for e107==================
|	Sunout, http://e107.compolys.ru, sunout@compolys.ru
|	GNU General Public License (http://gnu.org)
======================march 2011===============================*/
require_once("../../class2.php");
//if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once("languages/".e_LANGUAGE.".php");
require_once(HEADERF);
//$nom_pic = $_GET["image"];
$ns = new e107table;
$cat = $_GET['cat'];
$id = $_GET["id"];
	$sql -> db_Select("vt_conf", "*", "");
	while($row = $sql -> db_Fetch()){
		$conf_sizepicsmall = $row['conf_sizepicsmall'];
		$conf_func = $row['conf_func'];
		$conf_vthead = $row['conf_vthead'];
	}
	$sql -> db_Select("vt_nom", "*", "nom_id ='$id'");
                while($row = $sql -> db_Fetch()){
			$nom_desc = $row['nom_desc'];
			$nom_name = $row['nom_name'];
			$nom_pic = $row['nom_pic'];
			$nom_price2 = $row['nom_price2'];
			$nom_price3 = $row['nom_price3'];
		}
	$text ="<table class='forumheader1' style='width:100%' border=0>";
	$text .="<tr><td class='forumheader2' rowspan=4><img width='$conf_sizepicsmall' src='vt_pictures/products/big/$nom_pic' border='0'></td>";
	$text .="<tr><td class='forumheader2'><font size=3>$nom_name</font></td></tr>";
	$text .="<tr><td class='forumheader2'><br>$nom_desc</center><br></td></tr>";
//===============function_trade=====================
	if ($conf_func == VT_YES){
		if ($nom_price3 <> ''){
		$text .= "<td class='forumheader2'><b><font size=3 color=red>$nom_price3</font></b><br>";
		$text .= "<b><strike>$nom_price2</strike></b>";
		} else{
		$text .="<tr><td class='forumheader2'><font size=3>$nom_price2</font>";
		}
		$text .="<br><form method='post' action='cart.php?action=add_item&id=$id'>Количество: <input class='tbox' type='text' size='3' name='qty' value='1'> <input class='button' style='cursor:pointer' type='submit' value='".VT_BUT_ADDBASK."' name='submit'></form></td></tr>";
	}
//============end_function_trade====================
	$text .="</table>";
	$text .="<center><a href='vtrade.php'>".VT_BUT_BEGIN."</a> | ";
//===============function_trade=====================
	if ($conf_func == VT_YES){
	$text .="<a href='cart.php?action=view_cart'>".VT_BUT_BASK."</a> | ";
	}
//============end_function_trade====================
	$text .="<a href='vtrade.php?cat=$cat'>".VT_BUT_BACK." </a></center>";
$caption = "$conf_vthead - ".VT_DESC_01."";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>