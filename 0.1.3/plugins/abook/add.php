<?php
/*=================================Addresss Book 1.0=============================
|  author - Web Studio "ComPolyS", http://e107.compolys.ru, sunout@compolys.ru	|
|  GNU General Public License (http://gnu.org)					|
====================================may 2011===================================*/
if (USER==FALSE){
	$text =AB_ADD_MesNoReg;
	$text .=AB_ADD_AReg;
	}
if (USER==TRUE){

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
	$message = "<font color=blue>".AB_MES_21."</font>";
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
	$gnl_check_admin=AB_SEL_NO;
	$sql -> db_Insert("ab_gnl", "0,'$gnl_cat', '$gnl_name','$gnl_mag','$gnl_city','$gnl_address','$gnl_site','$gnl_mail','$gnl_icq','$gnl_user','$gnl_conname','$gnl_conphone','$gnl_logo','$gnl_img','$gnl_devision','$gnl_desc','$gnl_check_admin'");
	 $message = "".AB_MES_19." <br><font color=red>".AB_MES_20."</font>";   //$gnl_name=$gnl_city=$gnl_address=$gnl_cat=$gnl_site=$gnl_mail=$gnl_icq=$gnl_phone=$gnl_conname=$gnl_conphone=$gnl_logo=$gnl_img=$gnl_devision=$gnl_desc='';
	//header ("Location: ".e_PLUGIN."abook/abook.php?add");
	//exit;
	}
	$ns -> tablerender(AB_MES_00, $message);
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
	}
	$vis = 'yes';
	$unvis = 'none';
}
//======Update_notes======//
if (isset($_POST['submit_update'])){
	if ($gnl_name=='' || $gnl_city==''|| $gnl_address=='' || $gnl_conname=='' || $gnl_conphone=='' || $gnl_devision==''){
	$message = "<font color=red>Заполните пожалуйста все поля отмеченные знаком *</font>";
	}
	else {
	$sql -> db_Update("ab_gnl", "gnl_name='$gnl_name', gnl_city='$gnl_mag', gnl_city='$gnl_city', gnl_address='$gnl_address', gnl_site='$gnl_site',gnl_icq='$gnl_icq', gnl_conname='$gnl_conname', gnl_conphone='$gnl_conphone', gnl_devision='$gnl_devision', gnl_desc='$gnl_desc' WHERE gnl_id='$gnl_id'");
		$message = "<font color=red>Объявление обновлено</font>$gnl_id;$gnl_sub_id;$gnl_name;$gnl_city;$gnl_cat;$gnl_conname;$gnl_conphone;$gnl_devision;";
	}
	$ns -> tablerender(AB_MES_00, $message);
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
	$ns -> tablerender(AB_MES_00, $message);
}
//========================================form edit and delete====================

	$gnl_user=USERNAME;
		$text .="<form  method='post' enctype='multipart/form-data' name='form_select' id='form_select' action=''>
			<table class='border' style='width:100%' align='center'>
			<td class='fcaption'>".AB_ADD_org." <select class='tbox' name='gnl_id'>";
			$sql -> db_Select("ab_gnl", "*", "gnl_user='$gnl_user'");
				while($row = $sql -> db_Fetch()){
					$gnlId = $row['gnl_id'];
					$gnlName=$row['gnl_name'];
				$text .="<option value='$gnlId'>$gnlName</option>";
				}
	$text .="</select> 
	<input class='button' type='submit' style='cursor:pointer;' name='submit_edit' value='".AB_BUT_EDIT."'>
	<input class='button' type='submit' style='cursor:pointer;' name='submit_delete' value='".AB_BUT_DEL."' onclick='return confirmDeleteNotice();'>
	</td></table></form>";
//==========================Form_add=============================
$text .="<form method='post' enctype='multipart/form-data' name='form_add' id='form_add' style='border:0;float:top;' action=''>
<table><tr><td><img src='images/img_abook.png' alt='".AB_ALT_1."'></td><td>".AB_ADD_PR1."</td></tr></table>";

$text .="<table>";
	$text .="<tr><td></td><td><input class='tbox'  type='hidden' name='gnl_id' value='$gnl_id' maxlength='200'/></td>";

	$text .="<tr><td></td><td><input class='tbox'  type='hidden' name='gnl_cat' value='$gnl_cat' maxlength='200'/></td>";

	$text .="<tr><td>".AB_ADD_name." *</td><td><input class='tbox' type='text' name='gnl_name' onblur='checkname()' size='50' value='$gnl_name' maxlength='200'/><span id='check_name'></span></td>";

	$text .="<tr><td>".AB_ADD_mag."</td><td><input class='tbox' type='text' name='gnl_mag' size='50' value='$gnl_mag' maxlength='200'/></td>";

	$text .="<tr><td>".AB_ADD_city." *</td><td><input class='tbox' type='text' name='gnl_city' onblur='checkcity()' size='50' value='$gnl_city' maxlength='200'/><span id='check_city'></span></td>";

	$text .="<tr><td>".AB_ADD_address." *</td><td><input class='tbox' type='text' name='gnl_address' onblur='checkaddress()' size='50' value='$gnl_address' maxlength='200'/><span id='check_address'></span></td>";
	
