<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================
require_once("../../class2.php");
if (!getperms("5")) { header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_handler.php");
require_once(e_PLUGIN."catalog/cat_class.php");
require_once(e_HANDLER."file_handler.php");
require_once(e_HANDLER.'ren_help_handler.php');
require_once(e_ADMIN."auth.php");
require_once("languages/".e_LANGUAGE.".php");
require_once(e_HANDLER."tiny_mce/wysiwyg.php");
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


// ==================================================================================
//					CATEGORIES
// ==================================================================================
if( !isset($action) || (isset($action) && $action == "cat")){
// -----on wysiwyg-------------------------------------------------------------------
if (((varset($pref['wysiwyg'],FALSE) && check_class($pref['post_html'])) || defsettrue('e_WYSIWYG')) && varset($e_wysiwyg) != ""){
	require_once(e_HANDLER."tiny_mce/wysiwyg.php");
	define("e_WYSIWYG",TRUE);
	$wy = new wysiwyg($e_wysiwyg);
	$wy->render();
} else {
	define("e_WYSIWYG",FALSE);
}
// -----variable---------------------------------------------------------------------
	$cat_id = $_POST['cat_id'];
	$cat_sub = $_POST['cat_sub'];
	$cat_name = $_POST['cat_name'];
	$cat_pic = $_POST['cat_pic'];
	$cat_desc = $_POST['cat_desc'];
// -----removal of existing record---------------------------------------------------
if (isset($tmp[1]) && $tmp[1] == "delete"){
	$catsql -> db_Delete("catalog_cat", "cat_id='$id'");
}
// -----creation of new record-------------------------------------------------------
if (IsSet($_POST['submit_insert'])){
	if ($cat_name == ""){
		$message = LAN_MES_04;
	}
	else {
		$catsql -> db_Insert("catalog_cat","'0','$cat_sub','$cat_name','$cat_pic','$cat_desc'");
	$message = LAN_MES_05;
	$cat_id=$cat_name=$cat_desc=$cat_pic='';
	header ("Location: ".e_PLUGIN."catalog/admin_config.php?cat");
	exit;
	}
$caption = LAN_MES_CAP;
$ns -> tablerender($caption, $message);
}
// -----updating of existing record---------------------------------------------------
	if (IsSet($_POST['submit_update'])){
	$catsql1 -> db_Update("catalog_cat", "cat_sub='$cat_sub', cat_name='$cat_name', cat_desc='$cat_desc', cat_pic='$cat_pic' WHERE cat_id='$cat_id'");
		$message = LAN_MES_06;
		$ns -> tablerender(LAN_MES_00, $message);
	$cat_id=$cat_name=$cat_sub=$cat_desc=$cat_pic='';
	$vis = 'none';
	$unvis = 'yes';
	}
// -----dumping of all values---------------------------------------------------------
	if (IsSet($_POST['submit_reset'])){
	$cat_id=$cat_name=$cat_sub=$cat_desc=$cat_pic='';
	$vis = 'none';
	$unvis = 'yes';
	}

//------loading images----------------------------------------------------------------
if (IsSet($_FILES['file_userfile']['error'])){
	
	require_once(e_HANDLER."upload_handler.php");
	if ($uploaded = file_upload('/'.e_PLUGIN."catalog/images/category/", "attachment")){
		foreach($uploaded as $name){
			if ($name['error'] == 0 ) {
				$orig_file = $name['name'];
				$gnl_pic[] = $orig_file;
				$nb_patch = e_PLUGIN.'catalog/images/category/';
				if(strstr($name['type'], "image")){
					require_once(e_HANDLER."resize_handler.php");
					if(resize_image(e_PLUGIN.'catalog/images/category/'.$orig_file, e_PLUGIN.'catalog/images/category/'.$orig_file, $pref['conf_catsizepicbig'])){
//					$parms = image_getsize(e_PLUGIN.'catalog/images/category/'.$big_img);
//					$gnl_pic1 = $orig_file;
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
if(IsSet($sub_action) && ($sub_action =='create') || ($sub_action =='edit')) {
	if($sub_action =='create') {
		$vis_upd = 'none';
		$vis_agr = 'block';
	}
	if($sub_action =='edit'){
		$sql -> db_Select("catalog_cat", "*", "cat_id='$id'");
		while($row = $sql -> db_Fetch()){
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
		$cat_sub = $row['cat_sub'];
		$cat_pic = $row['cat_pic'];
		$cat_desc = $row['cat_desc'];
		}
		$vis_upd = 'block';
		$vis_agr = 'none';
	}
// -----form for processing of records------------------------------------------------
$text.="<div class='r_window_block'>";
$text.="<div class='r_window_dialog'>";
$text.="<div class='r_window_caption'>Категории</div>";
$text.="<div class='r_window_close'><a href='".e_PLUGIN."catalog/admin_config.php?cat' >Закрыть</a></div>";
$text.="<div class='r_window_scroll'>";
$text .="<form name='config' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .= "<tr><td width='30%' class='forumheader3'>".LAN_CAT_NAME."</td><td class='forumheader3' width='70%'>
			<input size='40' class='tbox' type='text' name='cat_name' value='$cat_name'>
			<input type='text' name='cat_id' value='$cat_id' style='display:none;'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_CAT_SUB."</td><td class='forumheader3'>";
	$text .= "<select class='tbox' name='cat_sub'>";
	if($sub_action == 'edit') {
	$sql -> db_Select("catalog_cat", "*", "cat_id='$cat_sub' ORDER BY cat_name ASC");
		while($row = $sql -> db_Fetch()){
		$cat_sub_id = $row['cat_id'];
		$cat_sub_name = $row['cat_name'];
	$text .= "<option value='$cat_sub_id'>$cat_sub_name</option>";
		}
	$text .= "<option value='0' checked>Не принадлежит</option>";
	
	}
	if($sub_action == 'create') {
	$text .= "<option value='0' checked>Не принадлежит</option>";
	}
	$sql -> db_Select("catalog_cat", "*", "cat_sub='0' ORDER BY cat_name ASC");
	while($row = $sql -> db_Fetch()){
		$Cat_id = $row['cat_id'];
		$Cat_name = $row['cat_name'];
	$text .= "<option value='$Cat_id'>$Cat_name</option>";
	}
	$text .="</select></td></tr>";
	

// -----output agent of images---------------------------------------------------------
$fl = new e_file;
if($imglist = $fl->get_files(e_PLUGIN."catalog/images/category/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        sort($imglist);
}
	$text .= "<tr>
			<td class='forumheader3'>".LAN_IMG_02."</td>
			<td class='forumheader3'><input class='tbox' type='text' id='cat_pic' name='cat_pic' value='$cat_pic' size='40'><input type ='button' class='button' style='cursor:pointer' size='30' value='".LAN_IMG_03."' onclick='expandit(this)'>
			<div id='linkimg' style='display:none;{head}'>";
	foreach($imglist as $img){
			$list_img = str_replace(e_PLUGIN."catalog/images/category/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_img."','cat_pic','linkimg')\"><img src='".$img['path'].$img['fname']."' style='border:0' width=50px alt='' /></a> ";
	}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='forumheader3'>".LAN_CAT_DESC." </td><td class='forumheader3'>";
	$insertjs = (!e_WYSIWYG)?"rows='25' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='25' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='cat_desc' cols='80' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$cat_desc</textarea><br>".display_help('')."";
	$text .= "</td></tr>";
	$text .= "<tr><td></td><td>
			<input type='submit' class='button' style='cursor:pointer;display:$vis_agr;' value=".LAN_BUT_AGR." name='submit_insert'>
			<input type='submit' class='button' style='cursor:pointer;display:$vis_upd;' value=".LAN_BUT_UPD." name='submit_update'>
			<input type='submit' class='button' style='cursor:pointer;' value=".LAN_BUT_CANS." name='submit_reset'>
			</td></tr></table></form>";
	$text.="</div>";
	$text.="</div>";
	$text.="</div>";		
}

$text .= "<a href='".e_PLUGIN."catalog/admin_config.php?cat.create' style='cursor:pointer;' >Добавить категорию</a> | ";
$text .="<a href='".e_PLUGIN."catalog/admin_config.php?cat.load'>Загрузить изображения</a>";

$text.="<table width=100%>";
$text.="<tr><td class='fcaption' width='5%'>ID</td>";
$text.="<td class='fcaption' width='10%'>Картинка</td>";
$text.="<td class='fcaption' width='75%'>Наименование категории</td>";
$text.="<td class='fcaption' width='10%'>Опции</td>";
$text.="<td class='fcaption' width='7px'></td>";
$text.="</table>";
$text.="<div class='r_frame_scroll'>";
$text.="<table width=100%>";


$sql -> db_Select("catalog_cat", "*", "cat_sub='0' ORDER BY cat_name ASC");
	while($row = $sql -> db_Fetch()){
	$cat_id = $row['cat_id'];
	$cat_name = $row['cat_name'];
	$cat_pic = $row['cat_pic'];
	$text .="<tr>";
	$text .="<td class='forumheader' width='5%'><b>$cat_id</b></td>";
	$text .="<td class='forumheader' width='10%'><img src='".e_PLUGIN."catalog/images/category/$cat_pic' height='16' alt='$cat_name' /></td>";
	$text .="<td class='forumheader' width='75%'>❖<b> $cat_name</b></td>";
	$text .= "<td class='forumheader' width='10%'>
			<a href='".e_PLUGIN."catalog/admin_config.php?cat.edit.$cat_id' style='cursor:pointer;'>".ADMIN_EDIT_ICON."</a>
			<a href='".e_PLUGIN."catalog/admin_config.php?cat.delete.$cat_id' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_CAT_DEL_CONFIRM." [ ID: $cat_id] ]')\">".ADMIN_DELETE_ICON."</a>
		  </td></tr>";
	$catsql1 -> db_Select("catalog_cat", "*", "cat_sub='$cat_id' ORDER BY cat_name ASC");
		while($row = $catsql1 -> db_Fetch()){
		$cat_id1 = $row['cat_id'];
		$cat_name1 = $row['cat_name'];
		$cat_pic1 = $row['cat_pic'];
		$text .="<tr>";
		$text .="<td class='forumheader2' width='5%'><i>$cat_id1</i></td>";
		$text .="<td class='forumheader2' width='10%'><img src='".e_PLUGIN."catalog/images/category/$cat_pic1' height='16' alt='$cat_name' /></td>";
		$text .="<td class='forumheader2' width='75%'>❖❖<i> $cat_name1</i></td>";
		$text .= "<td class='forumheader2' width='10%'>
			<a href='".e_PLUGIN."catalog/admin_config.php?cat.edit.$cat_id1' style='cursor:pointer;'>".ADMIN_EDIT_ICON."</a>
			<a href='".e_PLUGIN."catalog/admin_config.php?cat.delete.$cat_id1' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_CAT_DEL_CONFIRM." [ ID: $cat_id1] ]')\">".ADMIN_DELETE_ICON."</a>
		  </td></tr>";	  
		}
	}		
$text.="</table>";
$text.="</div>";
if(IsSet($sub_action) && $sub_action =='load') {

$text.="<div class='r_window_block'>";
$text.="<div class='r_window_dialog'>";
$text.="<div class='r_window_caption'>Загрузить изображения</div>";
$text.="<div class='r_window_close'><a href='".e_PLUGIN."catalog/admin_config.php?cat' >Закрыть</a></div>";
$text.="<div class='r_window_scroll'>";
// ------form for loading of images---------------------------------------------------
	$text .="<form name='cat_upload_img' method='post' action='". $PHP_SELF ."' enctype=multipart/form-data><table class='forumheader3' style='width:100%'>";
	$text .= "<tr>
			<td class='forumheader3'>".LAN_UPLOAD_IMAGES."</td>
			<td class='forumheader3'>".$tp->parseTemplate("{UPLOADFILE=".e_PLUGIN."catalog/images/category/}")."</td>
			</tr>";
	$text .="</table></form>";
	$text.="</div>";
	$text.="</div>";
	$text.="</div>";
}

$caption = LAN_CAT_FORMNEW;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//					NOMENCLATURE
// =================================================================================================
if(isset($tmp[0]) && $tmp[0] == "nom"){
if (((varset($pref['wysiwyg'],FALSE) && check_class($pref['post_html'])) || defsettrue('e_WYSIWYG')) && varset($e_wysiwyg) != ""){
	require_once(e_HANDLER."tiny_mce/wysiwyg.php");
	define("e_WYSIWYG",TRUE);
	$wy = new wysiwyg($e_wysiwyg);
	$wy->render();
} else {
	define("e_WYSIWYG",FALSE);
}

	$cat_id = $_POST['cat_id'];
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$nom_id = $_POST['nom_id'];
	$nom_cat = $_POST['nom_cat'];
	$nom_art = $_POST['nom_art'];
	$nom_name = $_POST['nom_name'];
	$nom_type = $_POST['nom_type'];
	$nom_unit = $_POST['nom_unit'];
	$nom_desc = $_POST['nom_desc'];
	$nom_pic = $_POST['nom_pic'];
	$nom_price = $_POST['nom_price'];

	
// -----removal of existing record---------------------------------------------------
if (isset($tmp[1]) && $tmp[1] == "delete"){
	$sql -> db_Delete("catalog_nom", "nom_id='$id'");
}
if (IsSet($_POST['submit_edit'])){
$catsql -> db_Select("catalog_nom", "*", "nom_id='".$nom_id."'");
	while($row = $catsql -> db_Fetch()){
	$nom_id = $row['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_art = $row['nom_art'];
	$nom_name = $row['nom_name'];
	$nom_desc = $row['nom_desc'];
	$nom_pic = $row['nom_pic'];
	$nom_price = $row['nom_price'];
	}
$unvis = 'none';
$vis = 'yes';
}

if (isset($_POST['submit_update'])){
$sql -> db_Update("catalog_nom", "nom_art='$nom_art', nom_name='$nom_name', nom_cat='$nom_cat', nom_desc='$nom_desc', nom_pic='$nom_pic', nom_price='$nom_price' WHERE nom_id='$nom_id'");
	$nom_art=$nom_name=$nom_type=$nom_unit=$nom_desc=$nom_pic=$nom_price='';
	$message = LAN_MES_06;
	$ns -> tablerender(LAN_MES_00, $message);
	$vis = 'none';
	$unvis = 'yes';
}

if (IsSet($_POST['submit_insert'])){
	if ($nom_name == ""){
	    $message = "<font color=red>".LAN_MES_11."</font>";
	}
	else {
	    $catsql -> db_Insert("catalog_nom", "0, '$nom_cat', '$nom_art', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price'");
	    $message = "<font color=red>".LAN_MES_12."</font>";
	    header ("Location: ".e_PLUGIN."catalog/admin_config.php?nom");
	    exit;
	}
	$ns -> tablerender(LAN_MES_00, $message);
}
if(IsSet($sub_action) && ($sub_action =='edit' || $sub_action =='create')) {
	if($sub_action =='edit'){
	$sql -> db_Select("catalog_nom", "*", "nom_id='$id'");
	while($row = $sql -> db_Fetch()){
	$nom_id = $_POST['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_num = $row['nom_num'];
	$nom_art = $row['nom_art'];
	$nom_code = $row['nom_code'];
	$nom_name = $row['nom_name'];
	$nom_type = $row['nom_type'];
	$nom_unit = $row['nom_unit'];
	$nom_desc = $row['nom_desc'];
	$nom_pic = $row['nom_pic'];
	$nom_price = $row['nom_price'];
	}
	
	}
	
$text ="<div class='r_window_block'>";
$text.="<div class='r_window_dialog'>";
$text.="<div class='r_window_caption'>Номенклатура</div>";
$text.="<div class='r_window_close'><a href='".e_PLUGIN."catalog/admin_config.php?nom' >Закрыть</a></div>";
$text.="<div class='r_window_scroll'>";
	$text .= "<form method='post' action='". $PHP_SELF ."' id='dataform' enctype='multipart/form-data'>
		<table class='fborder' style='width:640px'>";
	$text .= "<tr>
		<td width='25%' class='forumheader3'>Артикул</td>
		<td width='75%' class='forumheader3'><input class='tbox' type='text' name='nom_art' size='50' value='".$nom_art."' maxlength='250' /></td>
		</tr>";
	$text .= "<tr>
		<td width='25%' class='forumheader3'>Наименование товара</td>
		<td width='75%' class='forumheader3'><input class='tbox' type='text' name='nom_name' size='50' value='".$nom_name."' maxlength='250' /></td>
		</tr>";
	$catsql -> db_Select("catalog_cat", "*", "cat_id='$cat_sub'");
		while($row = $catsql -> db_Fetch()){
		$Cat_id = $row['cat_id'];
		$Cat_name = $row['cat_name'];
		}
	$text .="<tr><td class='forumheader3'>Категории</td>";
	$text .="<td class='forumheader3'>";
	
	$text .="<select class='tbox' name='nom_cat'>";
	if($sub_action == 'edit') {
	$sql -> db_Select("catalog_cat", "*", "cat_id='$nom_cat' ORDER BY cat_name ASC");
		while($row = $sql -> db_Fetch()){
		$nom_cat_id = $row['cat_id'];
		$nom_cat_name = $row['cat_name'];
	$text .= "<option value='$nom_cat_id'>$nom_cat_name</option>";
		}
	}
	
	$catsql -> db_Select("catalog_cat", "*", "cat_sub=0 ORDER by `cat_name` ASC");
                while($row = $catsql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>- $catName</option>";
		$catsql1 -> db_Select("catalog_cat", "*", "cat_sub='$catId' ORDER by `cat_name` ASC");
                while($row = $catsql1 -> db_Fetch()){
			$catId1 = $row['cat_id'];
			$catName1 = $row['cat_name'];
			$text .="<option value='$catId1'>-- $catName1</option>";
			}
		}
	$text .="</select></td></tr>";
	$text .= "<tr>";
	$text .="<td style='width:25%' class='forumheader3'>Описание</td> <td style='width:75%' class='forumheader3'>";
		
	$insertjs = (!e_WYSIWYG)?"rows='25' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='25' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='nom_desc' cols='50' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$nom_desc</textarea><br>".display_help('')."</td></tr>";
	//===============================select cat_icon=================================
        $fl = new e_file;
	if($iconlist = $fl->get_files(e_PLUGIN."catalog/images/product_icons/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        sort($iconlist);
}
	
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>Выбрать иконку для товара</td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='nom_pic' name='nom_pic' value='$nom_pic' size='40' maxlength='100' />
		<input type ='button' class='button' style='cursor:pointer' size='30' value='Обзор' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."catalog/images/product_icons/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','nom_pic','linkicn')\"><img width=50px src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a>";
		}
	$text .= "</div></td></tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Цена товара</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_price' size='40' value='".$nom_price."' maxlength='250' /></td>
		</tr>";
	$text .= "<input type='hidden' name='nom_id' value='".$id."'>";
	$text .= "<tr><td colspan=2 class='forumheader3'><center>";
		if($sub_action =="create") {
	$text .="<input type='submit' class='button' style='cursor:pointer;' value=".LAN_BUT_AGR." name='submit_insert'>";
		}
		if($sub_action =="edit") {
	$text .="<input type='submit' class='button' style='cursor:pointer;' value=".LAN_BUT_UPD." name='submit_update'>";
		}
	$text .="</center></td></tr>";
	$text .= "</table></form>";
$text.="</div>";
$text.="</div>";
$text.="</div>";
}


//------------nomenclature list------------//
$text .= "<a href='".e_PLUGIN."catalog/admin_config.php?nom.create' style='cursor:pointer;' >Добавить номенклатуру</a> |";
$text .="<a href='#'>Загрузить изображения</a>";

$text.="<table width=100%>";
$text.="<tr><td class='fcaption' width='5%'>№</td>";
$text.="<td class='fcaption' width='10%'>Фото</td>";
$text.="<td class='fcaption' width='40%'>Наименование номенклатуры</td>";
$text.="<td class='fcaption' width='25%'>Категория</td>";
$text.="<td class='fcaption' width='10%'>Цена</td>";
$text.="<td class='fcaption' width='10%'>Опции</td>";
$text.="<td class='fcaption' width=0px padding=0px></td>";
$text.="</table>";
$text.="<div class='r_frame_scroll'>";
$text.="<table width=100%>";



$count=1;
$catsql = new db;
$catsql -> db_Select("catalog_nom", "*", "nom_id ORDER BY `nom_id` ASC");
	while($row = $catsql -> db_Fetch()){
	$nom_id = $row['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_num = $row['nom_num'];
	$nom_art = $row['nom_art'];
	$nom_code = $row['nom_code'];
	$nom_vis = $row['nom_vis'];
	$nom_name = $row['nom_name'];
	$nom_type = $row['nom_type'];
	$nom_unit = $row['nom_unit'];
	$nom_desc = $row['nom_desc'];
	$nom_pic = $row['nom_pic'];
	$nom_price = $row['nom_price'];
		
		if($count==1){
			  $style = "forumheader";
			  }
		if($count==2){
			  $style = "forumheader2";
			  $count = 0;
		}
			  $text.="<tr><td class='$style' width='5%' >$nom_id</td>";
			  $text.="<td class='$style' width='10%'>";
			  if (!empty($nom_pic)){
			  $text.="<img src='".e_PLUGIN."catalog/images/product_icons/$nom_pic' height=20px>";
			  }
			  $text .="</td>";
			  $text.="<td class='$style' width='40%'>$nom_name</td>";
			  $text.="<td class='$style' width='25%'>";
				$catsql2 -> db_Select("catalog_cat", "*", "cat_id='$nom_cat'");
				while($row = $catsql2 -> db_Fetch()){
					$cat_id = $row['cat_id'];
					$cat_name = $row['cat_name'];
					$text.=$cat_name;		
				}
			  $text.="</td>";

			  $text.="<td class='$style' width='10%'>$nom_price</td>";
			  $text .= "<td class='$style' width='10%'><a href='".e_PLUGIN."catalog/admin_config.php?nom.edit.$nom_id' style='cursor:pointer;' >".ADMIN_EDIT_ICON."</a>
				<a href='".e_PLUGIN."catalog/admin_config.php?nom.delete.$nom_id' style='cursor:pointer;' onclick=\"return jsconfirm('".LAN_NOM_DEL_CONFIRM." [ ID: $nom_id] ]')\">".ADMIN_DELETE_ICON."</a>
				</td>";
		
		$count++;
	}
$text .="</table>";
$text .="</div>";
$caption = LAN_MENU_NOM;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}

// =================================================================================================
//				NOMENCLATURE IMPORT OPTIONS MENU
// =================================================================================================
if((isset($tmp[0]) && $tmp[0] == "nom_import")){
	$catId = $_GET['catId'];
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$cat_id = $_POST['cat_id'];
	$nom_id = $_POST['nom_id'];
	$nom_cat = $_POST['nom_cat'];
	$nom_num = $_POST['nom_num'];
	$nom_art = $_POST['nom_art'];
	$nom_code = $_POST['nom_code'];
	$nom_name = $_POST['nom_name'];
	$nom_type = $_POST['nom_type'];
	$nom_unit = $_POST['nom_unit'];
	$nom_desc = $_POST['nom_desc'];
	$nom_pic = $_POST['nom_pic'];
	$nom_price1 = $_POST['nom_price1'];
	$nom_price2 = $_POST['nom_price2'];
	$nom_vis = $_POST['nom_vis'];
if (IsSet($_POST['submit_edit'])){
$sql -> db_Select("catalog_nom", "*", "nom_id='$nom_id'");
	while($row = $sql -> db_Fetch()){
	$nom_id = $_POST['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_num = $row['nom_num'];
	$nom_art = $row['nom_art'];
	$nom_code = $row['nom_code'];
	$nom_name = $row['nom_name'];
	$nom_type = $row['nom_type'];
	$nom_unit = $row['nom_unit'];
	$nom_desc = $row['nom_desc'];
	$nom_pic = $row['nom_pic'];
	$nom_price1 = $row['nom_price1'];
	$nom_price2 = $row['nom_price2'];
	$nom_vis = $row['nom_vis'];
	}
$unvis = 'none';
$vis = 'yes';
}
//======Reset_notes======//
if (IsSet($_POST['submit_reset'])){
	$nom_num=$nom_art=$nom_code=$nom_name=$nom_type=$nom_unit=$nom_cat=$nom_desc=$nom_pic=$nom_price1=$nom_price2=$nom_price3=$nom_price4='';
	$vis = 'none';
	$unvis = 'yes';
}
if (isset($_POST['submit_update'])){
$sql -> db_Update("catalog_nom", "nom_id='$nom_id', nom_cat='$nom_cat', nom_num='$nom_num', nom_art='$nom_art',  nom_code='$nom_code', nom_name = '$nom_name', nom_type='$nom_type', nom_unit='$nom_unit', nom_desc='$nom_desc', nom_pic='$nom_pic', nom_price1='$nom_price1', nom_price2='$nom_price2', nom_price3='$nom_price3', nom_price4='$nom_price4' WHERE nom_id=$nom_id");
	$nom_num=$nom_art=$nom_code=$nom_name=$nom_type=$nom_unit=$nom_cat=$nom_desc=$nom_pic=$nom_price1=$nom_price2=$nom_price3=$nom_price4='';
	$vis = 'none';
	$unvis = 'yes';
}
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("catalog_nom", "nom_id='$nom_id'");
}
if (IsSet($_POST['submit_insert'])){
	if ($nom_name == ""){ 
	$message = "<font color=red>".LAN_MES_11."</font>";
	}
	else {
		$sql = new db;
		$sql -> db_Insert("catalog_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
		$message = "<font color=red>".LAN_MES_12."</font>";
		$nom_id=$nom_name=$nom_cat=$nom_desc='';
		header ("Location: ".e_PLUGIN."catalog/admin_config.php?nomenclature");
		exit;
		}
	$ns -> tablerender(LAN_MES_00, $message);
}


/*
if (IsSet($_POST['submit_import'])){
	    $row=1;
	    $handle=fopen(e_PLUGIN."catalog/proba.csv","r");
	    while($data=fgetcsv($handle,1000,";")){
//	      $sql = new db;
//	      $sql -> db_Insert("catalog_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
	      $num=count($data);
	      $text .= "<p> $num полей в строке $row: \n";
		  $row++;
		  for ($c=0; $c<$num;$c++){
		  
//	      $text .= $data[$c] . "\n";
		  }
	      $sql = new db;
	      $sql -> db_Insert("catalog_nom", "0, '1', '$nom_num', '$data[0]', '$nom_code', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$data[3]', '$nom_price3', '$nom_price4'");
	     }
fclose($handle);
$ns -> tablerender($caption, $text);
}*/
// -----import procedure----------------------------------------------------------
/*
if (IsSet($_POST['submit_import'])){
	    if ($cat_id==''){
	    $cat_id=0;
	    } 

	    $row=1;
	    $handle=fopen(e_PLUGIN."catalog/price/proba.csv","r");
	    $count_cat=0;
	    $n=0;
	    while($data=fgetcsv($handle,65536,";")){
	    
//	      $sql = new db;
//	      $sql -> db_Insert("catalog_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
	      $num=count($data);
	      $text .= "<p> $num полей в строке $row: \n";
		  $row++;
		  for ($c=0; $c<$num;$c++){
		  
//	      $text .= $data[$c] . "\n";
		  }

	      if ($data[2]==''){
		  $count_cat++;
		  $count_cat1=10000+$count_cat;
		  $sql = new db;
		  $sql -> db_Insert("catalog_cat", "$count_cat1, '1', '0', '$data[1]','$data[3]','$data[4]'");
	     }
	     else{
	      $n++;
	      $sql = new db;
		if ($data[0]==''){
		  $sql -> db_Insert("catalog_nom", "$n, '$count_cat1', '$nom_num', '$data[0]', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc_mini','$data[4]', '$data[3]', '$data[2]', '$nom_price2'");
		 }
		 else{
		  $sql -> db_Insert("catalog_nom", "$n, '$count_cat1,$data[0]', '$nom_num', '$data[0]', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc_mini','$data[4]', '$data[3]', '$data[2]', '$nom_price2'");
		 }
	     }
	     }
fclose($handle);
//}
$ns -> tablerender($caption,$text);
}
*/
if (IsSet($_POST['submit_import'])){
	    $row=1;
	    $handle=fopen(e_PLUGIN."catalog/price/catalog_index.csv","r");
	    $count_cat=0;
	    while($data=fgetcsv($handle,65536,";")){
	    
//	      $sql = new db;
//	      $sql -> db_Insert("catalog_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
	      $num=count($data);
	      $text .= "<p> $num полей в строке $row: \n";
		  $row++;
		  for ($c=0; $c<$num;$c++){
		  
//	      $text .= $data[$c] . "\n";
		  }

	      
	$count_cat++;
	$sql = new db;
	$sql -> db_Insert("catalog_index", "$count_cat, '$data[0]','$data[1]'");
		if ($data[2]<>''){
		$count_cat++;
		$sql1 = new db;
		$sql1 -> db_Insert("catalog_index", "$count_cat, '$data[0]','$data[2]'");
		}
	     }
fclose($handle);
//}
$ns -> tablerender($caption,$text);
}

if (IsSet($_POST['submit_clearcat'])){
      if ($cat_id==''){
	    $message = "<font color=red>Не выбрана категория</font>";
	    $ns -> tablerender(LAN_MES_CAP, $message);
      } else {
	    $sql = new db;
	    $sql -> db_Select("catalog_cat", "*", "cat_sub='".$cat_id."'");
	    while($row = $sql -> db_Fetch()){
	      $catId = $row['cat_id'];
	      $sql1 = new db;
	      $sql1 -> db_Delete("catalog_nom", "nom_cat='".$catId."'");
	    $message = $catId;
	    $ns -> tablerender(LAN_MES_CAP, $message);
	    }
      $sql = new db;
      $sql -> db_Delete("catalog_cat", "cat_sub='".$cat_id."'");
      }
}
//======form import or export csv=============================.
$text ="<form enctype='multipart/form-data' name='form_nom_import' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .="<tr><td class='r_header' style='text-align:center' colspan='2'>";
	$text .="<tr><td class='forumheader3'>" .LAN_AI_01." *
	<select class='tbox' name='catId' id='cat'>
	<option value=''>" .LAN_AI_01."";
		$sql -> db_Select("catalog_cat", "*", "cat_sub='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
			}
	$text .="</option></select><br>";
	$text .="<input type='submit' class='button' style='cursor:pointer;' value='Импорт файла' name='submit_import'> ";
	$text .="<input type='submit' class='button' style='cursor:pointer;' value='Очистить категорию' name='submit_clearcat'>";
	$text .="</table></form>";
$caption = LAN_AI_CAP_01;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           ADMIN_CONFIG OPTIONS MENU
// =================================================================================================
if(isset($tmp[0]) && $tmp[0] == "config"){
	
//======UPDATE========//
if(IsSet($_POST['savesettings'])){
	$pref['conf_cathead'] = $_POST['conf_cathead'];
	$pref['conf_catdateformat'] = $_POST['conf_catdateformat'];
	$pref['conf_catfunc'] = $_POST['conf_catfunc'];
	$pref['conf_catadmail'] = $_POST['conf_catadmail'];
	$pref['conf_catdays'] = $_POST['conf_catdays'];
	$pref['conf_catsizepicbig'] = $_POST['conf_catsizepicbig'];
	$pref['conf_catsizepicsmall'] = $_POST['conf_catsizepicsmall'];
	$pref['conf_catshowcolscat'] = $_POST['conf_catshowcolscat'];
	$pref['conf_catshowrowscat'] = $_POST['conf_catshowrowscat'];
	$pref['conf_catshowcolsitems'] = $_POST['conf_catshowcolsitems'];
	$pref['conf_catshowrowsitems'] = $_POST['conf_catshowrowsitems'];
	$pref['conf_catnewshow'] = $_POST['conf_catnewshow'];
	$pref['conf_catnewhead'] = $_POST['conf_catnewhead'];
	$pref['conf_catnewitems'] = $_POST['conf_catnewitems'];
	$pref['conf_catsaleshow'] = $_POST['conf_catsaleshow'];
	$pref['conf_catsalehead'] = $_POST['conf_catsalehead'];
	$pref['conf_catsaleitems'] = $_POST['conf_catsaleitems'];
	save_prefs();
$message = LAN_MES_00;
$caption = LAN_MES_CAP;
$ns -> tablerender($caption,$message);
}
	$text ="<form enctype='multipart/form-data' name='config_form' method='post' action=''><table class='fborder' style='width:100%' align='center'>";
	$text .="<input type='hidden' name='conf_id' value='$conf_id'>";
	$text .= "<tr><td colspan=2 class='fcaption' width='60%'>".LAN_CONF_GNL_CAP."</td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_02."</td><td class='forumheader'><input class='tbox' size='40' type='text' name='conf_cathead' value='".$pref['conf_cathead']."'></input></td></tr>";

//	$text .= "<tr><td colspan=2 class='fcaption'>".LAN_CONF_03."</td></tr>";

	$text .= "<tr><td class='forumheader2'>".LAN_CONF_05."</td><td class='forumheader2'><input class='tbox' size='40' type='text' name='conf_catadmail' value='".$pref['conf_catadmail']."'></input></td></tr>";

//	$text .= "<tr><td colspan=2 class='fcaption'>".LAN_CONF_07."</td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_08."</td><td class='forumheader'><input type='text' name='conf_catsizepicbig' class='tbox' value='".$pref['conf_catsizepicbig']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader2'>".LAN_CONF_09."</td><td class='forumheader2'><input type='text' name='conf_catsizepicsmall' class='tbox' value='".$pref['conf_catsizepicsmall']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_10."</td><td class='forumheader'><input type='text' name='conf_catshowcolscat' class='tbox' value='".$pref['conf_catshowcolscat']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader2'>".LAN_CONF_11."</td><td class='forumheader2'><input type='text' name='conf_catshowrowscat' class='tbox' value='".$pref['conf_catshowrowscat']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_12."</td><td class='forumheader'><input type='text' name='conf_catshowcolsitems' class='tbox' value='".$pref['conf_catshowcolsitems']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader2'>".LAN_CONF_13."</td><td class='forumheader2'><input type='text' name='conf_catshowrowsitems' class='tbox' value='".$pref['conf_catshowrowsitems']."' size='40'></td></tr>";
	$text .= "<tr><td colspan=2 class='catalog_caption'>".LAN_CONF_NEW_CAP."</td></tr>";
        $text .= "<tr><td class='forumheader'>".LAN_CONF_NEW_01."</td>
	<td class='forumheader'><select class='tbox' type='text' name='conf_catnewshow'><option selected value='".$pref['conf_catnewshow']."'>".$pref['conf_catnewshow']."
		<option value=".LAN_YES.">".LAN_YES."
		<option value=".LAN_NO.">".LAN_NO."
	</select></td></tr>";
	$text .= "<tr><td class='forumheader2'>".LAN_CONF_NEW_02."</td><td class='forumheader2'><input class='tbox' size='40' type='text' name='conf_catnewhead' value='".$pref['conf_catnewhead']."'></input></td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_NEW_03."</td><td class='forumheader'><input type='text' name='conf_catnewitems' class='tbox' value='".$pref['conf_catnewitems']."' size='40'></td></tr>";

	$text .= "<tr><td colspan=2 class='catalog_caption'>".LAN_CONF_SALE_CAP."</td></tr>";
        $text .= "<tr><td class='forumheader'>".LAN_CONF_SALE_01."</td>
	<td class='forumheader'><select class='tbox' type='text' name='conf_catsaleshow'><option selected value='".$pref['conf_catsaleshow']."'>".$pref['conf_catsaleshow']."
		<option value=".LAN_YES.">".LAN_YES."
		<option value=".LAN_NO.">".LAN_NO."
	</select></td></tr>";
	$text .= "<tr><td class='forumheader2'>".LAN_CONF_SALE_02."</td><td class='forumheader2'><input class='tbox' size='40' type='text' name='conf_catsalehead' value='".$pref['conf_catsalehead']."'></input></td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_SALE_03."</td><td class='forumheader'><input type='text' name='conf_catsaleitems' class='tbox' value='".$pref['conf_catsaleitems']."' size='40'></td></tr>";
	$text .= "<tr><td colspan=2 class='catalog_caption'>".LAN_CONF_HIT_CAP."</td></tr>";
        $text .= "<tr><td class='forumheader'>".LAN_CONF_HIT_01."</td>
	<td class='forumheader'><select class='tbox' type='text' name='conf_hitshow'><option selected value='".$pref['conf_hitshow']."'>".$pref['conf_hitshow']."
		<option value=".LAN_YES.">".LAN_YES."
		<option value=".LAN_NO.">".LAN_NO."
	</select></td></tr>";
	$text .= "<tr><td class='forumheader2'>".LAN_CONF_HIT_02."</td><td class='forumheader2'><input class='tbox' size='40' type='text' name='conf_catsalehead' value='".$pref['conf_hithead']."'></input></td></tr>";
	$text .= "<tr><td class='forumheader'>".LAN_CONF_HIT_03."</td><td class='forumheader'><input type='text' name='conf_catsaleitems' class='tbox' value='".$pref['conf_hititems']."' size='40'></td></tr>";
	$text .= "<tr><td class='r_header' colspan='2' style='text-align:center'><input class='button' name='savesettings' type='submit' value= ".LAN_BUT_AGR."></td></tr></table></form>";
	
	$caption = LAN_MENU_ABOUT;
	$ns -> tablerender($caption, $text);
	require_once(e_ADMIN."footer.php");
	exit;
}
//==================================================================================================
//				           ABOUT PLUGIN
// =================================================================================================
if(isset($tmp[0]) && $tmp[0] == "about"){
$text="<table><tr>";
$text.="<td><a href='http://e107.compolys.ru'><img src='".e_PLUGIN."nboard/theme/logo_compolys.png' alt='".LAN_INFO."'></a>";
$text.= "<td align='center'> ".LAN_INFO_00."
<br>author - ComPolyS, http://e107.compolys.ru, e107@compolys.ru
<br>coder - Sunout, sunout@compolys.ru, license GNU GPL
<br>================= march 2011 ====================";
$text.="</tr></table>";
$text.="<b>".LAN_ABO_00."</b><br>";
$text.="".LAN_ABO_INFO."<br>";
$caption = LAN_ABO_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
require_once(e_ADMIN."footer.php");
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
	$var['cat']['text'] = LAN_MENU_CAT;
	$var['cat']['link'] = "admin_config.php?cat";
	$var['nom']['text'] = LAN_MENU_NOM;
	$var['nom']['link'] = "admin_config.php?nom";
	$var['nom_import']['text'] = LAN_MENU_IMPORT;
	$var['nom_import']['link'] = "admin_config.php?nom_import";
	$var['config']['text'] = LAN_MENU_CONF;
	$var['config']['link'] = "admin_config.php?config";
	$var['about']['text'] = LAN_MENU_ABOUT;
	$var['about']['link'] = "admin_config.php?about";
	
	show_admin_menu(LAN_MENU_CAP, $action, $var);
}
?>