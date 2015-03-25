<?php

//========================== banners ===============================//
//	$now = strftime($conf_dateformat,$today);
//	$sql -> db_Select("nb_ban", "*", "");
//	while($row = $sql -> db_Fetch()){
//		$ban_id = $row['ban_id'];
//		$ban_catid = $row['ban_catid'];
//		$ban_org = $row['ban_org'];
//		$ban_url = $row['ban_url'];
//		$ban_images = $row['ban_images'];
//		$ban_datebegin = $row['ban_datebegin'];
//		$ban_dateend = $row['ban_dateend'];
//	if (($ban_catid == '0' && $cat == 0) && ($ban_dateend > $now || $ban_dateend = $now)) {
//	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."nboard/banners/$ban_images' alt='$ban_org' border=0></a>";
//	}
//	if (($ban_catid == $cat && $cat <> 0) && ($ban_dateend > $now || $ban_dateend = $now)) {
//	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."nboard/banners/$ban_images' alt='$ban_org' border=0></a>";
//	}
//	if (($ban_catid == 'all_pages') && ($ban_dateend > $now || $ban_dateend = $now)) {
//	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."nboard/banners/$ban_images' alt='$ban_org' border=0></a>";
//	}
//	}
//========================== all output notes ======================//

$text .="<div class='menu_tt'>";
$sql -> db_Select("tt_gnl", "*", "");
		while($row = $sql -> db_Fetch()){
			$gnl_name = $row['gnl_name'];
			$gnl_desc = $row['gnl_desc'];
//			$gnl_icon = $row['gnl_icon'];
		
	$text .="<ul><li><a class='hide'>$gnl_name</a>";
	$text .="<ul><li>$gnl_desc";
	$text .="</ul></li>";
	$text .="</ul></li>";
		}
$text .="</div>";

?>