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

require_once("../../class2.php");
if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
}

require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."file_handler.php");
require_once("gallery_handler.php");

$lan_file = e_PLUGIN."gallery/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."gallery/languages/English.php"));

$folder = 'albums';

if(e_QUERY){
	$gall_qs = explode(".", e_QUERY);
	$action = $gall_qs[0];
	$subaction = $gall_qs[1];
	$id = $gall_qs[2];
	$parametr = $gall_qs[3];
}

$vis = 'none';
$unvis = 'yes';

// =================================================================================================
//					MENU CAT
// =================================================================================================

if (!IsSet($action) || $action == "" || $action == 'menu_cat') {

//===== Cat Delete
//if (IsSet($_POST['submit_delete'])){
if (IsSet($subaction) && $subaction == 'delete_cat'){
	if (IsSet($parametr) && $parametr<>''){
	$path = e_PLUGIN."gallery/albums/".$parametr;
	deltree($path);
	}
	$mydb -> db_Delete("gallery_cat", "cat_id=$id");
	$captions = LAN_GAL_MES;
	$message = "<b>".LAN_GAL_CAT." ".$parametr." ".LAN_GAL_MES_DELETE."</b>";
	$ns->tablerender($captions, $message);
}

$text ="<form enctype='multipart/form-data' method='post' action='".e_SELF."?menu_cat'>
	<table width=100%>
	<tr>
	<td class='fcaption' width='5%'>ID</td>
	<td class='fcaption' width='35%'>".LAN_GAL_CAT."</td>
	<td class='fcaption' width='10%'>".LAN_GAL_DIR."</td>
	<td class='fcaption' width='10%'>".LAN_GAL_DATE."</td>
	<td class='fcaption' width='10%'>".LAN_GAL_USER."</td>
	<td class='fcaption' width='10%'>".LAN_GAL_COUNT."</td>
	<td class='fcaption' width='10%'>".LAN_GAL_OPTIONS."</td>
	</tr>";


if ($mydb->db_Select("gallery_cat", "*", "cat_sub_id='0'")) {
      while($row = $mydb->db_Fetch()) {
	$cat_id = $row['cat_id'];
	$cat_sub_id = $row['cat_sub_id'];
        $cat_name = $row['cat_name'];
        $cat_foldername = $row['cat_foldername'];
        $cat_userid = $row['cat_userid'];
	$path = e_PLUGIN."gallery/albums/".$cat_foldername."";
	$text .="	<tr>
		<td class='forumheader2'>$cat_id</td>
		<td class='forumheader2' colspan=3>$cat_name</td>
		<td class='forumheader2'>$cat_userid</td>
		<td class='forumheader2'></td>
		<td class='forumheader2'>
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_cat_edit.create.$cat_id'>
		<img src='".e_IMAGE."admin/sublink_16.png' title='Создать подкаталог' alt='Создать подкаталог'></a>&nbsp;
		
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_cat_edit.edit.$cat_id'>
		<img src='".e_IMAGE."admin/edit_16.png' alt='".LAN_GAL_BUT_EDIT."' title='".LAN_GAL_BUT_EDIT."' style='border:0px; height:16px; width:16px'></a>&nbsp;
		
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_cat.delete.$cat_id.$cat_foldername' onclick=\"return jsconfirm('Хотите удалить эту директорию?')\">
		<img src='".e_IMAGE."admin/delete_16.png' alt='' title='Удалить' ></a>&nbsp;
		</td>
			</tr>";
		
		if ($mydb2->db_Select("gallery_cat", "*", "cat_sub_id='$cat_id'")) {
			while($row = $mydb2->db_Fetch()) {
			$cat_id = $row['cat_id'];
			$cat_sub_id = $row['cat_sub_id'];
			$cat_name = $row['cat_name'];
			$cat_foldername = $row['cat_foldername'];
			$cat_userid = $row['cat_userid'];
			$cat_count = $row['cat_count'];
			$cat_date = date('d-m-Y' , $cat_foldername);
			
		$text .="	<tr>
		<td class='forumheader3'>".$cat_id."</td>
		<input class='tbox' type='text' name='cat_id' value='".$cat_id."' style='cursor:pointer;display:none'>
		<td class='forumheader3'><img src='".e_IMAGE."admin/sublink.png' alt=''>".$cat_name."</td>
		<td class='forumheader3'>".$cat_foldername."</td>
		<td class='forumheader3'>".$cat_date."</td>
		<td class='forumheader3'>".$cat_userid."</td>
		<td class='forumheader3'>".$cat_count."</td>
		<td class='forumheader3'>
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_img_upload.upload.$cat_id'>
		<img src='".e_IMAGE."admin/uploads_16.png' title='Загрузить изображения в альбом' alt='Загрузить изображения в альбом'></a>&nbsp;
		
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_img.$cat_name.$cat_id'>
		<img src='".e_IMAGE."admin/images_16.png' title='Смотреть и редактировать изображения в альбоме' alt='Смотреть и редактировать изображения в альбоме'></a>&nbsp;
		
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_cat_edit.edit_sub.$cat_id'>
		<img src='".e_IMAGE."admin/edit_16.png' alt='' title='Править'></a>&nbsp;
		
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_cat.delete_cat.$cat_id.$cat_foldername' onclick=\"return jsconfirm('Хотите удалить эту директорию?')\">
		<img src='".e_IMAGE."admin/delete_16.png' alt='' title='Удалить' ></a>&nbsp;
			</td>
		</tr>";
		}
		}
//<input title='Удалить' name='submit_delete' src='".e_IMAGE."admin/delete_16.png' onclick=\"return jsconfirm('Уверены, что хотите удалить эту директорию?')\" type='image'>
	}
}
$text .= "</form></div>";

$captions = LAN_GAL_CAP_CAT_MAN;
$ns -> tablerender($captions, $text);
}

// =================================================================================================
//					MENU CAT ADD & EDIT
// =================================================================================================

