<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

$text ="<link rel='stylesheet' href='".e_PLUGIN."vtrade/theme/vtrade.css' type='text/css'/>";
$text .="<div id='vt_navi_box' width=574px><table><tr><td>";
$text .="<a href='".e_PLUGIN."vtrade/vtrade.php?page=frontpage'>".VT_BUT_BEGIN." </a> ";
$text .="| <a href='".e_PLUGIN."vtrade/vtrade.php?page=categories&cat=0'>Весь товар </a> ";
//$text .="| <a href='".e_PLUGIN."vtrade/vtrade.php?page=search'>Поиск товара </a>";
//$text .="| <a href='".e_PLUGIN."vtrade/vtrade.php?page=basket'>".VT_BUT_BASK." </a>";
	$sort1='ORDER BY `nom_price1` ASC';
	$sort2='ORDER BY `nom_price1` DESC';
	$sort3='ORDER BY `nom_name` ASC';
	$sort4='ORDER BY `nom_name` DESC';
$text .="<td> <form enctype='multipart/form-data' name='form_sorting' id='form_sorting' method='post' action='". $PHP_SELF ."'>";
$text .="<script language='JavaScript' type='text/javascript' src='js/sort.js'></script> | <select class='tbox' id='sort' name='sorting' onchange='seltag()'>";
$text .="<option value='' >Сортировка товара</option>";
$text .="<option value='".$sort1."' ".(($sorting == $sort1) ? 'selected' : '').">По возрастанию цены</option>";
$text .="<option value='".$sort2."' ".(($sorting == $sort2) ? 'selected' : '').">По убыванию цены</option>";
$text .="<option value='".$sort3."' ".(($sorting == $sort3) ? 'selected' : '').">По возрастанию наименования</option>";
$text .="<option value='".$sort4."' ".(($sorting == $sort4) ? 'selected' : '').">По убыванию наименования</option>";
$text .="</select>";
$text .="</form>";

$text .="<td>";
$text .="<form enctype='multipart/form-data' name='form_search' method='post' action='".e_PLUGIN."vtrade/vtrade.php?page=search'>";
$text .="<input type='text' value='' name='search' size='10'><input type='submit' style='cursor:pointer;' value='поиск' name='submit_search'>";
$text .="</form>";

$text .="</td></tr></table></div>";
//include('search.php');
?>