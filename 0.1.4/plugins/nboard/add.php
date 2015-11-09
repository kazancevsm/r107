<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/
	
	$catlink =" - <a href='".e_PLUGIN."md_nboard/nboard.php?page=add'> ".NB_ADD_CAP."</a>";
	$vis = 'none';
	$unvis = 'yes';
//======Configuration====//
	$conf_days = $pref['nb_days'];
	$conf_check_que = $pref['nb_check_que'];
	$conf_check_ans = $pref['nb_check_ans'];
//======Date=============//
	$month = date("m");
	$day = date("d");
	$year = date("y");
	$gnl_date_start = mktime(0,0,0,$month,$day,$year);
	$conf_days = $conf_days * 86400;
	$gnl_date_end = $gnl_date_start + $conf_days;

//======Edit_notes======//
if(IsSet($action) && $action=='edit'){
	$nbsql -> db_Select("nb_gnl", "*", "gnl_id='$id'");
	while($row = $nbsql -> db_Fetch()){
		$gnl_id = $row['gnl_id'];
		$gnl_scatid = $row['gnl_scatid'];
		$gnl_name = $row['gnl_name'];
		$gnl_city = $row['gnl_city'];
		$gnl_pic = $row['gnl_pic'];
		$gnl_detail = $row['gnl_detail'];
		$gnl_price = $row['gnl_price'];
		$gnl_user = $row['gnl_user'];
		$gnl_phone = $row['gnl_phone'];
		$gnl_email = $row['gnl_email'];
		$gnl_date_start = $row['gnl_date_start'];
		$gnl_date_end =$row['gnl_date_end'];
		$gnl_pic = explode(",", $gnl_pic);
		}
	$vis = 'yes';
	$unvis = 'none';
	$text .='<img src=/'.e_PLUGIN.'md_nboard/nb_pictures/small_'.$gnl_pic['0'].'>';
	$text .='<img src=/'.e_PLUGIN.'md_nboard/nb_pictures/small_'.$gnl_pic['1'].'>';
	$text .='<img src=/'.e_PLUGIN.'md_nboard/nb_pictures/small_'.$gnl_pic['2'].'>';
	$text .='<img src=/'.e_PLUGIN.'md_nboard/nb_pictures/small_'.$gnl_pic['3'].'>';
	$text .='<img src=/'.e_PLUGIN.'md_nboard/nb_pictures/small_'.$gnl_pic['4'].'>';
	$text .='<img src=/'.e_PLUGIN.'md_nboard/nb_pictures/small_'.$gnl_pic['5'].'>';
}
//file_userfile[]='$gnl_pic',
//======Update_notes======//
if (isset($_POST['submit_update'])){
	$gnl_id = $_POST['gnl_id'];
	$gnl_scatid = $_POST['gnl_scatid'];
	$gnl_name = $_POST['gnl_name'];
	$gnl_user = $_POST['gnl_user'];
	$gnl_city = $_POST['gnl_city'];
	$gnl_phone = $_POST['gnl_phone'];
	$gnl_email = $_POST['gnl_email'];
	$gnl_pic =  $_POST['file_userfile'];
	$gnl_detail = $_POST['gnl_detail'];
	$gnl_price = $_POST['gnl_price'];
	$gnl_date_start = $_POST['gnl_date_start'];
	$gnl_date_end = $_POST['gnl_date_end'];
	$cat_id = $_POST['cat_id'];
	$cat_name = $_POST['cat_name'];
	$cat_sub_id = $_POST['cat_sub_id'];
	$gnl_check = $_POST['gnl_check'];
	$conf_check_que = $_POST['conf_check_que'];
	$conf_check_ans = $_POST['conf_check_ans'];
	if ($cat_sub_id=='' || $gnl_name=='' || $gnl_phone=='' || $gnl_city=='' || $gnl_detail=='' || $gnl_price==''){
		$message = "<font color=red>".NB_MES_21."</font>";
	} 
	if (!$cat_sub_id=='' && !$gnl_name=='' && !$gnl_phone=='' && !$gnl_city=='' && !$gnl_detail=='' && !$gnl_price=='') {
		$nbsql -> db_Update("nb_gnl", "gnl_scatid='$cat_sub_id', gnl_name='$gnl_name', gnl_city='$gnl_city', gnl_detail='$gnl_detail', gnl_price='$gnl_price', gnl_user='$gnl_user', gnl_phone='$gnl_phone', gnl_email='$gnl_email', gnl_date_start='$gnl_date_start', gnl_date_end='$gnl_date_end' WHERE gnl_id='$gnl_id'");
//		$message = "<font color=red>".NB_MES_22."</font>";
//		$message = "<font color=red>$cat_sub_id, $gnl_name, $gnl_city, $gnl_detail, $gnl_price, $gnl_user, $gnl_phone, $gnl_email, $gnl_date_start/$gnl_date_end, $gnl_id</font>";
	}
	$ns -> tablerender(NB_MES_00, $message);
	$cat_id=$cat_name=$cat_desc=$cat_icon='';
	$vis = 'none';
	$unvis = 'yes';
	}
	
