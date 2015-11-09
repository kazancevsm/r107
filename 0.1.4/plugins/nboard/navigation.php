<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

$text ="<link rel='stylesheet' href='theme/nboard.css' type='text/css'/>";
$text .="<script type='text/javascript' src='".e_PLUGIN."md_nboard/js/add.js'></script>";
$text .="<script type='text/javascript' src='".e_PLUGIN."md_nboard/js/add_check.js'></script>";
//	$minus_view = $view - 1;
//	$plus_view = $view + 1;
	
$text .="<table width=100%><tr>";
//$text.="<td class='forumheader' width=50px>".NB_NAVI_01."</td>";
$text.="<td class='slportal_plugins_links'><br>";

//if ($view<>0){
//$text.="<a href='".e_PLUGIN."md_nboard/nboard.php?page=view&view=$plus_view'>[".NB_NAVI_06."]</a> ";
//	$text.="<a href='".e_PLUGIN."md_nboard/nboard.php?page=view&view=$minus_view'>[".NB_NAVI_05."]</a> ";
/*
	$text.="<a href='viewads.php?view=$plus_view'><img src='".e_PLUGIN."md_nboard/theme/navigator/left_nav.png' alt='".NB_CLASS_05."'></a>";
	$text.="<a href='viewads.php?view=$minus_view'><img src='".e_PLUGIN."md_nboard/theme/navigator/right_nav.png' alt='".NB_CLASS_06."'></a>";
*/
//}
$text.="<a href='nboard.php'>[".NB_NAVI_ALL."]</a> ";
$text.="<a href='".e_PLUGIN."md_nboard/nboard.php?page=search'>[".NB_NAVI_SEARCH."]</a> ";
$text.="<a href='".e_PLUGIN."md_nboard/nboard.php?page=add'>[".NB_NAVI_ADD."]</a>";
if (USER==TRUE){
$text.="<a href='".e_PLUGIN."md_nboard/nboard.php?page=po'>[".NB_NAVI_PO."]</a>";
}
/*
$text.="<a href='nboard.php'><img src='".e_PLUGIN."md_nboard/theme/navigator/home.png' alt='".NB_NAVI_04."'></a>";
$text.="<a href='search.php'><img src='".e_PLUGIN."md_nboard/theme/navigator/search.png' alt='".NB_NAVI_02."'></a>";
$text.="<a href='add.php'><img src='".e_PLUGIN."md_nboard/theme/navigator/add.png' alt='".NB_NAVI_03."'></a>";
*/
$text.="<br><br></td></tr></table>";
?>