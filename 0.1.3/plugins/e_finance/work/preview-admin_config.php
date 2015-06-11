<?php
/*============================= Virtual-Trade v1.0 ===============================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru		
//	coders: Sunout, Geo						
//	language officer Georgy Pyankov
//	license GNU GPL									
//==================================== March 2012 ===============================*/
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

$e_sub_cat = 'custom';
$e_wysiwyg = "data";
$vis = 'none';
$unvis = 'yes';
// =================================================================================================
//				               CAT OPTIONS MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == "cat")){
	$cat_id = $_POST['cat_id'];
	$cat_sub = $_POST['cat_sub'];
	$cat_name = $_POST['cat_name'];
	$cat_img = $_POST['cat_img'];
	$cat_desc = $_POST['cat_desc'];
//======Edit_notes======//
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
		}
	$vis = 'yes';
	$unvis = 'none';
	}
}
//======Delete_notes======//
if (IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("vt_cat", "cat_id='$cat_id'");
}
//======Insert_notes======//
if (IsSet($_POST['submit_insert'])){
	if ($cat_name == ""){
		$message = VT_MES_04;
	}
	else {
		$sql = new db;
		$sql -> db_Insert("vt_cat","'0','$cat_sub','$cat_name','$cat_img','$cat_desc'");
	$message = VT_MES_05;
	$cat_id=$cat_name=$cat_desc=$cat_img='';
	header ("Location: ".e_PLUGIN."vtrade/admin_config.php?cat");
	exit;
	}
$caption = VT_MES_CAP;
$ns -> tablerender($caption, $message);
}
//======Update_notes======//	
	if (IsSet($_POST['submit_update'])){
	$sql -> db_Update("vt_cat", "cat_sub='$cat_sub', cat_name='$cat_name', cat_desc='$cat_desc', cat_img='$cat_img' WHERE cat_id='$cat_id'");
		$message = VT_MES_06;
		$ns -> tablerender(VT_MES_00, $message);
	$cat_id=$cat_name=$cat_desc=$cat_img='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	$cat_id = $cat_name = $cat_desc = $cat_img = '';
	$vis = 'none';
	$unvis = 'yes';
	}
//==============Edit and Deleted
	$text ="<form name='config' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
        $text .= "<tr><td>".VT_AC_01."</td><td class='forumheader2' width='70%'><select class='tbox' name='cat_id'>";
	$sql -> db_Select("vt_cat", "*", "");
                while($row = $sql -> db_Fetch()){
			$eyetom = $row['cat_id'];
			$eyename = $row['cat_name'];
			$text .="<option value='$eyetom'>$eyename";
		}
	$text .="</select></td></tr><tr><td>";
	$text .="".VT_BUT_EDIT."<input type=radio name='submit_edit' value=edit>&nbsp;&nbsp;
		".VT_BUT_DEL."<input type=radio name='submit_delete' value=delete>&nbsp;&nbsp;
		<input class='button' type=submit value=".VT_BUT_AGR."></td></tr></table></form>";
$caption = VT_AC_CAP;
$ns -> tablerender($caption, $text);
//=============================form new category=================================
	$text ="<form name='config' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .= "<tr><td width='30%'>".VT_AC_02."</td><td class='forumheader2' width='70%'>
	<input size='40' class='tbox' type='text' name='cat_name' value='$cat_name'>
	<input type='text' name='cat_id' value='$cat_id' style='display:none;'></td></tr>";
	$text .= "<tr><td>".VT_AC_03."</td><td class='forumheader2'><select class='tbox' name='cat_sub'>
	<option value='0'><i>None</i>";
	$sql -> db_Select("vt_cat", "*", "");
	while($row = $sql -> db_Fetch()){
		$eyetom = $row['cat_id'];
		$eyename = $row['cat_name'];
		$text .="<option value='$eyetom'>$eyename";
	}
	$text .="</select></td></tr>";
