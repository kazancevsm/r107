<?php
/*============================= Tabletime v1.0 =========================\
|	author - Sunout, http://e107.compolys.ru, sunout@compolys.ru	\
|	coder - Sunout, Geo, license GNU GPL				\
====================================== 2011 ============================*/
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."file_class.php");
if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
    }
include_lan(e_PLUGIN."timetable/languages/".e_LANGUAGE.".php");
if (e_QUERY)
{
  $qs = explode(".", e_QUERY);
}
$vis = 'none';
$unvis = 'yes';
// =================================================================================================
//				               CAT OPTIONS MENU
// =================================================================================================
if (!isset($qs[0]) || (isset($qs[0]) && $qs[0] == "cat")){
	$gnl_id = $_POST['gnl_id'];
	$gnl_name = $_POST['gnl_name'];
	$gnl_desc = $_POST['gnl_desc'];
	$gnl_icon = $_POST['gnl_icon'];
//======Edit_notes======//
if (IsSet($_POST['submit_edit'])){
	if ($gnl_id == ''){ $message = "<font color=red>".TT_MES_01."</font>";
	$ns -> tablerender(TT_MES_00, $message);
	}
	else{
	$sql -> db_Select("tt_gnl", "*", "gnl_id ='$gnl_id'");
		while($row = $sql -> db_Fetch()){
			$gnl_name = $row['gnl_name'];
			$gnl_desc = $row['gnl_desc'];
			$gnl_icon = $row['gnl_icon'];
		}
	$vis = 'yes';
	$unvis = 'none';
	}
}
//======Delete_notes======//
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("tt_gnl", "gnl_id=$gnl_id");
}
//======Insert_notes======//
if (IsSet($_POST['submit_insert'])){
	if ($gnl_name == ""){ 
		$message = "<font color=red>".TT_MES_04."</font>";
	}
	else {
		$sql = new db;
		$sql -> db_Insert("tt_gnl", "0, '$gnl_name', '$gnl_desc', '$gnl_icon'");
	$message = "<font color=red>".TT_MES_05."</font>";
	$gnl_id=$gnl_name=$gnl_desc=$gnl_icon='';
	header ("Location: ".e_PLUGIN."timetable/admin_config.php?cat");
	exit;
	}
$ns -> tablerender(TT_MES_00, $message);
}
//======Update_notes======//	
	if (IsSet($_POST['submit_update'])){
	$sql -> db_Update("tt_gnl", "gnl_id='$gnl_id', gnl_name='$gnl_name', gnl_desc='$gnl_desc', gnl_icon='$gnl_icon' WHERE gnl_id='$gnl_id'");
		$message = "<font color=red>".TT_MES_06."</font>";
		$ns -> tablerender(TT_MES_00, $message);
	$gnl_id=$gnl_name=$gnl_desc=$gnl_icon='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	$gnl_id = $gnl_name = $gnl_desc = $gnl_icon = '';
	$vis = 'none';
	$unvis = 'yes';
	}
//========================================form select============================
	$text ="<form name='form_select_cat' method='post' action=''><table class='fborder' width='100%'>";
        $text .= "<tr><td class='forumheader3' width='30%'>".TT_CAT_02."</td><td class='forumheader3' width='70%'><select class='tbox' name='gnl_id'><option value=''>".TT_CAT_05."";
		$sql -> db_Select("tt_gnl", "*", "");
                while($row = $sql -> db_Fetch()){
			$catId= $row['gnl_id'];
			$catName = $row['gnl_name'];
			$text .="<option value='$catId'>$catName";
		}
	$text .="</select></td></tr>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".TT_BUT_EDIT." name='submit_edit'>
	<input type='submit' class='button' style='cursor:pointer;' value=".TT_BUT_DEL." name='submit_delete' onclick='return confirmDeleteCat();'></td></tr>";
	$text .="</table></form>";
