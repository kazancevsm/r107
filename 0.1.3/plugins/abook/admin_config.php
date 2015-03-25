<?php
/*==================================Address Book 1.0=============================
|  author - Sunout; Geo, http://e107.compolys.ru, support@compolys.ru		|
|  http://e107.ru, http://e107.ru, http://e107.org                            	|
|  GNU General Public License (http://gnu.org)					|
====================================19.11.2011=================================*/
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_handler.php");
require_once(e_HANDLER."file_handler.php");
if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
    }
include_lan(e_PLUGIN."abook/languages/".e_LANGUAGE.".php");
if (e_QUERY)
{
  $qs = explode(".", e_QUERY);
}
$vis = 'none';
$unvis = 'yes';
// =================================================================================================
//				               CAT OPTIONS MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == "cat")){
	$cat_id = $_POST['cat_id'];
	$cat_sub_id = 0;
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$cat_icon = $_POST['cat_icon'];
//======Edit_notes======//
if (IsSet($_POST['submit_edit'])){
	if ($cat_id == ''){ $message = "<font color=red>".LAN_AB_MES_01."</font>";
	$ns -> tablerender(LAN_AB_MES_00, $message);
	}
	else{
	$sql -> db_Select("ab_cat", "*", "cat_id ='$cat_id'");
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
	$sql -> db_Delete("ab_cat", "cat_id=$cat_id");
}
//======Insert_notes======//
if (IsSet($_POST['submit_insert'])){
	if ($cat_name == ""){ 
		$message = "<font color=red>".LAN_AB_MES_04."</font>";
	}
	else {
		$sql = new db;
		$sql -> db_Insert("ab_cat", "0,'$cat_name', '$cat_desc', '$cat_icon'");
	$message = "<font color=red>".LAN_AB_MES_05."</font>";
	$cat_id=$cat_name=$cat_desc=$cat_icon='';
	header ("Location: ".e_PLUGIN."abook/admin_config.php?cat");
	exit;
	}
$ns -> tablerender(LAN_AB_MES_00, $message);
}
//======Update_notes======//	
	if (IsSet($_POST['submit_update'])){
	$sql -> db_Update("ab_cat", " cat_name='$cat_name', cat_desc='$cat_desc', cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
		$message = "<font color=red>".LAN_AB_MES_06."</font>";
		$ns -> tablerender(LAN_AB_MES_00, $message);
	$cat_id=$cat_name=$cat_desc=$cat_icon='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	$cat_id = $cat_name = $cat_desc = $cat_icon = '';
	$vis = 'none';
	$unvis = 'yes';
	}
//========================================form select============================
	$text ="<form name='form_select_cat' method='post' action=''><table class='fborder' width='100%'>";
        $text .= "<tr><td class='forumheader3' width='30%'>".LAN_AB_CAT_MENU."</td><td class='forumheader3' width='70%'><select class='tbox' name='cat_id'><option value=''>".LAN_AB_CAT_SEL."";
		$sql -> db_Select("ab_cat", "*", "");
                while($row = $sql -> db_Fetch()){
			$catId= $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
		}
	$text .="</select></td></tr>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".LAN_AB_BUT_EDIT." name='submit_edit'>
	<input type='submit' class='button' style='cursor:pointer;' value=".LAN_AB_BUT_DEL." name='submit_delete' onclick='return confirmDeleteCat();'></td></tr>";
	$text .="</table></form>";
$caption = LAN_AB_CAT_CAP;
$ns -> tablerender($caption, $text);
//=============================form new category=================================
	$text ="<form name='insert_cat' enctype='multipart/form-data' method='post' action=''><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_AB_CAT_NAME."</td>
		<td class='forumheader3' width='70%'><input  class='tbox' type='text' name='cat_name' value='$cat_name' size='60'><input type='text' name='cat_id' value='$cat_id' style='display:none;'></td></tr>";
	$text .= "<tr><td class='forumheader3' width='30%'>".LAN_AB_CAT_DESC."</td><td class='forumheader3' width='70%'><input class='tbox' type='text' name='cat_desc' value='$cat_desc' size='60'></td></tr>";
//===============================select cat_icon=================================
        $fl = new e_file;
if($iconlist = $fl->get_files(e_PLUGIN."abook/theme/icons_cat/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        sort($iconlist);
}
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".LAN_AB_IMG_02." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='cat_icon' name='cat_icon' value='$cat_icon' size='40' maxlength='100' />
		<input type ='button' class='button' style='cursor:pointer' size='30' value='".LAN_AB_IMG_03."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."abook/theme/icons_cat/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','cat_icon','linkicn')\"><img src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a> ";
		}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='forumheader'></td><td class='forumheader'>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".LAN_AB_BUT_AGR." name='submit_insert'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".LAN_AB_BUT_UPD." name='submit_update'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".LAN_AB_BUT_CANS." name='submit_reset'>
		</td></tr></table></form>";
$caption = LAN_AB_CAT_EDIT;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           MANAGER NOTICE MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == "manager")){
$gnl_id = $_POST['gnl_id'];
$gnl_cat = $_POST['gnl_cat'];
$gnl_name = $_POST['gnl_name'];
$gnl_mag = $_POST['gnl_mag'];
$gnl_city = $_POST['gnl_city'];
$gnl_address = $_POST['gnl_address'];
$gnl_site = $_POST['gnl_site'];
$gnl_mail = $_POST['gnl_mail'];
$gnl_icq = $_POST['gnl_icq'];
$gnl_user = $_POST['gnl_user'];
$gnl_conname = $_POST['gnl_conname'];
$gnl_conphone = $_POST['gnl_conphone'];
$gnl_logo = $_POST['gnl_logo'];
$gnl_img = $_POST['gnl_img'];
$gnl_devision = $_POST['gnl_devision'];
$gnl_desc = $_POST['gnl_desc'];
//$gnl_check = '';
$gnl_check_admin = $_POST['gnl_check_admin'];
$gnl_check_cat = $_POST['gnl_check_cat'];
$vis = 'none';
$unvis = 'yes';
//======Insert_notes======//
if (IsSet($_POST['submit_insert'])){
//======check empty============//
	if ($gnl_name=='' || $gnl_city==''|| $gnl_address=='' || $gnl_conname=='' || $gnl_conphone=='' || $gnl_devision==''){
	$message = "<font color=blue>".LAN_AB_MES_21."</font>";
	}
	else {
	if (isset($_FILES['file_userfile']['error'])){
		require_once(e_HANDLER."upload_handler.php");
		if ($uploaded = file_upload('/'.e_PLUGIN."abook/ab_pictures/", "attachment")){
			foreach($uploaded as $upload){
			  if ($upload['error'] == 0) {
				$ab_patch = e_PLUGIN.'abook/ab_pictures/';
				if(strstr($upload['type'], "image")){
					require_once(e_HANDLER."resize_handler.php");
					$orig_file = $upload['name'];
					$gnl_logo = $orig_file;
					$small_img = "small_$orig_file";
					if(resize_image(e_PLUGIN.'abook/ab_pictures/'.$orig_file, e_PLUGIN.'abook/ab_pictures/'.$small_img, $pref['ab_sizecat'])){
//					$parms_small = image_getsize(e_PLUGIN.'abook/ab_pictures/'.$small_img);
//					$parms_big = image_getsize(e_PLUGIN.'abook/ab_pictures/'.$big_img);
					}
					if(resize_image(e_PLUGIN.'abook/ab_pictures/'.$orig_file, e_PLUGIN.'abook/ab_pictures/'.$orig_file, $pref['ab_sizepicbig'])){
//					$parms = image_getsize(e_PLUGIN.'abook/ab_pictures/'.$big_img);
//					$gnl_pic1 = $orig_file;
					}
				}
				else{	//upload was not an image, link to file
					$_POST['post'] .= "[br][file=".$ab_patch.$upload['name']."]".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."[/file]";
				}
			  }
			  else{  // Error in uploaded file
			    echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
			  }
			}
		}
	}
//=========================================insert==============================
$sql = new db;
	$gnl_user=USERNAME;
	$gnl_cat=0;
	$gnl_check_admin='no';
	$sql -> db_Insert("ab_gnl", "0,'$gnl_cat', '$gnl_name','$gnl_mag','$gnl_city','$gnl_address','$gnl_site','$gnl_mail','$gnl_icq','$gnl_user','$gnl_conname','$gnl_conphone','$gnl_logo','$gnl_img','$gnl_devision','$gnl_desc','$gnl_check_admin'");
	 $message = "".LAN_AB_MES_19." <br><font color=red>".LAN_AB_MES_20."</font>";   //$gnl_name=$gnl_city=$gnl_address=$gnl_cat=$gnl_site=$gnl_mail=$gnl_icq=$gnl_phone=$gnl_conname=$gnl_conphone=$gnl_logo=$gnl_img=$gnl_devision=$gnl_desc='';
	//header ("Location: ".e_PLUGIN."abook/abook.php?add");
	//exit;
	}
	$ns -> tablerender(LAN_AB_MES_00, $message);
}
//======Reset_notes======//
if (IsSet($_POST['submit_reset'])){
	$gnl_name=$gnl_mag=$gnl_city=$gnl_address=$gnl_cat=$gnl_site=$gnl_mail=$gnl_icq=$gnl_conname=$gnl_conphone=$gnl_logo=$gnl_img=$gnl_devision=$gnl_desc='';
}
//======Edit_notes======//
if(IsSet($_POST['submit_edit'])){
	$sql -> db_Select("ab_gnl", "*", "gnl_id='$gnl_id'");
	while($row = $sql -> db_Fetch()){
		$gnl_name=$row['gnl_name'];
		$gnl_mag=$row['gnl_mag'];
		$gnl_city=$row['gnl_city'];
		$gnl_address=$row['gnl_address'];
		$gnl_site=$row['gnl_site'];
		$gnl_mail=$row['gnl_mail'];
		$gnl_icq=$row['gnl_icq'];
		$gnl_logo=$row['gnl_logo'];
		$gnl_img=$row['gnl_img'];
		$gnl_conname=$row['gnl_conname'];
		$gnl_conphone=$row['gnl_conphone'];
		$gnl_devision=$row['gnl_devision'];
		$gnl_desc=$row['gnl_desc'];
		$gnl_check_admin=$row['gnl_check_admin'];
	}
	$vis = 'yes';
	$unvis = 'none';
}
//======Update_notes======//
if (isset($_POST['submit_update'])){
	if ($gnl_name=='' || $gnl_city==''|| $gnl_address=='' || $gnl_conname=='' || $gnl_conphone=='' || $gnl_devision==''){
	$message = "<font color=red>Заполните пожалуйста все поля отмеченные знаком *</font>";
	}
	else if (isset($_FILES['file_userfile']['error'])){
		require_once(e_HANDLER."upload_handler.php");
		if ($uploaded = file_upload('/'.e_PLUGIN."abook/ab_pictures/", "attachment")){
			foreach($uploaded as $upload){
			  if ($upload['error'] == 0) {
				$ab_patch = e_PLUGIN.'abook/ab_pictures/';
				if(strstr($upload['type'], "image")){
					require_once(e_HANDLER."resize_handler.php");
					$orig_file = $upload['name'];
					$gnl_logo = $orig_file;
					$small_img = "small_$orig_file";
					if(resize_image(e_PLUGIN.'abook/ab_pictures/'.$orig_file, e_PLUGIN.'abook/ab_pictures/'.$small_img, $pref['ab_sizecat'])){
//					$parms_small = image_getsize(e_PLUGIN.'abook/ab_pictures/'.$small_img);
//					$parms_big = image_getsize(e_PLUGIN.'abook/ab_pictures/'.$big_img);
					}
					if(resize_image(e_PLUGIN.'abook/ab_pictures/'.$orig_file, e_PLUGIN.'abook/ab_pictures/'.$orig_file, $pref['ab_sizepicbig'])){
//					$parms = image_getsize(e_PLUGIN.'abook/ab_pictures/'.$big_img);
//					$gnl_pic1 = $orig_file;
					}
				}
				else{	//upload was not an image, link to file
					$_POST['post'] .= "[br][file=".$ab_patch.$upload['name']."]".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."[/file]";
				}
			  }
			  else{  // Error in uploaded file
			    echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
			  }
			}
		}
	$sql -> db_Update("ab_gnl", "gnl_name='$gnl_name', gnl_mag='$gnl_mag', gnl_city='$gnl_city', gnl_address='$gnl_address', gnl_site='$gnl_site',gnl_mail='$gnl_mail', gnl_icq='$gnl_icq', gnl_conname='$gnl_conname', gnl_conphone='$gnl_conphone', gnl_logo='$gnl_logo', gnl_devision='$gnl_devision', gnl_desc='$gnl_desc',gnl_check_admin='$gnl_check_admin' WHERE gnl_id='$gnl_id'");
		$message = "<font color=red>Объявление обновлено</font>$gnl_id;$gnl_sub_id;$gnl_name;$gnl_city;$gnl_cat;$gnl_conname;$gnl_conphone;$gnl_devision;";
	}
	else if ($gnl_logo==''){
	$sql -> db_Update("ab_gnl", "gnl_name='$gnl_name', gnl_city='$gnl_mag', gnl_city='$gnl_city', gnl_address='$gnl_address', gnl_site='$gnl_site',gnl_mail='$gnl_mail', gnl_icq='$gnl_icq', gnl_conname='$gnl_conname', gnl_conphone='$gnl_conphone', gnl_devision='$gnl_devision', gnl_desc='$gnl_desc',gnl_check_admin='$gnl_check_admin' WHERE gnl_id='$gnl_id'");
		$message = "<font color=red>Объявление обновлено</font>$gnl_id;$gnl_sub_id;$gnl_name;$gnl_city;$gnl_cat;$gnl_conname;$gnl_conphone;$gnl_devision;";
	}
	$ns -> tablerender(LAN_AB_MES_00, $message);
	$gnl_id=$gnl_name=$gnl_desc=$gnl_icon='';
	$vis = 'none';
	$unvis = 'yes';
}
//======Delete_notes======//	
if (isset($_POST['submit_delete'])){
	$sql -> db_Select("ab_gnl", "*", "gnl_id='$gnl_id'");
 		while($row = $sql -> db_Fetch()){
			$gnl_logo=$row['gnl_logo'];
		}
		if (!$gnl_logo == ''){
		unlink("".e_PLUGIN."abook/ab_pictures/small_$gnl_logo");
		unlink("".e_PLUGIN."abook/ab_pictures/$gnl_logo");
	}
	$sql -> db_Delete("ab_gnl", "gnl_id=$gnl_id");
	$message = "<font color=red>Объявление удалено</font>";
	$ns -> tablerender(LAN_AB_MES_00, $message);
}
//===================form check, edit or delete of new notice====================
		$text .="<form  method='post' enctype='multipart/form-data' name='form_select_new' id='form_select' action=''>
			<table class='border' style='width:100%' align='center'>
			<td class='fcaption'>".LAN_AB_MAN_ORG_NEW." <select class='tbox' name='gnl_id'>";
			$sql -> db_Select("ab_gnl", "*", "gnl_check_admin='".LAN_AB_SEL_NO."'");
				while($row = $sql -> db_Fetch()){
					$gnlId = $row['gnl_id'];
					$gnlName=$row['gnl_name'];
				$text .="<option value='$gnlId'>$gnlName</option>";
				}
	$text .="</select> 
	<input class='button' type='submit' style='cursor:pointer;' name='submit_edit' value='".LAN_AB_BUT_EDIT."'>
	<input class='button' type='submit' style='cursor:pointer;' name='submit_delete' value='".LAN_AB_BUT_DEL."' onclick='return confirmDeleteNotice();'>
	</td></table></form>";
//===================form check, edit or delete of old notice====================
		$text .="<form  method='post' enctype='multipart/form-data' name='form_select_old' id='form_select' action=''>
			<table class='border' style='width:100%' align='center'>
			<td class='fcaption'>".LAN_AB_MAN_ORG_OLD." <select class='tbox' name='gnl_id'>";
			$sql -> db_Select("ab_gnl", "*", "gnl_check_admin='".LAN_AB_SEL_YES."'");
				while($row = $sql -> db_Fetch()){
					$gnlId = $row['gnl_id'];
					$gnlName=$row['gnl_name'];
				$text .="<option value='$gnlId'>$gnlName</option>";
				}
	$text .="</select> 
	<input class='button' type='submit' style='cursor:pointer;' name='submit_edit' value='".LAN_AB_BUT_EDIT."'>
	<input class='button' type='submit' style='cursor:pointer;' name='submit_delete' value='".LAN_AB_BUT_DEL."' onclick='return confirmDeleteNotice();'>
	</td></table></form>";
//==========================Form_add=============================
$text .="<form method='post' enctype='multipart/form-data' name='form_add' id='form_add' style='border:0;float:top;' action=''>
<table><tr><td><img src='images/img_abook.png' alt='".LAN_AB_ALT_1."'></td><td>".LAN_AB_MAN_PR1."</td></tr></table>";

$text .="<table>";
	$text .="<tr><td></td><td><input class='tbox'  type='hidden' name='gnl_id' value='$gnl_id' maxlength='200'/></td>";

	$text .="<tr><td></td><td><input class='tbox'  type='hidden' name='gnl_cat' value='$gnl_cat' maxlength='200'/></td>";

	$text .="<tr><td>".LAN_AB_ADD_name." *</td><td><input class='tbox' type='text' name='gnl_name' oablur='checkname()' size='50' value='$gnl_name' maxlength='200'/><span id='check_name'></span></td>";

	$text .="<tr><td>".LAN_AB_ADD_mag."</td><td><input class='tbox' type='text' name='gnl_mag' size='50' value='$gnl_mag' maxlength='200'/></td>";

	$text .="<tr><td>".LAN_AB_ADD_city." *</td><td><input class='tbox' type='text' name='gnl_city' oablur='checkcity()' size='50' value='$gnl_city' maxlength='200'/><span id='check_city'></span></td>";

	$text .="<tr><td>".LAN_AB_ADD_address." *</td><td><input class='tbox' type='text' name='gnl_address' oablur='checkaddress()' size='50' value='$gnl_address' maxlength='200'/><span id='check_address'></span></td>";
	
//	$text .="<tr><td>".LAN_AB_cat."</td><td><input class='tbox' type='text' name='gnl_cat' size='50' value='$gnl_cat' maxlength='200'/></td>";

	$text .="<tr><td>".LAN_AB_ADD_site."</td><td><input class='tbox' type='text' name='gnl_site' size='50' value='$gnl_site' maxlength='200'/></td>";

	$text .="<tr><td>".LAN_AB_ADD_mail."</td><td><input class='tbox' type='text' name='gnl_mail' size='50' value='$gnl_mail' maxlength='200'/></td>";

	$text .="<tr><td>".LAN_AB_ADD_icq."</td><td><input class='tbox' type='text' name='gnl_icq' size='50' value='$gnl_icq' maxlength='200'/></td>";

	$text .="<tr><td>".LAN_AB_ADD_conname." *</td><td><input class='tbox' type='text' name='gnl_conname' oablur='checkconname()' size='50' value='$gnl_conname' maxlength='200'/><span id='check_conname'></span></td>";

	$text .="<tr><td>".LAN_AB_ADD_conphone." *</td><td><input class='tbox' type='text' name='gnl_conphone' oablur='checkconphone()' size='50' value='$gnl_conphone' maxlength='200'/><span id='check_conphone'></span></td>";

 	if (!FILE_UPLOADS){
		$text .= "<b>".LAN_AB_UPLOAD_SERVEROFF."</b>";
	}else{	
		if (!is_writable(e_PLUGIN."abook/ab_pictures/")){
			$text .= LAN_AB_UPLOAD_777."<b>".str_replace("../","",e_PLUGIN."abook/ab_pictures/")."</b><br /><br />";
		}
	$text .= "<tr><td>".LAN_AB_ADD_logo."</td>
	<td><input class='tbox' name='file_userfile[]' type='file' size='30'></td></tr>";
	}
if (!FILE_UPLOADS){
		$text .= "<b>".LAN_AB_UPLOAD_SERVEROFF."</b>";
	}else{	
		if (!is_writable(e_PLUGIN."abook/ab_pictures/")){
			$text .= LAN_AB_UPLOAD_777."<b>".str_replace("../","",e_PLUGIN."abook/ab_pictures/")."</b><br /><br />";
		}
//	$text .= "<tr><td>".LAN_AB_ADD_img."</td>	<td><input class='tbox' name='file_userfile[]' type='file' size='30'></td></tr>";
	}

	$text .="<tr><td>".LAN_AB_ADD_devision." *</td><td><textarea cols=48 rows=10 class='tbox' type='text' name='gnl_devision' oablur='checkdevision()' maxlength='500'/>$gnl_devision</textarea><span id='check_devision'></span></td>";

	$text .="<tr><td>".LAN_AB_ADD_desc."</td><td><textarea cols=48 rows=10 class='tbox' type='text' name='gnl_desc' maxlength='500'/>$gnl_desc</textarea></td>";

	$text .="<tr><td>".LAN_AB_check_admin."</td><td><select class='tbox' name='gnl_check_admin'>";
				$text .="<option value='$gnl_check_admin'>$gnl_check_admin</option>";
				$text .="<option value=".LAN_AB_SEL_YES.">".LAN_AB_SEL_YES."</option>";
				$text .="<option value=".LAN_AB_SEL_NO.">".LAN_AB_SEL_NO."</option>";
	$text .="</select></td>";
	$text .="<tr><td>".LAN_AB_check_cat."</td><td><input class='tbox' type='text' name='gnl_check_cat' size='50' value='$gnl_check_cat' maxlength='200'/></td>";

//	$text .="<tr><td>".LAN_AB_check_antibot."</td><td><input class='tbox' type='text' name='gnl_check_antibot' size='50' value='$gnl_antibot' maxlength='200'/></td>";

$text .="</table>";

$text .= "<table class='fcaption' style='width:100%'><tr><td align='right'>
	<input type='submit' class='button' style='cursor:pointer;display:$unvis;' name='submit_insert' value='".LAN_AB_BUT_ADD."'  onClick='f_submit_add()'>
	<input type='submit' class='button' style='cursor:pointer;display:$unvis;' name='submit_reset' value='".LAN_AB_BUT_RES."'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis;' name='submit_update' value='".LAN_AB_BUT_UPD."' onClick='f_submit_add()'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis;' name='submit_reset' value='".LAN_AB_BUT_CANS."'>
	</td></tr></table>
</form>";
$caption = LAN_AB_BAN_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           ADMIN_CONFIG OPTIONS MENU
// =================================================================================================
if(!isset($qs[0]) || (isset($qs[0]) && $qs[0] == "config")){
//======UPDATE========//
if(IsSet($_POST['savesettings'])){
	$pref['ab_admail'] = $_POST['ab_admail'];
	$pref['ab_days'] = $_POST['ab_days'];
	$pref['ab_prolong'] = $_POST['ab_prolong'];
	$pref['ab_dateformat'] = $_POST['ab_dateformat'];
	$pref['ab_sizepicbig'] = $_POST['ab_sizepicbig'];
	$pref['ab_sizepicsmall'] = $_POST['ab_sizepicsmall'];
	$pref['ab_showcols'] = $_POST['ab_showcols'];
	$pref['ab_showrows'] = $_POST['ab_showrows'];
	save_prefs();
	$message = LAN_AB_MES_14;
	$ns -> tablerender(LAN_AB_MES_00, $message);
}
	$text .="<form enctype='multipart/form-data' name='form_config' method='post' action=''><table class='fborder' style='width:100%' align='center'>";
        $text .= "<tr><td class='forumheader3' width='60%'>".LAN_AB_CONF_01."</td><td class='forumheader3'><input class='tbox' size='40' type='text' name='ab_admail' value='".$pref['ab_admail']."'></input></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_02."</td><td class='forumheader3'><input type='text' name='ab_days' class='tbox' value='".$pref['ab_days']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_10."</td><td class='forumheader3'><input type='text' name='ab_prolong' class='tbox' value='".$pref['ab_prolong']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_03."</td>
	<td class='forumheader3'><select class='tbox' type='text' name='ab_dateformat'>
		<option value='".$pref['ab_dateformat']."'>".$pref['ab_dateformat']."
		<option value=".LAN_AB_FDATE_01.">".LAN_AB_RDATE_01."
		<option value=".LAN_AB_FDATE_01.">".LAN_AB_RDATE_02."
	</select></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_04."</td><td class='forumheader3'><input type='text' name='ab_sizepicbig' class='tbox' value='".$pref['ab_sizepicbig']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_05."</td><td class='forumheader3'><input type='text' name='ab_sizepicsmall' class='tbox' value='".$pref['ab_sizepicsmall']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_06."</td><td class='forumheader3'><input type='text' name='ab_showcols' class='tbox' value='".$pref['ab_showcols']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_AB_CONF_07."</td><td class='forumheader3'><input type='text' name='ab_showrows' class='tbox' value='".$pref['ab_showrows']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader' colspan='2' style='text-align:center'><input class='button' name='savesettings' type='submit' value= ".LAN_AB_BUT_AGR."></td></tr></table></form>";
$caption = LAN_AB_CONF_00;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//				           ABOUT PLUGIN
// =================================================================================================
if(!isset($qs[0]) || (isset($qs[0]) && $qs[0] == "about")){
$text="<table><tr>";
$text.="<td><a href='http://e107.compolys.ru'><img src='".e_PLUGIN."abook/theme/logo_compolys.png' alt='".LAN_AB_INFO."'></a>";
$text.= "<td align='center'> Notice-Board v3.0
<br>author - ComPolyS, http://e107.compolys.ru, e107@compolys.ru
<br>coder - Sunout sunout@compolys.ru, license GNU GPL
<br>==================== July 2011============================";
$text.="</tr></table>";
$text.="<b>".LAN_AB_ABO_00."</b><br>";
$text.="".LAN_AB_ABO_01."<br>";
$text.="".LAN_AB_ABO_02."<br>";
$text.="".LAN_AB_ABO_03."<br>";
$text.="".LAN_AB_ABO_04."<br>";
$text.="".LAN_AB_ABO_05."<br>";
$text.="".LAN_AB_ABO_06."<br>";
$text.="".LAN_AB_ABO_07."<br>";
$text.="".LAN_AB_ABO_08."<br>";
$text.="".LAN_AB_ABO_09."<br>";
$text.="".LAN_AB_ABO_10."<br>";
$text.="".LAN_AB_ABO_11."<br>";
$text.="".LAN_AB_ABO_12."<br>";
$text.="".LAN_AB_ABO_13."<br>";
$text.="".LAN_AB_ABO_14."<br>";
$text.="".LAN_AB_ABO_15."<br>";
$text.="".LAN_AB_ABO_16."<br>";
$text.="".LAN_AB_ABO_17."<br>";
$text.="".LAN_AB_ABO_18."<br>";
$text.="".LAN_AB_ABO_19."<br>";
$text.="<font color=blue>".LAN_AB_ABO_INFO."</font><br>";
$text.="<b>".LAN_AB_ABO_20."</b><br>";
$text.="".LAN_AB_ABO_21."<br>";
$text.="".LAN_AB_ABO_22."<br>";
$text.="".LAN_AB_ABO_23."<br>";
$text.="".LAN_AB_ABO_24."<br>";
$text.="".LAN_AB_ABO_25."<br>";
$text.="".LAN_AB_ABO_26."<br>";
$text.="".LAN_AB_ABO_27."<br>";
$text.="".LAN_AB_ABO_28."<br>";
$text.="".LAN_AB_ABO_29."<br>";
$caption = LAN_AB_ABO_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
require_once(e_ADMIN."footer.php");
function admin_config_adminmenu()
{
		if (e_QUERY) {
			$qs = explode(".", e_QUERY);
			$cat_action = $qs[0];
		}
		if (!isset($cat_action) || ($cat_action == ""))
		{
		  $cat_action = "manager";
		}
		$var['cat']['text'] = LAN_AB_MENU_CAT;
		$var['cat']['link'] ="admin_config.php?cat";
		$var['manager']['text'] = LAN_AB_MENU_MAN;
		$var['manager']['link'] ="admin_config.php?manager";
		$var['options']['text'] = LAN_AB_MENU_OPTIONS;
		$var['options']['link'] = "admin_config.php";
		$var['about']['text'] = LAN_AB_MENU_ABOUT;
		$var['about']['link'] ="admin_config.php?about";
		show_admin_menu(LAN_AB_MENU_CAP, $cat_action, $var);
}
?>