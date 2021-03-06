<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_handler.php");
require_once(e_HANDLER."file_handler.php");
if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
}
include_lan(e_PLUGIN."nboard/languages/".e_LANGUAGE.".php");
if (e_QUERY) {
	$tmp = explode (".", e_QUERY);
	$action     = $tmp[0];
	$sub_action = $tmp[1];
	$id         = $tmp[2];
}
$vis = 'none';
$unvis = 'yes';
$nb_showrows = $pref["nb_showrows"];
$nb_dateformat = $pref["nb_dateformat"];
$num_page = ($_GET['num_page']) ? $_GET['num_page'] : 0;
$delete_old = $_POST['delete_old'];
$month = date("m");
$day = date("d");
$year = date("y");
$today = mktime(0,0,0,$month,$day,$year);
$today1 = ("$month,$day,$year");
// =================================================================================================
//				          GENERAL OPTIONS MENU
// =================================================================================================
if((!isset($action)) || (isset($action) && $action == "gnl")){

//======Delete_notes======//
if (isset($tmp[1]) && $tmp[1] == "delete"){
	$nbsql = new db;
	$nbsql -> db_Select("nb_gnl", "*", "gnl_id=$id");
 		while($row = $nbsql -> db_Fetch()){
			$gnl_pic = $row['gnl_pic'];
		}
		if (!$gnl_pic == ''){
		$gnl_pic = explode(",",$gnl_pic);
		$message .= "<br>small_$gnl_pic[0],$gnl_pic[0],$gnl_pic[1],$gnl_pic[2],$gnl_pic[3],$gnl_pic[4],$gnl_pic[5]";
		
		for ($i = 0; $i <= 5; $i++) {
		    if (file_exists("nb_pictures/".$gnl_pic[$i]."") && ($gnl_pic[$i]<>'')){
			$message .= "<br>Файл ".$gnl_pic[$i]." существует";
			unlink("nb_pictures/".$gnl_pic[$i]."");
			$message .= "<br>Файл ".$gnl_pic[$i]." удален";
			$message .= "<br>Файл small_".$gnl_pic[$i]." существует";
			unlink("nb_pictures/small_".$gnl_pic[$i]."");
			$message .= "<br>Файл small_".$gnl_pic[$i]." удален";
			
		    } else {
			$message .= "<br>Файл ".$gnl_pic[$i]." не существует";
			$message .= "<br>Файл small_".$gnl_pic[$i]." не существует";
		    }
		}

			unlink("nb_pictures/small_$gnl_pic[0]");
			unlink("nb_pictures/small_$gnl_pic[1]");
			unlink("nb_pictures/small_$gnl_pic[2]");
			unlink("nb_pictures/small_$gnl_pic[3]");
			unlink("nb_pictures/small_$gnl_pic[4]");
			unlink("nb_pictures/small_$gnl_pic[5]");
			unlink("nb_pictures/$gnl_pic[0]");
			unlink("nb_pictures/$gnl_pic[1]");
			unlink("nb_pictures/$gnl_pic[2]");
			unlink("nb_pictures/$gnl_pic[3]");
			unlink("nb_pictures/$gnl_pic[4]");
			unlink("nb_pictures/$gnl_pic[5]");


		}
	$sql -> db_Delete("nb_gnl", "gnl_id=$id");
$ns -> tablerender(LAN_NB_MES_00, $message);
}



if (isset($tmp[1]) && $tmp[1] == "num_page"){
	$num_page = $tmp[2];
}

	$text = "<div>";
	$text .= "<table style='width:100%'>";
	$text .= "<tr>";
	$text .= "<td width='5%' class='fcaption'>".LAN_NB_GNL_ID."</td>";
	$text .= "<td width='5%' class='fcaption'>".LAN_NB_GNL_IMG."</td>";
	$text .= "<td width='55%' class='fcaption'>".LAN_NB_GNL_NAME."</td>";
	$text .= "<td width='10%' class='fcaption'>".LAN_NB_GNL_USER."</td>";
	$text .= "<td width='20%' class='fcaption'>".LAN_NB_GNL_DATE."</td>";
	$text .= "<td width='5%' class='fcaption'>".LAN_NB_GNL_OPT."</td>";
	$text .= "</tr>";
	
	$sql -> db_Select("nb_gnl", "*", "`gnl_id` ORDER BY `gnl_id` DESC LIMIT ".$num_page.",".$nb_showrows."");
		while($row = $sql -> db_Fetch()){
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
			
			if ($gnl_pic == ''){
				$pic = "";
			} else {
				$gnl_pic= explode(",", $gnl_pic);
				$pic = "<img src='".e_PLUGIN."nboard/nb_pictures/small_$gnl_pic[0]' style='width:40px; border:0px solid #000;' alt='".SITENAME." - $gnl_name' />";
			}
	$text .= "<tr>";
	$text .= "<td class='forumheader3'>$gnl_id</td>";
	$text .= "<td class='forumheader3'>$pic</td>";
	$text .= "<td class='forumheader3'>$gnl_name</td>";
	$text .= "<td class='forumheader3'>$gnl_user</td>";
	$text .= "<td class='forumheader3'>".strftime($nb_dateformat,$gnl_date_start)." / ".strftime($nb_dateformat,$gnl_date_end)."</td>";
	$text .= "<td class='forumheader3'>";
	$text .= "<a href='".e_PLUGIN."nboard/admin_config.php?notice.edit.$gnl_id' style='cursor:pointer;'>".ADMIN_EDIT_ICON."</a>";
	$text .= " <a href='".e_PLUGIN."nboard/admin_config.php?gnl.delete.$gnl_id' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_NB_QUE_DEL_NOT." [ ID: $gnl_id] ]')\">".ADMIN_DELETE_ICON."</a>";
	$text .= "</td>";
	$text .= "</tr>";
	}
	
