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

$mdsql = new db;

// =================================================================================================
//				          GENERAL PAGE
// =================================================================================================
if((!isset($action)) || (isset($action) && $action == "alb")){

//e_PLUGIN."md_gallery/".
$text .= "<table width=100%><tr>";
$text .= "<td class='fcaption' width=5%>".MG_ADMGNL_ID."</td>";
$text .= "<td class='fcaption' width=55%>".MG_ADMGNL_NAME_ALB."</td>";
$text .= "<td class='fcaption' width=20%>".MG_ADMGNL_AMOUNT."</td>";
$text .= "<td class='fcaption' width=10%>".MG_ADMGNL_USER."</td>";
$text .= "<td class='fcaption' width=10%>".MG_ADMGNL_OPT."</td>";

// *** !!! Нужно сделать проверку существования папки а затем ее создать если нет. если есть переходим к открытию папки.

// Create folder e_PLUGIN."gallery

$folder = e_FILE."gallery";
if ($handle = opendir($folder)){
	while (false !== ($folder_a = readdir($handle))){
		if ($folder_a != "." && $folder_a != ".." && is_dir($folder."/".$folder_a)){ 
			 $nav_a[] = $folder_a; 
		}
	}
closedir($handle);
}
sort($nav_a);
foreach ($nav_a as $folder_a){
	$text .= "<tr>";
	$text .= "<td class='forumheader'></td>";
	$text .= "<td class='forumheader'></td>";
        $text .= "<td class='forumheader'>".($folder_name[$folder."/".$folder_a] != "" ? $folder_name[$folder."/".$folder_a] : $folder_a."")."</td>";
        $text .= "<td class='forumheader'></td>";
        $text .= "<td class='forumheader'>".MYGAL_L076."</td>";
//        $text .= "<td class='forumheader'>".e_SELF."?createfolder:".$folder."/".$folder_a."' style='color:red;'>".MYGAL_L076."";
//        $selector_text2 .= "".
//        ($folder_name[$folder."/".$folder_a] != "" ? $folder_name[$folder."/".$folder_a] : $folder_a."")
 //       ."</td>";
        $nav_b = "";
	if ($handle = opendir("$folder/$folder_a")){
		while (false !== ($folder_b = readdir($handle))){
			if ($folder_b != "." && $folder_b != ".." && is_dir($folder."/".$folder_a."/".$folder_b))  { $nav_b[]= $folder_b; }
		}
	closedir($handle);
        }
        sort($nav_b);

	foreach ($nav_b as $folder_b){
		$text .= "<tr>";
		$text .= "<td class='forumheader3'></td>";
		$text .= "<td class='forumheader3'></td>";
		$text .= "<td class='forumheader3'>".($folder_name[$folder."/".$folder_a."/".$folder_b] != "" ? $folder_name[$folder."/".$folder_a."/".$folder_b] : $folder_b)
                ."</td>";
//                $selector_text2 .= "<option value='".e_SELF."?manage:".$folder_a.":".$folder_b."'>".
 //               ($folder_name[$folder."/".$folder_a."/".$folder_b] != "" ? $folder_name[$folder."/".$folder_a."/".$folder_b] : $folder_b)
//                ."</option>";
		$text .= "<td class='forumheader3'></td>";
		$text .= "<td class='forumheader3'>".MYGAL_L076."</td>";
               }
        }
      $text .= "<tr>";
      $text .= "<td class='forumheader'></td>";
      $text .= "<td class='forumheader'></td>";
      $text .= "<td class='forumheader'><a href='index.php?".$mass[$q]."'>".$mass[$q]."</a><br>\n";
      $text .= "<td class='forumheader'></td>";
      $text .= "<td class='forumheader'></td>";

$text .= "</table>";

$text .= "<select name='gallery_sections' class='tbox' onchange=\"if(this.options[this.selectedIndex].value.indexOf('-') &amp;&amp; this.options[this.selectedIndex].value != '' &amp;&amp; this.options[this.selectedIndex].value != '&nbsp;'){ return document.location=this.options[this.selectedIndex].value; }\">
<option value=''>
".($mygall_qs[2] !="" ? "".($folder_name[$folder."/".urldecode($mygall_qs[1])."/".urldecode($mygall_qs[2])] != ""
? $folder_name[$folder."/".urldecode($mygall_qs[1])."/".urldecode($mygall_qs[2])]
: urldecode($mygall_qs[2]))
."" : "")."</option>
<option value='".e_SELF."?createfolder:".$folder."' style='color:red;'>".MYGAL_L075."</option>
";

