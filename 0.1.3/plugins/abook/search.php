<link rel='stylesheet' href='theme/abook.css' type='text/css'/>
<?php
require_once("../../class2.php");
//if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."np_class.php");
@include_once(e_PLUGIN."abook/languages/".e_LANGUAGE.".php");


$ns = new e107table;
require_once(HEADERF);
$mid = $_GET['scat'];
$action = $_GET["action"];
$mye = $_GET["mid"];
$act = $_GET["act"];
require_once("classmen.php");
//================ Search =====================
$text .= "<table class='forumheader3' style='width:100%'><form action='". $PHP_SELF ."' method=post name='frm'>";
$text .="<tr><td><?=$navBar?></td></tr><tr><td><?=$pageBar?></td></tr> 
	<tr><td><?=$out?></td></tr><tr><td><?=$pageBar?></td></tr> 
	<tr><td width=40%>
	<div class='left-input'><div class='right-input'><div class='fill-input'>
	<input type='text' name='stext' value='".AB_SARCH_2."' size=40></div></div></div></td>";
$text .="<td width=40%>
	<div class='left-input'><div class='right-input'><div class='fill-input'>
	<select name='crit'><option value='cat_org'>поиск по названию организации<option value='cat_name'>поиск по названию магазина<option value='cat_street'>поиск по улице<option value='gnl_phone'>по № телефона</select></div></div></div></td>";
$text .="<td width=20%><input type='Submit' value=".AB_CLASS_2." name='sear'></td></tr></form>";
//================ Debug ======================

// if(IsSet($rus_alph)){

if(IsSet($_POST['sear'])){
$crit = $_POST["crit"];
	$stext = $_POST["stext"];
	$stext = strtoupper($stext);
	$sql -> db_Select("ab_cat", "*", "$crit LIKE '%$stext%'"); 
		}
$text .="<tr><td class='forumheader3' width='30%'><b>".AB_NAME_1."<b></td>
		<td class='forumheader3' width='30%'><b>".AB_NAME_2."<b></td>
		<td class='forumheader3' width='20%'><b>".AB_ADD_09."<b></td>
		<td class='forumheader3' width='20%'><b>".AB_ADD_05."<b></td></tr>";
while($row = $sql -> db_Fetch()){
$cat_id = $row["cat_id"];
$cat_name = $row["cat_name"];
$cat_city= $row['cat_city'];
$cat_org = $row["cat_org"];
$cat_street = $row['cat_street'];	
$cat_home = $row['cat_home'];
$cat_vid = $row['cat_vid'];
$cat_web = $row['cat_web'];

$sql2 -> db_Select("ab_gnl", "*","gnl_id=$cat_id" );
if(IsSet($_POST['sear'])){
while($row = $sql2 -> db_Fetch()){
	$gnl_id = $row["gnl_id"];
	$gnl_phone = $row['gnl_phone'];
	
	$text .="<tr><td class='forumheader2' width='10%' ><a href='viewads.php?act=det&cat=$cat_id'>$cat_org</a></td>
		<td class='forumheader2' width='65%'><a href='viewads.php?act=det&cat=$cat_id' >$cat_name</a></td>
		<td class='forumheader2' width='10%'><a href='viewads.php?act=det&cat=$cat_id'>$cat_street $cat_home</a></td>
		<td class='forumheader2' width='10%'><a href='viewads.php?act=det&cat=$cat_id'>$cat_vid</a></td></tr>";
//-------------------------------------------------------------
}
	}
}

if(IsSet($_POST['sear'])){
	$crit = $_POST["crit"];
	$stext = $_POST["stext"];
	$stext = strtoupper($stext);
$sql2 -> db_Select("ab_gnl", "*", "$crit LIKE '%$stext%'");

}
while($row = $sql2 -> db_Fetch()){
		$gnl_id = $row["gnl_id"];
		$gnl_cat=$row['gnl_cat'];
		$gnl_phone = $row['gnl_phone'];
	$gnl_division=$row['gnl_division'];
	$sql-> db_Select("ab_cat", "*", "cat_id=$gnl_cat");
	while($row = $sql -> db_Fetch()){
		$cat_id = $row["cat_id"];
		$cat_name = $row["cat_name"];
		$cat_city= $row['cat_city'];
		$cat_org = $row["cat_org"];
		$cat_street=$row['cat_street'];	
		$cat_home= $row['cat_home'];
	}
	if(IsSet($_POST['sear'])){
$text .="<tr><td class='forumheader3' width='25%'><b>".AB_NAME_5."</td><td class='forumheader3' width='25%'><b>".AB_NAME_1."</td><td class='forumheader3' width='25%'><b>".AB_NAME_2."</td><td class='forumheader3' width='25%' colspan='2'><b>".AB_NAME_3."</td><td class='forumheader3' width='25%' colspan='2'><b>".AB_NAME_4."</td><td class='forumheader3' width='25%' colspan='2'><b></td></tr>";
$text .="<tr><td class='forumheader2'><a href='viewads.php?act=det&cat=$gnl_id' >$cat_name</a></td>";
$text .="<td class='forumheader2' ><a href='viewads.php?act=det&cat=$cat_id'>$gnl_division</a></td>";
$text .="<td class='forumheader2' ><a href='viewads.php?act=det&cat=$cat_id'>$cat_city</a></td>";   
$text .="<td class='forumheader2' colspan='2'><a href='viewads.php?act=det&cat=$gnl_id'>$cat_street</a></td>";
$text .="<td class='forumheader2' colspan='2'><a href='viewads.php?act=det&cat=$gnl_id'>$cat_home</a></td>";
$text .="<td class='forumheader2' colspan='2'><a href='viewads.php?act=det&cat=$gnl_id'>$gnl_phone</a></td></tr>";
	}
}
$text .="</table>";
$caption = AB_SARCH_1;
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>