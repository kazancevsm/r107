<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

$catlink =" - <a href='".e_PLUGIN."md_nboard/nboard.php?page=search'> ".NB_SARCH_CAP."</a>";
$cat = $_GET['cat'];
$scat = $_GET['scat'];
//================ Head =====================
$text .= "<form action='".$PHP_SELF."' method=post>";
$text .= "<table class='forumheader3' style='width:100%'>";
$text .="<tr><td class='forumheader3' width=40%><input type='text' class='tbox' name='stext' value='".NB_SARCH_01."' size=40></td>";
$text .="<td class='forumheader3' width=40%>
	<select name='crit' class='tbox'>
		<option value='gnl_name'>".NB_SARCH_02."</option>
		<option value='gnl_detail'>".NB_SARCH_03."</option>
	</select></td>";
$text .="<td class='forumheader3' width=20%>
	<input class='button' style='cursor:pointer;' type='Submit' value=".NB_BUT_SEA." name='sear'></td></tr><tr></table></form>";
//================ Select ======================
if(IsSet($_POST['sear'])){
	
	$stext = strtoupper($stext);
	$text .= "<div class='nextprev'>";
	$total_items = $nbsql -> db_Select("nb_gnl", "*", "$crit LIKE '%$stext%'");
	$parms = $total_items.",".$conf_showrows.",".$num_page.",".e_SELF."?page=search&num_page=[FROM]";
	$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
	$text .= "</div>";
	$text .="<table width='100%'><tr>";
	$text .="<td class='fcaption' width='10%'><b>".NB_NAME_DATE."</td>";
	$text .="<td class='fcaption' width='5%'><b>".NB_NAME_PHOTO."</td>";
	$text .="<td class='fcaption' width='60%'><b>".NB_NAME_NAME."</td>";
	$text .="<td class='fcaption' width='10%'><b>".NB_NAME_PRICE."</td>";
	$text .="<td class='fcaption' width='15%'><b>".NB_NAME_CITY."</td></tr>";
	$count = $nbsql -> db_Count("nb_gnl", "(*)", "WHERE $crit LIKE '%$stext%'");
	if ($count==0){
	$text .= "<tr><td colspan=5>".NB_SARCH_06."</td></tr>";
	}
	if (!$count==0){
	$nbsql -> db_Select("nb_gnl", "*", "$crit LIKE '%$stext%' LIMIT $num_page, $conf_showrows");
	while($row = $nbsql -> db_Fetch()){
		$gnl_id = $row['gnl_id'];
		$gnl_date_start = $row['gnl_date_start'];
		$gnl_name = $row['gnl_name'];
		$gnl_detail = $row['gnl_detail'];
		$gnl_price = $row['gnl_price'];
		$gnl_pic = $row['gnl_pic'];
		$gnl_city = $row['gnl_city'];
	$sql2 = new db;
	$sql2 -> db_Select("nb_cat", "*", "cat_sub_id='$gnl_scatid'");
                while($row = $sql2 -> db_Fetch()){
			$cat_name = $row["cat_name"];
			$cat_sub_id = $row["cat_sub_tid"];
		}
	$sql3 = new db;
	$sql3 -> db_Select("nb_cat", "*", "cat_id='$cat_sub_id'");
                while($row = $sql3 -> db_Fetch()){
			$cat_id = $row["cat_id"];
			$cat_name = $row["cat_name"];
		}
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
			$text .= "<td class='$class'><a href='".e_PLUGIN."md_nboard/nboard.php?page=detail&id=$gnl_id'>$gnl_name</a></td>";
			$text .= "<td class='$class'>$gnl_price</td>";
			$text .= "<td class='$class'>$gnl_city</td></tr>";			
		$chet ++;
	}
	}
	$text .= "</table>";
}
?>