if ($action == 'menu_cat_edit') {

//===== Create Catalog/Folder
if(IsSet($_POST['submit_createcat'])) {
$cat_id = $_POST['cat_id'];
$cat_sub_id = $_POST['SelectId'];
$cat_name = $_POST['cat_name'];
$cat_foldername = $_POST['cat_foldername'];
$cat_desc = $_POST['cat_desc'];
$cat_userid = USERID;
$cat_img = $_POST['cat_img'];
$cat_full_name = $cat_foldername."_".$cat_userid;
$path = e_PLUGIN."gallery/albums/".$cat_full_name;

	if ($cat_name == ""){ 
		$message = "<font color=red>".LAN_GAL_MES_NOCRE."</font>";
	}
	else {
	if ($cat_sub_id =='0') {
		$mydb = new db;
		$mydb -> db_Insert("gallery_cat", "0, '$cat_sub_id','','$cat_name','$cat_desc','$cat_userid','$cat_img',''");
		$message = "<font color=green>".LAN_GAL_MES_ADD_CAT."</font>";
		$cat_id=$cat_sub_id=$cat_name=$cat_desc=$cat_img='';
	}
	if ($cat_sub_id <>'0' && $cat_sub_id<>'') {
		mkdir ($path,0755);
		if (!is_dir($path) && !mkdir($path)) {
			$message = "Folder: ".$path." - Not create";
		}
		else {
			$message = "Folder: ".$path."(".$cat_id.") - Created";
			$mydb = new db;
			$mydb -> db_Insert("gallery_cat", "0, '$cat_sub_id','$cat_full_name','$cat_name','$cat_desc','$cat_userid','$cat_img',''");
			$message = "<font color=green>".LAN_GAL_MES_ADD_CAT.". ".LAN_GAL_DIR." ".$cat_full_name." ".LAN_GAL_MES_DIR_CRE."</font>";
	}

	$cat_id=$cat_sub_id=$cat_name=$cat_desc=$cat_img='';
	header ("Location: ".e_PLUGIN."gallery/admin_config.php?menu_cat");
	exit;
//$path = "".$_POST['top_folder']."/".$_POST['folder_name']."";
//$mode = substr(sprintf('%o', fileperms($_POST['top_folder'])), -4);
   /*
   else {

        $sql_text = array(
              "img_name" =>      $tp -> toDB($path),
              "img_title" =>     $tp -> toDB($_POST['gallery_name']),
              "img_status" =>    "menu"
              );

        $mydb->db_Insert("gallery", $sql_text);

    */
      }
    }
    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}
//======Update_notes======//	
	if (IsSet($_POST['submit_update'])){
	
	$cat_id = $_POST['cat_id'];
	$cat_sub_id = $_POST['SelectId'];
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$cat_img = $_POST['cat_img'];

	$mydb -> db_Update("gallery_cat", "cat_sub_id='$cat_sub_id', cat_name='$cat_name', cat_desc='$cat_desc', cat_img='$cat_img' WHERE cat_id='$cat_id'");
		$message = "<font color=red>".LAN_GAL_MES_UPD_CAT."</font>";
		$ns -> tablerender(LAN_GAL_MES, $message);
	$cat_id=$cat_name=$cat_desc=$cat_icon='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	header ("Location: ".e_PLUGIN."gallery/admin_config.php?menu_cat");
	exit;
	}
	
//===== form edit or new category

$catFoldername = time();
	$text ="<form name='insert_cat' enctype='multipart/form-data' method='post' action=''>";
	$text .="<table class='fborder' style='width:100%'>";
        $text .= "<tr><td class='forumheader3' width='30%'>".LAN_GAL_PARENT.":</td>
		<td class='forumheader3' width='70%'>
		<select class='tbox' name='SelectId'>";
//===== if Create Catalog/Folder
		if (IsSet($subaction) && $subaction == 'create'){
			$mydb -> db_Select("gallery_cat", "*", "cat_id='$id'");
				while($row = $mydb -> db_Fetch()){
					$catName = $row['cat_name'];	
			}
			$catId = $id;
			$text .= "<option value='$catId'>$catName</option>";
		}
//===== if Edit Catalog/Folder
		if (IsSet($subaction) && $subaction == 'edit'){
			$mydb -> db_Select("gallery_cat", "*", "cat_id ='$id'");
				while($row = $mydb -> db_Fetch()){
					$cat_name = $row['cat_name'];
					$cat_desc = $row['cat_desc'];
					$cat_img = $row['cat_img'];
				}
		$vis = 'yes';
		$unvis = 'none';
		}
//===== if Edit SUB Catalog/Folder
		if (IsSet($subaction) && $subaction == 'edit_sub'){
			$mydb -> db_Select("gallery_cat", "*", "cat_id ='$id'");
				while($row = $mydb -> db_Fetch()){
					$cat_sub_id = $row['cat_sub_id'];
					$cat_name = $row['cat_name'];
					$cat_desc = $row['cat_desc'];
					$cat_img = $row['cat_img'];
				}
			$mydb1 -> db_Select("gallery_cat", "*", "cat_id ='$cat_sub_id'");
				while($row = $mydb1 -> db_Fetch()){
					$catId = $row['cat_id'];
					$catName = $row['cat_name'];
					
					}
			$text .= "<option value='$catId'>$catName</option>";
		$vis = 'yes';
		$unvis = 'none';
		}
		
		$text .= "<option value='0'>".LAN_GAL_NOPARENT."</option>";
		
		
			$mydb2 -> db_Select("gallery_cat", "*", "cat_sub_id='0'");
				while($row = $mydb2 -> db_Fetch()){
					$catId1= $row['cat_id'];
					$catName1 = $row['cat_name'];
					$text .="<option value='$catId1'>$catName1</option>";
				}
		
				
	$text .="</select></td></tr>";
	
	$text .="<tr><td class='forumheader3'>".LAN_GAL_DIR."</td>
		<td class='forumheader3'>
		<input class='tbox' type='text' name='cat_foldername' size='50' value='".$catFoldername."' readonly style='cursor:pointer;display:block'>
		</td></tr>";
	
		
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_GAL_CAT_NAME."</td>
		<td class='forumheader3' width='70%'>
		<input class='tbox' type='text' name='cat_id' value='$id' size='10' style='display:none;'>
		<input class='tbox' type='text' name='cat_name' value='$cat_name' size='60'>
		<input class='tbox' type='text' name='cat_foldername' size='50' value='".$catFoldername."' readonly style='cursor:pointer;display:none'>
		</td></tr>";
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_GAL_CAT_DESC."</td>
		<td class='forumheader3' width='70%'>
		<input class='tbox' type='text' name='cat_desc' value='$cat_desc' size='60'>
		</td></tr>";
		
//===== select cat_icon

$fl = new e_file;
  
if($iconlist = $fl->get_files(e_FILE."icons/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        sort($iconlist);
}
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".LAN_GAL_CAT_IMG." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='cat_img' name='cat_img' value='$cat_icon' size='40' maxlength='100' />
		<input type ='button' class='button' style='cursor:pointer' size='30' value='".LAN_GAL_IMG_BROUSE."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_FILE."icons/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','cat_img','linkicn')\"><img src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a> ";
		}
	$text .= "</div></td></tr>";
	$text .= "<tr><td colspan=2 class='forumheader'><center>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".LAN_GAL_BUT_CAN." name='submit_reset'>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".LAN_GAL_BUT_CREATE." name='submit_createcat'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".LAN_GAL_BUT_UPDATE." name='submit_update'>
		
		</center>
		</td></tr></table></form>";
    
$caption = LAN_GAL_CAP_CAT_CRE;
$ns -> tablerender($caption, $text);
}

