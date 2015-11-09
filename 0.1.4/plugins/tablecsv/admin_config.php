<?php
/*============================= Table CSV v1.0 ===================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru		
//	coders: Sunout						
//	license GNU GPL									
//==================================== 2013 ====================================*/
require_once("../../class2.php");
if (!getperms("5")) { header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."file_class.php");
require_once(e_ADMIN."auth.php");
require_once("languages/".e_LANGUAGE.".php");
if (e_QUERY){
	$qs = explode(".", e_QUERY);
}
$e_sub_cat = 'custom';		// on wysiwyg
$e_wysiwyg = "data";		// on wysiwyg
$vis = 'none';			// switch, display object none
$unvis = 'yes';		// switch, display object yes

// =================================================================================================
//				TABLE IMPORT OPTIONS MENU
// =================================================================================================
if((!isset($qs[0])) || (isset($qs[0]) && $qs[0] == "table")){
	$catId = $_GET['catId'];
	$cat_name = $_POST['cat_name'];
	$cat_desc = $_POST['cat_desc'];
		
if (IsSet($_POST['submit_edit'])){
$sql -> db_Select("vt_nom", "*", "nom_id='$nom_id'");
	while($row = $sql -> db_Fetch()){
	$nom_id = $_POST['nom_id'];
	$nom_cat = $row['nom_cat'];
	$nom_num = $row['nom_num'];
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

if (IsSet($_POST['submit_import'])){
//======clear table=====//
	$tcsql1 = new db;
	$tcsql1 -> db_Delete("tc_vac", "");
	$tcsql2 = new db;
	$tcsql2 -> db_Delete("tc_vacinv", "");
//======import in table tc_vac=====//
	$row=1;
	$handle=fopen("files/vac.csv","r");
	$count_cat=0;
		while($data=fgetcsv($handle,65536,",")){
			$num=count($data);
			$row++;
			for ($c=0; $c<$num;$c++){
			}
	$count_cat++;
	$tcsql3 = new db;
	$tcsql3 -> db_Insert("tc_vac", "$data[0], '$data[1]','$data[2]'");
		}
fclose($handle);
//======import in table tc_vacinv=====//
	$row=1;
	$handle=fopen("files/vac_inv.csv","r");
	$count_cat=0;
		while($data=fgetcsv($handle,65536,",")){
			$num=count($data);
			$row++;
			for ($c=0; $c<$num;$c++){
			}
	$count_cat++;
	$tcsql3 = new db;
	$tcsql3 -> db_Insert("tc_vacinv", "$data[0], '$data[1]','$data[2]'");
		}
fclose($handle);
$caption = "Соощение";
$text .= "Файл успешно импортирован";
$ns -> tablerender($caption,$text);
}

if (IsSet($_POST['UploadFiles'])){
	if ($_FILES['uf']['error'] == 0) {
		$dirtemp = $_FILES['uf']['tmp_name'];
		$typefile = $_FILES['uf']['type'];
		$dirfiles = "files/";
		$namefile = $_FILES['uf']['name'];
//		$text .= "<pre> $dirtemp <br>$dirfiles <br>$namefile <br>$typefile</pre>";
		move_uploaded_file($dirtemp,$dirfiles.$namefile);
	}
	else{  
		echo "Не удалось загрузить файл"; // Error in uploaded file
	}
}
	$text .="<form enctype='multipart/form-data' name='form_files_upload' method='post' action='". $PHP_SELF ."'>";
	$text .="<table class='forumheader3' style='width:100%'>";
	$text .="<tr><td colspan='2' class='nforumcaption2'>ШАг1. Загрузка файлов для импорта.</td></tr>";
	$text .="<tr><td colspan='2' class='nforumcaption2'>Файлы для загрузки: vac.csv и vac_inv.csv</td></tr>";
	$text .="<tr><td style='width:20%' class='forumheader3'>Выберите файл</td>";
	$text .="<td style='width:80%' class='forumheader3'><input class='tbox' name='uf' type='file' size='47' /></td></tr>";
	$text .="<tr><td colspan='2' class='nforumcaption2'><input type='submit' class='button' style='cursor:pointer;' value='Загрузка' name='UploadFiles'></td></tr>";
	$text .="</table></form>";
	
//======form import or export csv=============================//
	$text .="<br><form enctype='multipart/form-data' name='form_vac_import' method='post' action='". $PHP_SELF ."'>";
	$text .="<table class='forumheader3' style='width:100%'>";
	$text .="<tr><td class='nforumcaption2' colspan='2'>Шаг2. Обновление записей в базе данных.";
	$text .="<tr><td style='width:20%' class='forumheader3'><input type='submit' class='button' style='cursor:pointer;' value='Обновить базу' name='submit_import'> ";
	$text .="</table></form>";
	
$caption = "Управление таблицами";
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
require_once(e_ADMIN."footer.php");
function admin_config_adminmenu(){
	if (e_QUERY){
		$qs = explode(".", e_QUERY);
		$cat_action = $qs[0];
	}
	if (!isset($cat_action) || ($cat_action == "")){
		$cat_action = "table";
	}
	$var['table']['text'] = "Управление таблицами";
	$var['table']['link'] ="admin_config.php?table";
	$var['config']['text'] = "Настройки";
	$var['config']['link'] = "admin_config.php?config";
	$var['about']['text'] = "О плагине";
	$var['about']['link'] ="admin_config.php?about";
	
	show_admin_menu("Меню", $cat_action, $var);
}
?>