$caption = TT_CAT_00;
$ns -> tablerender($caption, $text);
//=============================form new category=================================
	$text ="<form name='insert_cat' enctype='multipart/form-data' method='post' action=''><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3' width='30%'>".TT_CAT_03."</td>
		<td class='forumheader3' width='70%'>
	<input class='tbox' type='text' name='gnl_name' value='$gnl_name' size='60'>
	<input type='text' name='gnl_id' value='$gnl_id' style='display:none;'></td></tr>";
	$text .= "<tr><td class='forumheader3' width='30%'>".TT_CAT_04."</td><td class='forumheader3' width='70%'><textarea class='tbox' type='text' name='gnl_desc' cols=38 rows=10 size='60'>$gnl_desc</textarea></td></tr>";
//===============================select gnl_icon=================================
        $fl = new e_file;
if($iconlist = $fl->get_files(e_PLUGIN."timetable/theme/icons_cat/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        sort($iconlist);
}
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".TT_IMG_02." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='gnl_icon' name='gnl_icon' value='$gnl_icon' size='40' maxlength='100' />
		<input type ='button' class='button' style='cursor:pointer' size='30' value='".TT_IMG_03."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."timetable/theme/icons_cat/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','gnl_icon','linkicn')\"><img src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a> ";
		}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='forumheader'></td><td class='forumheader'>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".TT_BUT_AGR." name='submit_insert'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".TT_BUT_UPD." name='submit_update'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".TT_BUT_CANS." name='submit_reset'>
		</td></tr></table></form>";
$caption = TT_CAT_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}


// =================================================================================================
//				           BANNERS OPTIONS MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == 'baners')){
	$ban_id=$_POST['ban_id'];
	$ban_catid =$_POST['ban_catid'];
	$now_date = date('d-m-Y');
	$ban_action = $_POST['ban_action'];
	$ban_org = $_POST['ban_org'];
	$ban_url = $_POST['ban_url'];
	$ban_datebegin = $_POST['ban_datebegin'];
	$ban_dateend = $_POST['ban_dateend'];
	$ban_images = $_POST['ban_images'];
	$gnl_name = $_POST['gnl_name'];
//======Insert_notes======//
if(IsSet($_POST['submit_insert'])){
	if ($ban_action == ""){
		$sql = new db;
		$sql -> db_Insert("tt_ban", "0, '$ban_catid', '$ban_org', '$ban_url', '$ban_datebegin', '$ban_dateend', '$ban_images'");
	header ("Location: ".e_PLUGIN."timetable/admin_config.php?baners");
	exit;
	}
}
//======Edit_notes======//
if (isset($_POST['submit_edit'])){
	$vis = 'yes';
	$unvis = 'none';
	$sql -> db_Select("tt_ban", "*", "ban_id=$ban_id");
	while($row = $sql -> db_Fetch()){
		$ban_id = $row['ban_id'];
		$ban_catid = $row['ban_catid'];
		$ban_org = $row['ban_org'];
		$ban_url = $row['ban_url'];
		$ban_datebegin = $row['ban_datebegin'];
		$ban_dateend = $row['ban_dateend'];
		$ban_images = $row['ban_images'];
	}
}
//======Update_notes======//
if (isset($_POST['submit_update'])){
	$sql -> db_Update("tt_ban", "ban_catid='$ban_catid', ban_org='$ban_org', ban_url='$ban_url', ban_datebegin='$ban_datebegin', ban_dateend='$ban_dateend', ban_images='$ban_images' WHERE ban_id='$ban_id'");
	$message = TT_MES_23;
	$ns -> tablerender($caption, $message);
	$ban_id =$ban_cati =$ban_org=$ban_url=$ban_datebegin=$ban_dateend=$ban_images='';
	$vis = 'none';
	$unvis = 'yes';
}
//======Delete_notes======//
if(IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("tt_ban", "ban_id='$ban_id'");
}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	$ban_org=$ban_url=$ban_datebegin=$ban_dateend=$ban_id='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Form Banners=========//
$text ="<form name='banner_add' method='post' action='' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".TT_BAN_01."</td><td class='forumheader3' width='70%'>
		<input type=hidden name='ban_id' value='$ban_id'>
		<select class='tbox' name='ban_catid' id='cat'>";
	
	$text .="<option value=''>".TT_BAN_02."";
	$text .="<option value='0'>".TT_BAN_10."";
	$text .="<option value='all_pages'>".TT_BAN_11."";
		$sql -> db_Select("tt_gnl", "*", "gnl_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['gnl_id'];
			$catName = $row['gnl_name'];
			$text .="<option value='$catId'>$catName";
		}
	$text .="</select></td></tr>";
	$text .= "<tr><td class='forumheader3'>".TT_BAN_03."</td><td class='forumheader3' width='80%'><input size='36' type='text' name='ban_org' class='tbox' value='$ban_org'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".TT_BAN_04."</td><td class='forumheader3' width='80%'><input size='36' type='text' name='ban_url' class='tbox' value='$ban_url'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".TT_BAN_05."</td><td class='forumheader3' width='80%'><input size='16' type='text' name='ban_datebegin' class='tbox' value='$ban_datebegin' onclick='event.cancelBubble=true;this.select();lcs(this)' <script src='".e_PLUGIN."timetable/js/calendar_ru.js'></script><style>
	input {border:1px solid #ababab}
	</style> / <input size='16' type='text' name='ban_dateend' class='tbox' value='$ban_dateend' onfocus='this.select();lcs(this)' onclick='event.cancelBubble=true;this.select();lcs(this)' <script src='".e_PLUGIN."timetable/js/calendar_ru.js'></script></td></tr>";
	$fl = new e_file;
        if($iconlist = $fl->get_files(e_PLUGIN."timetable/banners/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        	sort($iconlist);
        }
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".TT_BAN_07." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='ban_images' name='ban_images' value='$ban_images' size='36' maxlength='100' />
		<input class='button' type ='button' style='cursor:pointer' size='30' value='".TT_BAN_08."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."timetable/banners/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','ban_images','linkicn')\"><img src='".$icon['path'].$icon['fname']."' width='200px' style='border:0' alt='' /></a> ";
		}
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
			<input class='button' style='cursor:pointer;display:$unvis' type='submit' value=".TT_BUT_AGR." name='submit_insert'>
			<input class='button' style='cursor:pointer;display:$unvis' type='submit' value=".TT_BUT_RES." name='submit_reset'>
			<input class='button' style='cursor:pointer;display:$vis' type='submit' value=".TT_BUT_UPD." name='submit_update'>
			<input class='button' style='cursor:pointer;display:$vis' type='submit' value=".TT_BUT_CANS." name='submit_reset'>
			</td></tr></table></form>";