$text .= "</table></div>";

//======Numbering of pages======//
$text .= "<br><center><div>";
$nbsql1 = new db;
$total_items = $nbsql1 -> db_Select("nb_gnl", "*", "");
$parms = $total_items.",".$nb_showrows.",".$num_page.",".e_SELF."?gnl.num_page.[FROM]";
$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
$text .= "</div></center>";

$caption = LAN_NB_GNL_CAP;
$ns -> tablerender($caption, $text);
}
// =================================================================================================
//	CAT OPTIONS MENU
// =================================================================================================
if((isset($action) && $action == "cat")){
	$cat_id = $_POST['cat_id'];
	$cat_sub_id = 0;
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$cat_icon = $_POST['cat_icon'];
//======Edit_notes======//
if (IsSet($_POST['submit_edit'])){
	if ($cat_id == ''){ $message = "<font color=red>".LAN_NB_MES_01."</font>";
	$ns -> tablerender(LAN_NB_MES_00, $message);
	}
	else{
	$sql -> db_Select("nb_cat", "*", "cat_id ='$cat_id'");
		while($row = $sql -> db_Fetch()){
			$cat_name = $row['cat_name'];
			$cat_desc = $row['cat_desc'];
			$cat_icon = $row['cat_icon'];
		}
	$vis = 'yes';
	$unvis = 'none';
	}
}
//======Delete_notes======//
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("nb_cat", "cat_id=$cat_id");
}
//======Insert_notes======//
if (IsSet($_POST['submit_insert'])){
	if ($cat_name == ""){ 
		$message = "<font color=red>".LAN_NB_MES_04."</font>";
	}
	else {
		$sql = new db;
		$sql -> db_Insert("nb_cat", "0, '$cat_sub_id', '$cat_name', '$cat_desc', '$cat_icon'");
	$message = "<font color=red>".LAN_NB_MES_05."</font>";
	$cat_id=$cat_name=$cat_desc=$cat_icon='';
	header ("Location: ".e_PLUGIN."nboard/admin_config.php?cat");
	exit;
	}
$ns -> tablerender(LAN_NB_MES_00, $message);
}
//======Update_notes======//	
	if (IsSet($_POST['submit_update'])){
	$sql -> db_Update("nb_cat", "cat_sub_id='$cat_sub_id', cat_name='$cat_name', cat_desc='$cat_desc', cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
		$message = "<font color=red>".LAN_NB_MES_06."</font>";
		$ns -> tablerender(LAN_NB_MES_00, $message);
	$cat_id=$cat_name=$cat_desc=$cat_icon='';
	$vis = 'none';
	$unvis = 'yes';
	}
//========================================form select============================
	$text ="<form name='form_select_cat' method='post' action=''><table class='fborder' width='100%'>";
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_NB_CAT_02."</td><td class='forumheader3' width='70%'><select class='tbox' name='cat_id'><option value=''>".LAN_NB_CAT_05."";
		$nbsql1 = new db;
		
		$nbsql1 -> db_Select("nb_cat", "*", "cat_sub_id='0'");
		while($row = $nbsql1 -> db_Fetch()){
			$catId1= $row['cat_id'];
			$catName1 = $row['cat_name'];
			$text .="<option value='$catId1'>$catName1";
				$nbsql2 = new db;
				$nbsql2 -> db_Select("nb_cat", "*", "cat_sub_id=$catId1");
				while($row = $nbsql2 -> db_Fetch()){
					$catId2= $row['cat_id'];
					$catName2 = $row['cat_name'];
					$text .="<option value='$catId2'>$catName2";
				}
			
		}
	$text .="</select></td></tr>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".LAN_NB_BUT_EDIT." name='submit_edit'>
		<input type='submit' class='button' style='cursor:pointer;' value=".LAN_NB_BUT_DEL." name='submit_delete' onclick='return confirmDeleteCat();'></td></tr>";
	$text .="</table></form>";
$caption = LAN_NB_CAT_00;
$ns -> tablerender($caption, $text);
//=============================form new category=================================
	$text ="<form name='insert_cat' enctype='multipart/form-data' method='post' action=''><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_NB_CAT_03."</td>
		<td class='forumheader3' width='70%'><input  class='tbox' type='text' name='cat_name' value='$cat_name' size='60'><input type='text' name='cat_id' value='$cat_id' style='display:none;'></td></tr>";
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_NB_CAT_04."</td><td class='forumheader3' width='70%'><input class='tbox' type='text' name='cat_desc' value='$cat_desc' size='60'></td></tr>";
//===============================select cat_icon=================================
        $fl = new e_file;
if($iconlist = $fl->get_files(e_FILE."icons/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        sort($iconlist);
}
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".LAN_NB_IMG_02." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='cat_icon' name='cat_icon' value='$cat_icon' size='40' maxlength='100' />
		<input type ='button' class='button' style='cursor:pointer' size='30' value='".LAN_NB_IMG_03."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_FILE."icons/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','cat_icon','linkicn')\"><img src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a> ";
		}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='forumheader'></td><td class='forumheader'>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".LAN_NB_BUT_AGR." name='submit_insert'>
		<input type='reset' class='button' style='cursor:pointer;display:$unvis' value=".LAN_NB_BUT_CANS.">
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".LAN_NB_BUT_UPD." name='submit_update'>
		<input type='reset' class='button' style='cursor:pointer;display:$vis' value=".LAN_NB_BUT_CANS.">
		</td></tr></table></form>";
