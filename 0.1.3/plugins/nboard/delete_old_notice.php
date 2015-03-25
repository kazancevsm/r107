<?php
//============================= Notice-Board ===============================
//	author - Sunout, MagicDreamWebStudio, http://md.osgroup.pro		
//	coder - Sunout, Stalker_PEAOPLE, Geo, Sander and other		
//	sunout@osgroup.pro							
//	license GNU GPL								
//=======================the project beginning in 2011 =====================
$nb_days = $pref["nb_days"];
$month = date("m");
$day = date("d");
$day_end = $day - 60;
$year = date("y");
$now = mktime(0,0,0,$month,$day,$year);
$notice_end = mktime(0,0,0,$month,$day_end,$year);
	$message .= "Объявление действует до $nb_days дней";
	$message .= "<br>Сегодня:".$now.":".strftime("%d.%m.%Y", $now);
	$message .= "<br>Сегодня - $nb_days = ".$notice_end.":".strftime("%d.%m.%Y", $notice_end);
	$message .= "<br>Дата удаления:".$notice_end.":".strftime("%d.%m.%Y", $notice_end);
	$nbsql = new db;
	$nbsql -> db_Select("nb_gnl", "*", "gnl_date_end<$notice_end");
		while($row = $nbsql -> db_Fetch()){
			$gnl_id = $row['gnl_id'];
			$gnl_pic = $row['gnl_pic'];
			if (!$gnl_pic == ''){
			$gnl_pic = explode(",",$gnl_pic);
//			$message .= "<br>small_$gnl_pic[0],$gnl_pic[0],$gnl_pic[1],$gnl_pic[2],$gnl_pic[3],$gnl_pic[4],$gnl_pic[5]";
			$message .= "<br>$gnl_id";
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/small_$gnl_pic[0]");
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[0]");
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[1]");
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[2]");
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[3]");
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[4]");
//			unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[5]");
			}
//			$sql -> db_Delete("nb_gnl", "gnl_id=$gnl_id");
		}
//		unlink("nb_pictures/1375425060_0_snv38928.jpg");
		$message .= "<br>1375425060_0_snv38928.jpg - удалена";
$ns -> tablerender(NB_MES_00, $message);
?>
