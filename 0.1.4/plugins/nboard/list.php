<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/
//=====Output Category=====//
	$text .="<table width='100%'><tr>";
	$nbsql1 -> db_Select("nb_cat", "*", "cat_sub_id='0'") or die (LAN_NB_MES_NULL);
	while($row = $nbsql1 -> db_Fetch()){
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
		$cat_desc = $row['cat_desc'];
		$cat_icon = $row['cat_icon'];
		if ($i == $conf_showcols){
			$text  .= "<tr>";
			$i = 0;
		}
	$nbsql2 = new db;
	$count = $nbsql2 -> db_Count("nb_gnl","(*)", "where gnl_scatid in (select cat_id from ".MPREFIX."nb_cat where ".MPREFIX."nb_cat.cat_sub_id='$cat_id')");
	$text .= "<td class='forumheader'><a href='nboard.php?cat=$cat_id&scat=0'><img src='".e_PLUGIN."md_nboard/theme/icons_cat/$cat_icon' alt='".SITENAME." - $cat_name'></a></td>";
	$text .= "<td class='forumheader' width='auto'><a href='nboard.php?cat=$cat_id&scat=0'><h2>$cat_name</h2></a>";
	$text .= "<div class='smalltext'>$cat_desc<br>$count - ".LAN_NB_CAT_COUNT."</div></td>";
		$i= $i + 1;
	}
	$text .="</table>";
	$text .="<script type='text/javascript' src='".e_PLUGIN."md_nboard/js/yandex_direct.js'></script>";
