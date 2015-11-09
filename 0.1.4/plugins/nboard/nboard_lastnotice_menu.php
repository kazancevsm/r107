<?php
//============================= Notice-Board ===============================
//	author - Sunout, MagicDreamWebStudio, http://md.osgroup.pro		
//	coder - Sunout, Stalker_PEAOPLE, Geo, Sander and other		
//	sunout@osgroup.pro							
//	license GNU GPL								
//=======================the project beginning in 2011 ===================== 
@include_once(SITEURL.e_PLUGIN."md_nboard/languages/".e_LANGUAGE.".php");
$chet = 1;
$nb_menu_showrows = $pref["nb_menu_showrows"];
$nb_dateformat = $pref["nb_dateformat"];

$text =	"<table>";
$nbmsql = new db;
$nbmsql -> db_Select("nb_gnl", "*", "gnl_id ORDER BY `gnl_date_start` DESC LIMIT 0,$nb_menu_showrows");
	while($row = $nbmsql-> db_Fetch()){
		$gnl_id = $row['gnl_id'];
		$gnl_name = $row['gnl_name'];
		$gnl_pic = $row['gnl_pic'];
		$gnl_price = $row['gnl_price'];
		$gnl_date_start = $row['gnl_date_start'];
		$gnl_city = $row['gnl_city'];
		$gnl_pic = explode("," , $gnl_pic);
		//======output notice======//
		if ($chet == 1) {
			$class = "forumheader2";
		}
		if ($chet == 2) {
			$class = "forumheader3";
			$chet = 0;
		}
		$text .= "<tr><td class='$class'>$gnl_name<br>$gnl_price<br> ".strftime($nb_dateformat,$gnl_date_start)."<br><br></td></tr>";
		$chet ++;
	}
$text .= "</table>";
$caption = "<a href='".e_PLUGIN."md_nboard/nboard.php'>".NB_INFO."</a>";
$ns -> tablerender($caption,$text);
?>