$caption = LAN_NB_CAT_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           SUBCAT OPTIONS MENU
// =================================================================================================
if((isset($action) && $action == 'subcat')){
	$cat_id = $_POST['cat_id'];
	$catId = $_POST['catId'];
	$cat_sub_id = $_POST['cat_sub_id'];
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$cat_icon = $_POST['cat_icon'];
//======Edit_notes======//		
if (IsSet($_POST['submit_edit'])){
	$sql -> db_Select("nb_cat", "*", "cat_id ='$cat_id'");
	if ($cat_id == ''){ $message = "<font color=red>".LAN_NB_MES_01."</font>";
	$ns -> tablerender(LAN_NB_MES_00, $message);
	}
	else{
		while($row = $sql -> db_Fetch()){
			$cat_sub_id = $row['cat_sub_id'];
			$cat_name = $row['cat_name'];
			$cat_desc = $row['cat_desc'];
			$cat_icon = $row['cat_icon'];
		}
	$sql -> db_Select("nb_cat", "*", "cat_id='$cat_sub_id'");
                while($row = $sql -> db_Fetch()){
			$catName1 = $row['cat_name'];
			$catSub = $row['cat_id'];
		}
	$vis = 'yes';
	$unvis = 'none';
	}
}
//======Delete_notes======//
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("nb_cat", "cat_id='$cat_id'");
}
//======Insert_notes======//
if (IsSet($_POST['submit_insert'])){
	if ($cat_name == ""){ 
	$message = "<font color=red>".LAN_NB_MES_11."</font>";
	}
	else {
		$sql = new db;
		$sql -> db_Insert("nb_cat", "0, '$catId', '$cat_name', '$cat_desc', '$cat_icon'");
		$message = "<font color=red>".LAN_NB_MES_12."</font>";
		$cat_id=$cat_sub_id=$cat_name=$cat_desc=$cat_icon='';
		header ("Location: ".e_PLUGIN."nboard/admin_config.php?subcat");
		exit;
		}
	$ns -> tablerender(LAN_NB_MES_00, $message);		
}
//======Update_notes======//	
if (IsSet($_POST['submit_update'])){
	$catIdedit = $_POST['catIdedit'];
	$sql -> db_Update("nb_cat", "cat_sub_id='$catIdedit', cat_name='$cat_name', cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
	$message = "<font color=red>".LAN_NB_MES_13."</font>";	
	$cat_id=$cat_sub_id=$cat_name=$cat_desc=$cat_icon='';
	$vis = 'none';
	$unvis = 'yes';
	$ns -> tablerender(LAN_NB_MES_00, $message);
}

//========================================form select============================
	$text ="<form name='form_select_subcat' method='post' action='' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .="<tr><td class='forumheader3'>" .LAN_NB_CAT_02." </td><td class='forumheader3'>
	<select class='tbox' name='' id='cat' onChange='process()'>
	<option value=''>" .LAN_NB_SCAT_07."";
		$sql -> db_Select("nb_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
			}
	$text .="</option></select></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_SCAT_01."</td><td class='forumheader3' width='70%'>
		<select class='tbox' name='cat_id' id='sub' onblur='checkcat()' value='$cat_sub_id'><option value=''>".LAN_NB_SCAT_05."";
	$text .="</select></td></tr>";	
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".LAN_NB_BUT_EDIT." name='submit_edit'>
	<input type='submit' class='button' style='cursor:pointer;' value=".LAN_NB_BUT_DEL." name='submit_delete' onclick='return confirmDeleteSubcat();'>
	</td></tr></table></form>";
$caption = LAN_NB_SCAT_00;
$ns -> tablerender($caption, $text);
//=============================form new subcategory==============================
	$text ="<form enctype='multipart/form-data' name='new_note' method='post' action=''><table class='fborder' style='width:100%'>";
        $text .= "<tr><td class='forumheader3'>".LAN_NB_CAT_02."</td><td class='forumheader3' width='80%'>
		<font color=red style='cursor:pointer;display:$vis'>".LAN_NB_SCAT_06."</font>";
	$text .= "<select class='tbox' name='catIdedit' style='display:$vis'><option value='$catSub'>$catName1";
		$sql -> db_Select("nb_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName1 = $row['cat_name'];
			$text .="<option value='$catId'>$catName1";
		}
	$text .="</select>";
	$text .= "<select class='tbox' name='catId' style='display:$unvis'><option value=''>".LAN_NB_SCAT_07."";
		$sql -> db_Select("nb_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
		}
	$text .="</select></td></tr>";
	$cat_sub_id = $catId;
	$text .= "<tr><td class='forumheader3'>".LAN_NB_SCAT_03." </td><td class='forumheader3' width='80%'>
			<input type='text' name='cat_name' size='36' class='tbox' value='$cat_name'>
			<input type='hidden' name='cat_sub_id' value='$cat_sub_id'>
			<input type='hidden' name='cat_id' value='$cat_id'></td></tr>";
//===============================select cat_icon=================================
        $fl = new e_file;
        if($iconlist = $fl->get_files(e_PLUGIN."nboard/theme/icons_subcat/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        	sort($iconlist);
        }
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".LAN_NB_IMG_02." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='cat_icon' name='cat_icon'  value='$cat_icon' size='36' maxlength='100' />
		<input class='button' type ='button' style='cursor:pointer' size='30' value='".LAN_NB_IMG_03."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."nboard/theme/icons_subcat/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','cat_icon','linkicn')\"><img src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a> ";
		}
	$text .= "<tr><td class='forumheader'>&nbsp;</td><td class='forumheader'>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".LAN_NB_BUT_AGR." name='submit_insert'>
		<input type='reset' class='button' style='cursor:pointer;display:$unvis' value=".LAN_NB_BUT_CANS.">
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".LAN_NB_BUT_UPD." name='submit_update'>
		<input type='reset' class='button' style='cursor:pointer;display:$vis' value=".LAN_NB_BUT_CANS.">
			</td></tr></table></form>";
			
	$text .= "<script type='text/javascript' src='".e_PLUGIN."nboard/js/add.js'></script><script type='text/javascript' src='".e_PLUGIN."nboard/js/admin_config.js'></script>";
	
