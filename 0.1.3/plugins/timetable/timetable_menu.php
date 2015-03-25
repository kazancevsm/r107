<?php
/*============================= Timetable v1.0 =========================\
|	author - Sunout, http://e107.compolys.ru, sunout@compolys.ru	\
|	coder - Sunout, Geo, license GNU GPL				\
====================================== 2011 ============================*/
	require_once("../../class2.php");
	require_once(e_HANDLER."form_handler.php");
	require_once(e_HANDLER."userclass_class.php");
	@include_once(e_PLUGIN."timetable/languages/".e_LANGUAGE.".php");
	$ns = new e107table;
	$view = $_GET['view'];
	require_once(HEADERF);
	$text ="<table class='forumheader3' width='100%'><tr>";
	$text.="<td align='right'>";
//	$text.="<a href='http://slportal.ru/plugins/timetable/timetable.php'><img src='".e_PLUGIN."timetable/theme/icon_128.png' alt='расписание Сухой Лог'></a>";
	$text.="</td></tr></table>";
	$text.="<a href='".e_PLUGIN."timetable/timetable.php?map_view'>[".TT_NAVI_MAP."]</a> ";
	$text.="<a href='".e_PLUGIN."timetable/timetable.php?table_view'>[".TT_NAVI_TABLE."]</a> ";
	$text.="<a href='".e_PLUGIN."timetable/timetable.php?print_view'>[".TT_NAVI_PRINT."]</a>";
	$text .="<br><br>Здесь можно увидеть текущее расписание пригородных и городских автобусов<br><br>";
/*
$text .="<div class='menu_tt'>";
$sql -> db_Select("tt_gnl", "*", "");
		while($row = $sql -> db_Fetch()){
			$gnl_name = $row['gnl_name'];
			$gnl_desc = $row['gnl_desc'];
//			$gnl_icon = $row['gnl_icon'];
		
	$text .="<ul><li><a class='hide'>$gnl_name</a>";
	$text .="</ul></li>";
		}
$text .="</div>";

*/
/*
//====================Timetable CATEGORY=====================//
if(!IsSet($_GET['view']) && !IsSet($_GET['add']) && !IsSet($_GET['search'])){
	require_once("categories.php");
}

//====================Timetable VIEWADS======================//
if(IsSet($_GET['view']) && $_GET['view'] <> 0){
require_once("viewads.php");
}

//====================Timetable ADD =========================//
if(IsSet($_GET['add'])){
require_once("add.php");
}

//====================Timetable SEARCH======================//
if(IsSet($_GET['search'])){
require_once("search.php");
}
*/
$caption = "<a href='".e_PLUGIN."timetable/timetable.php'>".TT_INFO_1."</a>";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>