//===============================select cat_img=================================
$fl = new e_file;
if($imglist = $fl->get_files(e_PLUGIN."vtrade/vt_pictures/category/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        sort($imglist);
}
	$text .= "<tr>
		<td>".VT_IMG_02." </td>
		<td class='forumheader3'><input class='tbox' type='text' id='cat_img' name='cat_img' value='$cat_img' size='40'>
		<input type ='button' class='button' style='cursor:pointer' size='30' value='".VT_IMG_03."' onclick='expandit(this)'>
		<div id='linkimg' style='display:none;{head}'>";
		foreach($imglist as $img){
			$list_img = str_replace(e_PLUGIN."vtrade/vt_pictures/category/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_img."','cat_img','linkimg')\"><img src='".$img['path'].$img['fname']."' style='border:0' width=50px alt='' /></a> ";
		}
	$text .= "</div></td></tr>";

	$text .= "<tr><td>".VT_AC_04." </td><td class='forumheader2'><textarea name='cat_desc' class='tbox' cols='80' rows='5'>$cat_desc</textarea></td></tr>";
	$text .= "<tr><td></td><td>
		<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".VT_BUT_AGR." name='submit_insert'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_UPD." name='submit_update'>
		<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_CANS." name='submit_reset'>
		</td></tr></table></form>";
$caption = VT_AC_CAP;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//					NOMENKLATURE OPTIONS MENU
// =================================================================================================
if(isset($qs[0]) && $qs[0] == "nomenclature"){
// Wysiwyg JS support on or off.

if (((varset($pref['wysiwyg'],FALSE) && check_class($pref['post_html'])) || defsettrue('e_WYSIWYG')) && varset($e_wysiwyg) != ""){
	require_once(e_HANDLER."tiny_mce/wysiwyg.php");
	define("e_WYSIWYG",TRUE);
	$wy = new wysiwyg($e_wysiwyg);
	$wy->render();
	// echo wysiwyg();
} else {
	define("e_WYSIWYG",FALSE);
}
	$cat_id2 = $_GET['cat_id'];
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
	$nom_desc_all = $_POST['nom_desc_all'];
	$nom_pic = $_POST['nom_pic'];
	$nom_price1 = $_POST['nom_price1'];
	$nom_price2 = $_POST['nom_price2'];
		
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
	$nom_desc_all = $row['nom_desc_all'];
	$nom_pic = $row['nom_pic'];
	$nom_price1 = $row['nom_price1'];
	$nom_price2 = $row['nom_price2'];
	}
$unvis = 'none';
$vis = 'yes';
}
//======Reset_notes======//
if (IsSet($_POST['submit_reset'])){
	$nom_num=$nom_art=$nom_code=$nom_name=$nom_type=$nom_unit=$nom_cat=$nom_desc_all=$nom_pic=$nom_price1=$nom_price2=$nom_price3=$nom_price4='';
	$vis = 'none';
	$unvis = 'yes';
}
if (isset($_POST['submit_update'])){
$sql -> db_Update("vt_nom", "nom_id='$nom_id', nom_cat='$nom_cat', nom_num='$nom_num', nom_art='$nom_art',  nom_code='$nom_code', nom_name = '$nom_name', nom_type='$nom_type', nom_unit='$nom_unit', nom_desc_all='$nom_desc_all', nom_pic='$nom_pic', nom_price1='$nom_price1', nom_price2='$nom_price2', nom_price3='$nom_price3', nom_price4='$nom_price4' WHERE nom_id=$nom_id");
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
//		exit;
		}
	$ns -> tablerender(VT_MES_00, $message);
}
//======show the categories, to make product selection easier.
$text ="<form enctype='multipart/form-data' name='form_nom_select' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";

$text .="<tr><td class='forumheader3'>" .VT_AI_01." * 
	<select class='tbox' name='cat_id' id='cat' onChange='process()'>
	<option value=''>" .VT_AI_01."";
		$sql -> db_Select("vt_cat", "*", "");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
			}
	$text .="</option></select><br>";
	$text .="".VT_AI_02." *
	<select class='tbox' name='nom_id' id='sub' onblur='checkcat()' value='$nom_id'><option value=''>".VT_AI_02." </option></select></td></tr>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_EDIT." name='submit_edit'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_DEL." name='submit_delete' onclick='return confirmDeleteNom();'></td></tr>";
	$text .="</table></form>";