//	$text .="<tr><td>".AB_cat."</td><td><input class='tbox' type='text' name='gnl_cat' size='50' value='$gnl_cat' maxlength='200'/></td>";

	$text .="<tr><td>".AB_ADD_site."</td><td><input class='tbox' type='text' name='gnl_site' size='50' value='$gnl_site' maxlength='200'/></td>";

	$text .="<tr><td>".AB_ADD_mail."</td><td><input class='tbox' type='text' name='gnl_mail' size='50' value='$gnl_mail' maxlength='200'/></td>";

	$text .="<tr><td>".AB_ADD_icq."</td><td><input class='tbox' type='text' name='gnl_icq' size='50' value='$gnl_icq' maxlength='200'/></td>";

	$text .="<tr><td>".AB_ADD_conname." *</td><td><input class='tbox' type='text' name='gnl_conname' onblur='checkconname()' size='50' value='$gnl_conname' maxlength='200'/><span id='check_conname'></span></td>";

	$text .="<tr><td>".AB_ADD_conphone." *</td><td><input class='tbox' type='text' name='gnl_conphone' onblur='checkconphone()' size='50' value='$gnl_conphone' maxlength='200'/><span id='check_conphone'></span></td>";

 	if (!FILE_UPLOADS){
		$text .= "<b>".LAN_UPLOAD_SERVEROFF."</b>";
	}else{	
		if (!is_writable(e_PLUGIN."abook/ab_pictures/")){
			$text .= LAN_UPLOAD_777."<b>".str_replace("../","",e_PLUGIN."abook/ab_pictures/")."</b><br /><br />";
		}
	$text .= "<tr><td>".AB_ADD_logo."</td>
	<td><input class='tbox' name='file_userfile[]' type='file' size='30'></td></tr>";
	}
if (!FILE_UPLOADS){
		$text .= "<b>".LAN_UPLOAD_SERVEROFF."</b>";
	}else{	
		if (!is_writable(e_PLUGIN."abook/ab_pictures/")){
			$text .= LAN_UPLOAD_777."<b>".str_replace("../","",e_PLUGIN."abook/ab_pictures/")."</b><br /><br />";
		}
//	$text .= "<tr><td>".AB_ADD_img."</td>	<td><input class='tbox' name='file_userfile[]' type='file' size='30'></td></tr>";
	}

	$text .="<tr><td>".AB_ADD_devision." *</td><td><textarea cols=48 rows=10 class='tbox' type='text' name='gnl_devision' onblur='checkdevision()' maxlength='500'/>$gnl_devision</textarea><span id='check_devision'></span></td>";

	$text .="<tr><td>".AB_ADD_desc."</td><td><textarea cols=48 rows=10 class='tbox' type='text' name='gnl_desc' maxlength='500'/>$gnl_desc</textarea></td>";

//	$text .="<tr><td>".AB_check_admin."</td><td><input class='tbox' type='text' name='gnl_check_admin' size='50' value='$gnl_check_admin' maxlength='200'/></td>";

//	$text .="<tr><td>".AB_check_cat."</td><td><input class='tbox' type='text' name='gnl_check_cat' size='50' value='$gnl_check_cat' maxlength='200'/></td>";

//	$text .="<tr><td>".AB_check_antibot."</td><td><input class='tbox' type='text' name='gnl_check_antibot' size='50' value='$gnl_antibot' maxlength='200'/></td>";
$text .="</table>";

$text .= "<table class='fcaption' style='width:100%'><tr><td align='right'>
	<input type='submit' class='button' style='cursor:pointer;display:$unvis;' name='submit_insert' value='".AB_BUT_ADD."'  onClick='f_submit_add()'>
	<input type='submit' class='button' style='cursor:pointer;display:$unvis;' name='submit_reset' value='".AB_BUT_RES."'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis;' name='submit_update' value='".AB_BUT_UPD."' onClick='f_submit_add()'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis;' name='submit_reset' value='".AB_BUT_CANS."'>
	</td></tr></table>
</form>";
}

$caption = AB_ADD_CAP;

?>