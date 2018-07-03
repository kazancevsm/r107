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

   $menutitle  = LAN_TB_MENU_01;

   $butname[]  = LAN_TB_MENU_02;
   $butlink[]  = "admin_tb_config.php";
   $butid[]    = "config";
   
   $butname[]  = LAN_TB_MENU_03;
   $butlink[]  = "admin_tb_lisence.php";
   $butid[]    = "lisence";

   global $pageid;
   for ($i=0; $i<count($butname); $i++) {
      $var[$butid[$i]]['text'] = $butname[$i];
      $var[$butid[$i]]['link'] = $butlink[$i];
   };

   show_admin_menu($menutitle, $pageid, $var);
?>