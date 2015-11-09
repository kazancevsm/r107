<?php
/*============================= Timetable v1.0 =========================\
|	author - Sunout, http://e107.compolys.ru, sunout@compolys.ru	\
|	coder - Sunout, Geo, license GNU GPL				\
====================================== 2011 ============================*/
	require_once("../../class2.php");
	@include_once(e_PLUGIN."timetable/languages/".e_LANGUAGE.".php");
	$ns = new e107table;
	require_once(HEADERF);
	$text ="<table><tr>";
	$text .="<td><a href='".e_PLUGIN."abook/abook.php?list'>[Все организации]</a>  <a href='".e_PLUGIN."abook/abook.php?add'>[Добавить организацию]</a></td>";
//====================Timetable TABLE====================//

	$i = 1;
	$absql = new db;
	$absql -> db_Select("ab_gnl", "*", "gnl_id ORDER BY RAND() LIMIT 25") or die ("Запрос не верный");
	while($row = $absql -> db_Fetch()){
		$gnl_id = $row['gnl_id'];
		$gnl_name = $row['gnl_name'];
	      if ($i == 1){
		    $class= "forumheader3";
	      }
	      if ($i == 2){
		    $class= "forumheader2";
		    $i = 0;
	      }
		$text .="<tr><td class='$class' width=80%>$gnl_name</td></tr>";
		$i ++;
	   }
	   
$text .="<tr><td></td></tr>";
$text .="</table>";
fclose($handle);
$caption = "<a href='".e_PLUGIN."abook/abook.php'>Организации Сухого Лога</a>";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?> 
