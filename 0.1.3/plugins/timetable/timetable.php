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
	require_once("navigation.php");

if(!IsSet($_GET['map_view']) && !IsSet($_GET['table_view']) && !IsSet($_GET['print_view'])) {
	require_once("map.php");
}

//====================Timetable MAP=====================//
if(IsSet($_GET['map_view'])){
	require_once("map.php");
}
//====================Timetable TABLE====================//
if(IsSet($_GET['table_view'])){
	require_once("table.php");
}
//====================Timetable PRINT====================//
if(IsSet($_GET['print_view'])){
	require_once("print.php");
}
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
$text .="<div valign=bottom><i>coder: Sunout, Geo</i></div>";
$caption = "<a href='".e_PLUGIN."timetable/timetable.php'>".TT_INFO."</a>";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>