// =============== TN_ TV_ Create Script ==============
if(IsSet($_POST['tn_create'])) {

  $folder = $pref['gallery_folder'];
  $message = "";
  $foto_icon_height = $pref['gallery_img_icon_height'];
  $foto_icon_width = $pref['gallery_img_icon_width'];
  $foto_view_height = $pref['gallery_img_view_height'];
  $foto_view_width = $pref['gallery_img_view_width'];
  $img_quality = $pref['gallery_img_quality'];

  $pref['gallery_img_quality'] = $_POST['gallery_img_quality'];
  $pref['mg_icon_create'] = $_POST['mg_icon_create'];
  $pref['mg_view_create'] = $_POST['mg_view_create'];

    save_prefs();

  if ($handle = opendir($folder))
  {
    while (false !== ($folder_a = readdir($handle)))
    {
     if ($folder_a != "." && $folder_a != ".." && $folder_a != "index.php")  { $nav_a[] = $folder_a; }
    }
  closedir($handle);
  }

  foreach ($nav_a as $folder_a) {
          $nav_b = "";
          if ($handle = opendir("$folder/$folder_a"))
              {
              while (false !== ($folder_b = readdir($handle)))
                  {
                   if ($folder_b != "." && $folder_b != ".." && $folder_b != "index.php")  { $nav_b[]= $folder_b; }
                  }
              closedir($handle);
              }


          foreach ($nav_b as $folder_b) {
                  if ($handle = opendir("$folder/$folder_a/$folder_b")) {
                    while (false !== ($img_file = readdir($handle))) {
                        $str_tn = substr_count("$img_file", "tn_") + substr_count("$img_file", "tv_");
                        $str_type = substr_count("$img_file", ".jpg") + substr_count("$img_file", ".JPG") + substr_count("$img_file", ".jpeg") + substr_count("$img_file", ".JPEG");
                        if (($str_type!="0")&&($str_tn!="1")) {

                           If ((!file_exists("$folder/$folder_a/$folder_b/tn_$img_file") or $_POST['mg_file_rewrite']) and $_POST['mg_icon_create']) {

                              $sourse_file = "$folder/$folder_a/$folder_b/$img_file";
                              $dist_file = "$folder/$folder_a/$folder_b/tn_$img_file";


                              $height = $foto_icon_height;
                              $width= $foto_icon_width;

                            if ($pref['gallery_slide_show']) {
                              //======= Create icon in Slide TN_ =====================
                              $blank_tn = "images/tn_blank.jpg";

                              list($width_blank, $height_blank) = getimagesize($blank_tn);
                              list($width_orig, $height_orig) = getimagesize($sourse_file);

                              if ($width>$width_orig) { $width=$width_orig; }
                              if ($height>$height_orig) { $height=$height_orig; }
                              if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
                              if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }

                              // Resample
                              $dist_x = ($width_blank - $width)/2;
                              $dist_y = ($height_blank*0.9 - $height)/2;

                              $image_p = imagecreatefromjpeg($blank_tn);

                              // Print Image size
                              $color = imagecolorallocate($image_p, 90, 90, 90);
                              $string = "".$width_orig."x".$height_orig."";
                              imagestring($image_p, 1, 11, $height_blank - 14, $string, $color);

                              $image = imagecreatefromjpeg($sourse_file);
                              imagecopyresampled($image_p, $image, $dist_x, $dist_y, 0, 0, $width, $height, $width_orig, $height_orig);

                              $message .= "$folder_a/$folder_b/$img_file  - tn_$img_file (In Slide) ";

                            } else {

                              //=========== Create normal icon ==============================
                              list($width_orig, $height_orig) = getimagesize($sourse_file);
                              if ($width>$width_orig) { $width=$width_orig; }
                              if ($height>$height_orig) { $height=$height_orig; }
                              if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
                              if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
                              // Resample

                              $image_p = imagecreatetruecolor($width, $height);
                              $image = imagecreatefromjpeg($sourse_file);
                              imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                              $message .= "$folder_a/$folder_b/$img_file  - tn_$img_file ";

                            }

                            // Output
                            imagejpeg($image_p, $dist_file, $img_quality);
                            imagedestroy($image_p);
                            imagedestroy($image);

                            $message .= " created <br>";


                           }

                           If ((!file_exists("$folder/$folder_a/$folder_b/tv_$img_file") or $_POST['mg_file_rewrite']) and $_POST['mg_view_create']) {

                            //=========== Create views ==============================
                            $sourse_file = "$folder/$folder_a/$folder_b/$img_file";
                            $dist_file = "$folder/$folder_a/$folder_b/tv_$img_file";

                            $height = $foto_view_height;
                            $width= $foto_view_width;

                            list($width_orig, $height_orig) = getimagesize($sourse_file);
                            if ($width>$width_orig) { $width=$width_orig; }
                            if ($height>$height_orig) { $height=$height_orig; }
                            if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
                            if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
                            // Resample

                            $image_p = imagecreatetruecolor($width, $height);
                            $image = imagecreatefromjpeg($sourse_file);
                            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                            // Output
                            imagejpeg($image_p, $dist_file, $img_quality);
                            imagedestroy($image_p);
                            imagedestroy($image);

                            $message .= "$folder_a/$folder_b/$img_file  - tv_$img_file created<br>";


                           }

                        }
                    }
                  }
           }
   }





    $ns->tablerender(LAN_GAL_L049, $message);

}