//======Insert_notes======//
if (IsSet($_POST['submit_add'])){
	$gnl_id = $_POST['gnl_id'];
	$gnl_scatid = $_POST['gnl_scatid'];
	$gnl_name = $_POST['gnl_name'];
	$gnl_user = $_POST['gnl_user'];
	$gnl_city = $_POST['gnl_city'];
	$gnl_phone = $_POST['gnl_phone'];
	$gnl_email = $_POST['gnl_email'];
	$gnl_pic =  $_POST['file_userfile'];
	$gnl_detail = $_POST['gnl_detail'];
	$gnl_price = $_POST['gnl_price'];
	$gnl_date_start = $_POST['gnl_date_start'];
	$gnl_date_end = $_POST['gnl_date_end'];
	$cat_id = $_POST['cat_id'];
	$cat_name = $_POST['cat_name'];
	$cat_sub_id = $_POST['cat_sub_id'];
	$gnl_check = $_POST['gnl_check'];
	$conf_check_que = $_POST['conf_check_que'];
	$conf_check_ans = $_POST['conf_check_ans'];
	
	
	
//======check empty============//
	if ($cat_sub_id=='' || $gnl_name=='' || $gnl_phone=='' || $gnl_city=='' || $gnl_detail=='' || $gnl_price=='' || $gnl_check <> $conf_check_ans){
	$message = "<font color=red>".NB_MES_21."</font>";
	}
	if (!$cat_sub_id=='' && !$gnl_name=='' && !$gnl_phone=='' && !$gnl_city=='' && !$gnl_detail=='' && !$gnl_price=='' && $gnl_check == $conf_check_ans){
	
	$cnt = count($gnl_pic);
	if($cnt < 6){
		$gnl_pic = array_merge($gnl_pic, array_fill($cnt, 6 - $cnt, ''));
	}
	
	if (isset($_FILES['file_userfile']['error'])){
		require_once(e_HANDLER."upload_handler.php");
		if ($uploaded = file_upload('/'.e_PLUGIN."md_nboard/nb_pictures/", "attachment")){
			 	foreach($uploaded as $name){
				if ($name['error'] == 0 ) {
				$orig_file = $name['name'];
			$gnl_pic[] = $orig_file;
			$nb_patch = e_PLUGIN.'md_nboard/nb_pictures/';
				if(strstr($name['type'], "image")){
					require_once(e_HANDLER."resize_handler.php");
					$small_img = "small_$orig_file";
//					$big_img = "big_$orig_file";
					if(resize_image(e_PLUGIN.'md_nboard/nb_pictures/'.$orig_file, e_PLUGIN.'md_nboard/nb_pictures/'.$small_img, $pref['nb_sizepicsmall'])){
//					$parms_small = image_getsize(e_PLUGIN.'md_nboard/nb_pictures/'.$small_img);
//					$parms_big = image_getsize(e_PLUGIN.'md_nboard/nb_pictures/'.$big_img);
					}
					if(resize_image(e_PLUGIN.'md_nboard/nb_pictures/'.$orig_file, e_PLUGIN.'md_nboard/nb_pictures/'.$orig_file, $pref['nb_sizepicbig'])){
//					$parms = image_getsize(e_PLUGIN.'md_nboard/nb_pictures/'.$big_img);
//					$gnl_pic = $orig_file;
					}
				}
				else{	//upload was not an image, link to file
					$_POST['post'] .= "[br][file=".$nb_patch.$upload['name']."]".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."[/file]";
				}
			  }
			  else{  // Error in uploaded file
			    echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
			  }
			}
		}
	}
	
	$gnl_pic = implode(',', $gnl_pic);
	/*
	else{  // Error in uploaded file
			   	  //echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
		} */
	$first_letter = mb_substr($gnl_name,0,1, CHARSET);//первая буква
	$last_letter = mb_substr($gnl_name,1);//все кроме первой буквы
	$first_letter = mb_strtoupper($first_letter, CHARSET);
	$last_letter = mb_strtolower($last_letter, CHARSET);
	$gnl_name = $first_letter.$last_letter;
	
	$new_gnl_name = $tp->toDB($gnl_name);
	$new_gnl_city = $tp->toDB($gnl_city);
	$new_gnl_detail = $tp->toDB($gnl_detail);
	$new_gnl_price = $tp->toDB($gnl_price);
	$new_gnl_user = $tp->toDB($gnl_user);
	$new_gnl_phone = $tp->toDB($gnl_phone);
	$new_gnl_email= $tp->toDB($gnl_email);
	$nbsql -> db_Insert("nb_gnl", "0, '$cat_sub_id','$new_gnl_name','$new_gnl_city','$gnl_pic','$new_gnl_detail','$new_gnl_price','$new_gnl_user', '$new_gnl_phone','$new_gnl_email','$gnl_date_start','$gnl_date_end', '0'");
	$gnl_scatid=$gnl_name=$gnl_city=$gnl_picbig=$gnl_pic=$gnl_detail=$gnl_price=$gnl_user=$gnl_phone=$gnl_email=$gnl_date_start=$gnl_date_end=$conf_check_ans='';
	header ("Location: ".e_PLUGIN."md_nboard/nboard.php?page=add");
	exit;
//	$message = "<font color=red>".NB_MES_20." ".strftime('%d %b %Y',$gnl_date_end)."</font>";
//	$message = "<font color=red>".NB_MES_20."$cnt</font>";
	}
	$ns -> tablerender(NB_MES_00, $message);
}	

