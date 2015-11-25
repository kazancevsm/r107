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

include_once(e_PLUGIN."page_scrolling/languages/".e_LANGUAGE.".php");

$eplug_folder		= 'page_scrolling';
$eplug_name 		= LAN_TB_01;
$eplug_version 		= '1.2';
$eplug_author		= LAN_TB_02;
$eplug_description 	= LAN_TB_03;
$eplug_email		= 'plugin@e107club.ru';
$eplug_url 			= 'http://www.e107club.ru';
$eplug_compatible 	= 'e107 v0.7.2x++';
$eplug_caption 		= LAN_TB_03;
$eplug_icon 		= $eplug_folder.'/images/icon_32.png';
$eplug_icon_small 	= $eplug_folder.'/images/icon_20.png';
$eplug_conffile 	= 'admin_tb_config.php';
$eplug_status 		= TRUE;
$eplug_done			= LAN_TB_05;
$eplug_upgrade_done = LAN_TB_05;
$eplug_readme 		= '';
$eplug_compliant	= TRUE;
$eplug_menu_name	= '';


// Настройки
$eplug_prefs = array(
	"tb_colorground" => "555",
	"tb_size" => "20",
	"tb_radius" => "6",
	"tb_right" => "15",
	"tb_js" => "1",
	"tb_icons" => "up_01.png",
	"" => ""
 );
  
?>