/*
//============ Delete album ===============
if(IsSet($_POST['cat_delete'])) {

	$folder = $pref['gallery_folder'];
	$gallery = urldecode("".$folder."/".$gall_qs[1]."/".$gall_qs[2]."");

	if  (deltree($gallery)) {
		$db_del_msg = $mydb->db_Delete("gallery", "img_name = '".$gallery."'");
	    $message = "Catalog: ".$gallery." - deleted".($db_del_msg ? ", DB line erased" : "")."";
    } else {
    	$message = "Catalog: ".$gallery." - delete error";
    	}

    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}

//============ Delete catalog ===============
if(IsSet($_POST['deletecat'])) {

    foreach(array_keys($_POST['checked']) as $gallery) {

		if  (deltree($gallery)) {
			$db_del_msg = $mydb->db_Delete("gallery", "img_name like '".$gallery."%'");
		    $message .= "<br/>Catalog: ".$gallery." - deleted".($db_del_msg ? ", DB line erased" : "")."";
	    } else {
	    	$message .= "<br/>Catalog: ".$gallery." - delete error";
	    	}

    }

    if ($message == "")    $message = "Select any line!!!";


    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

}

//============ Move image script ===============
if(IsSet($_POST['move'])) {

    list($url_str, $guery) = explode("?menu_img:", $_POST['move_gallery']);
    list($move_folder_a, $move_folder_b) = explode(":", $guery);

    $move_folder = "".$pref['gallery_folder']."/".$move_folder_a."/".$move_folder_b."";

    foreach(array_keys($_POST['checked']) as $img_name) {

        list($folder, $folder_a, $folder_b, $img_file) = explode("/", $img_name);

		$file_move_msg = rename($img_name, $move_folder."/".$img_file);
		$tn_file_move_msg = rename($folder."/".$folder_a."/".$folder_b."/tn_".$img_file, $move_folder."/tn_".$img_file);
		$tv_file_move_msg = rename($folder."/".$folder_a."/".$folder_b."/tv_".$img_file, $move_folder."/tv_".$img_file);
        $db_file_move_msg = $mydb->db_Update("gallery", "img_name='".$move_folder."/".$img_file."' WHERE img_name='".$img_name."'");

        $message .= ($file_move_msg ? "".$img_file."" : "")
        .($tn_file_move_msg ? ", tn_".$img_file."" : "")
        .($tv_file_move_msg ? ", tv_".$img_file."" : "")
        ." move to ".$move_folder
        .($db_file_move_msg ? ", DB Line update" : "")."<br>";



    }

//    $message = "".$pref['gallery_folder']."/".$move_folder_a."/".$move_folder_b."";
    if ($message == "")    $message = "Select any line!!!";


    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

}

//============ Update image script ===============
if(IsSet($_POST['update'])) {

    foreach(array_keys($_POST['checked']) as $img_name) {

      if ( $mydb->db_Count("gallery", "(*)", "WHERE img_name = '".$img_name."'") > 0 ) {

        $mydb->db_Update("gallery", "img_title='".$_POST['img_title'][$img_name]."', img_description='".$_POST['img_description'][$img_name]."' WHERE img_name='$img_name'");
        $message .= "Image: ".$img_name." - DB line updated<br>";

      } else {

        $sql_text = array(
              "img_name" =>           $tp -> toDB($img_name),
              "img_title" =>          $tp -> toDB($_POST['img_title'][$img_name]),
              "img_description" =>    $tp -> toDB($_POST['img_description'][$img_name])
              );

        $mydb->db_Insert("gallery", $sql_text);
        $message .= "Image: ".$img_name." - DB line insert<br>";

      }
    }
    //--------- Update gallery name A ----------
    if ($_POST['folder_a_name'] != $_POST['folder_a_name_def']) {

        if ( $mydb->db_Count("gallery", "(*)", "WHERE img_name = '".$pref['gallery_folder']."/".urldecode($gall_qs[1])."' and img_status = 'menu'") > 0 ) {

        $mydb->db_Update("gallery", "img_title='".$tp -> toDB($_POST['folder_a_name'])."' WHERE img_name = '".$pref['gallery_folder']."/".urldecode($gall_qs[1])."' and img_status = 'menu'");
        $message .= "Gallery: ".$gall_qs[1]." - DB line updated<br>";

        } else {

        $sql_text = array(
              "img_name" =>           $tp -> toDB($pref['gallery_folder']."/".urldecode($gall_qs[1])),
              "img_title" =>          $tp -> toDB($_POST['folder_a_name']),
              "img_status" =>         $tp -> toDB("menu")
              );

        $mydb->db_Insert("gallery", $sql_text);
        $message .= "Gallery: ".$gall_qs[1]." - DB line insert<br>";

        }
    }

    //--------- Update gallery name B ----------
    if ($_POST['folder_b_name'] != $_POST['folder_b_name_def']) {

        if ( $mydb->db_Count("gallery", "(*)", "WHERE img_name='".$pref['gallery_folder']."/".urldecode($gall_qs[1]."/".$gall_qs[2])."' and img_status = 'menu'") > 0 )
        {
        $mydb->db_Update("gallery", "img_title='".$tp -> toDB($_POST['folder_b_name'])."' WHERE img_name='".$pref['gallery_folder']."/".urldecode($gall_qs[1]."/".$gall_qs[2])."' and img_status = 'menu'");
        $message .= "Gallery: ".$gall_qs[2]." - DB line updated<br>";
        } else {
        $sql_text = array(
              "img_name" =>           $tp -> toDB($pref['gallery_folder']."/".urldecode($gall_qs[1]."/".$gall_qs[2])),
              "img_title" =>          $tp -> toDB($_POST['folder_b_name']),
              "img_status" =>         $tp -> toDB("menu")
              );

        $mydb->db_Insert("gallery", $sql_text);
        $message .= "Gallery: ".$gall_qs[2]." - DB line insert<br>";
        }
    }

    if ($message == "")    $message = "Select any line!!!";

    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

}




//============ Public image script ===============
if(IsSet($_POST['public'])) {

  $pref['gallery_img_quality'] = $_POST['gallery_img_quality'];
  $pref['mg_icon_create'] = $_POST['mg_icon_create'];
  $pref['mg_view_create'] = $_POST['mg_view_create'];
  $pref['mg_original_change'] = $_POST['mg_original_change'];
  $pref['mg_original_size'] = $_POST['mg_original_size'];

    save_prefs();

    foreach(array_keys($_POST['checked']) as $img_name) {

    $img_title = $_POST['img_title'][$img_name];
    $img_description = $_POST['img_description'][$img_name];

    $mydb->db_Update("gallery", "img_status='public', img_title='$img_title', img_description='$img_description' WHERE img_name='$img_name'");

    $message .= "$img_title - $img_description - public<br>";

    //------------- Create views -------------------
    if ($_POST['mg_view_create']) {

        $sourse_file = $img_name;
        list($folder, $folder_a, $folder_b, $img_file) = explode("/", $img_name);
        $dist_file = "$folder/$folder_a/$folder_b/tv_$img_file";

        $height = $pref['gallery_img_view_height'];
        $width= $pref['gallery_img_view_width'];

        list($width_orig, $height_orig) = getimagesize($sourse_file);
        if ($width>$width_orig) { $width=$width_orig; }
        if ($height>$height_orig) { $height=$height_orig; }
        if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
        if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
        // Resample

        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($sourse_file);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        // Output
        imagejpeg($image_p, $dist_file, $pref['gallery_img_quality']);
        imagedestroy($image_p);
        imagedestroy($image);

        $message .= "$folder_a/$folder_b/$img_file  - tv_$img_file created<br>";

    }

    //------------- ReCreate Original  -------------------
	    if ($_POST['mg_original_change']) {

	        $sourse_file = $img_name;
	        $dist_file = $img_name;

	        $height = $pref['mg_original_size'];
	        $width = $pref['mg_original_size'];

	        list($width_orig, $height_orig) = getimagesize($sourse_file);

	        if ($width_orig > $width or $height_orig > $height) {

	          if ($width>$width_orig) { $width=$width_orig; }
	          if ($height>$height_orig) { $height=$height_orig; }
	          if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
	          if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
	          //------------- Resample -----------

	          $image_p = imagecreatetruecolor($width, $height);
	          $image = imagecreatefromjpeg($sourse_file);
	          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	          //-------- Output -------------
	          imagejpeg($image_p, $dist_file, $pref['gallery_img_quality']);
	          imagedestroy($image_p);
	          imagedestroy($image);

	          $message .= "".$img_name." - Original recreated<br>";

	        }
	    }

   		//------------- Create icon -----------------------
	     If ($_POST['mg_icon_create']) {

	        $sourse_file = $img_name;
	        list($folder, $folder_a, $folder_b, $img_file) = explode("/", $img_name);
	        $dist_file = "$folder/$folder_a/$folder_b/tn_$img_file";

	        $height = $pref['gallery_img_icon_height'];
	        $width= $pref['gallery_img_icon_width'];

	   //------------- Create icon in Slide --------------------
	      if ($pref['gallery_slide_show']) {

	        $blank_tn = "images/tn_blank.jpg";

	        list($width_blank, $height_blank) = getimagesize($blank_tn);
	        list($width_orig, $height_orig) = getimagesize($sourse_file);

	        if ($width>$width_orig) { $width=$width_orig; }
	        if ($height>$height_orig) { $height=$height_orig; }
	        if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
	        if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }

	        // Resample
	        $dist_x = ($width_blank - $width)/2;
	        $dist_y = ($height_blank*0.9 - $height)/2;

	        $image_p = imagecreatefromjpeg($blank_tn);

	        // Print Image size
	        $color = imagecolorallocate($image_p, 90, 90, 90);
	        $string = "".$width_orig."x".$height_orig."";
	        imagestring($image_p, 1, 11, $height_blank - 14, $string, $color);

	        $image = imagecreatefromjpeg($sourse_file);
	        imagecopyresampled($image_p, $image, $dist_x, $dist_y, 0, 0, $width, $height, $width_orig, $height_orig);

	        $message .= "$folder_a/$folder_b/$img_file  - tn_$img_file (In Slide) ";

	      } else {

	        //-------------- Create normal icon ---------------------------
	        list($width_orig, $height_orig) = getimagesize($sourse_file);
	        if ($width>$width_orig) { $width=$width_orig; }
	        if ($height>$height_orig) { $height=$height_orig; }
	        if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
	        if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
	        // Resample

	        $image_p = imagecreatetruecolor($width, $height);
	        $image = imagecreatefromjpeg($sourse_file);
	        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	        $message .= "$folder_a/$folder_b/$img_file  - tn_$img_file ";

	      }

	      //----------- Output ----------------
	      imagejpeg($image_p, $dist_file, $pref['gallery_img_quality']);
	      imagedestroy($image_p);
	      imagedestroy($image);

	      $message .= " created <br>";

	     }

    }

    if ($message == "")    $message = "Select any line!!!";

    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

}
*/
//==================================================================================================
//					MENU IMAGE
// =================================================================================================
if ($action == 'menu_img') {

//============ Delete image ===============
if (IsSet($subaction) && $subaction == 'delete_img'){
	$mydb->db_Select("gallery_img", "*", "img_id='$id'");
		while($row = $mydb->db_Fetch()) {
			$img_cat_id = $row['img_cat_id'];
			$img_name = $row['img_name'];
		}
	$mydb->db_Select("gallery_cat", "*", "cat_id='$img_cat_id'");
		while($row = $mydb->db_Fetch()) {
			$cat_foldername = $row['cat_foldername'];
		}
	$puth = e_PLUGIN."gallery/albums/$cat_foldername/$img_name";
//	$file_del_msg = unlink($puth);
//	$filename = '/path/to/foo.txt';

if (file_exists($puth)) {
//    $message = "Файл $puth существует";
//    $message .= substr(sprintf('%o', fileperms($puth)), -4);
    unlink($puth);
    $db_del_msg = $mydb->db_Delete("gallery_img", "img_id='$id'");
} else {
    $message = "Файл $puth не существует";
}
//	$db_del_msg = $mydb->db_Delete("gallery_img", "img_id='$id'");
/*	foreach(array_keys($_POST['checked']) as $img_name) {
		$file_del_msg = unlink($img_name);

        if ($mydb->db_Select("gallery", "*", "img_name = '".$img_name."'")) {
          while($row = $mydb->db_Fetch()) {
              $db_del_msg = $mydb->db_Delete("gallery_img", "img_id = '".$row['img_id']."'");
              $db_comm_del_msg = $mydb->db_Delete("comments", "comment_item_id = '".$row['img_id']."' AND comment_type = 'gallery'");
          }
        }
        $message .= ($file_del_msg ? "File: ".$img_name." - deleted" : "")
        .($db_del_msg ? ", DB line - deleted" : "")
        .($db_comm_del_msg ? ", Comments - deleted" : "")
        ."<br>";
    }
    */
//       $message = $puth;
 //      $message = file_exists($puth);
//    $message = ($file_del_msg ? "File: ".$img_name." - deleted" : "").($db_del_msg ? ", DB line - deleted" : "").($db_comm_del_msg ? ", Comments - deleted" : "");
        
   $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

}

$mydb->db_Select("gallery_cat", "*", "cat_id='$id'");
	while($row = $mydb->db_Fetch()) {
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
		$cat_foldername = $row['cat_foldername'];
	}

$text = "<div style='text-align:center'>
	<form enctype='multipart/form-data' method='post' action='".e_SELF."?menu_img'>
          <table class='fborder'>";
$text .="	<td class='fcaption'>ID</td>
		<td class='fcaption'>".LAN_GAL_IMG_IMG."</td>
		<td class='fcaption'>".LAN_GAL_IMG_NAME."</td>
		<td class='fcaption'>".LAN_GAL_IMG_DESC."</td>
		<td class='fcaption'>".LAN_GAL_IMG_STATUS."</td>
		<td class='fcaption'>".LAN_GAL_IMG_COUNT."</td>
		<td class='fcaption'>".LAN_GAL_IMG_OPTIONS."</td>
      ";

// if ($mydb->db_Select("gallery", "*", "img_status = 'upload'")) {
if (IsSet($id) && $id<>'') {
	$mydb->db_Select("gallery_img", "*", "img_cat_id='$id'");
	} else {
	$mydb->db_Select("gallery_img", "*", "");
	}
	while($row = $mydb->db_Fetch()) {
		$img_id = $row['img_id'];
		$img_cat_id = $row['img_cat_id'];
		$img_name = $row['img_name'];
		$img_desc = $row['img_desc'];
		$img_title = $row['img_title'];
		$img_status = $row['img_status'];
		$img_userid = $row['img_userid'];
		$img_count = $row['img_count'];
	$text .="<tr>";
	$text .="<td class='forumheader2'><input class='tbox' type='text' value='$img_id' name=img_id size='1'></td>";
	$text .="<td class='forumheader2'><img src='".e_PLUGIN."gallery/albums/$cat_foldername/$img_name' width=50px></td>";
	$text .="<td class='forumheader2'><input class='tbox' type='text' value='$img_title' name=img_title size='10'></td>";
	$text .="<td class='forumheader2'><textarea class='tbox' style='width:90%' name='img_desc' cols='50' rows='2'>$img_desc</textarea></td>";
	$text .="<td class='forumheader2'>$img_status</td>";
	$text .="<td class='forumheader2'>$img_count</td>";
	$text .="<td class='forumheader2'>
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_img.delete_img.$img_id' onclick=\"return jsconfirm('Хотите удалить это изображение?')\">
		<img src='".e_IMAGE."admin/delete_16.png' alt='' title='Удалить изображение' ></a>&nbsp;	
	</td>";
	$text .="</tr>";
        }

//$text .= $button_text;
$text .= "</table></form>";


$captions = LAN_GAL_CAP_IMG;
$ns -> tablerender($captions, $text);

}

