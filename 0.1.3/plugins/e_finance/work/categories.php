<?php
//============================= Virtual-Trade v1.0 ===============================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru		
//	coders: Sunout, Geo						
//	language officer Georgy Pyankov
//	license GNU GPL									
//==================================== March 2012 ================================

//-----процедура добавления товара в корзину-----//
if (IsSet($_POST['add'])){
//-----Проверка на пользователя-----//
    if (USER==FALSE) {
	$text .= "<div id='vt_block'>".VT_MES_NOLOGIN."</div>";
    }
    if (USER==TRUE) {
//-----Определение переменных из формы -----//      
	$basket_id = $_POST['basket_id'];
	$basket_userid = USERID;
	$basket_user = USERNAME;
	$basket_nom_name = $_POST['nom_name'];
	$basket_nom_art = $_POST['nom_art'];
	$basket_amount = $_POST['nom_amount'];
	$basket_price = $_POST['basket_price'];
	$basket_ordstat = "waiting";
	$basket_ordnumber = " ";
	$vtsql = new db;
	$vtsql -> db_Select("vt_profile", "*", "profile_id='".USERID."'");	
		while($row = $vtsql -> db_Fetch()){
			 $basket_bonus = $row['profile_bonus'];
		}
	$vtsql1 = new db;
	$vtsql1 -> db_Insert("vt_basket", "0, '$basket_userid', '$basket_user', '$basket_nom_name', '$basket_nom_art', '$basket_date', '$basket_ordstat', '$basket_ordnumber', '$basket_amount', '$basket_price', '$basket_bonus'");
    }
}
//======numbers of pages===========//
$vtsql1 = new db;
if (IsSet($cat) && $cat <> 0) $total_items = $vtsql1 -> db_Select("vt_index", "*", "index_catid='$cat'");
if (IsSet($cat) && $cat == 0) $total_items = $vtsql1 -> db_Select("vt_nom", "*", "");
$from = ($_GET['num_page']) ? $_GET['num_page'] : 0;
if ($total_items>$conf_showrowsitems){
$text .= "<div id='vt_block'><div id='vt_num_navi'>";
	$vtsql2 = new db;
	$vtsql2 -> db_Select("vt_cat", "*", "cat_id='$cat'");
	while($row = $vtsql2-> db_Fetch()){
	    $showcat = $row['cat_sub'];
	    $showcatname = $row['cat_name'];
	}
 $parms = $total_items.",".$conf_showrowsitems.",".$from.",".e_SELF."?page=categories&cat=".$cat."&num_page=[FROM]&showcat=".$showcat."";
 $text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
 $text .= "</div></div>";
}
//======numbers of pages===========//