//========================================form add and edit=======================
$text .="<form  method='post' enctype='multipart/form-data' name='form_add' id='form_add' style='border:0;float:top;' action=''>";
$text .="<table class='border' style='width:100%' align='center'>";

$text .= "<tr><td class='forumheader3'>".NB_ADD_01." *</td>
	<td class='forumheader3'><input class='tbox' type='text' name='gnl_name' value='$gnl_name' style='width:450px' onblur='checkname()' maxlength=60> <span id='check_name'></span></td></tr>";
	
$text .="<tr><td class='forumheader2'>" .NB_ADD_02." *</td><td class='forumheader2'>
	<select class='tbox' name='cat_id' id='cat' onChange='process()' style='width:450px'>
	<option value=''>" .NB_ADD_03."";
	$sql -> db_Select("nb_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
		}
$text .="</option></select></td></tr>";
	
$text .="<tr><td class='forumheader3'>".NB_ADD_04." *</td><td class='forumheader3'>
	<select class='tbox' name='cat_sub_id' id='sub' onblur='checkcat()' value='$cat_sub_id' style='width:450px'><option value=''>".NB_ADD_05." </option></select><span id='check_subcat'></span></td></tr>";
	if (!FILE_UPLOADS){
		$text .= "<b>".LANUPLOAD_15."</b>";
	}else{	
		if (!is_writable(e_PLUGIN."md_nboard/nb_pictures/")){
			$text .= "<b>".LANUPLOAD_4."<b>";
		}
		
	$text .=  "<tr>
			<td class='forumheader2'>".NB_ADD_06." 1 (не более 1024x768)</td>
			<td class='forumheader2'><input name='file_userfile[]' type='file' size='48' />
			</td></tr>
			<tr>
			<td class='forumheader3'>".NB_ADD_06." 2 (не более 1024x768)</td>
			<td class='forumheader3'><input name='file_userfile[]' type='file' size='48' />
			</td></tr>
			<tr>
			<td class='forumheader2'>".NB_ADD_06." 3 (не более 1024x768)</td>
			<td class='forumheader2'><input name='file_userfile[]' type='file' size='48' />
			</td></tr>
			<tr>
			<td class='forumheader3'>".NB_ADD_06." 4 (не более 1024x768)</td>
			<td class='forumheader3'><input name='file_userfile[]' type='file' size='48' />
			</td></tr>
			<tr>
			<td class='forumheader2'>".NB_ADD_06." 5 (не более 1024x768)</td>
			<td class='forumheader2'><input name='file_userfile[]' type='file' size='48' />
			</td></tr>
			<tr>
			<td class='forumheader3'>".NB_ADD_06." 6 (не более 1024x768)</td>
			<td class='forumheader3'><input name='file_userfile[]' type='file' size='48' />
			</td></tr>
			";
	}
	
