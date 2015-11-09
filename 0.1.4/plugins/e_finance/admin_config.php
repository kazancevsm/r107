<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

require_once("../../class2.php");
if (!getperms("5")) { header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."file_class.php");
require_once(e_ADMIN."auth.php");
require_once("languages/".e_LANGUAGE.".php");
require_once(e_HANDLER."tiny_mce/wysiwyg.php");
if (e_QUERY){
  $qs = explode(".", e_QUERY);
}
$e_sub_cat = 'custom';		// on wysiwyg
$e_wysiwyg = "data";		// on wysiwyg
$vis = 'none';			// switch, display object none
$unvis = 'yes';			// switch, display object yes

$vtsql = new db;
$vtsql1 = new db;
$vtsql2 = new db;
$vtsql3 = new db;
$vtsql4 = new db;
// ==================================================================================
//					CAT OPTIONS
// ==================================================================================
if((isset($qs[0]) && $qs[0] == "cat")){
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
	$cat_img = $_POST['cat_img'];
	$cat_desc = $_POST['cat_desc'];
	$cat_vis = $_POST['cat_vis'];
// -----editing of existing record---------------------------------------------------
if (IsSet($_POST['submit_edit'])){
	if ($cat_id == ''){ $message = "<font color=red>".VT_MES_01."</font>";
	$ns -> tablerender(VT_MES_00, $message);
	}
	else{
	$sql -> db_Select("vt_cat", "*", "cat_id ='$cat_id'");
		while($row = $sql -> db_Fetch()){
			$cat_sub = $row['cat_sub'];
			$cat_name = $row['cat_name'];
			$cat_img = $row['cat_img'];
			$cat_desc = $row['cat_desc'];
			$cat_vis = $row['cat_vis'];
		}
	$vis = 'yes';
	$unvis = 'none';
	}
}
// -----removal of existing record---------------------------------------------------
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("vt_cat", "cat_id='$cat_id'");
}
// -----creation of new record-------------------------------------------------------
if (IsSet($_POST['submit_insert'])){
	if ($cat_name == ""){
		$message = VT_MES_04;
	}
	else {
		$sql = new db;
		$sql -> db_Insert("vt_cat","'0','$cat_sub','$cat_name','$cat_img','$cat_desc','$cat_vis'");
	$message = VT_MES_05;
	$cat_id=$cat_name=$cat_desc=$cat_img='';
	header ("Location: ".e_PLUGIN."vtrade/admin_config.php?cat");
	exit;
	}
$caption = VT_MES_CAP;
$ns -> tablerender($caption, $message);
}
// -----updating of existing record---------------------------------------------------
	if (IsSet($_POST['submit_update'])){
	$vtsql1 -> db_Update("vt_cat", "cat_sub='$cat_sub', cat_name='$cat_name', cat_desc='$cat_desc', cat_img='$cat_img', cat_vis='$cat_vis' WHERE cat_id='$cat_id'");
	$vtsql2 -> db_Select("vt_index", "*", "index_catid='$cat_id'");
		while($row = $vtsql2 -> db_Fetch()){
			$IndexNomId = $row['index_nomid'];
			$vtsql3 -> db_Select("vt_nom", "*", "nom_id='$IndexNomId'");
				while($row = $vtsql3 -> db_Fetch()){
					$vtsql4 -> db_Update("vt_nom", "nom_vis='$cat_vis' WHERE nom_id='$IndexNomId'");
				}
		}
		$message = VT_MES_06;
		$ns -> tablerender(VT_MES_00, $message);
	$cat_id=$cat_name=$cat_sub=$cat_desc=$cat_img='';
	$vis = 'none';
	$unvis = 'yes';
	}
// -----dumping of all values---------------------------------------------------------
	if (IsSet($_POST['submit_reset'])){
	$cat_id=$cat_name=$cat_sub=$cat_desc=$cat_img='';
	$vis = 'none';
	$unvis = 'yes';
	}