$caption = VT_AI_CAP_01;
$ns -> tablerender($caption, $text);

	$text = "<div style='text-align:center'>
		<form method='post' action='".e_SELF."' id='dataform' enctype='multipart/form-data'>
		<table style='".ADMIN_WIDTH."' class='fborder'>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Артикул</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_art' size='50' value='".$nom_art."' maxlength='250' /></td>
		</tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Наименование товара</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_name' size='80' value='".$nom_name."' maxlength='250' /></td>
		</tr>";
	$text .="<tr><td class='forumheader3'>Категории *<td class='forumheader3'>
	<select class='tbox' name='cat_id' id='cat' onChange='process()'>
	<option value=''>" .VT_AI_01."";
		$sql -> db_Select("vt_cat", "*", "");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
			}
	$text .="</option></select></td></tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Описание</td>
		<td style='width:75%' class='forumheader3'>";
		
	$insertjs = (!e_WYSIWYG)?"rows='25' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);' style='width:100%'": "rows='25' style='width:100%' ";
	$data = $tp->toForm($data,FALSE,TRUE);	// Make sure we convert HTML tags to entities
	$text .= "<textarea class='tbox' id='data' name='nom_desc_all' cols='80' $insertjs>".(strstr($data, "[img]http") ? $data : str_replace("[img]../", "[img]", $data))."$nom_desc_all</textarea>";

	$text .= "</td></tr>
		<tr>
		<td style='width:25%' class='forumheader3'>".LAN_UPLOAD_IMAGES."</td>
		<td style='width:75%;' class='forumheader3'>".$tp->parseTemplate("{UPLOADFILE=".e_IMAGE."vt_pictures/products}")."</td>
		</tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Цена товара</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_price1' size='40' value='".$nom_price1."' maxlength='250' /></td>
		</tr>";
	$text .= "<tr>
		<td style='width:25%' class='forumheader3'>Цена товара со скидкой</td>
		<td style='width:75%' class='forumheader3'><input class='tbox' type='text' name='nom_price2' size='40' value='".$nom_price2."' maxlength='250' /></td>
		</tr>";
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
//				NOMENKLATURE IMPORT OPTIONS MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == "nomenclature_import")){
	$cat_id2 = $_GET['cat_id'];
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
	$nom_price3 = $_POST['nom_price3'];
	$nom_price4 = $_POST['nom_price4'];
		
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
	$nom_price3 = $row['nom_price3'];
	$nom_price4 = $row['nom_price4'];
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

if (IsSet($_POST['submit_import'])){

	    if ($cat_id==''){
	    $cat_id=0;
	    } 
//	    else {*/
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

	      if ($data[0]==''){
		  $count_cat++;
		  $count_cat1=10000+$count_cat;
		  $sql = new db;
		  $sql -> db_Insert("vt_cat", "$count_cat1, '$cat_id', '$data[1]','$data[3]','$data[4]'");
	     }
	     else{
	      $n++;
	      $sql = new db;
	      $sql -> db_Insert("vt_nom", "$n, '$count_cat1', '$nom_num', '$data[0]', '$data[1]', '$nom_type', '$nom_unit', '$nom_desc_mini','$data[4]', '$data[3]', '$data[2]', '$nom_price2'");
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
	    $sql -> db_Select("vt_cat", "*", "cat_sub='$cat_id'");
	    while($row = $sql -> db_Fetch()){
	      $catId = $row['cat_id'];
	      $sql1 = new db;
	      $sql1 -> db_Delete("vt_nom", "nom_cat='$catId'");
	    $message = $catId;
	    $ns -> tablerender(VT_MES_CAP, $message);
	    }
      $sql = new db;
      $sql -> db_Delete("vt_cat", "cat_sub='$cat_id'");
      }
}
//======form import or export csv=============================.
$text ="<form enctype='multipart/form-data' name='form_nom_import' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>";
	$text .="<tr><td class='forumheader3'>" .VT_AI_01." *
	<select class='tbox' name='cat_id' id='cat' onChange='process()'>
	<option value=''>" .VT_AI_01."";
		$sql -> db_Select("vt_cat", "*", "");
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

//======show the categories, to make product selection easier.
$text ="<form enctype='multipart/form-data' name='form_nom_select' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";

$text .="<tr><td class='forumheader3'>" .VT_AI_01." * 
	<select class='tbox' name='cat_id' id='cat' onChange='process()'>
	<option value=''>" .VT_AI_01."";
		$sql -> db_Select("vt_cat", "*", "");
                while($row = $sql -> db_Fetch()){
			$catId = $row['cat_id'];
			$catName = $row['cat_name'];
			$text .="<option value='$catId'>$catName";
			}
	$text .="</option></select><br>";
	$text .="".VT_AI_02." *
	<select class='tbox' name='nom_id' id='sub' onblur='checkcat()' value='$nom_id'><option value=''>".VT_AI_02." </option></select></td></tr>";
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_EDIT." name='submit_edit'>
	<input type='submit' class='button' style='cursor:pointer;' value=".VT_BUT_DEL." name='submit_delete' onclick='return confirmDeleteNom();'></td></tr>";
	$text .="</table></form>";
