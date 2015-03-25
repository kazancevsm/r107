<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/
	
	$puth_pictures0 = e_PLUGIN."md_nboard/nb_pictures/";
	$puth_pictures1 = e_PLUGIN."md_nboard/nb_pictures/";
	$puth_pictures2 = e_PLUGIN."md_nboard/nb_pictures/";
	$puth_pictures3 = e_PLUGIN."md_nboard/nb_pictures/";
	$puth_pictures4 = e_PLUGIN."md_nboard/nb_pictures/";
	$puth_pictures5 = e_PLUGIN."md_nboard/nb_pictures/";
	
	$sql -> db_Select("nb_gnl", "*", "gnl_id='$id'");
	while($row = $sql -> db_Fetch()){
		$gnlScatid = $row['gnl_scatid'];
		}
	$sql -> db_Select("nb_cat", "*", "cat_id='$gnlScatid'");
                while($row = $sql-> db_Fetch()){
			$catSubId = $row['cat_sub_id'];
			$subName = $row['cat_name'];
		}
	$first_letter = mb_substr($subName,0,1, 'UTF-8');//первая буква
	$last_letter = mb_substr($subName,1);//все кроме первой буквы
	$first_letter = mb_strtoupper($first_letter, 'UTF-8');
	$last_letter = mb_strtolower($last_letter, 'UTF-8');
	$subName = $first_letter.$last_letter;
	$sublink= " - <a href='".e_PLUGIN."md_nboard/nboard.php?cat=$catSubId&scat=$gnlScatid'>$subName</a>";
	
	$sql -> db_Select("nb_cat", "*", "cat_id='$catSubId'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
		}
	$first_letter = mb_substr($catName,0,1, 'UTF-8');//первая буква
	$last_letter = mb_substr($catName,1);//все кроме первой буквы
	$first_letter = mb_strtoupper($first_letter, 'UTF-8');
	$last_letter = mb_strtolower($last_letter, 'UTF-8');
	$catName = $first_letter.$last_letter;
	$catlink = " - <a href='".e_PLUGIN."md_nboard/nboard.php?cat=$catId&scat=0'>$catName</a>";

//========================== banners ===============================//
	$now = strftime($conf_dateformat,$today);
	$sql -> db_Select("nb_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$ban_id = $row['ban_id'];
		$ban_catid = $row['ban_catid'];
		$ban_org = $row['ban_org'];
		$ban_url = $row['ban_url'];
		$ban_images = $row['ban_images'];
		$ban_datebegin = $row['ban_datebegin'];
		$ban_dateend = $row['ban_dateend'];
	if (($ban_catid == '0' && $cat == 0) && ($ban_dateend > $now || $ban_dateend = $now)) {
	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."md_nboard/banners/$ban_images' alt='$ban_org' border=0></a>";
	}
	if (($ban_catid == $cat && $cat <> 0) && ($ban_dateend > $now || $ban_dateend = $now)) {
	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."md_nboard/banners/$ban_images' alt='$ban_org' border=0></a>";
	}
	if (($ban_catid == 'all_pages') && ($ban_dateend > $now || $ban_dateend = $now)) {
	$text .= "<a href='$ban_url'><img src='".e_PLUGIN."md_nboard/banners/$ban_images' alt='$ban_org' border=0></a>";
	}
	}
	
