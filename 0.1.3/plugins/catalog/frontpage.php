<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================

//=====================Output All Category======================\
$text .= "<center>";
$text .= "<table width='100%'><tr>";
$my_width = 100/$conf_catshowcolscat;
$catsql -> db_Select("catalog_cat", "*", "cat_sub='0' ORDER BY `cat_id` ASC");
	$i = 1;
	while($row = $catsql -> db_Fetch()){
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
		$cat_pic = $row['cat_pic'];
		$cat_desc = $row['cat_desc'];
		
		if ($cat_pic == '') {
			$cat_pic = 'photo_emp.gif';
		}
		if ($i <= $conf_catshowcolscat){
			$text .= "<td class='forumheader' width='$my_width%'><div>";
			$text .= "<center><a href=catalog.php?page=list&cat=$cat_id><img src='images/category/$cat_pic' alt='$cat_name'></a></center><br>";
			$text .= "<center><a href=catalog.php?page=list&cat=$cat_id><b><font id='cat_name'>$cat_name</font></b></a></center>";
			$text .= "</div></td>";
			$i++;
		} 
		if ($i > $conf_catshowcolscat) {
			$text .= "<tr>";
			$i = 1;
			
		}
		
	}
$text .= "</table></center>";
?>