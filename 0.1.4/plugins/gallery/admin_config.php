<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "md_gallery"
|     Author: Alex ANP alex-anp@ya.ru
|     Home page: http://e107.seafoxy.ru
|				 http://e107plugins.blogspot.com
+-----------------------------------------------------------------------------------------------+
*/
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_handler.php");
require_once(e_HANDLER."file_handler.php");
require_once(e_HANDLER.'ren_help_handler.php');
require_once(e_HANDLER."tiny_mce/wysiwyg.php");
require_once("gallery_class.php");
if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
}

$lan_file = e_PLUGIN."gallery/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."gallery/languages/English.php"));

//if (!defined("USER_WIDTH")){ define("USER_WIDTH","width:95%;"); }

if (e_QUERY) {
	$tmp = explode (".", e_QUERY);
	$action     = $tmp[0];
	$sub_action = $tmp[1];
	$id         = $tmp[2];
}

$e_sub_cat = 'custom';		// on wysiwyg
$e_wysiwyg = "data";		// on wysiwyg
$vis = 'none';			// switch, display object none
$unvis = 'yes';			// switch, display object yes

$mg_sql = new db;
$mg_sql_2 = new db;
$mg_sql_3 = new db;
// =================================================================================================
//				          GENERAL PAGE
// =================================================================================================
if((!isset($action)) || (isset($action) && $action == "cat")){

// ----- on wysiwyg
if (((varset($pref['wysiwyg'],FALSE) && check_class($pref['post_html'])) || defsettrue('e_WYSIWYG')) && varset($e_wysiwyg) != ""){
	require_once(e_HANDLER."tiny_mce/wysiwyg.php");
	define("e_WYSIWYG",TRUE);
	$wy = new wysiwyg($e_wysiwyg);
	$wy->render();
} else {
	define("e_WYSIWYG",FALSE);
}

// ----- variable
	$cat_id = $_POST['cat_id'];
//	$cat_sub = $_POST['cat_sub'];
	$cat_name = $_POST['cat_name'];
	$cat_icon = $_POST['cat_icon'];
	$cat_desc = $_POST['cat_desc'];
	
// ----- sub_action CREATE OF CATEGORY
if(IsSet($sub_action) && ($sub_action =='create_cat') || ($sub_action =='edit_cat')) {
	if($sub_action =='create_cat') {
		$vis_upd = 'none';
		$vis_agr = 'block';
	}
	if($sub_action =='edit_cat'){
		$mg_sql -> db_Select("gallery_cat", "*", "cat_id='$id'");
		while($row = $mg_sql -> db_Fetch()){
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
//		$cat_sub = $row['cat_sub'];
		$cat_icon = $row['cat_icon'];
		$cat_desc = $row['cat_desc'];
		}
		$vis_upd = 'block';
		$vis_agr = 'none';
	}
	
if (isset($sub_action) && $sub_action == 'delete_cat'){
	$mg_sql -> db_Delete("gallery_cat", "cat_id='$id'");
}

if (isset($_POST['submit_update_cat'])){
	$mg_sql -> db_Update("gallery_cat", "cat_sub_id='$cat_sub_id', cat_name='$cat_name', cat_desc='$cat_desc', cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
		$cat_art=$cat_name=$cat_type=$cat_unit=$cat_desc=$cat_pic=$cat_price='';
		$message = LAN_MES_06;
		$ns -> tablerender(LAN_MES_00, $message);
		$vis = 'none';
		$unvis = 'yes';
}

if (IsSet($_POST['submit_insert_cat'])){
	if ($cat_name == ""){
	    $message = "<font color=red>".LAN_MES_11."</font>";
	}
	else {
	    $mg_sql -> db_Insert("gallery_cat", "0, '', '$cat_name', '$cat_desc', '$cat_icon'");
	    $message = "<font color=red>".LAN_MES_12."</font>";
	    header ("Location: ".e_PLUGIN."gallery/admin_config.php?cat.create_cat");
	    exit;
	}
	$ns -> tablerender(LAN_MES_00, $message);
}
	
// ----- FORM - CREATE AND EDITION OF CATEGORY
$text.="<div id='r_window_block_cat' class='r_window_block'>";
$text.="<div class='r_window_dialog'>";
$text.="<div class='r_window_caption'>Категории</div>";
$text.="<div class='r_window_close'><a href='".e_PLUGIN."gallery/admin_config.php?cat'>Закрыть</a></div>";
$text.="<div class='r_window_scroll'>";

$text .="<form name='config' method='post' action='". $PHP_SELF ."'><table class='r_header3' style='width:100%'>";
	$text .= "<tr><td width='30%' class='r_header3'>".LAN_CAT_NAME."</td><td class='r_header3' width='70%'>
			<input size='40' class='tbox' type='text' name='cat_name' value='$cat_name'>
			<input type='text' name='cat_id' value='$cat_id' style='display:none;'></td></tr>";

// -----output agent of images---------------------------------------------------------
$fl = new e_file;
if($imglist = $fl->get_files(e_FILE."icons/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        sort($imglist);
}
	$text .= "<tr>
			<td class='r_header3'>".LAN_CAT_ICON."</td>
			<td class='r_header3'><input class='tbox' type='text' id='cat_pic' name='cat_icon' value='$cat_icon' size='40'><input type ='button' class='button' style='cursor:pointer' size='30' value='".LAN_IMG_03."' onclick='expandit(this)'>
			<div id='linkimg' style='display:none;{head}'>";
	foreach($imglist as $img){
			$list_img = str_replace(e_FILE."icons/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_img."','cat_pic','linkimg')\"><img src='".$img['path'].$img['fname']."' style='border:0' width=50px alt='' /></a> ";
	}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='r_header3'>".LAN_CAT_DESC." </td><td class='r_header3'>";
	$insertjs = (!e_WYSIWYG)?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='10' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='cat_desc' cols='80' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$cat_desc</textarea><br>".display_help('')."";
	$text .= "</td></tr>";
	
	$text .= "<tr><td></td><td>
			<input type='submit' class='button' style='cursor:pointer;display:$vis_agr; float:left; margin-right:3px;' value=".LAN_BUT_AGR." name='submit_insert_cat'>
			<input type='submit' class='button' style='cursor:pointer;display:$vis_upd; float:left; margin-right:3px;' value=".LAN_BUT_UPD." name='submit_update_cat'>
			<input type='submit' class='button' style='cursor:pointer;' value=".LAN_BUT_CANS." name='submit_reset'>
			</td></tr></table></form>";
			
	$text.="</div>";
	$text.="</div>";
	$text.="</div>";
}



// ----- sub_action CREATE OF ALBUM




if(IsSet($sub_action) && ($sub_action =='create_album') || ($sub_action =='edit_album')) {

$dir = e_FILE."images_gallery";
chmod (e_FILE."images_gallery",0777);



$album_user = USERID;
$album_dir = $_POST["album_dir"];
$album_cat = $_POST["album_cat"];
$album_name = $_POST["album_name"];
$album_desc = $_POST["album_desc"];

	if($sub_action =='create_album') {
		$vis_upd = 'none';
		$vis_agr = 'block';
	}
	if($sub_action =='edit_album'){
		$mg_sql -> db_Select("gallery_album", "*", "album_id='$id'");
		while($row = $mg_sql -> db_Fetch()){
		$album_id = $row['album_id'];
		$album_name = $row['album_name'];
//		$cat_sub = $row['cat_sub'];
		$album_icon = $row['album_icon'];
		$album_desc = $row['album_desc'];
		}
		$vis_upd = 'block';
		$vis_agr = 'none';
	}
	
if (isset($sub_action) && $sub_action == 'delete_album'){
	$mg_sql -> db_Delete("gallery_album", "album_id='$id'");
}

if (isset($_POST['submit_update_album'])){
	$mg_sql -> db_Update("gallery_album", "album_cat='$album_cat', album_name='$album_name', album_desc='$album_desc', album_icon='$album_icon' WHERE album_id='$album_id'");
		$album_cat=$album_name=$album_desc=$album_icon='';
		$message = LAN_MES_06;
		$ns -> tablerender(LAN_MES_00, $message);
		$vis = 'none';
		$unvis = 'yes';
}

if (IsSet($_POST['submit_insert_album'])){
	if ($album_name == ""){
	    $message = "<font color=red>".LAN_MES_11."</font>";
	}
	else {
	    $mg_sql -> db_Insert ("gallery_album", "0, '$album_user', '$album_cat', '$album_dir', '$album_name', '$album_desc', '', ''");
	    mkdir("$dir/$album_dir",0777);
	    $message = "<font color=red>".LAN_MES_12."</font>";
	    header ("Location: ".e_PLUGIN."gallery/admin_config.php?cat.create_album");
	    exit;
	}
	$ns -> tablerender(LAN_MES_00, $message);
}
// ----- FORM - CREATE AND EDITION OF ALBUM
$text.="<div id='r_window_block_cat' class='r_window_block'>";
$text.="<div class='r_window_dialog'>";
$text.="<div class='r_window_caption'>Категории</div>";
$text.="<div class='r_window_close'><a href='".e_PLUGIN."gallery/admin_config.php?cat'>Закрыть</a></div>";
$text.="<div class='r_window_scroll'>";

$text .="<form name='config' method='post' action='". $PHP_SELF ."'><table class='r_header3' style='width:100%'>";
	$text .= "<table style='width:85%' class='fborder'>";
$text .= "<tr><td class='forumheader'>".LAN_ALBUM_CAT."</td>";
$text .= "<td class='forumheader'><select class='tbox' name='album_cat'>
	<option value='0' selected='selected'>".MYGAL_L024."</option>";
	$mg_sql -> db_Select("gallery_cat", "*", "");
	while($row = $mg_sql -> db_Fetch()){
		$cat_id = $row["cat_id"];
		$cat_name = $row["cat_name"];
	$text .= "<option value='$cat_id'>$cat_name</option>";
	}
$text .= "</select></td></tr>";
$album_dir = time();
$text .= "<tr><td class='forumheader'>".LAN_ALBUM_DIR."</td>";
$text .= "<td class='forumheader'><input class='tbox' type='text' name='album_dir' size='60' value='$album_dir' readonly></td></tr>";
$text .= "<tr><td class='forumheader'>".LAN_ALBUM_NAME."</td>";
$text .= "<td class='forumheader'><input class='tbox' type='text' name='album_name' size='60' value='$album_name'></td></tr>";

// -----output agent of images---------------------------------------------------------
$fl = new e_file;
if($imglist = $fl->get_files(e_FILE."icons/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        sort($imglist);
}
	$text .= "<tr>
			<td class='r_header3'>".LAN_CAT_ICON."</td>
			<td class='r_header3'><input class='tbox' type='text' id='cat_pic' name='cat_icon' value='$cat_icon' size='40'><input type ='button' class='button' style='cursor:pointer' size='30' value='".LAN_IMG_03."' onclick='expandit(this)'>
			<div id='linkimg' style='display:none;{head}'>";
	foreach($imglist as $img){
			$list_img = str_replace(e_FILE."icons/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_img."','cat_pic','linkimg')\"><img src='".$img['path'].$img['fname']."' style='border:0' width=50px alt='' /></a> ";
	}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='r_header3'>".LAN_ALBUM_DESC." </td><td class='r_header3'>";
	$insertjs = (!e_WYSIWYG)?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='10' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='album_desc' cols='80' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$album_desc</textarea><br>".display_help('')."";
	$text .= "</td></tr>";
	
	$text .= "<tr><td></td><td>
			<input type='submit' class='button' style='cursor:pointer;display:$vis_agr; float:left; margin-right:3px;' value=".LAN_BUT_AGR." name='submit_insert_album'>
			<input type='submit' class='button' style='cursor:pointer;display:$vis_upd; float:left; margin-right:3px;' value=".LAN_BUT_UPD." name='submit_update_album'>
			<input type='submit' class='button' style='cursor:pointer;' value=".LAN_BUT_CANS." name='submit_reset'>
			</td></tr></table></form>";
			
	$text.="</div>";
	$text.="</div>";
	$text.="</div>";
}

//----- FORM - OUTPUT OF CATEGORIES AND ALBUMS
$text .= "<a href='".e_PLUGIN."gallery/admin_config.php?cat.create_cat' style='cursor:pointer;' onClick=\"document.getElementById('r_window_block_cat').style.display='block'; return false;\">Добавить категорию</a> | ";
$text .="<a href='".e_PLUGIN."gallery/admin_config.php?cat.create_album' style='cursor:pointer;' onClick=\"document.getElementById('r_window_block_upload').style.display='block'; return false;\">Добавить альбом</a>";

$text.="<div class='r_frame_scroll'>";
$text .= "<table width=100%><tr>";
$text .= "<td class='fcaption' width=5%>".LAN_ALBUM_ID."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_USER."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_CAT."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_DIR."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_NAME."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_DESC."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_ICON."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_RATE."</td>";
$text .= "<td class='fcaption' width=10%>".LAN_ALBUM_OPTIONS."</td>";
$text .= "</tr>";


$mg_sql -> db_Select("gallery_cat", "*", "");
	while($row = $mg_sql -> db_Fetch()){
		$cat_id = $row["cat_id"];
		$cat_name = $row["cat_name"];
		$text .= "<tr>";
		$text .= "<td class='forumheader2' width=5%>".$cat_id."</td>";
//		$text .= "<td class='forumheader' width=5%>".$cat_sub_id."</td>";
		$text .= "<td class='forumheader2' colspan=7>".$cat_name."</td>";
		$text .= "<td class='forumheader2' width='10%'>
			<a href='".e_PLUGIN."gallery/admin_config.php?cat.edit_cat.$cat_id' style='cursor:pointer;' onClick=\"document.getElementById('r_window_block_cat').style.display='block'; return false;\">".ADMIN_EDIT_ICON."</a>
			<a href='".e_PLUGIN."gallery/admin_config.php?cat.delete_cat.$cat_id' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_CAT_DEL_CONFIRM." [ ID: $cat_id] ]')\">".ADMIN_DELETE_ICON."</a>
		  </td>";
		$text .= "</tr>";
		$mg_sql_2 -> db_Select("gallery_album", "*", "");
			while($row = $mg_sql_2 -> db_Fetch()){
				$album_id = $row["album_id"];
				$album_user_id = $row["album_user_id"];
				$album_name_dir = $row["album_name_dir"];
				$album_name = $row["album_name"];
				$album_desc = $row["album_desc"];
				$album_icon = $row["album_icon"];
				$album_rate = $row["album_rate"];
				$mg_sql_3 -> db_Select("user", "*", "user_id='$album_user_id'");
					while($row = $mg_sql_3 -> db_Fetch()){
					$album_user = $row["user_name"];
					}
		$text .= "<tr>";
		$text .= "<td class='forumheader' width=5%>".$album_id."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_user."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_catid."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_name_dir."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_name."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_desc."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_icon."</td>";
		$text .= "<td class='forumheader' width=10%>".$album_rate."</td>";
		$text .= "<td class='forumheader' width='10%'>
			<a href='".e_PLUGIN."gallery/admin_config.php?cat.edit_album.$album_id' style='cursor:pointer;' onClick=\"document.getElementById('r_window_block_cat').style.display='block'; return false;\">".ADMIN_EDIT_ICON."</a>
			<a href='".e_PLUGIN."gallery/admin_config.php?cat.delete_album.$album_id' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_CAT_DEL_CONFIRM." [ ID: $album_id] ]')\">".ADMIN_DELETE_ICON."</a>
		  </td>";
		$text .= "</tr>";
		}
	}

$text .= "</table>";
$text .= "</div>";

$caption = LAN_ADMGNL_CAP;
$ns -> tablerender($caption, $text);
}


// =================================================================================================
//				          PAGE OF CATALOG
// =================================================================================================
if(isset($action) && $action == "create_alb"){


$dir = e_FILE."images_gallery";
chmod (e_FILE."images_gallery",0777);

$album_dir = time();

if(isset($_POST["submit_create"])) {

$album_user = USERID;
$album_dir = $_POST["album_dir"];
$album_catid = $_POST["album_catid"];
$album_name = $_POST["album_name"];
$album_desc = $_POST["album_desc"];



$sql = new db;
$sql -> db_Insert ("gal_album", "0, '$album_user', '$album_catid', '$album_dir', '$album_name', '$album_desc', '', ''");
mkdir("$dir/$album_dir",0777);
$message = MYGAL_L004;
    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}

$text ="Путь к директории $dir, пользователь ".USERID;
$text .= "<form name='manage_album' action='' method='post'>";
$text .= "<table style='width:85%' class='fborder'>";
$text .= "<tr><td class='forumheader3'><b>".LAN_ALBUM_CAT."</b></td>";
$text .= "<td class='forumheader3'><select class='tbox' name='album_catid'>
    <option value='0' selected='selected'>".MYGAL_L024."</option>
    <option value='0'>".MYGAL_L024."</option>
    </select></td></tr>";
$text .= "<tr><td class='forumheader3'><b>".LAN_ALBUM_DIR."</b></td>";
$text .= "<td class='forumheader3'><input class='tbox' type='text' name='album_dir' size='60' value='$album_dir' readonly></td></tr>";
$text .= "<tr><td class='forumheader3'><b>".LAN_ALBUM_NAME."</b></td>";
$text .= "<td class='forumheader3'><input class='tbox' type='text' name='album_name' size='60' value='$album_name' ></td></tr>";
$text .= "<tr><td class='forumheader3'><b>".LAN_ALBUM_DESC."</b></td>";
$text .= "<td class='forumheader3'><input class='tbox' type='text' name='album_desc' size='60' value='$album_desc' ></td></tr>";

$text .= "</table>";

$text .="<input class='button' type='submit' name='submit_create' value='".LAN_CREATE_ALBUM."'>";
$text .="</form>";
$caption = LAN_ADMCAT_CAP;
$ns -> tablerender($caption, $text);
}

// =================================================================================================
//				          PAGE OF ADD IMAGES
// =================================================================================================
if(isset($action) && $action == "add"){



$caption = LAN_ADMADD_CAP;
$ns -> tablerender($caption, $text);
}

// =================================================================================================
//				          PAGE OF UPLOAD IMAGES
// =================================================================================================
if(isset($action) && $action == "upload"){



$caption = LAN_ADMUPL_CAP;
$ns -> tablerender($caption, $text);
}

// =================================================================================================
//				          PAGE OF OPTIONS
// =================================================================================================
if(isset($action) && $action == "options"){

//=========== Update settings script =================
if(IsSet($_POST['updatesettings'])) {
    $pref['mdgal_folder'] = $_POST['mdgal_folder'];
    $pref['mdgal_rows'] = $_POST['mdgal_rows'];
    $pref['mdgal_columns'] = $_POST['mdgal_columns'];
    $pref['mdgal_pic_in_page'] = $pref['mdgal_rows'] * $pref['mdgal_columns'];
    $pref['mdgal_pic_icon_height'] = $_POST['mdgal_pic_icon_height'];
    $pref['mdgal_pic_icon_width'] = $_POST['mdgal_pic_icon_width'];
    $pref['mdgal_pic_view_height'] = $_POST['mdgal_pic_view_height'];
    $pref['mdgal_pic_view_width'] = $_POST['mdgal_pic_view_width'];
    $pref['mdgal_title_image'] = $_POST['mdgal_title_image'];
    $pref['mdgal_gallery_name'] = $_POST['mdgal_gallery_name'];
    $pref['mdgal_nav_position'] = $_POST['mdgal_nav_position'];
    $pref['mdgal_menu_caption'] = $_POST['mdgal_menu_caption'];
    $pref['mdgal_menu_pic_size'] = $_POST['mdgal_menu_pic_size'];
    $pref['mdgal_slide_show'] = $_POST['mdgal_slide_show'];
    $pref['mdgal_memo_show'] = $_POST['mdgal_memo_show'];
    $pref['mdgal_mine_cikle'] = $_POST['mdgal_mine_cikle'];
    $pref['mdgal_nav_show'] = $_POST['mdgal_nav_show'];
    $pref['mdgal_comments'] = $_POST['mdgal_comments'];
    $pref['mdgal_raters'] = $_POST['mdgal_raters'];
    $pref['mdgal_hs_theme'] = $_POST['mdgal_hs_theme'];
    $pref['mdgal_pic_quality'] = $_POST['mdgal_pic_quality'];
    $pref['mdgal_sort_type'] = $_POST['mdgal_sort_type'];
    $pref['mg_icon_create'] = $_POST['mg_icon_create'];
    $pref['mg_view_create'] = $_POST['mg_view_create'];
    $pref['mg_minepage_logo'] = $_POST['mg_minepage_logo'];
    $pref['mg_minepage_random'] = $_POST['mg_minepage_random'];
    $pref['mg_minepage_upload'] = $_POST['mg_minepage_upload'];
    $pref['mg_minepage_comment'] = $_POST['mg_minepage_comment'];
    save_prefs();
    $message = MYGAL_L004;
    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}
//============ GD test ==================
if ($array = gd_info ()) {
    $gd_message =  "GD Version - ".$array['GD Version']."";

    if ($array['JPG Support']===true) {
	$gd_message .=  ", JPG Support - Enabled";
    } else { 
	$gd_message .=  ", JPG Support - Disabled";
    }
} else {
$gd_message =  "GD not support!!!";
}
$ns->tablerender("GD Version/Test", "<div style='text-align:center'><b>".$gd_message."</b></div>");

$text = "<form name='setings' action='".e_SELF."' method='post'>";
$text .= "<table style='width:85%' class='fborder'><tr>";
$text .= "<td class='forumheader3' colspan='2'><b>".MYGAL_L005."</b></td></tr>";

$text .= "<tr>
<td class='forumheader3'>".MYGAL_L006."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_folder' size='60' value='".$pref['mdgal_folder']."' ></td>
</tr>";

$text .= "<tr>
<td class='forumheader3'>".MYGAL_L007."</td>
<td class='forumheader3'>
<input class='tbox' type='text' name='mdgal_columns' size='5' value='$mdgal_pic_show_cols'> *
<input class='tbox' type='text' name='mdgal_rows' size='5' value='$mdgal_pic_show_rows'> = $mdgal_pic_on_page
</td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L008."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_pic_icon_height' size='10' value='$mdgal_pic_icon_height'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L009."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_pic_icon_width' size='10' value='$mdgal_pic_icon_width'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L010."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_pic_view_height' size='10' value='".$pref['mdgal_pic_view_height']."'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L011."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_pic_view_width' size='10' value='".$pref['mdgal_pic_view_width']."'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L028." </td>
<td class='forumheader3'>". ($pref['mdgal_slide_show']
? "<input type='checkbox' name='mdgal_slide_show' value='1' checked='checked' /> ".MYGAL_L029.""
: "<input type='checkbox' name='mdgal_slide_show' value='1' /> ".MYGAL_L029."")."
</td>
</tr>";

$text .="<tr>
<td class='forumheader3'>".MYGAL_L049."</td>
<td class='forumheader3'>
<input type='checkbox' name='mg_icon_create' value='1' ".($pref['mg_icon_create'] ? "checked='checked'" : "")." /> ".MYGAL_L050."
<input type='checkbox' name='mg_view_create' value='1' ".($pref['mg_view_create'] ? "checked='checked'" : "")." /> ".MYGAL_L051."
<input class='tbox' type='text' name='mdgal_pic_quality' size='5' value='".$pref['mdgal_pic_quality']."'> ".MYGAL_L054."
<br><input type='checkbox' name='mg_file_rewrite' value='1' /> ".MYGAL_L052."
<input class='button' type='submit' name='tn_create' value='".MYGAL_L053."'></td>
</tr>
";

$text .= "<tr>
<td class='forumheader3'>".MYGAL_L039."</td>
<td class='forumheader3'>
    <input type='checkbox' name='mg_minepage_logo' value='1' ".($pref['mg_minepage_logo'] ? "checked='checked'" : "")." /> ".MYGAL_L040."
    <input type='checkbox' name='mg_minepage_upload' value='1' ".($pref['mg_minepage_upload'] ? "checked='checked'" : "")." /> ".MYGAL_L068."
    <br>
    <input type='checkbox' name='mg_minepage_comment' value='1' ".($pref['mg_minepage_comment'] ? "checked='checked'" : "")." /> ".MYGAL_L069."
    <input type='checkbox' name='mg_minepage_random' value='1' ".($pref['mg_minepage_random'] ? "checked='checked'" : "")." /> ".MYGAL_L041."
</td>
</tr>";
$text .= "<tr>
<td class='forumheader3'>".MYGAL_L012."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_title_image' size='60' value='".$pref['mdgal_title_image']."'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L013."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_gallery_name' size='60' value='".$pref['mdgal_gallery_name']."'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L023."</td>
<td class='forumheader3'>"
    . ($pref['mdgal_nav_show'] ? "<input type='checkbox' name='mdgal_nav_show' value='1' checked='checked' /> ".MYGAL_L031."" : "<input type='checkbox' name='mdgal_nav_show' value='1' /> ".MYGAL_L031."").
    "<br><select class='tbox' name='mdgal_nav_position'>"
    .($pref['mdgal_nav_position'] == "0" ? "<option value='0' selected='selected'>".MYGAL_L024."</option>"
    : "<option value='0'>".MYGAL_L024."</option>")
    .($pref['mdgal_nav_position'] == "1" ? "<option value='1' selected='selected'>".MYGAL_L025."</option>"
    : "<option value='1'>".MYGAL_L025."</option>")
    ."</select>
</td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L048."</td>
<td class='forumheader3'>
".($mdsql->db_Count("plugin", "(*)", "WHERE plugin_path='eHighSlide' AND plugin_installflag=1")
? "".MYGAL_L077.""
: "<select class='tbox' name='mdgal_hs_theme'>"
    .($pref['mdgal_hs_theme'] == "0" ? "<option value='0' selected='selected'>White 10px border and drop shadow</option>"
    : "<option value='0'>White 10px border and drop shadow</option>")
    .($pref['mdgal_hs_theme'] == "1" ? "<option value='1' selected='selected'>Drop shadow and no border</option>"
    : "<option value='1'>Drop shadow and no border</option>")
    .($pref['mdgal_hs_theme'] == "2" ? "<option value='2' selected='selected'>Dark design with outer glow</option>"
    : "<option value='2'>Dark design with outer glow</option>")
    .($pref['mdgal_hs_theme'] == "3" ? "<option value='3' selected='selected'>White outline with rounded corners</option>"
    : "<option value='3'>White outline with rounded corners</option>")
    .($pref['mdgal_hs_theme'] == "4" ? "<option value='4' selected='selected'>No graphic outline</option>"
    : "<option value='4'>No graphic outline</option>")
    .($pref['mdgal_hs_theme'] == "5" ? "<option value='5' selected='selected'>Slideshow with a controlbar</option>"
    : "<option value='5'>Slideshow with a controlbar</option>")
    ."</select>")."
</td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L030."</td>
<td class='forumheader3'>
    <select class='tbox' name='mdgal_memo_show'>"
    .($pref['mdgal_memo_show'] == "0" ? "<option value='0' selected='selected'>".MYGAL_L031."</option>"
    : "<option value='0'>".MYGAL_L031."</option>")
    .($pref['mdgal_memo_show'] == "1" ? "<option value='1' selected='selected'>".MYGAL_L032."</option>"
    : "<option value='1'>".MYGAL_L032."</option>")
    .($pref['mdgal_memo_show'] == "2" ? "<option value='2' selected='selected'>".MYGAL_L033."</option>"
    : "<option value='2'>".MYGAL_L033."</option>")
    ."</select>
</td>
</tr>
<tr>
	<td class='forumheader3'>".MYGAL_L044." </td>
	<td class='forumheader3'>".($pref['mdgal_comments'] ? "<input type='checkbox' name='mdgal_comments' value='1' checked='checked' /> " : "<input type='checkbox' name='mdgal_comments' value='1' /> ")."
</td>
</tr>
<tr>
	<td class='forumheader3'>".MYGAL_L047." </td>
	<td class='forumheader3'>".($pref['mdgal_raters'] ? "<input type='checkbox' name='mdgal_raters' value='1' checked='checked' /> " : "<input type='checkbox' name='mdgal_raters' value='1' /> ")."
</td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L055."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_sort_type' size='5' value='".$pref['mdgal_sort_type']."'>
<br><b>NA</b> - Name ASC, <b>ND</b> - Name DESC,<br><b>DA</b> - Date ASC, <b>DD</b> - Date DESC.
</td>
</tr>
<tr>
<td class='forumheader3' colspan='2'><b>".MYGAL_L014."</b></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L015."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_menu_caption' value='".$pref['mdgal_menu_caption']."'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L017."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_menu_pic_size' size='10' value='".$pref['mdgal_menu_pic_size']."'></td>
</tr>
<tr>
<td class='forumheader3'>".MYGAL_L042."</td>
<td class='forumheader3'><input class='tbox' type='text' name='mdgal_mine_cikle' size='5' value='".$pref['mdgal_mine_cikle']."'></td>
</tr>";


$text .="<tr>
<td class='forumheader3' colspan='2'><div align='center'><input class='button' type='submit' name='updatesettings' value='".MYGAL_L018."'></div></td>
</tr>
</table>
</form>";
$caption = LAN_ADMOPT_CAP;
$ns -> tablerender($caption, $text);
}


require_once(e_ADMIN."footer.php");
//======= Admin config menu==================
function admin_config_adminmenu(){
    if (e_QUERY) {
	$tmp = explode (".", e_QUERY);
	$action     = $tmp[0];
	$sub_action = $tmp[1];
	$id         = $tmp[2];
}
	if (!isset($action) || ($action == "")){
		$action = "cat";
	}

    $mdsql = new db();

    $var['cat']['text'] = LAN_ADMENU_ALB;
    $var['cat']['link'] = "".e_SELF."?cat";

    $var['create_alb']['text'] = LAN_ADMENU_IMG;
    $var['create_alb']['link'] = "".e_SELF."?create_alb";

 //   $var['add']['text'] = LAN_ADMENU_ADDPIC;
//    $var['add']['link'] = "".e_SELF."?add";

    $var['upload']['text'] = "".LAN_ADMENU_NEWPIC." (".$mdsql->db_Count("md_gallery", "(*)", "WHERE pic_status = 'upload'").")";
    $var['upload']['link'] = "".e_SELF."?upload";

    $var['options']['text'] = LAN_ADMENU_OPTION;
    $var['options']['link'] = "".e_SELF."?options";

    show_admin_menu(LAN_ADMENU_CAP, $action, $var);
}
?>