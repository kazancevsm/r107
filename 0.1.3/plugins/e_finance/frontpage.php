<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

//=====================Output All Category======================
	$text .="<table id='vt_cat_all_frontpage'><tr>";
	$sql -> db_Select("vt_cat", "*", "cat_sub='1' AND cat_vis='".VT_YES."' ORDER BY `cat_name` ASC");
		while($row = $sql -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_img = $row['cat_img'];
		$cat_desc = $row['cat_desc'];
		if ($cat_img == '') {
			$cat_img = 'photo_emp.gif';
		}
	if ($i == $conf_showcolscat){
	$text  .= "<tr>";
	$i = 0;
	}
	$width_cat_item = (780/$conf_showcolscat);
	$text .= "<td id='vt_cat_item' width=$width_cat_item><a href=".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=$cat_id><div id='vt_cat_block'>";
	    $text .= "<table width=100%><tr>";
	    $text .= "<td id='vt_cat_cap'><a href=vtrade.php?page=categories&cat=$cat_id><b><font size=2 color=#ccc>$cat_name</font></b></a></td></tr>";
	    $text .= "<tr><td id='vt_cat_img'><img src='vt_pictures/category/$cat_img' alt='$cat_name'></td></tr>";
//	$text .= "<td class='forumheader2' width=auto><a href=vtrade.php?cat=$cat_id>$cat_name</a></td>";
//	$text .= "<tr><td id='vt_cat_link'><ul><li><a href=#>Смотреть описание... </a>";
//	$text .= "<ul><li><img width=120px src='vt_pictures/category/$cat_img' alt='$cat_name'><br>$cat_desc</li></ul></li></ul></td>";
	$text .= "</table></div></a></td>";
//	$text .= "<td class='forumheader2' width=auto>$cat_desc</td>";
	$i= $i + 1;
	}
	$text .="</table>";
?>