//==================================================================================================
//					MENU IMAGE UPLOAD
// =================================================================================================
if ($action == 'menu_img_upload') {
	if ($mydb->db_Select("gallery", "*", "img_status = 'menu'")) {
		while($row = $mydb->db_Fetch()) {
			$folder_name[$row['img_name']] = $row['img_title'];
		}
	}
//============ Add image script ==================
if (IsSet($_POST['submit_add_img'])){
//======check empty============//

$img_status = 'public';
$img_userid = USERID;
$file_name = $_POST['file_name'];
$file_cat_id = $_POST['file_cat_id'];
$file_foldername = $_POST['file_foldername'];
$gall_patch = e_PLUGIN."gallery/albums/$file_foldername/";
$file_desc = $_POST['file_desc'];

if ($file_name==''){
	$message = "<font color=red>".NB_MES_21."$gall_patch $file_desc</font>";
	$ns -> tablerender(LAN_GAL_MES, $message);
	}
	else {
//		$cnt = count($gnl_pic);
//if($cnt  < 6){
//	$gnl_pic = array_merge($gnl_pic, array_fill($cnt, 6 - $cnt, ''));
//}
	
	$message = "<font color=red>".NB_MES_21."$gall_patch</font>";
	$ns -> tablerender(LAN_GAL_MES, $message);
		if (isset($_FILES['file_userfile']['error'])){
		require_once(e_HANDLER."upload_handler.php");
		if ($uploaded = file_upload("$gall_patch", "attachment")){
			 	foreach($uploaded as $name){
				 if ($name['error'] == 0 ) {
				$orig_file = $name['name'];
			$file_userfile[] = $orig_file;
			
				if(strstr($name['type'], "image")){
					require_once(e_HANDLER."resize_handler.php");
		$small_img = "small_$orig_file";
		$big_img = "big_$orig_file";
					if(resize_image($gall_patch.$orig_file, $gall_patch.$small_img, $pref['gallery_img_icon_width'])){
//					$parms_small = image_getsize(e_PLUGIN.'nboard/nb_pictures/'.$small_img);
//					$parms_big = image_getsize(e_PLUGIN.'nboard/nb_pictures/'.$big_img);
					}
					if(resize_image($gall_patch.$orig_file, $gall_patch.$big_img, $pref['gallery_img_view_width'])){
//					$parms = image_getsize(e_PLUGIN.'nboard/nb_pictures/'.$big_img);
//					$gnl_pic1 = $orig_file;
					}
				}
				else{	//upload was not an image, link to file
					$_POST['post'] .= "[br][file=".$gall_patch.$upload['name']."]".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."[/file]";
				}
			  }
			  else{  // Error in uploaded file
			    echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
			  }
		$sql = new db;
		$sql -> db_Insert("gallery_img", "0,'$file_cat_id','$orig_file','$file_desc','$file_name','$img_status','$img_userid','$img_count'");
		
			}
	
		}
	}
	
//
	/*
else{  // Error in uploaded file
			   	  //echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
		} */
			
//	$sql = new db;
//	$sql -> db_Insert("nb_gnl", "0, '$cat_sub_id','$gnl_name','$gnl_city','$gnl_pic','$gnl_pic2','$gnl_pic3','$gnl_pic4','$gnl_pic5','$gnl_pic6','$gnl_detail','$gnl_price','$gnl_user', '$gnl_phone','$gnl_email','$gnl_date_start','$gnl_date_end', '0'");
//$gnl_scatid=$gnl_name=$gnl_city=$gnl_picbig=$gnl_pic1=$gnl_detail=$gnl_price=$gnl_user=$gnl_phone=$gnl_email=$gnl_date_start=$gnl_date_end=$conf_check_ans='';
//	header ("Location: ".e_PLUGIN."gallery/gallery.php?add");
//	exit;
	$message = "<font color=red>".NB_MES_20." ".strftime('%d %b %Y',$gnl_date_end)."</font>";
	$ns -> tablerender(LAN_GAL_MES, $message);
	}
}

$text = "
	<div style='text-align:center'>
	<form enctype='multipart/form-data' method='post' action='".e_SELF."?menu_img_upload'>
	<table class='fborder'>
	<tr>
	<td class='forumheader3'>".LAN_GAL_DIR."</td>
	<td class='forumheader3'>
	";

//========= Select folders list ==================


$text .= "<select name='catFoldername' class='tbox'>";
	if (IsSet($id) && $id<>''){
		$mydb->db_Select("gallery_cat", "*", "cat_id='$id'");
		     while($row = $mydb->db_Fetch()) {
			$cat_name = $row['cat_name'];
			$cat_foldername = $row['cat_foldername'];
	$text .= "<option value='$cat_foldername'>$cat_name</option>";
		}
	}
	
$text .= "</select>";

//$text .= "$id - $catFoldername - $cat_name";
$text .= "</td></tr>";
$text .= "<tr>
	<td class='forumheader3'>".LAN_GAL_IMG_NAME.":</td>
	<td class='forumheader3'>
	<input class='tbox' name='file_name' type='text' size='50' maxlength='100' />
	<input class='tbox' name='file_foldername' type='text' size='50' value='$cat_foldername' />
	<input class='tbox' name='file_cat_id' type='text' size='50' value='$id' />
	</td>
	</tr>
	<tr>
	<td class='forumheader3'>".LAN_GAL_IMG_DESC.":</td>
	<td style='width:70%' class='forumheader3'><textarea class='tbox' style='width:90%' name='file_desc' cols='59' rows='3'>$file_desc</textarea></td>
	</tr>
	<tr>
	<td class='forumheader3'>".LAN_GAL_IMG_FILE."</td>
	<td class='forumheader3'>
		<div id='fiupsection'>
			<span id='fiupopt'>
				<input class='tbox' name='file_userfile[]' type='file' size='50' />
			</span>
		</div>
		<input class='button' type='button' name='addoption' value='+' onclick=\"duplicateHTML('fiupopt','fiupsection')\" />
	</td>
	</tr>
		<tr>
	<td class='forumheader3' colspan='2' style='text-align:center;'>
		<input class='button' type='submit' name='submit_add_img' value='".LAN_GAL_BUT_PUBLIC."' />
		<a href='".e_PLUGIN."gallery/admin_config.php?menu_cat' class='button'>".LAN_GAL_BUT_CAN."</a>&nbsp;
	</td>
	</tr>
</table></form>";
	$ns -> tablerender(LAN_GAL_CAP_IMG_UP, $text);
}