$caption = VT_AI_CAP_01;
$ns -> tablerender($caption, $text);

//======items form==================================
$text ="<form enctype='multipart/form-data' name='nom_edit' method='post' action='". $PHP_SELF ."'><table class='forumheader3' style='width:100%'>";
$text .= "<input class='tbox' type='hidden' name='nom_id' value='$nom_id'>";
$text .= "<tr><td colspan=4 class='forumheader2'>".VT_AI_NUM." <input class='tbox' type='text' name='nom_num' value='$nom_num'></td>
	<td colspan=4 class='forumheader2'>".VT_AI_ART." <input class='tbox' type='text' name='nom_art' value='$nom_art'></td>
	<td colspan=4 class='forumheader2'>".VT_AI_CODE." <input class='tbox' type='text' name='nom_code' value='$nom_code'></td></tr>";
$text .= "<tr><td colspan=3 class='forumheader2'>".VT_AI_NAME."* <input class='tbox' type='text' name='nom_name' value='$nom_name'></td>
	<td colspan=3 class='forumheader2'>".VT_AI_TYPE." <input class='tbox' type='text' name='nom_type' value='$nom_type'></td>
	<td colspan=3 class='forumheader2'>".VT_AI_UNIT." <input class='tbox' type='text' name='nom_unit' value='$nom_unit'></td>
	<td colspan=3 class='forumheader2'>".VT_AI_CAT."* <select class='tbox' name='nom_cat'>";
		$sql -> db_Select("vt_cat", "*", "");
                while($row = $sql -> db_Fetch()){
					$eyetom = $row['cat_id'];
					$eyename = $row['cat_name'];
					$text .="<option value='$eyetom'>$eyename";
				}
				$text .="</select></td></tr>";
$text .= "<tr><td colspan=12 class='forumheader2'>".VT_AI_DESC." <textarea name='nom_desc' class='tbox' cols='80' rows='5'>$nom_desc</textarea></td></tr>";

//===============================select cat_img=================================
$fl = new e_file;
if($imglist = $fl->get_files(e_PLUGIN."vtrade/vt_pictures/products/small/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        sort($imglist);
}
	$text .= "<tr>
		<td colspan=12 class='forumheader2'>".VT_IMG_02." <input class='tbox' type='text' id='nom_pic' name='nom_pic' value='$nom_pic' size='40'>
		<input type ='button' class='button' style='cursor:pointer' size='30' value='".VT_IMG_03."' onclick='expandit(this)'>
		<div id='linkimg' style='display:none;{head}'>";
		foreach($imglist as $img){
			$list_img = str_replace(e_PLUGIN."vtrade/vt_pictures/products/small/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_img."','nom_pic','linkimg')\"><img src='".$img['path'].$img['fname']."' style='border:0' width=50px alt='' /></a> ";
		}
	$text .= "</div></td></tr>";

$text .= "<tr><td colspan=3 class='forumheader2'>".VT_AI_PRICE1." <input type='text' class='tbox' name='nom_price1' value='$nom_price1'></td>
	<td colspan=3 class='forumheader2'>".VT_AI_PRICE2." <input type='text' class='tbox' name='nom_price2' value='$nom_price2'></td>
	<td colspan=3 class='forumheader2'>".VT_AI_PRICE3." <input type='text' class='tbox' name='nom_price3' value='$nom_price3'></td>
	<td colspan=3 class='forumheader2'>".VT_AI_PRICE4." <input type='text' class='tbox' name='nom_price4' value='$nom_price4'></td>
</tr>";
$text .= "<tr><td colspan=12 class='forumheader2'>
	<input type='submit' class='button' style='cursor:pointer;display:$unvis' value=".VT_BUT_AGR." name='submit_insert'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_UPD." name='submit_update'>
	<input type='submit' class='button' style='cursor:pointer;display:$vis' value=".VT_BUT_CANS." name='submit_reset'>
	</td></tr></table></form>";

$caption = VT_AI_CAP_02;
$ns -> tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
exit;
}
// =================================================================================================
//				           BANNERS OPTIONS MENU
// =================================================================================================
if((isset($qs[0]) && $qs[0] == 'banners')){
	$ban_id=$_POST['ban_id'];
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
		$sql -> db_Insert("vt_ban", "0, '$cat_name', '$ban_org', '$ban_url', '$ban_datebegin', '$ban_dateend', '$ban_images'");
	header ("Location: ".e_PLUGIN."nboard/admin_config.php?baners");
	exit;
	}
}
//======Edit_notes======//
if (isset($_POST['edit'])){
	$sql -> db_Update("vt_ban", "cat_name='$cat_name',ban_org='$ban_org', ban_url='$ban_url', ban_datebegin='$ban_datebegin', ban_dateend='$ban_dateend', ban_images='$ban_images'");
}
//======Delete_notes======//
if(IsSet($_POST['submit_delete'])){
	$sql -> db_Delete("vt_ban", "ban_id='$ban_id'");
}
//======Reset_notes======//
	if (IsSet($_POST['submit_reset'])){
	$ban_org=$ban_url=$ban_datebegin=$ban_dateend=$ban_id='';
	$vis = 'none';
	$unvis = 'yes';
	}
