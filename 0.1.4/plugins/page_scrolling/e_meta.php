<?php
/*
+ ------------------------------------------------------------------------------+
|	© е107 Клуб 2010-2011. Все права защищены.									|
|	Сайт: http://www.e107club.ru												|
|	Почта: plugin@e107club.ru													|
|	Плагин: Прокрутка страницы													|
|	Версия: 1.2																	|
|	Дата: 07.07.2011 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
+-------------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }
	
	echo "<link rel='stylesheet' href='".e_PLUGIN_ABS."page_scrolling/top-button.php' type='text/css' />";
	
if ($pref['tb_js']){
	echo "<script type='text/javascript' src='http://code.jquery.com/jquery.min.js'></script>";
	}
	echo "<script type='text/javascript' src='".e_PLUGIN_ABS."page_scrolling/top-js.php'></script>";
	
?>