//==================================================================================================
//					OPTIONS
// =================================================================================================
if ($action == 'menu_options') {


//=========== Update settings script =================
if(IsSet($_POST['updatesettings'])) {

	$pref['gallery_rows'] = $_POST['gallery_rows'];
	$pref['gallery_columns'] = $_POST['gallery_columns'];
	$pref['gallery_menu_rows'] = $_POST['gallery_menu_rows'];
	$pref['gallery_menu_columns'] = $_POST['gallery_menu_columns'];
	$pref['gallery_img_icon_height'] = $_POST['gallery_img_icon_height'];
	$pref['gallery_img_icon_width'] = $_POST['gallery_img_icon_width'];
	$pref['gallery_img_view_height'] = $_POST['gallery_img_view_height'];
	$pref['gallery_img_view_width'] = $_POST['gallery_img_view_width'];
	$pref['gallery_title_image'] = $_POST['gallery_title_image'];
	$pref['gallery_gallery_name'] = $_POST['gallery_gallery_name'];
	$pref['gallery_nav_position'] = $_POST['gallery_nav_position'];
	$pref['gallery_menu_caption'] = $_POST['gallery_menu_caption'];
	$pref['gallery_menu_img_size'] = $_POST['gallery_menu_img_size'];
	$pref['gallery_slide_show'] = $_POST['gallery_slide_show'];
	$pref['gallery_memo_show'] = $_POST['gallery_memo_show'];
	$pref['gallery_mine_cikle'] = $_POST['gallery_mine_cikle'];
	$pref['gallery_nav_show'] = $_POST['gallery_nav_show'];
	$pref['gallery_comments'] = $_POST['gallery_comments'];
	$pref['gallery_raters'] = $_POST['gallery_raters'];
	$pref['gallery_hs_theme'] = $_POST['gallery_hs_theme'];
	$pref['gallery_img_quality'] = $_POST['gallery_img_quality'];
	$pref['gallery_sort_type'] = $_POST['gallery_sort_type'];
	$pref['mg_icon_create'] = $_POST['mg_icon_create'];
	$pref['mg_view_create'] = $_POST['mg_view_create'];
	$pref['mg_minepage_logo'] = $_POST['mg_minepage_logo'];
	$pref['mg_minepage_random'] = $_POST['mg_minepage_random'];
	$pref['mg_minepage_upload'] = $_POST['mg_minepage_upload'];
	$pref['mg_minepage_comment'] = $_POST['mg_minepage_comment'];

    save_prefs();

    $message = LAN_GAL_MES_SAVE_PREFS;
    $ns->tablerender(LAN_GAL_MES, "<div style='text-align:center'><b>$message</b></div>");
}


$text = "<form name='setings' action='".e_SELF."?menu_options' method='post'>

<table width=100%>
<tr>
<td class='fcaption' colspan=4>".LAN_GAL_OPT_CAP1."</td>
</tr>
<tr>
<td class='fcaption'>Порядок</td>
<td class='fcaption'>Разделы</td>
<td class='fcaption'>Видимость</td>
<td class='fcaption'>Количество (колонок-рядов)</td>
</tr>
<tr>
<td class='forumheader3'>Порядок</td>
<td class='forumheader3'>".LAN_GAL_OPT_003."</td>
<td class='forumheader3'><input type='checkbox' name='mg_minepage_upload' value='1' ".($pref['mg_minepage_upload'] ? "checked='checked'" : "")." /></td>
<td class='forumheader3'>
<input class='tbox' type='text' name='gallery_columns' size='5' value='".$pref['gallery_columns']."'> *
<input class='tbox' type='text' name='gallery_rows' size='5' value='".$pref['gallery_rows']."'> =
".$gallery_img_in_page."
</td>
</tr>
<tr>
<td class='forumheader3'>Порядок</td>
<td class='forumheader3'>".LAN_GAL_OPT_003."</td>
<td class='forumheader3'><input type='checkbox' name='mg_minepage_upload' value='1' ".($pref['mg_minepage_upload'] ? "checked='checked'" : "")." /></td>
<td class='forumheader3'>
<input class='tbox' type='text' name='gallery_columns' size='5' value='".$pref['gallery_columns']."'> *
<input class='tbox' type='text' name='gallery_rows' size='5' value='".$pref['gallery_rows']."'> =
".$gallery_img_in_page."
</td>
</tr>
<tr>
<td class='forumheader3'>Порядок</td>
<td class='forumheader3'>".LAN_GAL_OPT_004."</td>
<td class='forumheader3'><input type='checkbox' name='mg_minepage_upload' value='1' ".($pref['mg_minepage_comment'] ? "checked='checked'" : "")." /></td>
<td class='forumheader3'>
<input class='tbox' type='text' name='gallery_columns' size='5' value='".$pref['gallery_columns']."'> *
<input class='tbox' type='text' name='gallery_rows' size='5' value='".$pref['gallery_rows']."'> =
".$gallery_img_in_page."
</td>
</tr>
<tr>
<td class='forumheader3'>Порядок</td>
<td class='forumheader3'>".LAN_GAL_OPT_005."</td>
<td class='forumheader3'><input type='checkbox' name='mg_minepage_upload' value='1' ".($pref['mg_minepage_random'] ? "checked='checked'" : "")." /></td>
<td class='forumheader3'>
<input class='tbox' type='text' name='gallery_columns' size='5' value='".$pref['gallery_columns']."'> *
<input class='tbox' type='text' name='gallery_rows' size='5' value='".$pref['gallery_rows']."'> =
".$gallery_img_in_page."
</td>
</tr>
</table>

<table style='width:100%' class='fborder'>";

$text .="<tr><td class='forumheader3' colspan=2><b>".LAN_GAL_OPT_CAP2."</b></td>
</tr>";

//============ GD test ==================
$text .="<tr><td class='forumheader3'>GD Version/Test</td>";
if ($array = gd_info ()) {
    $gd_test =  "GD Version - ".$array['GD Version']."";
    if ($array['JPG Support']===true) {
	$text .="<td class='forumheader3'>$gd_test, JPG Support - Enabled</td>";
    } else { 
    $text .="<td class='forumheader3'>$gd_test, JPG Support - Disabled</td>";
    }
} else {
$text .="<td class='forumheader3'>$gd_test, GD not support!!!</td>";
}
$text .="</tr><tr>";


$text .="<tr>
<td class='forumheader3'>".LAN_GAL_OPT_001."</td>
<td class='forumheader3'><input class='tbox' type='text' name='gallery_gallery_name' size='60' value='".$pref['gallery_gallery_name']."'></td>
</tr>
<tr>
<td class='forumheader3'>".LAN_GAL_OPT_006."</td>
<td class='forumheader3'>    
    <select class='tbox' name='gallery_nav_show'>"
    .($pref['gallery_nav_show'] == "0" ? "<option value='0' selected='selected'>".LAN_GAL_OPT_010."</option>"
    : "<option value='0'>".LAN_GAL_OPT_010."</option>")
    .($pref['gallery_nav_show'] == "1" ? "<option value='1' selected='selected'>".LAN_GAL_OPT_007."</option>"
    : "<option value='1'>".LAN_GAL_OPT_007."</option>")
    .($pref['gallery_nav_show'] == "2" ? "<option value='2' selected='selected'>".LAN_GAL_OPT_008."</option>"
    : "<option value='2'>".LAN_GAL_OPT_008."</option>")
    ."</select>
</td>
</tr>

<tr>
<td class='forumheader3'>".LAN_GAL_OPT_009."</td>
<td class='forumheader3'>
    <select class='tbox' name='gallery_memo_show'>"
    .($pref['gallery_memo_show'] == "0" ? "<option value='0' selected='selected'>".LAN_GAL_OPT_010."</option>"
    : "<option value='0'>".LAN_GAL_OPT_010."</option>")
    .($pref['gallery_memo_show'] == "1" ? "<option value='1' selected='selected'>".LAN_GAL_OPT_011."</option>"
    : "<option value='1'>".LAN_GAL_OPT_011."</option>")
    .($pref['gallery_memo_show'] == "2" ? "<option value='2' selected='selected'>".LAN_GAL_OPT_012."</option>"
    : "<option value='2'>".LAN_GAL_OPT_012."</option>")
    ."</select>
</td>
</tr>

";

$gallery_img_in_page = $pref['gallery_columns'] * $pref['gallery_rows'];
$text .="<tr>
<td class='forumheader3'>".LAN_GAL_OPT_013."</td>
<td class='forumheader3'>
<input class='tbox' type='text' name='gallery_columns' size='5' value='".$pref['gallery_columns']."'> *
<input class='tbox' type='text' name='gallery_rows' size='5' value='".$pref['gallery_rows']."'> =
".$gallery_img_in_page."
</td>
</tr>

<tr>
<td class='forumheader3'>".LAN_GAL_OPT_014."</td>
<td class='forumheader3'><input class='tbox' type='text' name='gallery_img_icon_height' size='5' value='".$pref['gallery_img_icon_height']."'> 
<input class='tbox' type='text' name='gallery_img_icon_width' size='5' value='".$pref['gallery_img_icon_width']."'> </td>
</tr>

<tr>
<td class='forumheader3'>".LAN_GAL_OPT_015."</td>
<td class='forumheader3'><input class='tbox' type='text' name='gallery_img_view_height' size='5' value='".$pref['gallery_img_view_height']."'> 
<input class='tbox' type='text' name='gallery_img_view_width' size='5' value='".$pref['gallery_img_view_width']."'></td>
</tr>


<tr>
<td class='forumheader3'>".LAN_GAL_OPT_018." </td>
<td class='forumheader3'>". ($pref['gallery_slide_show']
? "<input type='checkbox' name='gallery_slide_show' value='1' checked='checked' /> ".LAN_GAL_OPT_019.""
: "<input type='checkbox' name='gallery_slide_show' value='1' /> ".LAN_GAL_OPT_019."")."
</td>
</tr>