// ======output nomenklature of category==========================================
if (IsSet($cat) && $cat <> 0) {
	$text .="<div id='vt_cat_desc_block'>";
	$vtsql = new db;
	$vtsql -> db_Select("vt_cat", "*", "cat_id='$cat'");
	while($row = $vtsql -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_img = $row['cat_img'];
		$cat_desc = $row['cat_desc'];
		if ($cat_img == '') {
			$cat_img = 'nom_empty.png';
		}
	$text .= "<table><tr><td>";
//	$text .= "<font size=1 color=#00d400><h1>$cat_name</h1></font>";
	$parseBB = $tp->toHTML($cat_desc,true,'body');
	$text .= "<img src='vt_pictures/category/$cat_img' alt='$cat_name' style='width:200px; float:left;'>";
	$text .= "<div id='vt_but_desc_block_up'><a href=# onclick=\"document.getElementById('vt_cat_desc_block').style.height='100%'; return false;\"><img src='theme/but_desc_block_up.png' align=right></a></div>";
	
	$text .= "<br><div id='vt_short_cat_desc'>$parseBB<br></div><br>";
	
	$text .= "<div id='vt_but_desc_block_down'><a href=# onclick=\"document.getElementById('vt_cat_desc_block').style.height='200px'; return false;\"><img src='theme/but_desc_block_down.png' align=right></a></div>";
	
//	$text .= "<div id='vt_cat_desc_block'>$parseBB<br><a href=# onclick=\"document.getElementById('vt_cat_desc_block').style.display='none'; return false;\"><img src='theme/but_desc_none.png' align=right></a></div>";
	}
	$text .="</td></table> </div>";
	$row_i = 1;
	$vtsql1 = new db;
	$vtsql1 -> db_Select("vt_index", "*", "index_catid='$cat' LIMIT $from,$conf_showrowsitems");
	while($row = $vtsql1 -> db_Fetch()){
		$index_nomid = $row['index_nomid'];
		$vtsql2 = new db;
		$vtsql2 -> db_Select("vt_nom", "*", "`nom_id`='".$index_nomid."' $sorting");
			while($row = $vtsql2 -> db_Fetch()){
			      $nom_id = $row['nom_id'];
			      $nom_num = $row['nom_num'];
			      $nom_art = $row['nom_art'];
			      $nom_code = $row['nom_code'];
			      $nom_name = $row['nom_name'];
			      $nom_type = $row['nom_type'];
			      $nom_unit = $row['nom_unit'];
			      $nom_desc_mini = $row['nom_desc_mini'];
			      $nom_desc_all = $row['nom_desc_all'];
			      $nom_pic = $row['nom_pic'];
			      $nom_price1 = $row['nom_price1'];
			      $nom_price2 = $row['nom_price2'];
			$text .= "<div id='vt_nom_item'><form name='nom' method='post' action='".$PHP_SELF."'><table width=98%><tr>";
			$text .= "<td width=120px valign=top>";
			if ($nom_pic == '') {
			    $text .="<img src='".e_PLUGIN."vtrade/theme/nom_empty.png' height=120px></td>";
			}
			if ($nom_pic <> '') {
			    $text .="<img src='vt_pictures/product_icons/$nom_pic' height=120px></td>";
			}
			
			$text .= "<td width=250px valign=top><a href='".e_PLUGIN."vtrade/vtrade.php?page=item&id=$nom_id'><font size=2><b>$nom_name</b></font></a></br>";
			
			$text .= "$nom_desc_mini <br><a href='".e_PLUGIN."vtrade/vtrade.php?page=item&id=$nom_id'>Подробное описание...</a></td>";
			if ($nom_price2 <> '' AND $nom_price2 <> '0'){
			    $text .= "<td width=20%><b><font size=3 color=red>".number_format($nom_price2,2)." руб.</font></b>";
			    $text .= "<b><strike> ".number_format($nom_price1,2)." руб.</strike></b>";
			    $basket_price = $nom_price2;
			}
			else {
			    $text .= "<td width=140px valign=top><b><font size=3>".number_format($nom_price1,2)." руб.</font></b>";
			    $basket_price = $nom_price1;
			}
			if ($nom_amount == ""){
			    $nom_amount = 1;
			}
			$text .="<input type='hidden' name='nom_name' value='$nom_name'>";
			$text .="<input type='hidden' name='nom_art' value='$nom_art'>";
			$text .="<input type='hidden' name='basket_price' value='$basket_price'>";
 			$text .="<br><br><input id='tbox' type='text' size='2' name='nom_amount' value='$nom_amount'> <input type='submit' size='2' value='".VT_BUT_ADDBASK."' name='add'>";
 			//$text .="<input id='button' style='cursor:pointer' type='submit' src='".e_PLUGIN."vtrade/theme/but_in_basket.png' value='".VT_BUT_ADDBASK."' name='but_addbask'>";
 			$text .="<font color=#00d400>Цены со скидкой:<br>";
 			$sale5 = $nom_price1-($nom_price1*0.05);
 			$sale10 = $nom_price1-($nom_price1*0.1);
 			$sale15 = $nom_price1-($nom_price1*0.15);
//			$sale5 = $nom_price1;
 			$text .="5% - ".number_format($sale5,2)." руб.<br>";
 			$text .="10% - ".number_format($sale10,2)." руб.<br>";
 			$text .="15% - ".number_format($sale15,2)." руб.";
 			$text .="</font></td></tr>";
			$text .="</tr></table></form></div>";
			}
		}
$caption_section = " - <a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat'>$cat_name</a>";
}
// ======output all nomenklature================================================
if (IsSet($cat) && $cat == 0) {
	$cat =intval($cat);
		$row_i = 1;
		$vtsql = new db;
		$vtsql -> db_Select("vt_nom", "*", "$sorting LIMIT $from,$conf_showrowsitems", "no-where");	
			while($row = $vtsql -> db_Fetch()){
			      $nom_id = $row['nom_id'];
			      $nom_cat = $row['nom_cat'];
			      $nom_num = $row['nom_num'];
			      $nom_art = $row['nom_art'];
			      $nom_code = $row['nom_code'];
			      $nom_name = $row['nom_name'];
			      $nom_type = $row['nom_type'];
			      $nom_unit = $row['nom_unit'];
			      $nom_desc_mini = $row['nom_desc_mini'];
			      $nom_desc_all = $row['nom_desc_all'];
			      $nom_pic = $row['nom_pic'];
			      $nom_price1 = $row['nom_price1'];
			      $nom_price2 = $row['nom_price2'];
			      $desc_short = substr ($nom_desc_all, 0, 300);
			$text .= "<div id='vt_nom_item'><form name='nom' method='post' action='".$PHP_SELF."'><table width=98%><tr>";
			$text .= "<td width=120px valign=top><center>";
			if ($nom_pic == '') {
			    $text .="<img src='".e_PLUGIN."vtrade/theme/nom_empty.png' height=120px></center></td>";
			}
			if ($nom_pic <> '') {
			    $text .="<img src='vt_pictures/product_icons/$nom_pic' height=120px></center></td>";
			}
			
			$text .= "<td width=250px valign=top><a href='".e_PLUGIN."vtrade/vtrade.php?page=item&id=$nom_id'><font size=2><b>$nom_name</b></font></a></br>";
			
			$text .= "$nom_desc_mini <br><a href='".e_PLUGIN."vtrade/vtrade.php?page=item&id=$nom_id'>Подробное описание...</a></td>";
			if ($nom_price2 <> '' AND $nom_price2 <> '0'){
			    $text .= "<td width=20%><b><font size=3 color=red>".number_format($nom_price2,2)." руб.</font></b>";
			    $text .= "<b><strike> ".number_format($nom_price1,2)." руб.</strike></b>";
			    $basket_price = $nom_price2;
			}
			else {
			    $text .= "<td width=140px valign=top><b><font size=3>".number_format($nom_price1,2)." руб.</font></b>";
			    $basket_price = $nom_price1;
			}
			if ($nom_amount == ""){
			    $nom_amount = 1;
			}
			$text .="<input type='hidden' name='nom_name' value='$nom_name'>";
			$text .="<input type='hidden' name='nom_art' value='$nom_art'>";
			$text .="<input type='hidden' name='basket_price' value='$basket_price'>";
 			$text .="<br><br><input id='tbox' type='text' size='2' name='nom_amount' value='$nom_amount'> <input type='submit' size='2' value='".VT_BUT_ADDBASK."' name='add'>";
 			//$text .="<input id='button' style='cursor:pointer' type='submit' src='".e_PLUGIN."vtrade/theme/but_in_basket.png' value='".VT_BUT_ADDBASK."' name='but_addbask'>";
 			$text .="<font color=#00d400>Цены со скидкой:<br>";
 			$sale5 = $nom_price1-($nom_price1*0.05);
 			$sale10 = $nom_price1-($nom_price1*0.1);
 			$sale15 = $nom_price1-($nom_price1*0.15);
//			$sale5 = $nom_price1;
 			$text .="5% - ".number_format($sale5,2)." руб.<br>";
 			$text .="10% - ".number_format($sale10,2)." руб.<br>";
 			$text .="15% - ".number_format($sale15,2)." руб.";
 			$text .="</font></td></tr>";
			$text .="</tr></table></form></div>";
			}
	$caption_section = "";
}
//======numbers of pages===========//
$vtsql1 = new db;
if (IsSet($cat) && $cat <> 0) $total_items = $vtsql1 -> db_Select("vt_index", "*", "index_catid='$cat'");
if (IsSet($cat) && $cat == 0) $total_items = $vtsql1 -> db_Select("vt_nom", "*", "");
$from = ($_GET['num_page']) ? $_GET['num_page'] : 0;
if ($total_items>$conf_showrowsitems){
$text .= "<div id='vt_block'><div id='vt_num_navi'>";
	$vtsql2 = new db;
	$vtsql2 -> db_Select("vt_cat", "*", "cat_id='$cat'");
	while($row = $vtsql2-> db_Fetch()){
	    $showcat = $row['cat_sub'];
	    $showcatname = $row['cat_name'];
	}
 $parms = $total_items.",".$conf_showrowsitems.",".$from.",".e_SELF."?page=categories&cat=".$cat."&num_page=[FROM]&showcat=".$showcat."";
 $text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
 $text .= "</div></div>";
}
//======numbers of pages===========//

//-----функции для вывода обезанного текста-----//
function short_cat_desc($cat_desc, $counttext = 50, $sep = ' ') {
    $words = split($sep, $cat_desc);
    if ( count($words) > $counttext )
        $cat_desc = join($sep, array_slice($words, 0, $counttext));
    return $cat_desc;
}
function short_nom_desc($nom_desc_all, $counttext = 40, $sep = ' ') {
    $words = split($sep, $nom_desc_all);
    if ( count($words) > $counttext )
        $nom_desc_all = join($sep, array_slice($words, 0, $counttext));
    return $nom_desc_all;
}

?>