<?php
/*
+ ------------------------------------------------------------------------------+
|	Русский языковой пакет для e107 0.7.26										|
|	Сайт: http://www.e107club.ru												|
|	Почта: translate@e107club.ru												|
|	Ревизия: 1.0																|
|	Кодировка: utf-8															|
|	Дата: 25.09.2011 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
|	© е107 Клуб 2010-2011. Все права защищены.									|
|																				|
|	Russian Language Pack for e107 0.7.26										|
|	Site: http://www.e107club.ru												|
|	Email: translate@e107club.ru												|
|	Revision: 1.0																|
|	Charset: utf-8																|
|	Date: 25.09.2011 05:05:05													|
|	Author: © Alexander Kadnikov [Predator]										|
|	© е107 Club 2010-2011. All Rights Reserved.									|
+-------------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "Здесь вы можете изменять ссылки вашего сайта. Ссылки, добавленные здесь, будут отображаться в главном меню навигации, для других ссылок, пожалуйста, используйте плагин Links Page.
<br />
";
$ns -> tablerender("Ссылки: Справка", $text);
?>