$caption = TT_BAN_00;
$ns -> tablerender($caption, $text);
//=============================form edit and delete ========================
$text ="<form name='form_banner_edit' method='post' action='$ban_action' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".TT_BAN_03."</td><td class='forumheader3' width='70%'><input type=hidden name='gnl_name' value=''><select class='tbox' name='ban_id' id='cat'>";
	$sql -> db_Select("tt_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$banId = $row["ban_id"];
		$banOrg = $row["ban_org"];
	$text .="<option value='$banId'>$banOrg";
	}
	$text .="</select>";
	$text .=" <input class='button' style='cursor:pointer;' type='submit' name='submit_edit' value=".TT_BUT_EDIT."> <input class='button' style='cursor:pointer;' type='submit' name='submit_delete' value=".TT_BUT_DEL." onclick='return confirmDeleteBan();'>";
$text .="</td></tr>";
$text .="</table></form>";
$caption = TT_BAN_00;
$ns -> tablerender($caption, $text);
//=============================form all banner==============================
$text ="<form enctype='multipart/form-data' name='form_banner_man' method='post' action=''><table style='width:100%' border=1><tr>";
	$text .="<td>".TT_BAN_06."</td>";
	$text .="<td class='notice_caption'>".TT_BAN_03."</td>";
	$text .="<td class='notice_caption'>".TT_BAN_05."</td>";
	$text .="<td class='notice_caption'>".TT_BAN_01."</td>";
