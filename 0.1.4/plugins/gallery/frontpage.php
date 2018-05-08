<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://r107.slog.su
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "gallery"
|     Author: Sunout sunout@mail.ru
|     Home page: http://r107.slog.su
+-----------------------------------------------------------------------------------------------+
*/

//========================================================================
//				ALBUMS
//========================================================================
	
	$img_columns = $pref['gallery_columns'];
	$img_rows = $pref['gallery_rows'];
	$icon_div_width = $pref['gallery_img_icon_width'];
	
	
	$img_view_height = $pref['gallery_img_view_height'];
	$img_view_widt = $pref['gallery_img_view_width'];
	
	$text = "<table class='gall_wrapper'>";
	$text .= "<tr>";
	
	$i = 0;

$mydb->db_Select("gallery_cat", "*", "cat_sub_id = '0' ORDER BY cat_id DESC"); 
while($row = $mydb->db_Fetch()) {
	$cat_id = $row['cat_id'];
	$cat_sub_id = $row['cat_sub_id'];
	$cat_name = $row['cat_name'];
	$cat_foldername = $row['cat_foldername'];
	$cat_userid = $row['cat_userid'];
		
		$mydb1->db_Select("gallery_cat", "*", "cat_sub_id = '$cat_id' ORDER BY cat_name ASC"); 
		while($row = $mydb1->db_Fetch()) {
			$catId = $row['cat_id'];
			$catSubId = $row['cat_sub_id'];
			$catName = $row['cat_name'];
			$catFoldername = $row['cat_foldername'];
			$catUserid = $row['cat_userid'];
			$path = e_PLUGIN."gallery/albums/".$catFoldername."";
			
			if ($i < $img_columns) {
		$i++;
	}
	else {
	$text .="<tr>";
		$i=1;
	}
			$mydb2->db_Select("gallery_img", "*", "img_cat_id='$catId' LIMIT 1");
			while($row = $mydb2->db_Fetch()) {
				$img_id = $row['img_id'];
				$img_name = $row['img_name'];
				$img_title = $row['img_title'];
				$img_description = $row['img_description'];
				$img_user = $row['img_user'];
				
				$filename = e_PLUGIN."gallery/albums/$catFoldername/$img_name";
				list($img_width_orig, $img_height_orig) = getimagesize($filename);
				
				$icon_div_height = $pref['gallery_img_icon_height'];
				if ($img_width_orig > $img_height_orig) {
					$icon_width = $pref['gallery_img_icon_width']*1.5;
					$icon_left_minus = $icon_div_width /4;
					$icon_top_minus =  0;
					}
				if ($img_width_orig < $img_height_orig) {
					$icon_width = $pref['gallery_img_icon_width'];
					$icon_top_minus = $icon_div_width /10;
					$icon_left_minus = 0;
					}
				
	$text .="<td>";
		
	$text .="<div style='height:".$icon_div_height."px;' class='gall_albums_shell'>";
		
		$text .="<div class='gall_albums_name'><a href='".e_PLUGIN."gallery/gallery.php?page=albums&id=".$catId."#gallery'>$catName</a></div>";
		
		$text .="<div style='width:".$icon_div_width."px;height:".$icon_div_height."px;' class='gall_albums_icon'>";
		
			$text .="<div style='border:#eee 1px solid;position:absolute;left:-".$icon_left_minus."px;top:-".$icon_top_minus."px;'>";
		
			$text .="<a href='".e_PLUGIN."gallery/gallery.php?page=albums&id=".$catId."#gallery' title='$img_description'>";
			
			$text .="<img  src='".e_PLUGIN."gallery/albums/$catFoldername/$img_name' width='$icon_width' alt='$img_description' title='$img_description'/>";
			$text .="</a>";
	$text .= "</div></div></div>";
	$text .= "</td>";
			}
		}
	}
$text .= "</table>";