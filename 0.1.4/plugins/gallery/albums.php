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


//if (getperms("P") && $m_position != "0" && $gallery != $folder) $memo .= "<div class='memo_edit_buton'><a href='memo_edit.php?gallery=$gallery'>".MYGAL_L038."</a></div>";




//========================================================================
//				ALBUMS
//========================================================================
//	$table_width = 100%;
	
//	$td_width = $table_width / $img_columns;
//	$img_count = $img_columns*$img_rows;
	
	$img_columns = $pref['gallery_columns'];
	$img_rows = $pref['gallery_rows'];
	$icon_div_width = $pref['gallery_img_icon_width'];
	$icon_div_height = $pref['gallery_img_icon_height'];

	$img_view_height = $pref['gallery_img_view_height'];
	$img_view_widt = $pref['gallery_img_view_width'];
    
	$text = "<table style='overflow:hidden;'>";
	$text .= "<tr>";
	
	$i = 0;
	$j = 0;
	
		
		$mydb1->db_Select("gallery_cat", "*", "cat_id='$id' ORDER BY cat_name ASC"); 
		while($row = $mydb1->db_Fetch()) {
			$cat_id = $row['cat_id'];
			$cat_sub_id = $row['cat_sub_id'];
			$cat_name = $row['cat_name'];
			$cat_foldername = $row['cat_foldername'];
			$cat_userid = $row['cat_userid'];
			$cat_count = $row['cat_count'];
			$path = e_PLUGIN."gallery/albums/$cat_foldername";
			
		
//	$text .= "<div width='$cat_div_width%'>$catName";
	
			//$mydb2->db_Select("gallery", "*", "img_status = 'public' AND img_status='face'");
		$mydb2->db_Select("gallery_img", "*", "img_cat_id='$id'");
			while($row = $mydb2->db_Fetch()) {
				$img_id = $row['img_id'];
				$img_name = $row['img_name'];
				$img_title = $row['img_title'];
				$img_description = $row['img_description'];
				$img_user = $row['img_user'];
				
				$filename = e_PLUGIN."gallery/albums/$cat_foldername/$img_name";
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
				
				if ($i < $img_columns) {
					$i++;
				}
				else {
					$text .="<tr>";
					$i=1;
				}
			
			$j++;
			$j_minus = $j-1;
			$j_plus = $j+1;

		$text .="<td>";
		
		$text .="<div style='overflow:hidden;left:0px;top:0px;width:".$icon_div_width."px;height:".$icon_div_height."px;margin:0px;position:relative;'>";
		
			$text .="<div style='position:absolute;bottom:0px;margin:5px;z-index:2;'>$img_title</div>";
		
			$text .="<div style='border:#eee 1px solid;position:absolute;left:-".$icon_left_minus."px;top:-".$icon_top_minus."px;'>";
		
			$text .="<a href='#gallery' onclick=\"document.getElementById('big_picture_show_$j').style.display='block'; return false;\" title='".SITENAME."'>";
				        
			$text .="<img src='$path/$img_name' width='$icon_width' alt='$img_description' title='$img_description'/>";
			$text .="</a></div></div>";
			
			
		
		$text .= "</div>";
		$text .= "</td>";
		
		
	$text .="<div id='big_picture_show_$j' class='r_window_block'>";
		$text .="<div><img class='r_window_img'  height='80%' src='$path/$img_name' alt='$img_description' title='$img_description' />";
			$text .="<div class='r_window_caption'>$img_title</div>";
			
			$text .="<div class='r_window_close'><a href='#gallery' onclick=\"document.getElementById('big_picture_show_$j').style.display='none';return false;\">CLOSE</a></div>";
			
			if ($j_minus>=1) $text .="<div class='r_window_pre'><a href='#gallery' onclick=\"document.getElementById('big_picture_show_$j_minus').style.display='block'; document.getElementById('big_picture_show_$j').style.display='none';return false;\" >PREVIEW</a></div>";
			
			$text .="<div class='r_window_next'><a href='#gallery' onclick=\"document.getElementById('big_picture_show_$j_plus').style.display='block'; document.getElementById('big_picture_show_$j').style.display='none';return false;\" >NEXT</a></div>";
			
			
		$text .= "</div>";
	$text .= "</div>";
		
			}
		}
$text .= "</table>";
$cat_count ++;
$mydb -> db_Update("gallery_cat", "cat_count='$cat_count' WHERE cat_id='$id'");




