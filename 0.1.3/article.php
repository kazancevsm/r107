<?php
/*
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. Все права защищены.
	Сайт: http://r107.pro
	Почта: support@r107.pro
	Файл: article.php
	Версия: 0.1
	Кодировка: utf8
	Дата: 04.11.2014 05:05:05
	Автор: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+

*/
// This file is now deprecated and remains in core for backward compatibility reasons.
	
$tmp = explode(".", $_SERVER['QUERY_STRING']);
$action = -1;
$sub_action = 0;
if (isset($tmp[0])) 
{ 
	$action = $tmp[0]; 
	if (isset($tmp[1])) { $sub_action = $tmp[1]; }
}

	
if ($sub_action == 255) 
{
	// content page
	header("Location: content.php?content.{$action}");
	exit;
}

	
if ($action == 0) 
{
	// content page
	header("Location: content.php?article");
	exit;
} 
else 
{
	header("Location: content.php?review");
	exit;
}
	
?>