//	$text .="<td class='notice_caption'>".TT_BAN_09."</td></tr>";
	$sql -> db_Select("tt_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$ban_id = $row["ban_id"];
		$ban_catid = $row["ban_catid"];
		$ban_org = $row["ban_org"];
//		$ban_url = $row["ban_url"];
		$ban_datebegin = $row["ban_datebegin"];
		$ban_dateend = $row["ban_dateend"];
		$ban_images = $row["ban_images"];
	$sql2 -> db_Select("tt_gnl", "*", "gnl_id='$ban_catid'");
	while($row = $sql2 -> db_Fetch()){
		$catId = $row["gnl_id"];
		$catName = $row["gnl_name"];
	}
	if ($ban_catId == '0'){
		$catName=TT_BAN_10;
	}
	$text .="<tr><td class='notice_4'><img src='".e_PLUGIN."timetable/banners/$ban_images' width=200></td>";
	$text .="<td class='notice_4'>$ban_org</td>";
	$text .="<td class='notice_4'>$ban_datebegin / $ban_dateend</td>";
	$text .="<td class='notice_4'>$catName</td>";
//	$text .="<td><input type='text' name='ban_id' value='$ban_id'><input class='radio' style='cursor:pointer;' type='radio' id='ban_id' name='ban_id' value=''>";
//	$text .="<td><input type='text' name='ban_id' value='$ban_id'><input class='button' style='cursor:pointer;' type='submit' name='submit_delete' value=".TT_BUT_DEL." >";
}
	$text .="</table></form>";
$caption = TT_BAN_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//				           ABOUT PLUGIN
// =================================================================================================
if(!isset($qs[0]) || (isset($qs[0]) && $qs[0] == "about")){
$text="<table><tr>";
$text.="<td><a href='http://e107.compolys.ru'><img src='".e_PLUGIN."timetable/theme/logo_compolys.png' alt='".TT_INFO."'></a>";
$text.= "<td align='center'> Notice-Board v3.0
<br>author - ComPolyS, http://e107.compolys.ru, e107@compolys.ru
<br>coder - Sunout sunout@compolys.ru, license GNU GPL
<br>==================== July 2011============================";
$text.="</tr></table>";
$text.="<b>".TT_ABO_00."</b><br>";
$text.="".TT_ABO_01."<br>";
$text.="".TT_ABO_02."<br>";
$text.="".TT_ABO_03."<br>";
$text.="".TT_ABO_04."<br>";
$text.="".TT_ABO_05."<br>";
$text.="".TT_ABO_06."<br>";
$text.="".TT_ABO_07."<br>";
$text.="".TT_ABO_08."<br>";
$text.="".TT_ABO_09."<br>";
$text.="".TT_ABO_10."<br>";
$text.="".TT_ABO_11."<br>";
$text.="".TT_ABO_12."<br>";
$text.="".TT_ABO_13."<br>";
$text.="".TT_ABO_14."<br>";
$text.="".TT_ABO_15."<br>";
$text.="".TT_ABO_16."<br>";
$text.="".TT_ABO_17."<br>";
$text.="".TT_ABO_18."<br>";
$text.="".TT_ABO_19."<br>";
$text.="<font color=blue>".TT_ABO_INFO."</font><br>";
$text.="<b>".TT_ABO_20."</b><br>";
$text.="".TT_ABO_21."<br>";
$text.="".TT_ABO_22."<br>";
$text.="".TT_ABO_23."<br>";
$text.="".TT_ABO_24."<br>";
$text.="".TT_ABO_25."<br>";
$text.="".TT_ABO_26."<br>";
$text.="".TT_ABO_27."<br>";
$text.="".TT_ABO_28."<br>";
$text.="".TT_ABO_29."<br>";
$caption = TT_ABO_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
require_once(e_ADMIN."footer.php");
function admin_config_adminmenu()
{
		if (e_QUERY) {
			$tmp = explode(".", e_QUERY);
			$gnl_action = $tmp[0];
		}
		if (!isset($gnl_action) || ($gnl_action == ""))
		{
		  $gnl_action = "cat";
		}
		$var['cat']['text'] = TT_CAT_MENU;
		$var['cat']['link'] = "admin_config.php";
		$var['baners']['text'] = TT_BAN_MENU;
		$var['baners']['link'] ="admin_config.php?baners";
		$var['about']['text'] = TT_ABO_MENU;
		$var['about']['link'] ="admin_config.php?about";
		show_admin_menu(TT_ADMIN_MENU, $gnl_action, $var);
}
function theme_head() {
	return "<script type='text/javascript' src='".e_PLUGIN."timetable/js/add.js'></script>
	<script type='text/javascript' src='".e_PLUGIN."timetable/js/admin_config.js'></script>\n";
}
?>