<tr>
<td class='forumheader3'>".LAN_GAL_OPT_020."</td>
<td class='forumheader3'>
".($mydb->db_Count("plugin", "(*)", "WHERE plugin_path='eHighSlide' AND plugin_installflag=1")
? "".LAN_GAL_OPT_021.""
: "<select class='tbox' name='gallery_hs_theme'>"
    .($pref['gallery_hs_theme'] == "0" ? "<option value='0' selected='selected'>White 10px border and drop shadow</option>"
    : "<option value='0'>White 10px border and drop shadow</option>")
    .($pref['gallery_hs_theme'] == "1" ? "<option value='1' selected='selected'>Drop shadow and no border</option>"
    : "<option value='1'>Drop shadow and no border</option>")
    .($pref['gallery_hs_theme'] == "2" ? "<option value='2' selected='selected'>Dark design with outer glow</option>"
    : "<option value='2'>Dark design with outer glow</option>")
    .($pref['gallery_hs_theme'] == "3" ? "<option value='3' selected='selected'>White outline with rounded corners</option>"
    : "<option value='3'>White outline with rounded corners</option>")
    .($pref['gallery_hs_theme'] == "4" ? "<option value='4' selected='selected'>No graphic outline</option>"
    : "<option value='4'>No graphic outline</option>")
    .($pref['gallery_hs_theme'] == "5" ? "<option value='5' selected='selected'>Slideshow with a controlbar</option>"
    : "<option value='5'>Slideshow with a controlbar</option>")
    ."</select>")."
</td>
</tr>
";

$text .= "




<tr>
	<td class='forumheader3'>".LAN_GAL_OPT_022." </td>
	<td class='forumheader3'>".($pref['gallery_comments'] ? "<input type='checkbox' name='gallery_comments' value='1' checked='checked' /> " : "<input type='checkbox' name='gallery_comments' value='1' /> ")."
</td>
</tr>
<tr>
	<td class='forumheader3'>".LAN_GAL_OPT_023." </td>
	<td class='forumheader3'>".($pref['gallery_raters'] ? "<input type='checkbox' name='gallery_raters' value='1' checked='checked' /> " : "<input type='checkbox' name='gallery_raters' value='1' /> ")."
</td>
</tr>
<tr>
<td class='forumheader3'>".LAN_GAL_OPT_024."</td>
<td class='forumheader3'><input class='tbox' type='text' name='gallery_sort_type' size='5' value='".$pref['gallery_sort_type']."'>
<br><b>NA</b> - Name ASC, <b>ND</b> - Name DESC,<br><b>DA</b> - Date ASC, <b>DD</b> - Date DESC.
</td>
</tr>
<tr>
<td class='forumheader3' colspan='2'><b>".LAN_GAL_OPT_CAP7."</b></td>
</tr>";
$gallery_img_in_menu = $pref['gallery_menu_columns'] * $pref['gallery_menu_rows'];
$text .="
<tr>
<td class='forumheader3'>".LAN_GAL_OPT_033."</td>
<td class='forumheader3'>
<input class='tbox' type='text' name='gallery_columns' size='5' value='".$pref['gallery_menu_columns']."'> *
<input class='tbox' type='text' name='gallery_rows' size='5' value='".$pref['gallery_menu_rows']."'> =
".$gallery_img_in_menu."
</td>
</tr>
<tr>
<td class='forumheader3'>".LAN_GAL_OPT_025."</td>
<td class='forumheader3'><input class='tbox' type='text' name='gallery_menu_caption' value='".$pref['gallery_menu_caption']."'></td>
</tr>
<tr>
<td class='forumheader3'>".LAN_GAL_OPT_026."</td>
<td class='forumheader3'><input class='tbox' type='text' name='gallery_menu_img_size' size='10' value='".$pref['gallery_menu_img_size']."'></td>
</tr>