//==================================Debug=======================================
	$text .="<table width='100%'>";
		
	$sql -> db_Select("nb_gnl", "*", "gnl_id='$id'");
	while($row = $sql -> db_Fetch()){
		$gnl_id = $row['gnl_id'];
		$gnl_name = $row['gnl_name'];
		$gnl_city = $row['gnl_city'];
		$gnl_pic = $row['gnl_pic'];
		$gnl_detail = $row['gnl_detail'];
		$gnl_user = $row['gnl_user'];
		$gnl_phone = $row['gnl_phone'];
		$gnl_email = $row['gnl_email'];
		$gnl_date_start = $row['gnl_date_start'];
		$gnl_date_end = $row['gnl_date_end'];
		$gnl_price = $row['gnl_price'];
		$gnl_counter = $row['gnl_counter'];
		$gnl_counter = $gnl_counter +1;
		$sql -> db_Update("nb_gnl", "gnl_counter='$gnl_counter' WHERE gnl_id='$gnl_id'");
	$text .="<tr><td class='fcaption' colspan=2>(№$gnl_id)  $gnl_name";
	if (ADMIN==TRUE){	
	$text .= "<div align=right style='float:right;top:0px;right:0px;'><a href='".e_PLUGIN."md_nboard/admin_config.php?notice.edit.$id' style='cursor:pointer;'><img src='".e_IMAGE."admin_images/edit_16.png'></a></div>";
	}
	
	$text .="</td></tr>";
//	list($gnl_pic, $gnl_pic2, $gnl_pic3, $gnl_pic4, $gnl_pic5, $gnl_pic6) = explode("," , $gnl_pic);
	$gnl_pic = explode(",", $gnl_pic);
	
	if ($gnl_pic[0] == "") {
	$puth_pictures0 = "".e_PLUGIN."md_nboard/theme/";
	$gnl_pic[0] = 'photo_emp_big.png';
	}
	if ($gnl_pic[1] == "") {
	$puth_pictures1 = "".e_PLUGIN."md_nboard/theme/";
	$gnl_pic[1] = 'photo_emp_big.png';
	}
	if ($gnl_pic[2] == "") {
	$puth_pictures2 = "".e_PLUGIN."md_nboard/theme/";
	$gnl_pic[2] = 'photo_emp_big.png';
	}
	if ($gnl_pic[3] == "") {
	$puth_pictures3 = "".e_PLUGIN."md_nboard/theme/";
	$gnl_pic[3] = 'photo_emp_big.png';
	}
	if ($gnl_pic[4] == "") {
	$puth_pictures4 = "".e_PLUGIN."md_nboard/theme/";
	$gnl_pic[4] = 'photo_emp_big.png';
	}
	if ($gnl_pic[5] == "") {
	$puth_pictures5 = "".e_PLUGIN."md_nboard/theme/";
	$gnl_pic[5] = 'photo_emp_big.png';
	}
	$text .="<tr><td class='forumheader2' rowspan='7'>
		    <div id='container'>
			<div id='big_picture_default'>
			    <img src='$puth_pictures0$gnl_pic[0]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='big_picture_show0'>
			    <img src='$puth_pictures0$gnl_pic[0]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='big_picture_show1'>
			    <img src='$puth_pictures1$gnl_pic[1]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='big_picture_show2'>
			    <img src='$puth_pictures2$gnl_pic[2]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='big_picture_show3'>
			    <img src='$puth_pictures3$gnl_pic[3]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='big_picture_show4'>
			    <img src='$puth_pictures4$gnl_pic[4]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='big_picture_show5'>
			    <img src='$puth_pictures5$gnl_pic[5]' width=490px alt='".SITENAME." $catName $gnl_name'>
			</div>
			<div id='mini_picture0'>
				<a href='' onmouseover=\"document.getElementById('big_picture_show0').style.display='block'; return false;\" onmouseout=\"document.getElementById('big_picture_show0').style.display='none'; return false;\">
				<img src='$puth_pictures0$gnl_pic[0]' width=80px alt='".SITENAME." $catName $gnl_name'></a>
			</div>
			<div id='mini_picture1'>
				<a href='' onmouseover=\"document.getElementById('big_picture_show1').style.display='block'; return false;\" onmouseout=\"document.getElementById('big_picture_show1').style.display='none'; return false;\">
				<img src='$puth_pictures1$gnl_pic[1]' width=80px alt='".SITENAME." $catName $gnl_name'></a>
			</div>
			<div id='mini_picture2'>
				<a href='' onmouseover=\"document.getElementById('big_picture_show2').style.display='block'; return false;\"
				onmouseout=\"document.getElementById('big_picture_show2').style.display='none'; return false;\">
				<img src='$puth_pictures2$gnl_pic[2]' width=80px alt='".SITENAME." $catName $gnl_name'></a>
			</div>
			<div id='mini_picture3'>
				<a href='' onmouseover=\"document.getElementById('big_picture_show3').style.display='block'; return true;\"
				onmouseout=\"document.getElementById('big_picture_show3').style.display='none'; return false;\">
				<img src='$puth_pictures3$gnl_pic[3]' width=80px alt='".SITENAME." $catName $gnl_name'></a>
			</div>
			<div id='mini_picture4'>
				<a href='' onmouseover=\"document.getElementById('big_picture_show4').style.display='block'; return false;\" 
				onmouseout=\"document.getElementById('big_picture_show4').style.display='none'; return false;\">
				<img src='$puth_pictures4$gnl_pic[4]' width=80px alt='".SITENAME." $catName $gnl_name'></a>
			</div>
			<div id='mini_picture5'>
				<a href='' onmouseover=\"document.getElementById('big_picture_show5').style.display='block'; return false;\" 
				onmouseout=\"document.getElementById('big_picture_show5').style.display='none'; return false;\">
				<img src='$puth_pictures5$gnl_pic[5]' width=80px alt='".SITENAME." $catName $gnl_name'></a>
			</div>
		    </div>
		</td>";
	$text .="<td class='forumheader2' align=justify><b>".NB_DETAIL_02.":</b><br> $gnl_detail</td></tr>";
	$text .="<tr><td class='forumheader2'><font size=3><b>".NB_DETAIL_03.":</b> $gnl_price</font></td></tr>";
	$text .="<tr><td class='forumheader2'><b>".NB_DETAIL_08.":</b> <a href='$uslink'>$gnl_user</a></td></tr>";
	$text .="<tr><td class='forumheader2'><b>".NB_DETAIL_09.":</b> $gnl_city</td></tr>";
	$text .="<tr><td class='forumheader2'><b>".NB_DETAIL_10.":</b> $gnl_phone</td></tr>";
	$text .="<tr><td class='forumheader2'><b>".NB_DETAIL_11.":</b> <a href='mailto:$gnl_email'>".NB_DETAIL_12."</a></td></tr>";
	$text .="<tr><td class='forumheader2'><b>".NB_DETAIL_13.":</b> ".strftime($conf_dateformat,$gnl_date_start)." / ".strftime($conf_dateformat,$gnl_date_end)."</td></tr>";
	$text .="<tr><td class='forumheader2' colspan=2>".NB_DETAIL_14.": $gnl_counter</td></tr>";
	$text .="<tr><td class='fcaption' colspan=2>".NB_DETAIL_COMMENT."</td></tr>";
}
$text .="</table>";
if ($conf_comments == NB_SEL_YES){
	require_once(e_HANDLER."comment_class.php");
	$com = new comment;
	$table = 'nb_gnl';
//	$pid = $_GET['id'];
	$pid = $gnl_id;
	if (IsSet($_POST['commentsubmit'])){
		$_POST['subject'] = $gnl_name;
		$com->enter_comment(USERNAME, $_POST['comment'], $table, $pid, 0, $_POST['subject'], false);
	}
	$com_result = $com->compose_comment($table, 'comment', $pid,'', '', false, true, false);
	$text .=$com_result['comment'];
	$text .=$com_result['comment_form'];
}
?>