<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

$cat = $_GET['cat'];
$sub = $_GET['sub'];
$id = $_GET['id'];

$ns = new e107table;
$text ="<table><tr><td>89xxxxxxxxx</td></tr></table>";
$caption = "Контакты";

$ns -> tablerender($caption, $text);
?>