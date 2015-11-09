<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

@include_once(e_PLUGIN."md_nboard/languages/".e_LANGUAGE.".php");

if (!defined('e107_INIT')) { exit; }
	if(!$nboard_install = $sql -> db_Select("plugin", "*", "plugin_path = 'md_nboard' AND plugin_installflag = '1' ")) {
		return;
 	}
	$LIST_CAPTION = $arr[0];
	$LIST_DISPLAYSTYLE = ($arr[2] ? "" : "none");
	$LIST_CAPTION = $arr[0];
	$LIST_DISPLAYSTYLE = ($arr[2] ? "" : "none");
	if($mode == "new_page" || $mode == "new_menu" ){
		$lvisit = $this -> getlvisit();
		$qry = "gnl_date_start>".$lvisit;

	}else{
		$qry = "gnl_id != '0' ";
	}
	$qry .= "ORDER BY gnl_date_start DESC LIMIT 0".intval($arr[7]);
	$bullet = $this -> getBullet($arr[6], $mode);
	
	if(!$nboard_posts = $sql -> db_Select("nb_gnl", "*", "gnl_pic<>'' AND $qry")){ 
		$LIST_DATA = LIST_NBOARD_NONOTICE;
	} else {
		while($row = $sql -> db_Fetch()) {
			$nb_id	= substr($row['gnl_id'] , 0, strpos($row['gnl_id'] , "."));
			$gnl_name = $row['gnl_name'];
			$nb_nick = $row['gnl_user'];
			$gnl_pic = $row['gnl_pic'];
			$gnl_pic = explode(",", $gnl_pic);
			$first_letter = mb_substr($gnl_name,0,1, 'UTF-8');//первая буква
			$last_letter = mb_substr($gnl_name,1);//все кроме первой буквы
			$first_letter = mb_strtoupper($first_letter, 'UTF-8');
			$last_letter = mb_strtolower($last_letter, 'UTF-8');
			$gnl_name = $first_letter.$last_letter;
			
			$nb_message = "<a href=".e_PLUGIN."md_nboard/nboard.php?page=detail&id=".$row['gnl_id'].">".$gnl_name."</a>";
			$rowheading = $this -> parse_heading($nb_message, $mode);
			if ($row['gnl_pic'] == ''){
			$ICON		= "<img src='".e_PLUGIN."md_nboard/theme/photo_emp_small.png' style='width:50px; border:0px solid #000;' alt='".SITENAME." - $gnl_name' />";
			} else {
				if (@fopen("".e_PLUGIN."md_nboard/nb_pictures/small_$gnl_pic[0]", "r")){
					$ICON	= "<a href='".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[0]'><img src='".e_PLUGIN."md_nboard/nb_pictures/small_$gnl_pic[0]' style='width:50px; border:0px solid #000;' alt='".SITENAME." - $gnl_name' /></a>";
				}
				else{
					$ICON	= "<a href='".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[0]'><img src='".e_PLUGIN."md_nboard/nb_pictures/$gnl_pic[0]' style='width:50px; border:0px solid #000;' alt='".SITENAME." - $gnl_name' /></a>";
				}
			}
//			$ICON		= $bullet;
			$HEADING	= $rowheading;
			$AUTHOR		= ($arr[3] ? ($nb_id != 0 ? "<a href='".e_BASE."user.php?id.$nb_id'>".$nb_nick."</a>" : $nb_nick) : "");
			//$CATEGORY	= "";
			$DATE = ($arr[5] ? $this -> getListDate($row['gnl_date_start'], $mode) : "");
//			$DATE		= ($arr[5] ? (strftime('%d.%m.%Y',$row['gnl_date_start'])) : "");
			/*$INFO		= "";*/
			$LIST_DATA[$mode][] = array( $ICON, $HEADING, $AUTHOR, $CATEGORY, $DATE, $INFO );
		}
	}
?>