$text .="<tr><td class='forumheader2'>".NB_ADD_07." *</td>
	<td class='forumheader2'><textarea class='textarea' name='gnl_detail' style='width:450px' rows=10 onblur='checkdetail()' maxlength=1000>$gnl_detail</textarea> <span id='check_detail'></span></td>";
	
$text .="<tr><td class='forumheader3'>".NB_ADD_08." *</td>
	<td class='forumheader3'><input class='tbox' type='text' name='gnl_price' value='$gnl_price' style='width:450px' maxlength=20 onblur='checkprice()'> <span id='check_price'></span></td>";
if (USER==FALSE){	

$text .= "<tr><td class='forumheader2' width='30%'>".NB_ADD_09." *</td>
	<td class='forumheader2' width='70%'><input class='tbox' type='text' name='gnl_user' value='$gnl_user' style='width:450px' onblur='checkuser()'> <span id='check_user'></span></td>";
}
if (USER==TRUE){
	$gnl_user=USERNAME;
$text .="<input class='tbox' type='hidden' name='gnl_user' value='$gnl_user' style='width:450px'>";
}

$text .= "<tr><td class='forumheader3'>".NB_ADD_10." *</td>
	<td class='forumheader3'><input class='tbox' type='text' name='gnl_city' value='$gnl_city' maxlength=20 style='width:450px' onblur='checkcity()'> <span id='check_city'></span></td>";
	
$text .= "<tr><td class='forumheader2'>".NB_ADD_11." *</td>
	<td class='forumheader2'><input class='tbox' type='text' name='gnl_phone' value='$gnl_phone' style='width:450px' onblur='checkphone()'> <span id='check_phone'></span></td>";
	
if (USER==FALSE){
$text .= "<tr><td class='forumheader3'>".NB_ADD_12."</td>
	<td class='forumheader3'><input class='tbox' type='text' name='gnl_email' value='$gnl_email' style='width:450px'></td>";
}

if (USER==TRUE){
$text .= "<tr><td class='forumheader2'></td>
	<td class='forumheader2'><input type='hidden' name='gnl_email' value='".USEREMAIL."' style='width:450px'></td>";
}
//$text .= $tp->post_toHTML("{CONTACT_IMAGECODE}");
//$text .= $tp->post_toHTML("{CONTACT_IMAGECODE}");
include_once(e_HANDLER.'shortcode_handler.php');
$text .= $tp->post_toHTML("{LOGO}");

if (USER==FALSE){
	$text .="<tr><td class='forumheader3'>".NB_ADD_13." *</td>
	<td class='forumheader3'><b>$conf_check_que</b> $newtext <input class='tbox' type='text' name='gnl_check' value='$gnl_check' maxlength=100 size='10' onblur='checkans()'><span id='check_ans'></span></td>";
} 

if (USER==TRUE){
	$gnl_check = $conf_check_ans;
	$text .="<input type='hidden' name='gnl_check' value='$gnl_check'>";
}

$text .="<input type='hidden' name='gnl_id' value='$gnl_id'><input type='hidden' name='conf_check_ans' value='$conf_check_ans'>
	<input type='hidden' name='gnl_date_start' value='$gnl_date_start'>
	<input type='hidden' name='gnl_date_end' value='$gnl_date_end'>";
	
$text .="<tr><td class='forumheader2'></td><td class='forumheader2'>
	<input type='submit' class='button' style='display:$unvis;' name='submit_add' value='".NB_BUT_ADD."'  onClick='f_submit_add()'>
	<input type='reset' class='button' style='display:$unvis;' name='submit_reset' value='".NB_BUT_RES."'>
	<input type='submit' class='button' style='display:$vis;' name='submit_update' value='".NB_BUT_UPD."' onClick='f_submit_add()'>
	<input type='submit' class='button' style='display:$vis;' name='submit_reset' value='".NB_BUT_CANS."'>
	</td></tr></table></span></form>";
//	require_once(e_FILE."shortcode/batch/contact_shortcodes.php");
//	$newtext. = $tp->parseTemplate($text, TRUE, $contact_shortcodes);
//	$ns -> tablerender(LANCONTACT_02, $newtext, "contact");
?>