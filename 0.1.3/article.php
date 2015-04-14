<?php
/*
+ ----------------------------------------------------------------------------+
|     	r107 website system
|     	Copyright (C) 2014-2015 r107.pro
|	Author: Open Source Group
|	E-mail: support@r107.pro
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
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