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

$text = "<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_core.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Файл ядра</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_warning.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Известная уязвимость</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_check.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Файл ядра<br/> (Целостность проверена)</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_fail.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Файл ядра <br/> (Нарушена целостность)</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_uncalc.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Файл ядра <br/> (Неподсчитываемый)</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_missing.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Потеряный файл ядра</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_old.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Файл старого ядра</div>
<div style='margin-left: 0px; margin-bottom: 1px; margin-top: 2px; vertical-align: top; white-space: nowrap'>
<img src='".e_IMAGE."fileinspector/file_unknown.png' alt='".$dir."' style='margin-left: 3px; width: 16px; height: 16px' />&nbsp;Файл НЕ ядра</div>";
$ns -> tablerender("Условные обозначения", $text);

$text = "Файловый инспектор сканирует и анализирует файлы на сервере вашего сайта. Когда инспектор обнаруживает 
файл ядра e107, он проверяет его на неизменность, чтобы убедиться в том, что файл не поврежден.";

if ($pref['developer']) {
$text .= "<br /><br />
Дополнительный инструмент поиска соответствия по строке (только при включеном режиме разработчика) предоставляет вам возможность сканировать файлы на вашем сервере на предмет текстовых строк 
с использованим регулярных выражений. Regex-механизм использует возможность языка PHP <a href='http://php.net/pcre'>PCRE</a>
(the preg_* functions), так что вводите ваш запрос, как #pattern#modifiers в нужных полях.";

}

$ns -> tablerender("Файловый инспектор: Справка", $text);

?>