$caption = LAN_NB_SCAT_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           MANAGER NOTICE MENU
// =================================================================================================
if((isset($action) && $action == "notice")){
	$gnl_id_select = $_POST['gnl_id_select'];
	$gnl_id = $_POST["gnl_id"];
	$gnl_scatid = $_POST["cat_sub_id"];
	$gnl_name = $_POST["gnl_name"];
	$gnl_city = $_POST["gnl_city"];
	$gnl_detail = $_POST["gnl_detail"];
	$gnl_price = $_POST['gnl_price'];
	$gnl_user=$_POST['gnl_user'];	
	$gnl_email=$_POST['gnl_email'];
	$gnl_phone = $_POST['gnl_phone'];
	$days = $_POST['days'];	
	$gnl_date_start = date("d-m-Y");
	$gnl_date_end =date("d-m-Y" , strtotime("+ $days day"));

//-----editing procedure------------------------------
if(IsSet($sub_action) && $sub_action =='edit'){
	$nbsql = new db;
	$nbsql -> db_Select("nb_gnl", "*", "gnl_id=$id");
		while($row = $nbsql -> db_Fetch()){
			$gnl_name = $row['gnl_name'];
			$gnl_scatid = $row['gnl_scatid'];
			$gnl_city = $row['gnl_city'];
			$gnl_detail = $row['gnl_detail'];
			$gnl_pic1 = $row['gnl_pic1'];
			$gnl_price = $row['gnl_price'];
			$gnl_user = $row['gnl_user'];
			$gnl_phone = $row['gnl_phone'];
			$gnl_email = $row['gnl_email'];
			$gnl_date_start = $row['gnl_date_start'];
			$gnl_date_end = $row['gnl_date_end'];
		}
	}
if (isset($_POST['submit_update'])){
	$vtsql = new db;
	$vtsql -> db_Update("nb_gnl", "gnl_scatid='$gnl_scatid', gnl_name='$gnl_name', gnl_city='$gnl_city',  gnl_detail='$gnl_detail', gnl_price = '$gnl_price', gnl_user='$gnl_user', gnl_phone='$gnl_phone', gnl_email='$gnl_email', gnl_date_start='$gnl_date_start', gnl_date_end='$gnl_date_end' WHERE gnl_id=$gnl_id");
}
//-----editing form------------------------------------
	$text = "<form  method='post' enctype='multipart/form-data' name='form_not_edit' action=''>
	<table class='border' style='width:100%' align='center'>";
	
	$text .= "<tr><td class='forumheader2' width=100px>".LAN_NB_NOT_ID." *</td><td class='forumheader2' width=auto>
	<input type='text' class='tbox' name='gnl_id' value='$id'></td></tr>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_NAME." *</td><td class='forumheader2'>
	<input type='text' class='tbox' size='50' name='gnl_name' value='$gnl_name'></td></tr>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_CAT_02."</td><td class='forumheader2'>
		";
	$nbsql1 = new db;
	$nbsql1 -> db_Select("nb_cat", "*", "cat_id='$gnl_scatid'");
                while($row = $nbsql1 -> db_Fetch()){
			$catId1 = $row['cat_id'];
			$catSubId1 = $row['cat_sub_id'];
			$catName1 = $row['cat_name'];
		}
	$nbsql2 = new db;
	$nbsql2 -> db_Select("nb_cat", "*", "cat_id='$catSubId1'");
                while($row = $nbsql2 -> db_Fetch()){
			$catId2 = $row['cat_id'];
			$catName2 = $row['cat_name'];
		}
	$text .="<tr><td class='forumheader2'>".LAN_NB_NOT_CAT." *</td><td class='forumheader2'>
	<select class='tbox' name='cat_id' id='cat' onChange='process()' style='width:450px'>
	<option value='$catId2'>$catName2";
	$sql -> db_Select("nb_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
		}
$text .="</option></select></td></tr>";
	
$text .="<tr><td class='forumheader2'>".LAN_NB_NOT_SCAT." *</td><td class='forumheader2'>
	<select class='tbox' name='cat_sub_id' id='sub' onblur='checkcat()' value='$cat_sub_id' style='width:450px'><option value='$catId1'>$catName1 </option></select><span id='check_subcat'></span></td></tr>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_DET." *</td><td class='forumheader2'>
	<textarea class='tbox' name='gnl_detail' cols=30 rows=10>$gnl_detail</textarea></td>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_PRICE." *</td><td class='forumheader2'>
	<input class='tbox' type='text' size='50' name='gnl_price' value='$gnl_price'></td>";
	
	$text .= "<tr><td class='forumheader2' width='30%'>".LAN_NB_NOT_USER." *</td><td class='forumheader2' width='70%'>
	<input type='text' class='tbox' size='50' name='gnl_user' value='$gnl_user'></td>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_CITY." *</td><td class='forumheader2'>
	<input type='text' class='tbox' size='50' name='gnl_city' value='$gnl_city'></td>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_PHONE." *</td><td class='forumheader2'>
	<input class='tbox' type='text' size='50' name='gnl_phone' value='$gnl_phone'></td>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_EMAIL."</td><td class='forumheader2' width='70%'>
	<input class='tbox' type='text' size='50' name='gnl_email' value='$gnl_email'></td>";
	
	$text .= "<tr><td class='forumheader2'>".LAN_NB_NOT_LONG."*</td> <td class='forumheader2'><select class='tbox' name='days'>";
	$text .= "<option value=''></option>";
	$text .= "<option value='15'>".LAN_NB_NOT_DATESTART."</option>";
	$text .= "<option value='30'>".LAN_NB_NOT_DATESTOP."</option>";
	$text .= "</select>";
	$text .="<input type='hidden' name='gnl_date_start' class='tbox' style='width:150px' value='$gnl_date_start'>
	<input type='hidden' name='gnl_date_end' class='tbox' style='width:150px' value='$gnl_date_end'></td></tr>";
	$text .="<tr><td class='forumheader2'></td><td class='forumheader2'>
	<input class='button' style='cursor:pointer' type='submit' name='submit_update' value='".LAN_NB_BUT_UPD."'>
	<input class='button' style='cursor:pointer' type='submit' name='submit_reset' id='otmena' value=".LAN_NB_BUT_RES." onClick='otmena()'>
	</td></tr></table></form>";
	$text .= "<script type='text/javascript' src='".e_PLUGIN."nboard/js/add.js'></script><script type='text/javascript' src='".e_PLUGIN."nboard/js/admin_config.js'></script>";
$caption = LAN_NB_NOT_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           DELETE NOTICE MENU
// =================================================================================================
if((isset($action) && $action == "delete")){
$nb_days = $pref["nb_days"];
$month = date("m");
$day = date("d");
$day_end = $day - 60;
$year = date("y");
$now = mktime(0,0,0,$month,$day,$year);
$notice_end = mktime(0,0,0,$month,$day_end,$year);
	$text = "Объявления действуют $nb_days дней";
	$text .= "<br>Сегодня:".$now.":".strftime("%d.%m.%Y", $now);
	$text .= "<br>Сегодня - $nb_days = ".$notice_end.":".strftime("%d.%m.%Y", $notice_end);
	
if (isset($tmp[1]) && $tmp[1] == "delete_old"){
//	include("delete_old_notice.php");

	$nbsql = new db;
	$nbsql -> db_Select("nb_gnl", "*", "gnl_date_end<$notice_end");
		while($row = $nbsql -> db_Fetch()){
			$gnl_id = $row['gnl_id'];
			$gnl_pic = $row['gnl_pic'];
			if (!$gnl_pic == ''){
			$gnl_pic = explode(",",$gnl_pic);
//			$message .= "<br>small_$gnl_pic[0],$gnl_pic[0],$gnl_pic[1],$gnl_pic[2],$gnl_pic[3],$gnl_pic[4],$gnl_pic[5]";
			$message .= "<br>$gnl_id";
//			unlink("".e_PLUGIN."nboard/nb_pictures/small_$gnl_pic[0]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[0]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[1]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[2]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[3]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[4]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[5]");
			}
//			$sql -> db_Delete("nb_gnl", "gnl_id=$gnl_id");
		}
//		unlink("nb_pictures/1375425060_0_snv38928.jpg");
		$message .= "<br>1375425060_0_snv38928.jpg - удалена";
$ns -> tablerender(LAN_NB_MES_00, $message);
}
$text .= "<br><br><a href='".e_PLUGIN."nboard/admin_config.php?delete.delete_old' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_NB_QUE_DEL_NOTOLD."')\">[Удалить все старые объявления]</a><br><br>";

$caption = LAN_NB_NOT_CAP;
$ns -> tablerender($caption, $text);

$text = "Изображения в которых нет в базе, но остались неудаленными";
//$nb_pictures = file('/nb_pictures/');
$nbsql = new db;
	$nbsql -> db_Select("nb_gnl", "*", "");
		while($row = $nbsql -> db_Fetch()){
			$gnl_id = $row['gnl_id'];
			$gnl_pic = $row['gnl_pic'];
			if (!$gnl_pic == ''){
			$gnl_pic = explode(",",$gnl_pic);
//			$message .= "<br>small_$gnl_pic[0],$gnl_pic[0],$gnl_pic[1],$gnl_pic[2],$gnl_pic[3],$gnl_pic[4],$gnl_pic[5]";
			$text .= "<br>$gnl_pic";
//			unlink("".e_PLUGIN."nboard/nb_pictures/small_$gnl_pic[0]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[0]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[1]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[2]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[3]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[4]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[5]");
			}
//			$sql -> db_Delete("nb_gnl", "gnl_id=$gnl_id");
		}



$dir = "nb_pictures/";
$dh  = opendir($dir);
$filename = readdir($dh);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
//sort($files);
$text .= "<br>$files";
//rsort($files);
//print_r($files);
foreach ($files as $key => $nb_pictures) {
//  $text .= "<b>$key => $nb_pictures ".$files[$key]."</b>  <br />\n";
  
//	$nbsql = new db;
//	$nbsql -> db_Select("nb_gnl", "*", "");
//		while($row = $nbsql -> db_Fetch()){
//			$gnl_id = $row['gnl_id'];
//			$gnl_pic = $row['gnl_pic'];
			
//			if (!$gnl_pic == ''){
//			$gnl_pic = explode(",",$gnl_pic);
//			
//			$message .= "<br>small_$gnl_pic[0],$gnl_pic[0],$gnl_pic[1],$gnl_pic[2],$gnl_pic[3],$gnl_pic[4],$gnl_pic[5]";
//			$message .= "<br>$gnl_id";
//			unlink("".e_PLUGIN."nboard/nb_pictures/small_$gnl_pic[0]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[0]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[1]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[2]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[3]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[4]");
//			unlink("".e_PLUGIN."nboard/nb_pictures/$gnl_pic[5]");
//			}
//			$sql -> db_Delete("nb_gnl", "gnl_id=$gnl_id");
//		}
}
$caption = LAN_NB_NOT_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
}
// =================================================================================================
//				           BANNERS OPTIONS MENU
// =================================================================================================
if((isset($action) && $action == 'baners')){
	$ban_id=$_POST['ban_id'];
	$ban_catid =$_POST['ban_catid'];
	$now_date = date('d-m-Y');
	$ban_action = $_POST['ban_action'];
	$ban_org = $_POST['ban_org'];
	$ban_url = $_POST['ban_url'];
	$ban_datebegin = $_POST['ban_datebegin'];
	$ban_dateend = $_POST['ban_dateend'];
	$ban_images = $_POST['ban_images'];
	$cat_name = $_POST['cat_name'];
//======Insert_notes======//
if(IsSet($_POST['submit_insert'])){
	if ($ban_action == ""){
		$sql = new db;
		$sql -> db_Insert("nb_ban", "0, '$ban_catid', '$ban_org', '$ban_url', '$ban_datebegin', '$ban_dateend', '$ban_images'");
	header ("Location: ".e_PLUGIN."nboard/admin_config.php?baners");
	exit;
	}
}
//======Edit_notes======//
if (isset($_POST['submit_edit'])){
	$vis = 'yes';
	$unvis = 'none';
	$sql -> db_Select("nb_ban", "*", "ban_id=$ban_id");
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
	$sql -> db_Update("nb_ban", "ban_catid='$ban_catid', ban_org='$ban_org', ban_url='$ban_url', ban_datebegin='$ban_datebegin', ban_dateend='$ban_dateend', ban_images='$ban_images' WHERE ban_id='$ban_id'");
	$message = LAN_NB_MES_23;
	$ns -> tablerender($caption, $message);
	$ban_id =$ban_cati =$ban_org=$ban_url=$ban_datebegin=$ban_dateend=$ban_images='';
	$vis = 'none';
	$unvis = 'yes';
}
//======Delete_notes======//
if(IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("nb_ban", "ban_id='$ban_id'");
}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	$ban_org=$ban_url=$ban_datebegin=$ban_dateend=$ban_id='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Form Banners=========//
$text ="<form name='banner_add' method='post' action='' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_BAN_01."</td><td class='forumheader3' width='70%'>
		<input type=hidden name='ban_id' value='$ban_id'>
		<select class='tbox' name='ban_catid' id='cat'>";
	
	$text .="<option value=''>".LAN_NB_BAN_02."";
	$text .="<option value='0'>".LAN_NB_BAN_10."";
	$text .="<option value='all_pages'>".LAN_NB_BAN_11."";
		$sql -> db_Select("nb_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
		}
	$text .="</select></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_BAN_03."</td><td class='forumheader3' width='80%'><input size='36' type='text' name='ban_org' class='tbox' value='$ban_org'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_BAN_04."</td><td class='forumheader3' width='80%'><input size='36' type='text' name='ban_url' class='tbox' value='$ban_url'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_BAN_05."</td><td class='forumheader3' width='80%'><input size='16' type='text' name='ban_datebegin' class='tbox' value='$ban_datebegin' onclick='event.cancelBubble=true;this.select();lcs(this)' <script src='".e_PLUGIN."nboard/js/calendar_ru.js'></script><style>
	input {border:1px solid #ABABAB}
	</style> / <input size='16' type='text' name='ban_dateend' class='tbox' value='$ban_dateend' onfocus='this.select();lcs(this)' onclick='event.cancelBubble=true;this.select();lcs(this)' <script src='".e_PLUGIN."nboard/js/calendar_ru.js'></script></td></tr>";
	$fl = new e_file;
        if($iconlist = $fl->get_files(e_PLUGIN."nboard/banners/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        	sort($iconlist);
        }
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".LAN_NB_BAN_07." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='ban_images' name='ban_images' value='$ban_images' size='36' maxlength='100' />
		<input class='button' type ='button' style='cursor:pointer' size='30' value='".LAN_NB_BAN_08."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."nboard/banners/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','ban_images','linkicn')\"><img src='".$icon['path'].$icon['fname']."' width='200px' style='border:0' alt='' /></a> ";
		}
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
			<input class='button' style='cursor:pointer;display:$unvis' type='submit' value=".LAN_NB_BUT_AGR." name='submit_insert'>
			<input class='button' style='cursor:pointer;display:$unvis' type='submit' value=".LAN_NB_BUT_RES." name='submit_reset'>
			<input class='button' style='cursor:pointer;display:$vis' type='submit' value=".LAN_NB_BUT_UPD." name='submit_update'>
			<input class='button' style='cursor:pointer;display:$vis' type='submit' value=".LAN_NB_BUT_CANS." name='submit_reset'>
			</td></tr></table></form>";
$caption = LAN_NB_BAN_00;
$ns -> tablerender($caption, $text);
//=============================form edit and delete ========================
$text ="<form name='form_banner_edit' method='post' action='$ban_action' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_BAN_03."</td><td class='forumheader3' width='70%'><input type=hidden name='cat_name' value=''><select class='tbox' name='ban_id' id='cat'>";
	$sql -> db_Select("nb_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$banId = $row["ban_id"];
		$banOrg = $row["ban_org"];
	$text .="<option value='$banId'>$banOrg";
	}
	$text .="</select>";
	$text .=" <input class='button' style='cursor:pointer;' type='submit' name='submit_edit' value=".LAN_NB_BUT_EDIT."> <input class='button' style='cursor:pointer;' type='submit' name='submit_delete' value=".LAN_NB_BUT_DEL." onclick='return confirmDeleteBan();'>";
$text .="</td></tr>";
$text .="</table></form>";
$caption = LAN_NB_BAN_00;
$ns -> tablerender($caption, $text);
//=============================form all banner==============================
$text ="<form enctype='multipart/form-data' name='form_banner_man' method='post' action=''><table style='width:100%' border=1><tr>";
	$text .="<td>".LAN_NB_BAN_06."</td>";
	$text .="<td class='notice_caption'>".LAN_NB_BAN_03."</td>";
	$text .="<td class='notice_caption'>".LAN_NB_BAN_05."</td>";
	$text .="<td class='notice_caption'>".LAN_NB_BAN_01."</td>";
//	$text .="<td class='notice_caption'>".LAN_NB_BAN_09."</td></tr>";
	$sql -> db_Select("nb_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$ban_id = $row["ban_id"];
		$ban_catid = $row["ban_catid"];
		$ban_org = $row["ban_org"];
//		$ban_url = $row["ban_url"];
		$ban_datebegin = $row["ban_datebegin"];
		$ban_dateend = $row["ban_dateend"];
		$ban_images = $row["ban_images"];
	$sql2 -> db_Select("nb_cat", "*", "cat_id='$ban_catid'");
	while($row = $sql2 -> db_Fetch()){
		$catId = $row["cat_id"];
		$catName = $row["cat_name"];
	}
	if ($ban_catId == '0'){
		$catName=LAN_NB_BAN_10;
	}
	$text .="<tr><td class='notice_4'><img src='".e_PLUGIN."nboard/banners/$ban_images' width=200></td>";
	$text .="<td class='notice_4'>$ban_org</td>";
	$text .="<td class='notice_4'>$ban_datebegin / $ban_dateend</td>";
	$text .="<td class='notice_4'>$catName</td>";
//	$text .="<td><input type='text' name='ban_id' value='$ban_id'><input class='radio' style='cursor:pointer;' type='radio' id='ban_id' name='ban_id' value=''>";
//	$text .="<td><input type='text' name='ban_id' value='$ban_id'><input class='button' style='cursor:pointer;' type='submit' name='submit_delete' value=".LAN_NB_BUT_DEL." >";
}
	$text .="</table></form>";
$caption = LAN_NB_BAN_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           ADMIN_CONFIG OPTIONS MENU
// =================================================================================================
if((isset($action) && $action == "config")){
//======UPDATE========//
if(IsSet($_POST['savesettings'])){
	$pref['nb_admail'] = $_POST['nb_admail'];
	$pref['nb_days'] = $_POST['nb_days'];
	$pref['nb_prolong'] = $_POST['nb_prolong'];
	$pref['nb_dateformat'] = $_POST['nb_dateformat'];
	$pref['nb_sizepicbig'] = $_POST['nb_sizepicbig'];
	$pref['nb_sizepicsmall'] = $_POST['nb_sizepicsmall'];
	$pref['nb_showcols'] = $_POST['nb_showcols'];
	$pref['nb_showrows'] = $_POST['nb_showrows'];
	$pref['nb_menu_showrows'] = $_POST['nb_menu_showrows'];
	$pref['nb_check_que'] = $_POST['nb_check_que'];
	$pref['nb_check_ans'] = $_POST['nb_check_ans'];
	$pref['nb_comments'] = $_POST['nb_comments'];
	save_prefs();
	$message = LAN_NB_MES_14;
	$ns -> tablerender(LAN_NB_MES_00, $message);
}
	$text .="<form enctype='multipart/form-data' name='form_config' method='post' action=''><table class='fborder' style='width:100%' align='center'>";
        $text .= "<tr><td class='forumheader3' width='60%'>".LAN_NB_CONF_MAIL."</td><td class='forumheader3'><input class='tbox' size='40' type='text' name='nb_admail' value='".$pref['nb_admail']."'></input></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_DAY."</td><td class='forumheader3'><input type='text' name='nb_days' class='tbox' value='".$pref['nb_days']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_PROLONG."</td><td class='forumheader3'><input type='text' name='nb_prolong' class='tbox' value='".$pref['nb_prolong']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_FORM."</td>
	<td class='forumheader3'><select class='tbox' type='text' name='nb_dateformat'>
		<option value='".$pref['nb_dateformat']."'>".$pref['nb_dateformat']."
		<option value=".LAN_NB_FDATE_01.">".LAN_NB_RDATE_01."
		<option value=".LAN_NB_FDATE_01.">".LAN_NB_RDATE_02."
	</select></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_IMBIG."</td><td class='forumheader3'><input type='text' name='nb_sizepicbig' class='tbox' value='".$pref['nb_sizepicbig']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_IMSMALL."</td><td class='forumheader3'><input type='text' name='nb_sizepicsmall' class='tbox' value='".$pref['nb_sizepicsmall']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_COL1."</td><td class='forumheader3'><input type='text' name='nb_showcols' class='tbox' value='".$pref['nb_showcols']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_ROW1."</td><td class='forumheader3'><input type='text' name='nb_showrows' class='tbox' value='".$pref['nb_showrows']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_ROW2."</td><td class='forumheader3'><input type='text' name='nb_menu_showrows' class='tbox' value='".$pref['nb_menu_showrows']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_QUE."</td><td class='forumheader3'><input type='text' name='nb_check_que' class='tbox' value='".$pref['nb_check_que']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_ANS."</td><td class='forumheader3'><input type='text' name='nb_check_ans' class='tbox' value='".$pref['nb_check_ans']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_NB_CONF_COMMENT."</td>
	<td class='forumheader3'><select class='tbox' type='text' name='nb_comments'>
		<option value='".$pref['nb_comments']."'>".$pref['nb_comments']."
		<option value=".LAN_NB_SEL_YES.">".LAN_NB_SEL_YES."
		<option value=".LAN_NB_SEL_NO.">".LAN_NB_SEL_NO."
	</select></td></tr>";
	$text .= "<tr><td class='forumheader' colspan='2' style='text-align:center'><input class='button' name='savesettings' type='submit' value= ".LAN_NB_BUT_AGR."></td></tr></table></form>";
$caption = LAN_NB_CONF_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//				           ABOUT PLUGIN
// =================================================================================================
if(isset($action) && $action == "about"){
$text="<h1>".LAN_NB_INFO." RC ".LAN_NB_VERSION."</h1><br><br>";

$text .= LAN_NB_ABO_INFO."<br><br>";
$text .= "<b><a href='".e_PLUGIN."nboard/doc/".e_LANGUAGE.".pdf'>".LAN_NB_ABO_DOC."</a></b><br>";

$text.="<table><tr><td> </td>";
$text.= "<td align='center'>
<br><br><br>".LAN_NB_AUTH.", 
<br> http://e107.compolys.ru, e107@compolys.ru
<br>Sunout sunout@compolys.ru, license GNU GPL
<br>================= start project July 2011=================
<br><a href='http://e107.compolys.ru'><img src='".e_PLUGIN."nboard/theme/logo_compolys.png' alt='".LAN_NB_INFO."'></a>";
$text .= "</tr></table>";
$caption = LAN_NB_ABO_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
require_once(e_ADMIN."footer.php");

function admin_config_adminmenu()
{	
	if (e_QUERY) {
	      $tmp = explode (".", e_QUERY);
	      $action     = $tmp[0];
	      $sub_action = $tmp[1];
	      $id         = $tmp[2];
	}
	if (!isset($action) || ($action == "")){
		$action = "gnl";
	}
		$var['gnl']['text'] = LAN_NB_MENU_GNL;
		$var['gnl']['link'] = e_SELF;
		$var['cat']['text'] = LAN_NB_MENU_CAT;
		$var['cat']['link'] = e_SELF."?cat";
		$var['subcat']['text'] = LAN_NB_MENU_SCAT;
		$var['subcat']['link'] = e_SELF."?subcat";
		$var['notice']['text'] = LAN_NB_MENU_NOT;
		$var['notice']['link'] = e_SELF."?notice";
		$var['config']['text'] = LAN_NB_MENU_CON;
		$var['config']['link'] = e_SELF."?config";
		$var['delete']['text'] = LAN_NB_MENU_DEL;
		$var['delete']['link'] = e_SELF."?delete";
		$var['baners']['text'] = LAN_NB_MENU_BAN;
		$var['baners']['link'] = e_SELF."?baners";
		$var['about']['text'] = LAN_NB_MENU_ABO;
		$var['about']['link'] = e_SELF."?about";
		show_admin_menu(LAN_NB_ADMIN_MENU_CAP, $action, $var);
}
?>