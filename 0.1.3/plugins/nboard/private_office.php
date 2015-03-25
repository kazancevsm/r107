<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

$catlink =" - <a href='".e_PLUGIN."md_nboard/nboard.php?page=po'> ".NB_PO_CAP."</a>";
$gnl_user=USERNAME;
if (USER==TRUE){
//======Delete_notes======//
if (isset($action) && $action=='del'){
	$nbsql1 = new db;
	$nbsql1 -> db_Select("nb_gnl", "*", "gnl_id='$id'");
 		while($row = $nbsql1 -> db_Fetch()){
			$gnl_id = $row['gnl_id'];
			$gnl_pic = $row['gnl_pic'];
		}
	if (!$gnl_pic == ''){
		$gnl_pic = explode(",", $gnl_pic);
		unlink("".e_PLUGIN."md_nboard/nb_pictures/small_$gnl_pic[0]");
		unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[0]");
		unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[1]");
		unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[2]");
		unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[3]");
		unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[4]");
		unlink("".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[5]");
	}
	$nbsql2 = new db;
	$nbsql2 -> db_Delete("nb_gnl", "gnl_id='$gnl_id'");
	$message = "<font color=red>".NB_MES_24."</font>";
	$ns -> tablerender(NB_MES_00, $message);
}
//======Prolong_notes======//
if(isset($action) && $action=='prolong'){
	$nbsql1 = new db;
	$nbsql1 -> db_Select("nb_gnl", "*", "gnl_id='$id'");
	while($row = $nbsql1 -> db_Fetch()){
		$gnl_id = $row['gnl_id'];
		$gnl_date_start=$row['gnl_date_start'];
		$gnl_date_end=$row['gnl_date_end'];
	}
	$date_start_new = mktime(0,0,0,$month,$day,$year);
	$date_end_new = $date_start_new + $conf_prolong * 86400;
	
	
	$nbsql2 = new db;
	$nbsql2 -> db_Update("nb_gnl", "gnl_date_start='$date_start_new', gnl_date_end='$date_end_new' WHERE gnl_id='$gnl_id'");
	$message = "<font color=red>".NB_MES_30." $conf_prolong ".NB_MES_31."</font> ";
	$ns -> tablerender($caption, $message);
}

$text .= "<table style='width:100%'>";
	$text .= "<tr>";
	$text .= "<td width='30px' class='fcaption'>№</td>";
	$text .= "<td width='30px' class='fcaption'>".NB_GNL_IMG."</td>";
	$text .= "<td width='70%' class='fcaption'>".NB_GNL_NAME."</td>";
	$text .= "<td width='20%' class='fcaption'>".NB_GNL_DATE."</td>";
	$text .= "<td width='10%' class='fcaption'>".NB_GNL_OPT."</td>";
	$text .= "</tr>";
	$count = 0;
	$nbsql = new db;
	$nbsql -> db_Select("nb_gnl", "*", "gnl_user='$gnl_user' ORDER BY `gnl_date_end` DESC");
		while($row = $nbsql -> db_Fetch()){
			$gnl_id= $row['gnl_id'];
			$gnl_name = $row['gnl_name'];
			$gnl_scatid = $row['gnl_scatid'];
			$gnl_city = $row['gnl_city'];
			$gnl_detail = $row['gnl_detail'];
			$gnl_pic = $row['gnl_pic'];
			$gnl_price = $row['gnl_price'];
			$gnl_user = $row['gnl_user'];
			$gnl_phone = $row['gnl_phone'];
			$gnl_email = $row['gnl_email'];
			$gnl_date_start = $row['gnl_date_start'];
			$gnl_date_end = $row['gnl_date_end'];
			$gnl_counter = $row['gnl_counter'];
			
			if ($gnl_pic == ''){
				$pic = "<img src='".e_PLUGIN."md_nboard/theme/photo_emp_small.png' style='width:80px; border:0px solid #000;' alt='".SITENAME." - $gnl_name' />";
			} else {
				$gnl_pic= explode(",", $gnl_pic);
				$pic = "<img src='".e_PLUGIN."md_nboard/nb_pictures/small_$gnl_pic[0]' style='width:80px; border:0px solid #000;' alt='".SITENAME." - $gnl_name' />";
			}
			$count ++;
			if ($count==1){
				$class = "forumheader3";
			}
			if ($count==2){
				$class = "forumheader2";
				$count = 0;
			}
	$text .= "<tr>";
	$text .= "<td class='$class'>$gnl_id</td>";
	$text .= "<td class='$class'><a href='".e_PLUGIN."md_nboard/nboard.php?page=detail&id=$gnl_id'>$pic</a></td>";
	$text .= "<td class='$class'><a href='".e_PLUGIN."md_nboard/nboard.php?page=detail&id=$gnl_id'><b>[$gnl_name]</b></a><br>$gnl_detail</td>";
	$text .= "<td class='$class'>".NB_PO_TO." ".strftime($conf_dateformat,$gnl_date_end)."<br>".NB_PO_FROM." ".strftime($conf_dateformat,$gnl_date_start)."</td>";
	$text .= "<td class='$class'>";
	$text .= "<a href='".e_PLUGIN."md_nboard/nboard.php?page=po&action=prolong&id=$gnl_id' style='cursor:pointer;' onclick=\"return alert('".NB_MES_30." $conf_prolong ".NB_MES_31."')\"><b>[Продлить]</b></a><br>";
	$text .= "<a href='".e_PLUGIN."md_nboard/nboard.php?page=add&action=edit&id=$gnl_id' style='cursor:pointer;'><b>[Редактировать]</b></a><br>";
	$text .= "<a href='".e_PLUGIN."md_nboard/nboard.php?page=po&action=del&id=$gnl_id' style='cursor:pointer;' onclick=\"return jsconfirm('".NB_QUE_DEL_NOT."')\"><b>[Удалить]</b></a>";
	$text .= "</td>";
	$text .= "</tr>";
	}
$text .= "</table>";
}
?>
