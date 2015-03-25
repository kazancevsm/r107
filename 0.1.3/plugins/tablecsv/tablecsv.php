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
	require_once(HEADERF);
//=========================================================================
	$time_file=strftime('%d.%m.%y',(filemtime("".e_PLUGIN."tablecsv/files/vac.csv")));
	
	$text ="<table width=100%><tr>";
	$text .="<td class='slportal_plugins_links' ><a href='".e_PLUGIN."tablecsv/tablecsv.php?vac'>[Вакансии] </a>  <a href='".e_PLUGIN."tablecsv/tablecsv.php?vac_inv'>[Вакансии для инвалидов]</a> <a href='http://slportal.ru/plugins/nboard/nboard.php?cat=13&scat=0'>[Другие предложения]</a></td>";
	$text .="</tr></table>";
//====================Timetable TABLE====================//
    $row_color = 1;
    $text .="<table width=100%>";
    
    /*
    if(IsSet($_GET['vac']) || !IsSet($_GET['vac_inv'])){
	$handle=fopen(e_PLUGIN."tablecsv/files/vac.csv","r");
    }
    if(IsSet($_GET['vac_inv'])) {
	$handle=fopen(e_PLUGIN."tablecsv/files/vac_inv.csv","r");
    }
    */

$tcsql1 = new db;
if(IsSet($_GET['vac']) || !IsSet($_GET['vac_inv'])){
	$tcsql1 -> db_Select("tc_vac", "*", "") or die ("Запрос не верный");
}
if(IsSet($_GET['vac_inv'])) {
	$tcsql1 -> db_Select("tc_vacinv", "*", "") or die ("Запрос не верный");
}
	while($row = $tcsql1 -> db_Fetch()){
		$vac_id = $row['vac_id'];
		$vac_name = $row['vac_name'];
		$vac_salary = $row['vac_salary'];
	      if ($row_color == 1){
		    $text .="<tr><td class='forumheader2' widht=10%>$vac_id</td><td class='forumheader2' width=80%>$vac_name</td><td class='forumheader2' widht=10%>$vac_salary</td></tr>";
	      }
	      if ($row_color == 2){
		    $text .="<tr><td class='forumheader3'>$vac_id</td><td class='forumheader3'>$vac_name</td><td class='forumheader3'>$vac_salary</td></tr>";
		    $row_color = 0;
	      }
	      $row_color ++;
	   }

$text .="</table>";

$caption = "<a href='".e_PLUGIN."tablecsv/tablecsv.php'>Вакансии на $time_file</a>";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>