if ($handle = opendir($folder)){
	while (false !== ($folder_a = readdir($handle))){
		if ($folder_a != "." && $folder_a != ".." && is_dir($folder."/".$folder_a))  { $nav_a[] = $folder_a; }
	}
closedir($handle);
}
sort($nav_a);
foreach ($nav_a as $folder_a){
        $selector_text .= "<optgroup label='".
        ($folder_name[$folder."/".$folder_a] != "" ? $folder_name[$folder."/".$folder_a] : $folder_a."")
        ."'>
        <option value='".e_SELF."?createfolder:".$folder."/".$folder_a."' style='color:red;'>".MYGAL_L076."</option>";
        $selector_text2 .= "<optgroup label='".
        ($folder_name[$folder."/".$folder_a] != "" ? $folder_name[$folder."/".$folder_a] : $folder_a."")
        ."'>";
        $nav_b = "";
	if ($handle = opendir("$folder/$folder_a")){
		while (false !== ($folder_b = readdir($handle))){
			if ($folder_b != "." && $folder_b != ".." && is_dir($folder."/".$folder_a."/".$folder_b))  { $nav_b[]= $folder_b; }
		}
	closedir($handle);
        }
        sort($nav_b);

	foreach ($nav_b as $folder_b){
		$selector_text .= "<option value='".e_SELF."?manage:".$folder_a.":".$folder_b."'>".
		($folder_name[$folder."/".$folder_a."/".$folder_b] != "" ? $folder_name[$folder."/".$folder_a."/".$folder_b] : $folder_b)
                ."</option>";
                $selector_text2 .= "<option value='".e_SELF."?manage:".$folder_a.":".$folder_b."'>".
                ($folder_name[$folder."/".$folder_a."/".$folder_b] != "" ? $folder_name[$folder."/".$folder_a."/".$folder_b] : $folder_b)
                ."</option>";
                }
        $selector_text .= "</optgroup>";
        }
$text .= $selector_text;
$text .= "</select>";


$caption = MG_ADMGNL_CAP;
$ns -> tablerender($caption, $text);
}


// =================================================================================================
//				          PAGE OF CATALOG
// =================================================================================================
if(isset($action) && $action == "create_alb"){



//if(!is_writable($folder)) {
//$text .="$folder";
//}
$path = e_FILE."images_gallery";
$folder_name = time();
$folder = $path."/".$folder_name;
if (!is_dir($path) && !mkdir($path)) {

        $message = "Folder: ".$folder." - Not create";

    } else {

       $sql_text = array(
              "album_name_dir" =>	$tp -> toDB($folder_name),
              "album_name_dir" =>	$tp -> toDB("Осень"),
              "album_desc" =>		$tp -> toDB("dfgerg"),
              "album_user_id" =>   	$tp -> toDB(USERID)
              );
    mkdir($folder, 0700);
    mkdir("$folder_name", 0700);
    $mydb->db_Insert("gal_album", $sql_text);
    $message = "Folder: ".$folder." - Created";

    }
$ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

if(IsSet($_POST['createfolder'])) {

$folder = $path."/".$folder_name;
//$mode = substr(sprintf('%o', fileperms($_POST['top_folder'])), -4);
    if (!is_dir($path) && !mkdir($path)) {

        $message = "Folder: ".$folder." - Not create";

    } else {

        $sql_text = array(
              "img_name" =>      $tp -> toDB($path),
              "img_title" =>     $tp -> toDB($_POST['gallery_name']),
              "img_status" =>    "menu"
              );

        $mydb->db_Insert("my_gallery", $sql_text);


    $message = "Folder: ".$path." - Created";

    }

    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}

//if(isset($sub_action) && $sub_action == "create"){
if(isset($_POST["create"])) {

//$name_album = $_POST['name_album'];
$text .="Папка";

mkdir("$folder/123", 0777);

$action = "create_alb";
$message = MYGAL_L004;
    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}
$text ="$folder";
$text .= "<form name='setings' action='".e_SELF."' method='post'>";
$text .= "<table style='width:85%' class='fborder'>";

$text .= "<tr><td class='forumheader3'><b>".MG_NAME_ALBUM."</b></td></tr>";
$text .= "<td class='forumheader3'><input class='tbox' type='text' name='folder_name' size='60' value='$folder_name' ></td></tr>";

$text .= "</table>";

$text .="<input class='button' type='submit' name='createfolder' value='".MG_CREATE_ALBUM."'>";
//$text .="<a href=".e_PLUGIN."gallery/admin_config.php?create_alb.create'>".MG_CREATE_ALBUM."</a>";
$text .="</form>";
$caption = MG_ADMCAT_CAP;
$ns -> tablerender($caption, $text);
}

// =================================================================================================
//				          PAGE OF ADD IMAGES
// =================================================================================================
if(isset($action) && $action == "add"){



$caption = MG_ADMADD_CAP;
$ns -> tablerender($caption, $text);
}

// =================================================================================================
//				          PAGE OF UPLOAD IMAGES
// =================================================================================================
if(isset($action) && $action == "upload"){



$caption = MG_ADMUPL_CAP;
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
$caption = MG_ADMOPT_CAP;
$ns -> tablerender($caption, $text);
}


require_once(e_ADMIN."footer.php");
//======= Admin config menu==================
function admin_config_adminmenu(){
    if (e_QUERY) {
	      $tmp = explode (".", e_QUERY);
	      $action     = $tmp[0];
    }
//    if (!isset($action) || ($action == "")){
//	  $action = "alb";
//    }

    $mdsql = new db();

    $var['alb']['text'] = MG_ADMENU_ALB;
    $var['alb']['link'] = "".e_SELF."";

    $var['create_alb']['text'] = MG_ADMENU_ALB;
    $var['create_alb']['link'] = "".e_SELF."?create_alb";

    $var['add']['text'] = MG_ADMENU_ADDPIC;
    $var['add']['link'] = "".e_SELF."?add";

    $var['upload']['text'] = "".MG_ADMENU_NEWPIC." (".$mdsql->db_Count("md_gallery", "(*)", "WHERE pic_status = 'upload'").")";
    $var['upload']['link'] = "".e_SELF."?upload";

    $var['options']['text'] = MG_ADMENU_OPTION;
    $var['options']['link'] = "".e_SELF."?options";

    show_admin_menu(MG_ADMENU_CAP, $action, $var);
}
?>