//------loading images----------------------------------------------------------------
if (IsSet($_FILES['file_userfile']['error'])){
	
	require_once(e_HANDLER."upload_handler.php");
	if ($uploaded = file_upload('/'.e_PLUGIN."vtrade/vt_pictures/category/", "attachment")){
		foreach($uploaded as $name){
			if ($name['error'] == 0 ) {
				$orig_file = $name['name'];
				$gnl_pic[] = $orig_file;
				$nb_patch = e_PLUGIN.'vtrade/vt_pictures/category/';
				if(strstr($name['type'], "image")){
					require_once(e_HANDLER."resize_handler.php");
					if(resize_image(e_PLUGIN.'vtrade/vt_pictures/category/'.$orig_file, e_PLUGIN.'vtrade/vt_pictures/category/'.$orig_file, $pref['conf_sizepicbig'])){
//					$parms = image_getsize(e_PLUGIN.'vtrade/vt_pictures/category/'.$big_img);
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
	
// -----form for a choice of records--------------------------------------------------
	$text ="<form name='cat_select' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".VT_CAT_CAT."</td><td class='forumheader2' width='70%'>";
	$text .= "<select class='tbox' name='cat_id'>";
	$text .="<option value=''>Нажмите для выбора категории</option>";
	$vtsql1 -> db_Select("vt_cat", "*", "cat_sub='0' ORDER BY `cat_name` ASC");
        while($row = $vtsql1 -> db_Fetch()){
				$CatId1 = $row['cat_id'];
				$CatName1 = $row['cat_name'];
				$text .="<option value='$CatId1'>- $CatName1</option>";
				$vtsql2 -> db_Select("vt_cat", "*", "cat_sub='$CatId1' ORDER BY `cat_name` ASC");
				while($row = $vtsql2 -> db_Fetch()){
					$CatId2 = $row['cat_id'];
					$CatName2 = $row['cat_name'];
					$text .="<option value='$CatId2'>- - $CatName2</option>";
				}
			}
	$text .="</select></td></tr><tr><td colspan=2 class='forumheader3'><center>";
	$text .="<input type=submit name='submit_edit' value=".VT_BUT_EDIT.">&nbsp;&nbsp;";
	$text .="<input type=submit name='submit_delete' value=".VT_BUT_DEL.">&nbsp;&nbsp;";
	$text .="</center></td></tr></table></form>";
$caption = VT_CAT_FORMEDIT;
$ns -> tablerender($caption, $text);
// ------form for loading of images---------------------------------------------------
	$text ="<form name='cat_upload_img' method='post' action='". $PHP_SELF ."' enctype=multipart/form-data><table class='forumheader3' style='width:100%'>";
	$text .= "<tr>
			<td class='forumheader3'>".LAN_UPLOAD_IMAGES."</td>
			<td class='forumheader3'>".$tp->parseTemplate("{UPLOADFILE=".e_PLUGIN."vtrade/vt_pictures/category/}")."</td>
			</tr>";
	$text .="</table></form>";
$caption = VT_CAT_FORMUPLOAD;
$ns -> tablerender($caption, $text);
// -----form for processing of records------------------------------------------------
	$text ="<form name='config' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .= "<tr><td width='30%' class='forumheader3'>".VT_CAT_NAME."</td><td class='forumheader2' width='70%'>
			<input size='40' class='tbox' type='text' name='cat_name' value='$cat_name'>
			<input type='text' name='cat_id' value='$cat_id' style='display:none;'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".VT_CAT_SUB."</td><td class='forumheader2'>";
	$sql -> db_Select("vt_cat", "*", "cat_id='$cat_sub'");
	while($row = $sql -> db_Fetch()){
		$Cat_id = $row['cat_id'];
		$Cat_name = $row['cat_name'];
	}
	$text .= "<select class='tbox' name='cat_sub'>";
	$text .= "<option value='$Cat_id' style='display:$vis'>$Cat_name</option>";
	$text .= "<option value='0'>None</option>";
	$vtsql -> db_Select("vt_cat", "*", "");
		while($row = $vtsql -> db_Fetch()){
			$eyetom = $row['cat_id'];
			$eyename = $row['cat_name'];
			$text .="<option value='$eyetom'>$eyename</option>";
		}
	$text .="</select></td></tr>";
	
	$text .= "<tr><td class='forumheader3'>".VT_CAT_VIS."</td><td class='forumheader2' width='70%'>";
	$text .= "<select class='tbox' name='cat_vis'>";
	$text .= "<option value='cat_vis'>$cat_vis</option>";
	$text .= "<option value='".VT_YES."'>".VT_YES."</option>";
	$text .= "<option value='".VT_NO."'>".VT_NO."</option>";
	$text .="</select></td></tr>";
// -----output agent of images---------------------------------------------------------
$fl = new e_file;
if($imglist = $fl->get_files(e_PLUGIN."vtrade/vt_pictures/category/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        sort($imglist);
}
	$text .= "<tr>
			<td class='forumheader3'>".VT_IMG_02."</td>
			<td class='forumheader3'><input class='tbox' type='text' id='cat_img' name='cat_img' value='$cat_img' size='40'><input type ='button' class='button' style='cursor:pointer' size='30' value='".VT_IMG_03."' onclick='expandit(this)'>
			<div id='linkimg' style='display:none;{head}'>";
	foreach($imglist as $img){
			$list_img = str_replace(e_PLUGIN."vtrade/vt_pictures/category/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_img."','cat_img','linkimg')\"><img src='".$img['path'].$img['fname']."' style='border:0' width=50px alt='' /></a> ";
	}
	$text .= "</div></td></tr>";
	$text .= "<tr><td class='forumheader3'>".VT_CAT_DESC." </td><td class='forumheader2'>";
	$insertjs = (!e_WYSIWYG)?"rows='25' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='25' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='cat_desc' cols='80' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$cat_desc</textarea>";
	$text .= "</textarea></td></tr><tr><td></td><td>
			<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".VT_BUT_AGR." name='submit_insert'>
			<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_UPD." name='submit_update'>
			<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_CANS." name='submit_reset'>
			</td></tr></table></form>";
$caption = VT_CAT_FORMNEW;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//					NOMENKLATURE OPTIONS
// =================================================================================================
if(isset($qs[0]) && $qs[0] == "nomenclature"){
// Wysiwyg JS support on or off.
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
	$nom_num = $_POST['nom_num'];
	$nom_art = $_POST['nom_art'];
	$nom_name = $_POST['nom_name'];
	$nom_type = $_POST['nom_type'];
	$nom_unit = $_POST['nom_unit'];
	$nom_desc_mini = $_POST['nom_desc_mini'];
	$nom_desc_all = $_POST['nom_desc_all'];
	$nom_pic = $_POST['nom_pic'];
	$nom_price1 = $_POST['nom_price1'];
	$nom_price2 = $_POST['nom_price2'];
	$nom_vis = $_POST['nom_vis'];
		
if (IsSet($_POST['submit_edit'])){
$vtsql -> db_Select("vt_nom", "*", "nom_id='".$nom_id."'");
	while($row = $vtsql -> db_Fetch()){
	$nom_id = $row['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_num = $row['nom_num'];
	$nom_art = $row['nom_art'];
	$nom_code = $row['nom_code'];
	$nom_name = $row['nom_name'];
	$nom_type = $row['nom_type'];
	$nom_unit = $row['nom_unit'];
	$nom_desc_mini = $row['nom_desc_mini'];
	$nom_desc_all = $row['nom_desc_all'];
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
	$nom_num=$nom_art=$nom_code=$nom_name=$nom_type=$nom_unit=$nom_cat=$nom_desc_all=$nom_pic=$nom_price1=$nom_price2=$nom_vis='';
	$vis = 'none';
	$unvis = 'yes';
}
if (isset($_POST['submit_update'])){
/* -----обновление записи в базе-----*/
//$sql -> db_Update("vt_nom", "nom_id='$nom_id', nom_cat='$nom_cat', nom_num='$nom_num', nom_art='$nom_art',  nom_name='$nom_name', nom_type='$nom_type', nom_unit='$nom_unit', nom_desc_mini='$nom_desc_mini', nom_desc_all='$nom_desc_all', nom_pic='$nom_pic', nom_price1='$nom_price1', nom_price2='$nom_price2' WHERE nom_id='".$nom_id."'");
$sql -> db_Update("vt_nom", "nom_num='$nom_num', nom_art='$nom_art', nom_name='$nom_name', nom_type='$nom_type', nom_unit='$nom_unit', nom_desc_mini='$nom_desc_mini', nom_desc_all='$nom_desc_all', nom_pic='$nom_pic', nom_price1='$nom_price1',  nom_price2='$nom_price2', nom_vis='$nom_vis' WHERE nom_id='".$nom_id."'");
	$nom_num=$nom_art=$nom_name=$nom_type=$nom_unit=$nom_desc_mini=$nom_desc_all=$nom_pic=$nom_price1=$nom_price2=$nom_vis='';
	$message = VT_MES_06;
	$ns -> tablerender(VT_MES_00, $message);
	$vis = 'none';
	$unvis = 'yes';
}
if (IsSet($_POST['submit_delete'])){
	$vtsql1 -> db_Delete("vt_index", "index_nomid='$nom_id'");
	$vtsql2 -> db_Delete("vt_nom", "nom_id='$nom_id'");
}
if (IsSet($_POST['submit_insert'])){
	if ($nom_name == ""){
	    $message = "<font color=red>".VT_MES_11."</font>";
	}
	else {
	    $nom_cat = '0'; // Идентификатор пустой категории. Далее нужно присвоить категории в разделе Мультикатегории
	    $vtsql1 -> db_Insert("vt_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc_mini', '$nom_desc_all', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_vis'");
	    $message = "<font color=red>".VT_MES_12."</font>";
	    $nom_id=$nom_name=$nom_cat=$nom_desc='';
	    header ("Location: ".e_PLUGIN."vtrade/admin_config.php?nomenclature");
	    exit;
	}
	$ns -> tablerender(VT_MES_00, $message);
}
//======show the categories, to make product selection easier.
$text ="<form enctype='multipart/form-data' name='form_nom_select' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";

$text .="<tr><td class='forumheader3'> 
	<select class='tbox' name='cat_id' id='cat'>
	<option value=''>" .VT_AI_01."";
		$vtsql -> db_Select("vt_cat", "*", "cat_sub<>0 AND cat_id ORDER by `cat_name` ASC");
		while($row = $vtsql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>-- $catName</option>";
			}
	$text .="</option></select> ";
	$text .="<input type='submit' class='button' style='cursor:pointer;' value='Перейти в категорию' name='submit_selectcat'><br>";
	
	if (IsSet($_POST['submit_selectcat'])){
	$vtsql -> db_Select("vt_cat", "*", "cat_id='$cat_id'");
                while($row = $vtsql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
		}
	$text .="Выбрана категория $cat_id $catName<br>";
	$text .="<select class='tbox' name='nom_id' value='$nom_id'><option value=''>".VT_AI_02." </option>";
	$vtsql1 -> db_Select("vt_index", "*", "index_catid='$cat_id'");
	    while($row = $vtsql1 -> db_Fetch()){
	    $indexNomid = $row['index_nomid'];
	    $vtsql2 -> db_Select("vt_nom", "*", "nom_id='$indexNomid'");
                while($row = $vtsql2 -> db_Fetch()){
			$nomId = $row['nom_id'];
			$nomName = $row['nom_name'];
			$text .="<option value='$nomId'>$nomName</option>";
			}
			
	    }
	$text .="</select></td></tr>";
	}
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_EDIT." name='submit_edit'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_DEL." name='submit_delete'></td></tr>";
	$text .="</table></form>";
$caption = VT_AI_CAP_01;
$ns -> tablerender($caption, $text);

	$text = "<div style='text-align:center'>
		<form method='post' action='". $PHP_SELF ."' id='dataform' enctype='multipart/form-data'>
		<table style='".ADMIN_WIDTH."' class='fborder' style='width:100%'>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Артикул</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_art' size='50' value='".$nom_art."' maxlength='250' /></td>
		</tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Наименование товара</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_name' size='80' value='".$nom_name."' maxlength='250' /></td>
		</tr>";
	$vtsql -> db_Select("vt_cat", "*", "cat_id='$cat_sub'");
		while($row = $vtsql -> db_Fetch()){
		$Cat_id = $row['cat_id'];
		$Cat_name = $row['cat_name'];
		}
	$text .="<tr><td class='forumheader3'>Категории</td>";
	$text .="<td class='forumheader3'>Присваиваются в разделе Мультикатегории после создания номенклатуры</td></tr>";
	$text .= "<tr>

		<td style='width:25%' class='forumheader3'>Подробное описание</td>
		<td style='width:75%' class='forumheader3'>";
		
	$insertjs = (!e_WYSIWYG)?"rows='25' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='25' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='nom_desc_all' cols='80' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$nom_desc_all</textarea>";
	//===============================select cat_icon=================================
        $fl = new e_file;
	if($iconlist = $fl->get_files(e_PLUGIN."vtrade/vt_pictures/product_icons/", ".jpg|.gif|.png|.JPG|.GIF|.PNG")){
        sort($iconlist);
}
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Краткое описание</td>
		<td style='width:75%' class='forumheader3'>";
	$text .= "<textarea class='tbox' id='data' name='nom_desc_mini' cols='80'>$nom_desc_mini</textarea></td>";
	
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>Выбрать иконку для товара</td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='nom_pic' name='nom_pic' value='$nom_pic' size='40' maxlength='100' />
		<input type ='button' class='button' style='cursor:pointer' size='30' value='Обзор' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($iconlist as $icon){
			$list_icon = str_replace(e_PLUGIN."vtrade/vt_pictures/product_icons/","",$icon['path'].$icon['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','nom_pic','linkicn')\"><img width=50px src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a>";
		}
	$text .= "</div></td></tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Видимость товара</td>
		<td style='width:75%' class='forumheader3'>";
	$text .="<select class='tbox' name='nom_vis' value='$nom_vis'>";
	if ($nom_vis <>'') $text .="<option value=''>$nom_vis</option>";
	$text .="<option value='".VT_YES."'>".VT_YES."</option>
		    <option value='".VT_NO."'>".VT_NO."</option>";
	$text .= "</td></tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Цена товара</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_price1' size='40' value='".$nom_price1."' maxlength='250' /></td>
		</tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Цена товара со скидкой</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_price2' size='40' value='".$nom_price2."' maxlength='250' /></td>
		</tr>";
	$text .= "<input type='hidden' name='nom_id' value='".$nom_id."'>";
	$text .= "<tr><td colspan=12 class='forumheader2'><center>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".VT_BUT_AGR." name='submit_insert'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_UPD." name='submit_update'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_CANS." name='submit_reset'>
		</center></td></tr>";
	$text .= "</table></form></div>";

	$caption = "Редактирование номенклатуры";
	$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//					MULTICATEGORY OPTIONS
// =================================================================================================
if(isset($qs[0]) && $qs[0] == "multicat"){
	$cat_id = $_POST['cat_id'];
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
	$nom_id = $_POST['nom_id'];
	$nom_cat = $_POST['nom_cat'];
	$nom_num = $_POST['nom_num'];
	$nom_art = $_POST['nom_art'];
	$nom_name = $_POST['nom_name'];
	$nom_type = $_POST['nom_type'];
	$nom_unit = $_POST['nom_unit'];
	$nom_desc_mini = $_POST['nom_desc_mini'];
	$nom_desc_all = $_POST['nom_desc_all'];
	$nom_pic = $_POST['nom_pic'];
	$nom_price1 = $_POST['nom_price1'];
	$nom_price2 = $_POST['nom_price2'];
	$index_id = $_POST['index_id'];
if (IsSet($_POST['submit_edit'])){
	$vtsql -> db_Select("vt_nom", "*", "nom_id='$nom_id'");
	while($row = $vtsql -> db_Fetch()){
	$nom_id = $row['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_name = $row['nom_name'];
	}
}
if (isset($_POST['submit_add'])){
	$index_nomid = $nom_id;
	$index_catid = $cat_id;
	$vtsql1 -> db_Insert("vt_index", "0,'$index_nomid','$index_catid'");
	$count = $vtsql2 -> db_Count("vt_index", "(*)", "WHERE index_nomid='$index_nomid'");
	$message = $count;
	$vtsql3 -> db_Update("vt_nom", "nom_cat='$count' WHERE nom_id='$nom_id'");
}
if (isset($_POST['submit_reset'])){
	header ("Location: ".e_PLUGIN."vtrade/admin_config.php?multicat");
	exit;
}
// -----removal of existing record---------------------------------------------------
if (IsSet($_POST['submit_delete'])){
	$vtsql1 -> db_Select("vt_index", "*", "index_id='$index_id'");
	while($row = $vtsql1 -> db_Fetch()){
		$index_nomid = $row['index_nomid'];
	}
	$vtsql2 -> db_Delete("vt_index", "index_id='$index_id'");
	$count = $vtsql3 -> db_Count("vt_index", "(*)", "WHERE index_nomid='$index_nomid'");
	$vtsql4 -> db_Update("vt_nom", "nom_cat='$count' WHERE nom_id='$index_nomid'");
}
//======show the categories, to make product selection easier.
$text ="<form enctype='multipart/form-data' name='form_nom_select' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";

$text .="<tr><td class='forumheader3'> 
	<select class='tbox' name='cat_id'>
	<option value=''>" .VT_AI_01."</option>
	<option value='0'>-- Нераспределенная номенклатура</option>";

	$vtsql -> db_Select("vt_cat", "*", "cat_sub<>0 AND cat_id ORDER by `cat_name` ASC");
                while($row = $vtsql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>-- $catName</option>";
			}
	$text .="</select> ";
	$text .="<input type='submit' class='button' style='cursor:pointer;' value='Перейти в категорию' name='submit_selectcat'><br>";
	
	if (IsSet($_POST['submit_selectcat'])){
	    if ($cat_id=='0'){
		$text .="Выбрана категория Нераспределенная номенклатура<br>";
		$text .="<select class='tbox' name='nom_id'>";
		$text .="<option value=''>".VT_AI_02." </option>";
		$vtsql2 = new db;
		$vtsql2 -> db_Select("vt_nom", "*", "nom_cat='0' OR nom_cat=''");
		while($row = $vtsql2 -> db_Fetch()){
			$nomId = $row['nom_id'];
			$nomName = $row['nom_name'];
			$text .="<option value='$nomId'>$nomName";
		}
	    }
	    else {
		$vtsql -> db_Select("vt_cat", "*", "cat_sub<>0 AND cat_id ORDER by `cat_name` ASC");
                while($row = $vtsql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
		}
		$text .="Выбрана категория $catName<br>";
		$text .="<select class='tbox' name='nom_id' value='$nom_id'><option value=''>".VT_AI_02." </option>";
		$vtsql1 = new db;
		$vtsql1 -> db_Select("vt_index", "*", "index_catid='$cat_id'");
		while($row = $vtsql1 -> db_Fetch()){
		      $indexNomid = $row['index_nomid'];
		      $vtsql2 = new db;
		      $vtsql2 -> db_Select("vt_nom", "*", "nom_id='$indexNomid'");
		      while($row = $vtsql2 -> db_Fetch()){
			  $nomId = $row['nom_id'];
			  $nomName = $row['nom_name'];
			  $text .="<option value='$nomId'>$nomName";
		      }
			
		 }
	    }
	$text .="</select></td></tr>";
	}
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_EDIT." name='submit_edit'></td></tr>";
	$text .="</table></form>";
	$caption = VT_AI_CAP_01;
$ns -> tablerender($caption, $text);
//------форма добавления в категории и удаления из категорий-----//
	$text = "<div style='text-align:center'>
		<form method='post' action='". $PHP_SELF ."' id='dataform' enctype='multipart/form-data'>
		<table style='".ADMIN_WIDTH."' class='fborder' style='width:100%'>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Принадлежит категориям</td>
		<td style='width:75%' class='forumheader3'>";
		$vtsql1 = new db;
		$vtsql1 -> db_Select("vt_index", "*", "index_nomid='$nom_id'");
		while($row = $vtsql1 -> db_Fetch()){
		      $IndexCatId = $row['index_catid'];
		      $vtsql2 = new db;
		      $vtsql2 -> db_Select("vt_cat", "*", "cat_id='$IndexCatId'");
		      while($row = $vtsql2 -> db_Fetch()){
			  $CatId = $row['cat_id'];
			  $CatName = $row['cat_name'];
			  $text .="$CatName<br>";
		      }
		 }
	$text .= "</td></tr>";
//------Наименование товара-----//
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Наименование товара</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_name' size='80' value='$nom_name' maxlength='250' /></td>
		</tr>";
//------Окно выбора для присвоение номенклатуре категории------//
	$vtsql -> db_Select("vt_cat", "*", "cat_sub<>0 AND cat_id ORDER by `cat_name` ASC");
		while($row = $vtsql -> db_Fetch()){
		$Cat_id = $row['cat_id'];
		$Cat_name = $row['cat_name'];
		}
	$text .="<tr><td class='forumheader3'>Назначить категорию<td class='forumheader3'>
	<select class='tbox' name='cat_id'>";
	$text .= "<option value=''>" .VT_AI_01."</option>";
	$vtsql -> db_Select("vt_cat", "*", "cat_sub<>0 AND cat_id ORDER by `cat_name` ASC");
                while($row = $vtsql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>-- $catName</option>";
			}
	$text .="</select>  <input type='submit' class='button' value=".VT_BUT_ADD." name='submit_add'></td></tr>";
//------Окно для удаления номенклатуры из категории------//
	$text .="<tr><td class='forumheader3'>Удалить из категории<td class='forumheader3'>
	<select class='tbox' name='index_id'>";
	$text .= "<option value=''>" .VT_AI_01."</option>";
	$vtsql -> db_Select("vt_index", "*", "index_nomid='$nom_id'");
		while($row = $vtsql -> db_Fetch()){
		      $IndexCatId = $row['index_catid'];
		      $IndexId = $row['index_id'];
		      $vtsql1 -> db_Select("vt_cat", "*", "cat_id='$IndexCatId' ORDER by `cat_name` ASC");
		      while($row = $vtsql1 -> db_Fetch()){
			  $CatId = $row['cat_id'];
			  $CatName = $row['cat_name'];
			  $text .="<option value='$IndexId'>$IndexId $CatName</option>";
		      }
		 }
	$text .="</select> <input type='submit' class='button' value=".VT_BUT_DEL." name='submit_delete'></td></tr>";
	$text .= "<input type='hidden' name='nom_id' value='".$nom_id."'>";
	$text .= "<tr><td colspan=12 class='forumheader2'><center>
		<input type='submit' class='button' value=".VT_BUT_RES." name='submit_reset'>
		</center></td></tr>";
	$text .= "</table></form></div>";
	$caption = "Распределение номенклатуры по категориям";
	$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				NOMENKLATURE IMPORT OPTIONS MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == "nomenclature_import")){
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
$sql -> db_Select("vt_nom", "*", "nom_id='$nom_id'");
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
$sql -> db_Update("vt_nom", "nom_id='$nom_id', nom_cat='$nom_cat', nom_num='$nom_num', nom_art='$nom_art',  nom_code='$nom_code', nom_name = '$nom_name', nom_type='$nom_type', nom_unit='$nom_unit', nom_desc='$nom_desc', nom_pic='$nom_pic', nom_price1='$nom_price1', nom_price2='$nom_price2', nom_price3='$nom_price3', nom_price4='$nom_price4' WHERE nom_id=$nom_id");
	$nom_num=$nom_art=$nom_code=$nom_name=$nom_type=$nom_unit=$nom_cat=$nom_desc=$nom_pic=$nom_price1=$nom_price2=$nom_price3=$nom_price4='';
	$vis = 'none';
	$unvis = 'yes';
}
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("vt_nom", "nom_id='$nom_id'");
}
if (IsSet($_POST['submit_insert'])){
	if ($nom_name == ""){ 
	$message = "<font color=red>".VT_MES_11."</font>";
	}
	else {
		$sql = new db;
		$sql -> db_Insert("vt_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
		$message = "<font color=red>".VT_MES_12."</font>";
		$nom_id=$nom_name=$nom_cat=$nom_desc='';
		header ("Location: ".e_PLUGIN."vtrade/admin_config.php?nomenclature");
		exit;
		}
	$ns -> tablerender(VT_MES_00, $message);
}


/*
if (IsSet($_POST['submit_import'])){
	    $row=1;
	    $handle=fopen(e_PLUGIN."vtrade/proba.csv","r");
	    while($data=fgetcsv($handle,1000,";")){
//	      $sql = new db;
//	      $sql -> db_Insert("vt_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
	      $num=count($data);
	      $text .= "<p> $num полей в строке $row: \n";
		  $row++;
		  for ($c=0; $c<$num;$c++){
		  
//	      $text .= $data[$c] . "\n";
		  }
	      $sql = new db;
	      $sql -> db_Insert("vt_nom", "0, '1', '$nom_num', '$data[0]', '$nom_code', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$data[3]', '$nom_price3', '$nom_price4'");
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
	    $handle=fopen(e_PLUGIN."vtrade/price/proba.csv","r");
	    $count_cat=0;
	    $n=0;
	    while($data=fgetcsv($handle,65536,";")){
	    
//	      $sql = new db;
//	      $sql -> db_Insert("vt_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
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
		  $sql -> db_Insert("vt_cat", "$count_cat1, '1', '0', '$data[1]','$data[3]','$data[4]'");
	     }
	     else{
	      $n++;
	      $sql = new db;
		if ($data[0]==''){
		  $sql -> db_Insert("vt_nom", "$n, '$count_cat1', '$nom_num', '$data[0]', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc_mini','$data[4]', '$data[3]', '$data[2]', '$nom_price2'");
		 }
		 else{
		  $sql -> db_Insert("vt_nom", "$n, '$count_cat1,$data[0]', '$nom_num', '$data[0]', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc_mini','$data[4]', '$data[3]', '$data[2]', '$nom_price2'");
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
	    $handle=fopen(e_PLUGIN."vtrade/price/vt_index.csv","r");
	    $count_cat=0;
	    while($data=fgetcsv($handle,65536,";")){
	    
//	      $sql = new db;
//	      $sql -> db_Insert("vt_nom", "0, '$nom_cat', '$nom_num', '$nom_art', '$nom_code', '$nom_name', '$nom_type', '$nom_unit', '$nom_desc', '$nom_pic', '$nom_price1', '$nom_price2', '$nom_price3', '$nom_price4'");
	      $num=count($data);
	      $text .= "<p> $num полей в строке $row: \n";
		  $row++;
		  for ($c=0; $c<$num;$c++){
		  
//	      $text .= $data[$c] . "\n";
		  }

	      
	$count_cat++;
	$sql = new db;
	$sql -> db_Insert("vt_index", "$count_cat, '$data[0]','$data[1]'");
		if ($data[2]<>''){
		$count_cat++;
		$sql1 = new db;
		$sql1 -> db_Insert("vt_index", "$count_cat, '$data[0]','$data[2]'");
		}
	     }
fclose($handle);
//}
$ns -> tablerender($caption,$text);
}

if (IsSet($_POST['submit_clearcat'])){
      if ($cat_id==''){
	    $message = "<font color=red>Не выбрана категория</font>";
	    $ns -> tablerender(VT_MES_CAP, $message);
      } else {
	    $sql = new db;
	    $sql -> db_Select("vt_cat", "*", "cat_sub='".$cat_id."'");
	    while($row = $sql -> db_Fetch()){
	      $catId = $row['cat_id'];
	      $sql1 = new db;
	      $sql1 -> db_Delete("vt_nom", "nom_cat='".$catId."'");
	    $message = $catId;
	    $ns -> tablerender(VT_MES_CAP, $message);
	    }
      $sql = new db;
      $sql -> db_Delete("vt_cat", "cat_sub='".$cat_id."'");
      }
}
//======form import or export csv=============================.
$text ="<form enctype='multipart/form-data' name='form_nom_import' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>";
	$text .="<tr><td class='forumheader3'>" .VT_AI_01." *
	<select class='tbox' name='catId' id='cat'>
	<option value=''>" .VT_AI_01."";
		$sql -> db_Select("vt_cat", "*", "cat_sub='0'");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
			}
	$text .="</option></select><br>";
	$text .="<input type='submit' class='button' style='cursor:pointer;' value='Импорт файла' name='submit_import'> ";
	$text .="<input type='submit' class='button' style='cursor:pointer;' value='Очистить категорию' name='submit_clearcat'>";
	$text .="</table></form>";
$caption = VT_AI_CAP_01;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//				           ORDERS
// =================================================================================================
if(!isset($qs[0]) || isset($qs[0]) && $qs[0] == "order"){
$order_id = $_POST['order_id'];
$order_userid = $_POST['orderUserId'];
// -----form for purchases in the status the 'sending'---------------------------
$text .="<form enctype='multipart/form-data' name='form_select_old' method='post' action='". $PHP_SELF ."'>";
$text .="<table height='50px'>";
$count = $sql -> db_Count("vt_order", "(*)", "WHERE order_status='send'");
$text .="<tr><td><font size=2>На данный момент есть <b>$count</b> необработанных заказов (статус <b>[Отправлен]</b>)</font></td></tr>";
$text .="<tr><td>
	<select name='order_id'>
	<option value=''>Нажмите, чтобы выбрать</option>";
		$sql -> db_Select("vt_order", "*", "order_status='send'");
                while($row = $sql -> db_Fetch()){
			$orderId = $row['order_id'];
			$orderDate = $row['order_date'];
			$text .="<option value='$orderId'>Заказ № $orderId от ".strftime('%d.%m.%y',$orderDate)."</option>";
			}
	$text .="</select> <input type='submit' style='cursor:pointer;' value='Обработать заказ' name='submit_viewing'>
	</td></tr>";
	$text .="</table></form>";
$caption = "Заказы";
$ns -> tablerender($caption, $text);
//-----ready
if (IsSet($_POST['submit_ready'])){
$vtsql -> db_Update("vt_order", "order_status='ready' WHERE order_id='$order_id'");
}
//-----form
if (IsSet($_POST['submit_viewing'])){
    
	$vtsql -> db_Select("vt_order", "*", "order_id='$order_id' AND order_status='send'");
                while($row = $vtsql -> db_Fetch()){
			$orderId = $row['order_id'];
			$orderDate = $row['order_date'];
			$orderUserId = $row['order_userid'];
			}
	$text ="<font size=2>Заказ № $orderId от ".strftime('%d.%m.%y',$orderDate)."</font><hr><br>";
	$text .="<form enctype='multipart/form-data' name='form_order' method='post' action='".$PHP_SELF."'><table width=100%>";
	$text .="<tr><td class='fcaption'>№</td><td class='fcaption'>Наименование</td><td class='fcaption'>Цена</td><td class='fcaption'>Количество</td><td class='fcaption'>Сумма</td>";
	$number = 1;
	$chet = 1;
	$total = 0;
	$vtsql -> db_Select("vt_order", "*", "order_id='$order_id'");
	while($row = $vtsql -> db_Fetch()){
		$order_id = $row['order_id'];
		$order_user = $row['order_user'];
		$order_date = $row['order_date'];
		$order_address = $row['order_address'];
		$order_icq = $row['order_icq'];
		$order_email = $row['order_email'];
		$order_phone = $row['order_phone'];
		$order_bonus = $row['order_bonus'];
		$order_delivery = $row['order_delivery'];
		$order_payment = $row['order_payment'];
	}
	$vtsql -> db_Select("vt_basket", "*", "basket_ordnumber='$order_id'");
	while($row = $vtsql -> db_Fetch()){
		$basket_id = $row['basket_id'];
		$basket_userid = $row['basket_userid'];
		$basket_nom_name = $row['basket_nom_name'];
		$basket_nom_art = $row['basket_nom_art'];
		$basket_amount = $row['basket_amount'];
		$basket_price = $row['basket_price'];
		$sum = $basket_amount * $basket_price;
	if ($chet == 1) {    
		$class = "forumheader2";
	}
	if ($chet == 2) {    
		$class = "forumheader3";
		$chet = 0;
	}
    $text .="<tr><td class='$class'>$number</td><td class='$class'>$basket_nom_name</td><td class='$class'>$basket_price</td><td class='$class'>$basket_amount</td><td class='$class'>$sum</td>";
    $chet++;
    $number ++;
    $total = $total + $sum;
    }
    $text .="<tr><td colspan=5 class='fcaption'>Всего: ".number_format($total,2)." руб</td>";
    $text .="</table>";
    include('discount.php');
    $text .="<font size=2><br>Данный заказ сделан с типом скидки: <u>$order_bonus</u>";
    $text .="<font size=2><br>Способ оплаты: <u>$order_payment</u>";
    $text .="<br>Сумма заказа: <u>".number_format($total,2)." руб</u>";
    $text .="<br>Скидка составила: <u>".number_format($discount,2)." руб</u>";
    $text .="<br>Доставка: <u>".number_format($order_delivery,2)." руб</u>";
    $text .="<br>Итог: <u>".number_format($total-$discount+$order_delivery,2)." руб</u><br><br><br>";
   
    $text .="<font size=2>Информация о заказчике</font><hr>";
    $text .= "Данный заказ сделал(а): <u>$order_user</u><br>";
    $text .= "Организация: <u>$order_org</u><br>";
    $text .= "Адрес: <u>$order_address</u><br>";
    $text .= "ICQ: <u>$order_icq</u><br>";
    $text .= "E-mail: <u>$order_email</u><br>";
    $text .= "Tелефон(ы): <u>$order_phone</u><br>";
    $text .="<input class='tbox' type='hidden' name='order_id' value='$order_id' />";
    $text .= "<br><input style='cursor:pointer' type='submit' value='Перевести заказ в статус [Обработан]' name='submit_ready'>";
    
    $text .="</font></form>";
    $caption = "Обработка заказа";
    $ns -> tablerender($caption, $text);
}
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//				           ABOUT PLUGIN
// =================================================================================================
if(isset($qs[0]) && $qs[0] == "about"){
$text="<table><tr>";
$text.="<td><a href='http://e107.compolys.ru'><img src='".e_PLUGIN."nboard/theme/logo_compolys.png' alt='".VT_INFO."'></a>";
$text.= "<td align='center'> ".VT_INFO_00."
<br>author - ComPolyS, http://e107.compolys.ru, e107@compolys.ru
<br>coder - Sunout, sunout@compolys.ru, license GNU GPL
<br>================= march 2011 ====================";
$text.="</tr></table>";
$text.="<b>".VT_ABO_00."</b><br>";
$text.="".VT_ABO_INFO."<br>";
$caption = VT_ABO_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
//==================================================================================================
//				           GENERAL
// =================================================================================================
if(isset($qs[0]) && $qs[0] == "gnl"){
$text ="<table width=100%>";
$text.="<tr><td style='background:#ccc;width:50px;font-size:14px;'>№</td>";
$text.="<td style='background:#ccc;width:40px;font-size:14px;'>Фото</td>";
$text.="<td style='background:#ccc;width:auto;font-size:14px;'>Наименование номенклатуры</td>";
$text.="<td style='background:#ccc;width:100px;font-size:14px;'>Цена</td>";
$text.="<td style='background:#ccc;width:100px;font-size:14px;'>Опции</td>";
$text .="</table>";
$text .="<div style='height:500px; overflow-y:scroll;'>";
$text .="<table width=100%>";

$count=1;
$vtsql = new db;
$vtsql -> db_Select("vt_nom", "*", "nom_id ORDER BY `nom_id` ASC");
	while($row = $vtsql -> db_Fetch()){
	$nom_id = $row['nom_id'];
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
	$nom_price3 = $row['nom_price3'];
	$nom_price4 = $row['nom_price4'];
		if($count==1){
			  $text.="<tr><td style='background:#fff;width:50px;'>$nom_id</td>";
			  $text.="<td style='background:#fff;height:20px;width:40px;'><img src='".e_PLUGIN."vtrade/vt_pictures/product_icons/$nom_pic' height=20px></td>";
			  $text.="<td style='background:#fff;'>$nom_name</td>";
			  $text.="<td style='background:#fff;width:100px;'>$nom_price1</td>";
			  $text.="<td style='background:#fff;width:80px;'><a href='".e_SELF."?".($pge['page_theme'] ? "createm": "create").".edit.{$pge['page_id']}'>".ADMIN_EDIT_ICON."</a>
				<input type='image' title='".LAN_DELETE."' name='delete[{$pge['page_id']}]' src='".ADMIN_DELETE_ICON_PATH."' onclick=\"return jsconfirm('".CUSLAN_4." [ ID: $pge[page_id] ]')\"/></td>";
		}
		if($count==2){
			  $text.="<tr><td style='background:#eee;'>$nom_id</td>";
			  $text.="<td style='background:#eee;height:20px;width:40px;'><img src='".e_PLUGIN."vtrade/vt_pictures/product_icons/$nom_pic' height=20px></td>";
			  $text.="<td style='background:#eee;'>$nom_name</td>";
			  $text.="<td style='background:#eee;width:100px;'>$nom_price1</td>";
			  $text.="<td style='background:#eee;width:80px;'><a href='".e_SELF."?".($pge['page_theme'] ? "createm": "create").".edit.{$pge['page_id']}'>".ADMIN_EDIT_ICON."</a>
				<input type='image' title='".LAN_DELETE."' name='delete[{$pge['page_id']}]' src='".ADMIN_DELETE_ICON_PATH."' onclick=\"return jsconfirm('".CUSLAN_4." [ ID: $pge[page_id] ]')\"/></td>";
			  $count = 0;
		}
		$count++;
	}
$text .="</table>";
$text .="</div><br>";
$text .="<input type=submit value='Добавить категорию'>";
$text .="<input type=submit value='Добавить номенклатуру'>";
$text .="<input type=submit value='Загрузить изображения'>";
$caption = VT_ABO_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           ADMIN_CONFIG OPTIONS MENU
// =================================================================================================
if(isset($qs[0]) && $qs[0] == "config"){
	
//======UPDATE========//
if(IsSet($_POST['savesettings'])){
	$pref['conf_vthead'] = $_POST['conf_vthead'];
	$pref['conf_dateformat'] = $_POST['conf_dateformat'];
	$pref['conf_func'] = $_POST['conf_func'];
	$pref['conf_admail'] = $_POST['conf_admail'];
	$pref['conf_days'] = $_POST['conf_days'];
	$pref['conf_sizepicbig'] = $_POST['conf_sizepicbig'];
	$pref['conf_sizepicsmall'] = $_POST['conf_sizepicsmall'];
	$pref['conf_showcolscat'] = $_POST['conf_showcolscat'];
	$pref['conf_showrowscat'] = $_POST['conf_showrowscat'];
	$pref['conf_showcolsitems'] = $_POST['conf_showcolsitems'];
	$pref['conf_showrowsitems'] = $_POST['conf_showrowsitems'];
	$pref['conf_newshow'] = $_POST['conf_newshow'];
	$pref['conf_newhead'] = $_POST['conf_newhead'];
	$pref['conf_newitems'] = $_POST['conf_newitems'];
	$pref['conf_saleshow'] = $_POST['conf_saleshow'];
	$pref['conf_salehead'] = $_POST['conf_salehead'];
	$pref['conf_saleitems'] = $_POST['conf_saleitems'];
	save_prefs();
$message = VT_MES_00;
$caption = VT_MES_CAP;
$ns -> tablerender($caption,$message);
}
	$text ="<form enctype='multipart/form-data' name='config_form' method='post' action=''><table class='fborder' style='width:100%' align='center'>";
	$text .="<input type='hidden' name='conf_id' value='$conf_id'>";
	$text .= "<tr><td colspan=2 class='vt_caption' width='60%'>".VT_CONF_GNL_CAP."</td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_02."</td><td class='vt_header1'><input class='tbox' size='40' type='text' name='conf_vthead' value='".$pref['conf_vthead']."'></input></td></tr>";

//	$text .= "<tr><td colspan=2 class='fcaption'>".VT_CONF_03."</td></tr>";

	$text .= "<tr><td class='vt_header2'>".VT_CONF_05."</td><td class='vt_header2'><input class='tbox' size='40' type='text' name='conf_admail' value='".$pref['conf_admail']."'></input></td></tr>";

//	$text .= "<tr><td colspan=2 class='fcaption'>".VT_CONF_07."</td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_08."</td><td class='vt_header1'><input type='text' name='conf_sizepicbig' class='tbox' value='".$pref['conf_sizepicbig']."' size='40'></td></tr>";
	$text .= "<tr><td class='vt_header2'>".VT_CONF_09."</td><td class='vt_header2'><input type='text' name='conf_sizepicsmall' class='tbox' value='".$pref['conf_sizepicsmall']."' size='40'></td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_10."</td><td class='vt_header1'><input type='text' name='conf_showcolscat' class='tbox' value='".$pref['conf_showcolscat']."' size='40'></td></tr>";
	$text .= "<tr><td class='vt_header2'>".VT_CONF_11."</td><td class='vt_header2'><input type='text' name='conf_showrowscat' class='tbox' value='".$pref['conf_showrowscat']."' size='40'></td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_12."</td><td class='vt_header1'><input type='text' name='conf_showcolsitems' class='tbox' value='".$pref['conf_showcolsitems']."' size='40'></td></tr>";
	$text .= "<tr><td class='vt_header2'>".VT_CONF_13."</td><td class='vt_header2'><input type='text' name='conf_showrowsitems' class='tbox' value='".$pref['conf_showrowsitems']."' size='40'></td></tr>";
	$text .= "<tr><td colspan=2 class='vt_caption'>".VT_CONF_NEW_CAP."</td></tr>";
        $text .= "<tr><td class='vt_header1'>".VT_CONF_NEW_01."</td>
	<td class='vt_header1'><select class='tbox' type='text' name='conf_newshow'><option selected value='".$pref['conf_newshow']."'>".$pref['conf_newshow']."
		<option value=".VT_YES.">".VT_YES."
		<option value=".VT_NO.">".VT_NO."
	</select></td></tr>";
	$text .= "<tr><td class='vt_header2'>".VT_CONF_NEW_02."</td><td class='vt_header2'><input class='tbox' size='40' type='text' name='conf_newhead' value='".$pref['conf_newhead']."'></input></td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_NEW_03."</td><td class='vt_header1'><input type='text' name='conf_newitems' class='tbox' value='".$pref['conf_newitems']."' size='40'></td></tr>";

	$text .= "<tr><td colspan=2 class='vt_caption'>".VT_CONF_SALE_CAP."</td></tr>";
        $text .= "<tr><td class='vt_header1'>".VT_CONF_SALE_01."</td>
	<td class='vt_header1'><select class='tbox' type='text' name='conf_saleshow'><option selected value='".$pref['conf_saleshow']."'>".$pref['conf_saleshow']."
		<option value=".VT_YES.">".VT_YES."
		<option value=".VT_NO.">".VT_NO."
	</select></td></tr>";
	$text .= "<tr><td class='vt_header2'>".VT_CONF_SALE_02."</td><td class='vt_header2'><input class='tbox' size='40' type='text' name='conf_salehead' value='".$pref['conf_salehead']."'></input></td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_SALE_03."</td><td class='vt_header1'><input type='text' name='conf_saleitems' class='tbox' value='".$pref['conf_saleitems']."' size='40'></td></tr>";
	$text .= "<tr><td colspan=2 class='vt_caption'>".VT_CONF_HIT_CAP."</td></tr>";
        $text .= "<tr><td class='vt_header1'>".VT_CONF_HIT_01."</td>
	<td class='vt_header1'><select class='tbox' type='text' name='conf_hitshow'><option selected value='".$pref['conf_hitshow']."'>".$pref['conf_hitshow']."
		<option value=".VT_YES.">".VT_YES."
		<option value=".VT_NO.">".VT_NO."
	</select></td></tr>";
	$text .= "<tr><td class='vt_header2'>".VT_CONF_HIT_02."</td><td class='vt_header2'><input class='tbox' size='40' type='text' name='conf_salehead' value='".$pref['conf_hithead']."'></input></td></tr>";
	$text .= "<tr><td class='vt_header1'>".VT_CONF_HIT_03."</td><td class='vt_header1'><input type='text' name='conf_saleitems' class='tbox' value='".$pref['conf_hititems']."' size='40'></td></tr>";
	$text .= "<tr><td class='forumheader' colspan='2' style='text-align:center'><input class='button' name='savesettings' type='submit' value= ".VT_BUT_AGR."></td></tr></table></form>";
	
	$caption = VT_CONF_CAP;
	$ns -> tablerender($caption, $text);
	require_once(e_ADMIN."footer.php");
	exit;
}
require_once(e_ADMIN."footer.php");
function admin_config_adminmenu(){
	if (e_QUERY){
		$tmp = explode(".", e_QUERY);
		$cat_action = $tmp[0];
	}
	if (!isset($cat_action) || ($cat_action == "")){
		  $cat_action = "order";
	}
	$var['order']['text'] = VT_MENU_04;
	$var['order']['link'] ="admin_config.php?order";
	$var['gnl']['text'] = "Главная страница";
	$var['gnl']['link'] ="admin_config.php?gnl";
	$var['cat']['text'] = VT_MENU_02;
	$var['cat']['link'] ="admin_config.php?cat";
	$var['nomenclature']['text'] = VT_MENU_03;
	$var['nomenclature']['link'] ="admin_config.php?nomenclature";
	$var['multicat']['text'] = "Мультикатегории";
	$var['multicat']['link'] ="admin_config.php?multicat";
	$var['nomenclature_import']['text'] = "Импорт номенклатуры";
	$var['nomenclature_import']['link'] ="admin_config.php?nomenclature_import";
	$var['config']['text'] = VT_MENU_CONF;
	$var['config']['link'] = "admin_config.php?config";
	$var['about']['text'] = VT_MENU_06;
	$var['about']['link'] ="admin_config.php?about";
	
	show_admin_menu(VT_MENU_00, $cat_action, $var);
}
//function theme_head() {
//	return "<script type='text/javascript' src='".e_PLUGIN."vtrade/ajax/select_nom.js'></script>
//		<script type='text/javascript' src='".e_PLUGIN."vtrade/ajax/admin_config.js'></script>\n
//		<link rel='stylesheet' href='".e_PLUGIN."vtrade/theme/vtrade.css' type='text/css' />";
//}
?>