//======Banners======//
$now = strftime($conf_dateformat,$today);
$sql -> db_Select("nb_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$ban_id = $row['ban_id'];
		$ban_catid = $row['ban_catid'];
		$ban_org = $row['ban_org'];
		$ban_url = $row['ban_url'];
		$ban_images = $row['ban_images'];
		$ban_datebegin = $row['ban_datebegin'];
		$ban_dateend = $row['ban_dateend'];
	if (($ban_catid == '0' && $cat == 0) && ($ban_dateend > $now || $ban_dateend = $now)) {
	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."md_nboard/banners/$ban_images' alt='".SITENAME." $ban_org'></a> ";
	}
	if (($ban_catid == $cat && $cat <> 0) && ($ban_dateend > $now || $ban_dateend = $now)) {
	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."md_nboard/banners/$ban_images' alt='".SITENAME." $ban_org'></a> ";
	}
	if (($ban_catid == 'all_pages') && ($ban_dateend > $now || $ban_dateend = $now)) {
	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."md_nboard/banners/$ban_images' alt='".SITENAME." $ban_org'></a> ";
	}
}
if((!IsSet($cat) && (!IsSet($scat))) || ((IsSet($cat) && $cat == 0) && (IsSet($scat) && $scat == 0))){
//======Numbering of pages======//
	$num_text = "<div class='nextprev'>";
	$total_items = $nbsql -> db_Select("nb_gnl", "*", "");
	$parms = $total_items.",".$conf_showrows.",".$num_page.",".e_SELF."?num_page=[FROM]";
	$num_text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
	$num_text .= "</div>";
	$result = $result_all;
}
//==================== output notes where Cat selected ======================//
if((IsSet($_GET['cat']) && $_GET['cat'] <> 0) && (IsSet($_GET['scat']) && $_GET['scat'] == 0)){
//======Numbering of pages======//
	$num_text = "<div class='nextprev'>";
	$nbsql -> db_Select("nb_cat", "*", "cat_sub_id='$cat'");
	while($row = $nbsql-> db_Fetch()){
			$catId = $row['cat_id'];
			$nbsql2 = new db;
			$total = $nbsql2 -> db_Count("nb_gnl", "(*)", "WHERE gnl_scatid='$catId'");
			$total_items = $total_items + $total;
		}
	$parms = $total_items.",".$conf_showrows.",".$num_page.",".e_SELF."?cat=$cat&scat=$scat&num_page=[FROM]";
	$num_text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
	$num_text .= "</div>";
	
	$text_cat ="<table style='width:100%'><tr>";
	$nbsql -> db_Select("nb_cat", "*", "cat_id='$cat'");
                while($row = $nbsql-> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
		}
	$catlink = " - <a href='".e_PLUGIN."md_nboard/nboard.php?cat=$cat&scat=0'>$catName</a>";

	$nbsql -> db_Select("nb_cat", "*", "cat_sub_id='$cat'");
                while($row = $nbsql-> db_Fetch()){
			$cat_id = $row['cat_id'];
			$cat_name = $row['cat_name'];
			$cat_icon = $row['cat_icon'];
			$text_cat .= "<td class='fcaption' width='16px'><a href='nboard.php?cat=$cat&scat=$cat_id'><img src='".e_PLUGIN."md_nboard/theme/icons_subcat/$cat_icon' alt='".SITENAME." - $cat_name'></a></td>";
			$text_cat .= "<td class='fcaption'><a href='nboard.php?cat=$cat&scat=$cat_id'> $cat_name</a></td>";
		}
	$text_cat .="</tr></table>";
	$result = $result_cat;
}
//================== output notes where Subcat selected =====================//
if((IsSet($_GET['cat']) && $_GET['cat'] <> 0)  && (IsSet($_GET['scat']) && $_GET['scat'] <> 0)){
//======Numbering of pages======//
	$num_text = "<div class='nextprev'>";
	$total_items = $nbsql -> db_Count("nb_gnl", "(*)", "WHERE gnl_scatid='$scat'");
	$parms = $total_items.",".$conf_showrows.",".$num_page.",".e_SELF."?cat=$cat&scat=$scat&num_page=[FROM]";
	$num_text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
	$num_text .= "</div>";
	
	$nbsql -> db_Select("nb_cat", "*", "cat_id='$cat'");
                while($row = $nbsql-> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
		}
	$catlink = " - <a href='".e_PLUGIN."md_nboard/nboard.php?cat=$cat&scat=0'>$catName</a>";
	$nbsql -> db_Select("nb_cat", "*", "cat_id='$scat'");
                while($row = $nbsql -> db_Fetch()){
			$subId = $row['cat_id'];
			$subName = $row['cat_name'];
		}
	$sublink = " - <a href='".e_PLUGIN."md_nboard/nboard.php?cat=$cat&scat=$scat'>$subName</a>";
	$text_cat ="<table style='width:100%'><tr>";
	$nbsql -> db_Select("nb_cat", "*", "cat_sub_id='$cat'");
                while($row = $nbsql-> db_Fetch()){
			$cat_id = $row['cat_id'];
			$cat_name = $row['cat_name'];
			$cat_icon = $row['cat_icon'];
			$text_cat .= "<td class='fcaption' width='16px'><a href='nboard.php?cat=$cat&scat=$cat_id'><img src='".e_PLUGIN."md_nboard/theme/icons_subcat/$cat_icon' alt='".SITENAME." - $cat_name'></a></td>";
			$text_cat .= "<td class='fcaption'><a href='nboard.php?cat=$cat&scat=$cat_id'> $cat_name</a></td>";
		}
	$text_cat .="</tr></table>";
	$result = $result_scat;
}
//======Numbering of pages======//
$text .=$num_text;
$text .=$text_cat;
//======Output All Notice=====//
$text .="<table class='fcaption'><tr>";
$text .="<td class='fcaption' width='10%'><b>".LAN_NB_NAME_DATE."</td>";
$text .="<td class='fcaption' width='5%'><b>".LAN_NB_NAME_PHOTO."</td>";
$text .="<td class='fcaption' width='60%'><b>".LAN_NB_NAME_NAME."</td>";
$text .="<td class='fcaption' width='10%'><b>".LAN_NB_NAME_PRICE."</td>";
$text .="<td class='fcaption' width='15%'><b>".LAN_NB_NAME_CITY."</td></tr>";
$chet = 1;
//		$nbsql4 = new db;
//		$nbsql4 -> db_Select("nb_cat", "*", "cat_sub_id='$gnl_scatid'");
//		while($row = $nbsql4-> db_Fetch()){
//			$cat_id = $row['cat_id'];
//		}
	while($data = mysql_fetch_array($result)){
		$gnl_id = $data['gnl_id'];
		$gnl_name = $data['gnl_name'];
		$gnl_price = $data['gnl_price'];
		$gnl_pic = $data['gnl_pic'];
		$gnl_date_start = $data['gnl_date_start'];
		$gnl_city = $data['gnl_city'];
		if (!$gnl_pic == ''){
			$gnl_pic = "<img src='".e_PLUGIN."md_nboard/theme/photo_emp_small.png' alt='".SITENAME." - $gnl_name'>";
		}
//======output notice======//
		if ($chet == 1) {
			$class = "forumheader2";
		}
		if ($chet == 2) {
			$class = "forumheader3";
			$chet = 0;
		}
			$text .= "<tr><td class='$class'>".strftime($conf_dateformat,$gnl_date_start)."</td>";
			$text .= "<td class='$class'>$gnl_pic</td>";
			$text .= "<td class='$class'><a href='".e_PLUGIN."md_nboard/nboard.php?page=detail&cat=$cat_id&scat=$gnl_scatid&id=$gnl_id'>$gnl_name</a></td>";
			$text .= "<td class='$class'>$gnl_price</td>";
			$text .= "<td class='$class'>$gnl_city</td>";			
		$chet ++;
	}
	$text .= "</tr></table>";
//======Numbering of pages======//
$text .=$num_text;
?>