//======Form Banners=========//
$text ="<form name='baner_add' method='post' action='$ban_action' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".VT_BAN_01."</td><td class='forumheader3' width='70%'><input type=hidden name='cat_name' value=''><select class='tbox' name='cat_name' id='cat'>";
	$text .="<option value=''>".VT_BAN_02."";
	$text .="<option value='0'>".VT_BAN_10."";
		$sql -> db_Select("vt_cat", "*", "cat_sub_id='0'");
                while($row = $sql -> db_Fetch()){
			$cat_id = $row['cat_id'];
			$cat_name = $row['cat_name'];
			$text .="<option value='$cat_id'>$cat_name";
		}
	$text .="</select></td></tr>";
	$text .= "<tr><td class='forumheader3'>".VT_BAN_03."</td><td class='forumheader3' width='80%'><input size='36' type='text' name='ban_org' class='tbox' value='$ban_org'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".VT_BAN_04."</td><td class='forumheader3' width='80%'><input size='36' type='text' name='ban_url' class='tbox' value='$ban_url'></td></tr>";
	$text .= "<tr><td class='forumheader3'>".VT_BAN_05."</td><td class='forumheader3' width='80%'><input size='16' type='text' name='ban_datebegin' class='tbox' value='$ban_datebegin' onclick='event.cancelBubble=true;this.select();lcs(this)' <script src='".e_PLUGIN."nboard/js/calendar_ru.js'></script><style>
	input {border:1px solid #ABABAB}
	</style> / <input size='16' type='text' name='ban_dateend' class='tbox' value='$ban_dateend' onfocus='this.select();lcs(this)' onclick='event.cancelBubble=true;this.select();lcs(this)' <script src='".e_PLUGIN."nboard/js/calendar_ru.js'></script></td></tr>";
	$fl = new e_file;
        if($imglist = $fl->get_files(e_PLUGIN."nboard/banners/", ".jpg|.jpeg|.gif|.png|.JPG|.JPEG|.GIF|.PNG")){
        	sort($imglist);
        }
	$text .= "<tr>
		<td style='width:30%' class='forumheader3'>".VT_BAN_07." </td>
		<td style='width:70%' class='forumheader3'><input class='tbox' type='text' id='ban_images' name='ban_images' value='$cat_img' size='36' maxlength='100' />
		<input class='button' type ='button' style='cursor:pointer' size='30' value='".VT_BAN_08."' onclick='expandit(this)' />
		<div id='linkicn' style='display:none;{head}'>";
		foreach($imglist as $img){
			$list_icon = str_replace(e_PLUGIN."nboard/banners/","",$img['path'].$img['fname']);
			$text .= "<a href=\"javascript:insertext('".$list_icon."','ban_images','linkicn')\"><img src='".$img['path'].$img['fname']."' width='200px' style='border:0' alt='' /></a> ";
		}
	$text .="<tr><td class='forumheader' style='text-align:center' colspan='2'>
			<input class='button' style='cursor:pointer;' type='submit' value=".VT_BUT_AGR." name='submit_insert'>
			<input class='button' style='cursor:pointer;' type='submit' value=".VT_BUT_RES." name='submit_reset'>
			</td></tr></table></form>";
$caption = VT_BAN_00;
$ns -> tablerender($caption, $text);
//=============================form edit and delete ========================
$text ="<form name='form_banner_edit' method='post' action='$ban_action' enctype='multipart/form-data'><table class='fborder' style='width:100%'>";
	$text .= "<tr><td class='forumheader3'>".VT_BAN_01."</td><td class='forumheader3' width='70%'><input type=hidden name='cat_name' value=''><select class='tbox' name='ban_id' id='cat'>";
	$sql -> db_Select("vt_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$banId = $row['ban_id'];
		$banOrg = $row['ban_org'];
	$text .="<option value='$banId'>$banOrg";
	}
	$text .="</select>";
	$text .=" <input class='button' style='cursor:pointer;' type='submit' name='submit_delete' value=".VT_BUT_DEL." onclick='return confirmDeleteBan();'>";
$text .="</td></tr>";
$text .="</table></form>";
$caption = VT_BAN_00;
$ns -> tablerender($caption, $text);
//=============================form all banner==============================
$text ="<form enctype='multipart/form-data' name='form_banner_man' method='post' action=''><table style='width:100%' border=1><tr>";
	$text .="<td>".VT_BAN_06."</td>";
	$text .="<td class='notice_caption'>".VT_BAN_03."</td>";
	$text .="<td class='notice_caption'>".VT_BAN_05."</td>";
	$text .="<td class='notice_caption'>".VT_BAN_01."</td>";
//	$text .="<td class='notice_caption'>".VT_BAN_09."</td></tr>";
	$sql -> db_Select("vt_ban", "*", "");
	while($row = $sql -> db_Fetch()){
		$ban_id = $row['ban_id'];
		$ban_cat_id = $row['ban_cat_id'];
		$ban_org = $row['ban_org'];
//		$ban_url = $row['ban_url'];
		$ban_datebegin = $row['ban_datebegin'];
		$ban_dateend = $row['ban_dateend'];
		$ban_images = $row['ban_images'];
	$sql2 -> db_Select("vt_cat", "*", "cat_id='$ban_cat_id'");
	while($row = $sql2 -> db_Fetch()){
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
	}
	if ($ban_cat_id == '0'){
		$cat_name=VT_BAN_10;
	}
	$text .="<tr><td class='notice_4'><img src='".e_PLUGIN."nboard/banners/$ban_images' width=200></td>";
	$text .="<td class='notice_4'>$ban_org</td>";
	$text .="<td class='notice_4'>$ban_datebegin / $ban_dateend</td>";
	$text .="<td class='notice_4'>$cat_name</td>";
//	$text .="<td><input type='text' name='ban_id' value='$ban_id'><input class='radio' style='cursor:pointer;' type='radio' id='ban_id' name='ban_id' value=''>";
//	$text .="<td><input type='text' name='ban_id' value='$ban_id'><input class='button' style='cursor:pointer;' type='submit' name='submit_delete' value=".VT_BUT_DEL." >";
}
	$text .="</table></form>";
$caption = VT_BAN_00;
$ns -> tablerender($caption, $text);
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
// =================================================================================================
//				           ADMIN_CONFIG OPTIONS MENU
// =================================================================================================
if(!isset($qs[0]) || (isset($qs[0]) && $qs[0] == "config")){
	
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
		  $cat_action = "config";
	}
	$var['config']['text'] = VT_MENU_CONF;
	$var['config']['link'] = "admin_config.php";
	$var['cat']['text'] = VT_MENU_02;
	$var['cat']['link'] ="admin_config.php?cat";
	$var['nomenclature']['text'] = VT_MENU_03;
	$var['nomenclature']['link'] ="admin_config.php?nomenclature";
	$var['nomenclature_import']['text'] = "Импорт номенклатуры";
	$var['nomenclature_import']['link'] ="admin_config.php?nomenclature_import";
	$var['order']['text'] = VT_MENU_04;
	$var['order']['link'] ="admin_config.php?order";
	$var['banners']['text'] = VT_MENU_05;
	$var['banners']['link'] ="admin_config.php?banners";
	$var['about']['text'] = VT_MENU_06;
	$var['about']['link'] ="admin_config.php?about";
	show_admin_menu(VT_MENU_00, $cat_action, $var);
}
function theme_head() {
	return "<script type='text/javascript' src='".e_PLUGIN."vtrade/ajax/select_nom.js'></script>
		<script type='text/javascript' src='".e_PLUGIN."vtrade/ajax/admin_config.js'></script>\n
		<link rel='stylesheet' href='".e_PLUGIN."vtrade/theme/vtrade.css' type='text/css' />";
}
?>