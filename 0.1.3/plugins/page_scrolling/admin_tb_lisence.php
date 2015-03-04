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

require_once("../../class.php");
include_once(e_PLUGIN."page_scrolling/languages/".e_LANGUAGE.".php");

   if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
   }

   require_once(e_ADMIN."auth.php");

   $text = "
   <div class='r_header1' style='text-align: center; font-weight: bold; font-size: 12px;'>".LAN_TB_LISENCE_02."</div><br />
<div class='r_header3' style='text-align: left;'>
<ol>
	<li>".LAN_TB_LISENCE_03."</li>
	<li>".LAN_TB_LISENCE_04."</li>
	<li>".LAN_TB_LISENCE_05."</li>
	<li>".LAN_TB_LISENCE_06."</li>
	<li>".LAN_TB_LISENCE_07."</li>
	<li>".LAN_TB_LISENCE_08."</li>
	<li>".LAN_TB_LISENCE_09."</li>
	<li>".LAN_TB_LISENCE_10."</li>
	<li>".LAN_TB_LISENCE_11."</li>
</ol>
</div>
<br /><div class='r_header1' style='text-align: center;'>".LAN_TB_COPYRIGHT."</div><br />

";

   $ns->tablerender(LAN_TB_LISENCE_01, $text);

   require_once(e_ADMIN."footer.php");
?>