<td class='forumheader3' colspan='2'><b>".LAN_GAL_OPT_CAP6."</b></td>
<tr>
<td class='forumheader3'>".LAN_GAL_OPT_028."</td>
<td class='forumheader3'>
<input type='checkbox' name='mg_icon_create' value='1' ".($pref['mg_icon_create'] ? "checked='checked'" : "")." /> ".LAN_GAL_OPT_029."
<input type='checkbox' name='mg_view_create' value='1' ".($pref['mg_view_create'] ? "checked='checked'" : "")." /> ".LAN_GAL_OPT_030."
<input class='tbox' type='text' name='gallery_img_quality' size='5' value='".$pref['gallery_img_quality']."'> ".LAN_GAL_OPT_032."
</td>
</tr>

<tr>
<td class='forumheader3' colspan='2'><div align='center'><input class='button' type='submit' name='updatesettings' value='".LAN_GAL_L018."'></div></td>
</tr>
</table>
</form>";
/*
<tr>
	<td class='forumheader4' colspan='2' style='text-align:center;'>
	<input type='checkbox' name='mg_icon_create' value='1' ".($pref['mg_icon_create'] ? "checked='checked'" : "")." /> ".LAN_GAL_IMG_FI."
	<input type='checkbox' name='mg_view_create' value='1' ".($pref['mg_view_create'] ? "checked='checked'" : "")." /> ".LAN_GAL_IMG_FL."
	<input type='checkbox' name='mg_original_change' value='1' ".($pref['mg_original_change'] ? "checked='checked'" : "")." /> ".LAN_GAL_IMG_ORIG."
	&lt; <input class='tbox' type='text' name='mg_original_size' size='5' value='".($pref['mg_original_size'] != "" ? "".$pref['mg_original_size']."" : "1024")."' />
		".LAN_GAL_IMG_QUALITY." <input class='tbox' type='text' name='gallery_img_quality' size='5' value='".$pref['gallery_img_quality']."' />
	</td>
	 </tr>
<br><input type='checkbox' name='mg_file_rewrite' value='1' /> ".LAN_GAL_L052."<input class='button' type='submit' name='tn_create' value='".LAN_GAL_L053."'>
*/
$captions = LAN_GAL_CAP_OPTIONS;
$ns -> tablerender($captions, $text);


}





//================= Upload form ===============
if ($action == 'upload') {
require_once(e_HANDLER."ren_help.php");

$mydb->db_Select("gallery", "*", "img_id > 0 AND img_status = 'upload' ORDER BY img_id");

$text = "<div style='text-align:center'>
	<form enctype='multipart/form-data' method='post' action='".e_SELF."?upload'>
	<table style='".USER_WIDTH."' class='fborder'>";

while($row = $mydb->db_Fetch()) {
    $info = getimagesize($row['img_name']);
    $text_rows .= "<tr>

    <td class='forumheader3' style='width:30px' >
      <input type='checkbox' name='checked[".$row['img_name']."]' value='1' />
      <input type='hidden' name='img_name[]' value='".$row['img_name']."' />
    </td>

    <td class='forumheader3'  style='width:130px; text-align:center;'>
        <a id='thumb_".$row['img_name']."'
        href='foto.php?img=".$row['img_name']."&h=".$pref['gallery_img_view_height']."&w=".$pref['gallery_img_view_width']."'
        class='highslide'
        onclick=\"return hs.expand(this, { captionId: 'caption_".$row['img_name']."' } )\">
        <img src='foto.php?img=".$row['img_name']."&h=90&w=120' />
        </a>
        <div class='highslide-caption' id='caption_".$row['img_name']."'>".$tp->toHTML($row['img_name'], true)."</div>
        <br>".LAN_GAL_L026." $info[0]x$info[1]
    </td>

    <td class='forumheader3'>
      <b>".LAN_GAL_L027."</b> ".$row['img_name']." <b>".LAN_GAL_L067.":</b> ".$row['img_user']."
      <br>".LAN_GAL_L036.":
      <br><input class='tbox' type='text' name='img_title[".$row['img_name']."]' size='50' value='".$row['img_title']."'>
      <br>".LAN_GAL_L037.":
      <br><textarea onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' class='tbox' name='img_description[".$row['img_name']."]' rows='3' style='width: 90%'>".$row['img_description']."</textarea>
    </td>

    </tr>";
    }
if ($text_rows !="") {
    $text .= $text_rows;
    } else {
        $text .= "
            <tr>
            <td class='forumheader3' colspan='3' style='text-align:center;'>
            No upload images!!!
            </td>
            </tr>";
        }

$text .= "
    <tr>
      <td class='forumheader3' colspan='3' style='text-align:center;'>
        ".display_help()."
      </td>
    </tr>

    <tr>
      <td class='forumheader4' colspan='3' style='text-align:center;'>
        <input type='checkbox' name='mg_icon_create' value='1' ".($pref['mg_icon_create'] ? "checked='checked'" : "")." /> ".LAN_GAL_L050."
        <input type='checkbox' name='mg_view_create' value='1' ".($pref['mg_view_create'] ? "checked='checked'" : "")." /> ".LAN_GAL_L051."
        <input type='checkbox' name='mg_original_change' value='1' ".($pref['mg_original_change'] ? "checked='checked'" : "")." /> ".LAN_GAL_L071."
        &lt; <input class='tbox' type='text' name='mg_original_size' size='5' value='".($pref['mg_original_size'] != "" ? "".$pref['mg_original_size']."" : "1024")."' />
        ".LAN_GAL_L054." <input class='tbox' type='text' name='gallery_img_quality' size='5' value='".$pref['gallery_img_quality']."' />
      </td>
    </tr>

    <tr>
      <td class='forumheader3' colspan='3' style='text-align:center;'>
        <input class='button' type='submit' name='public' value='".LAN_GAL_L066."' />
        <input class='button' type='submit' name='delete' value='".LAN_GAL_L065."' />
      </td>
    </tr>

    </table></form>
    ";

$captions = "Upload";
$ns -> tablerender($captions, $text);

}



//======= Admin config menu==================
function admin_config_adminmenu()
{
  if (e_QUERY){
	$tmp = explode(".", e_QUERY);
	$action = $tmp[0];
  }
  if (!isset($action) || ($action == "")){
	$action = "menu_cat";
  }

  $mydb = new db();

  $var['menu_cat']['text'] = LAN_GAL_MENU_CAT;
  $var['menu_cat']['link'] ="".e_SELF."?menu_cat";
  
  $var['menu_cat_edit']['text'] = LAN_GAL_MENU_ADD_CAT;
  $var['menu_cat_edit']['link'] ="".e_SELF."?menu_cat_edit";
  
  $var['menu_img']['text'] = LAN_GAL_MENU_IMG;
  $var['menu_img']['link'] ="".e_SELF."?menu_img";
  
  $var['menu_img_upload']['text'] = LAN_GAL_MENU_IMG_UPLOAD;
  $var['menu_img_upload']['link'] = "".e_SELF."?menu_img_upload";
  
  $var['upload']['text'] = "".LAN_GAL_L074." (".$mydb->db_Count("gallery", "(*)", "WHERE img_status = 'upload'").")";
  $var['upload']['link'] ="".e_SELF."?upload";
  
  $var['menu_options']['text'] = LAN_GAL_MENU_OPTIONS;
  $var['menu_options']['link'] = "".e_SELF."?menu_options";

  show_admin_menu(LAN_GAL_MENU_CAP, $action, $var);
}

require_once(e_ADMIN."footer.php");

?>