<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ?Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_files/resetcore/resetcore.php $
|     $Revision: 11678 $
|     $Id: resetcore.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/


/* ####################################################


Чтобы использовать этот файл, вы должны отредактировать следующую строку: define("ACTIVE", false);

И заменить в ней false на true, должна получиться такая строка: define("ACTIVE", true);

Если вы этого не сделаете, скрипт не будет работать.

Когда вы закончили работу с утилитой resetcore, вам нужно произвести обратное изменение true на false во избежание использования утилиты посторонними людми. 

Если ваш сайт использует отличную от utf-8 кодировку, измените КОДИРОВКУ на ту, которая используется вашим сайтом для корректного отображения.

*/

define("ACTIVE", false);
define("CHARSET", 'utf-8');

/* #################################################### */


$register_globals = true;
if(function_exists('ini_get'))
{
	$register_globals = ini_get('register_globals');
}
if($register_globals == true)
{
	while (list($global) = each($GLOBALS))
	{
		if (!preg_match('/^(_POST|_GET|_COOKIE|_SERVER|_FILES|GLOBALS|HTTP.*|_REQUEST|eTimingStart)$/', $global))
		{
			unset($$global);
		}
	}
	unset($global);
}

require_once("../../config.php");
mysql_connect($mySQLserver, $mySQLuser, $mySQLpassword);
mysql_select_db($mySQLdefaultdb);
define("MAGIC_QUOTES_GPC", (ini_get('magic_quotes_gpc') ? TRUE : FALSE));

define("e107_INIT", TRUE);
require_once('../../'.$HANDLERS_DIRECTORY.'arraystorage_class.php');
$eArrayStorage = new ArrayData();

echo "<?xml version='1.0' encoding='".CHARSET."' ?>\n";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>e107 Сброс настроек ядра</title>
<link rel="stylesheet" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<meta http-equiv="content-style-type" content="text/css" />
</head>
<body>
<div class='mainbox'>
<a href="http://www.e107club.ru"><img src="../../images/icon_32.png" alt="Logo" style="border: 0px; vertical-align: middle;" /></a> <span class='headertext'>e107 Утилита для сброса настроек ядра</span>
<br />
<br />
<br />
<br />
<?php

if(ACTIVE !== true) {
	echo "<span class='headertext2'>В настоящее время отключена. Чтобы включить, пожалуйста, откройте этот файл в текстовом редакторе и следуйте инструкциям по активации.</span>";
	exit;
}

if (isset($_POST['usubmit'])) {
	if (($row = e_verify()) !== FALSE) {
		extract($row);

		$result = mysql_query("SELECT * FROM ".$mySQLprefix."core WHERE e107_name='pref_backup' ");
		$bu_exist = ($row = mysql_fetch_array($result) ? TRUE : FALSE);

		$admin_directory = "admin";

//			<input type='radio' name='mode' value='1' /> <span class='headertext2'>Manually edit core values</span><br />

		echo "<span class='headertext2'><b>Пожалуйста, выберите, какой метод вы хотите использовать, затем нажмите кнопку, чтобы продолжить...</b></span><br /><br /><br /><br />
			<table style='width: auto; margin-left:auto; margin-right: auto;'>
			<tr>
			<td>
			<form method='post' action='".$_SERVER['PHP_SELF']."'>
			<input type='radio' name='mode' value='2' /> <span class='headertext2'>Сброс ядра к значениям по умолчанию</span><br />". ($bu_exist ? "<input type='radio' name='mode' value='3' /> <span class='headertext2'>Восстановите базовое резервное копирование</span>" : "<br />( Нет существующей резервной копии ядра - утилита не в состоянии использовать опцию восстановления резервной копии )")."<br /><br /><input class='button' type='submit' name='reset_core_sub' value='Выбрав метод нажмите здесь, чтобы продолжить' />
				 
			<input type='hidden' name='a_name' value='".$_POST['a_name']."' />
			<input type='hidden' name='a_password' value='".$_POST['a_password']."' />
				 
			</form>
			</td>
			</tr>
			</table>
			";

		$END = TRUE;
	} else {
		$message = "<b>Администратор не найден в базе данных / неправильный пароль / недостаточные полномочия - выполнение прервано.</b><br />";
		$END = TRUE;
	}
}


if (isset($_POST['reset_core_sub']) && $_POST['mode'] == 2)
{
	if (($at = e_verify()) === FALSE) {
		exit;
	}

	$tmpr = substr(str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']), 1);
	$root = "/".substr($tmpr, 0, strpos($tmpr, "/"))."/";
	$e_HTTP = $root;
	$admin_directory = "admin";
	$url_prefix = substr($_SERVER['PHP_SELF'], strlen($e_HTTP), strrpos($_SERVER['PHP_SELF'], "/")+1-strlen($e_HTTP));
	$num_levels = substr_count($url_prefix, "/");
	$link_prefix = '';
	for($i = 1; $i <= $num_levels; $i++) {
		$link_prefix .= "../";
	}

	define("e_ADMIN", $e_HTTP.$admin_directory."/");
	define("e_SELF", "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	define("e_QUERY", preg_replace("#&|/?PHPSESSID.*#i", "", $_SERVER['QUERY_STRING']));
	define('e_BASE', $link_prefix);
	$e_path = (!strpos($_SERVER['SCRIPT_FILENAME'], ".php") ? $_SERVER['PATH_TRANSLATED'] : $_SERVER['SCRIPT_FILENAME']);
	define("e_PATH", $e_path);


	$pref_language = "Russian";
	include_once("../../".$LANGUAGES_DIRECTORY."Russian/lan_prefs.php");
	require_once("../../".$FILES_DIRECTORY."prefs.php");

	$PrefOutput = $eArrayStorage->WriteArray($pref);

	mysql_query("DELETE FROM ".$mySQLprefix."core WHERE e107_name='SitePrefs' OR e107_name='SitePrefs_Backup'");
	if (!mysql_query("INSERT INTO ".$mySQLprefix."core VALUES ('SitePrefs', '{$PrefOutput}')")) {
		$message = "Восстановление не удалось...";
		$END = TRUE;
	} else {
		mysql_query("INSERT INTO ".$mySQLprefix."core VALUES ('SitePrefs_Backup', '{$PrefOutput}')");
		$message = "Сброс настроек ядра. <br /><br /><a href='../../index.php'>Нажмите здесь для продолжения</a>";
		$END = TRUE;
	}
}

function recurse_pref($ppost) {
	$search = array("\"", "'", "\\", '\"', "\'", "$", "?");
	$replace = array("&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&#036;", "&copy;");
	foreach ($ppost as $key => $value) {
		if(!is_array($value)){
			$ret[$key] = str_replace($search, $replace, $text);
		} else {
			$ret[$key] = recurse_pref($value);
		}
	}
	return $ret;
}

if (isset($_POST['coreedit_sub']))
{
	if (($at = e_verify()) === FALSE) {
		exit;
	}

	$pref = recurse_pref($_POST);

	$PrefOutput = $eArrayStorage->WriteArray($pref);

	mysql_query("DELETE FROM ".$mySQLprefix."core WHERE e107_name='SitePrefs' OR e107_name='SitePrefs_Backup'");
	mysql_query("INSERT INTO ".$mySQLprefix."core VALUES ('SitePrefs', '{$PrefOutput}')");
	mysql_query("INSERT INTO ".$mySQLprefix."core VALUES ('SitePrefs_Backup', '{$PrefOutput}')");

	$message = "Настройки ядра успешно обновлены. <br /><br /><a href='../../index.php'>Нажмите здесь для продолжения</a>";
	$END = TRUE;
}

if (isset($_POST['reset_core_sub']) && $_POST['mode'] == 3) {
	if (($at = e_verify()) === FALSE) {
		exit;
	}

	$result = mysql_query("SELECT * FROM ".$mySQLprefix."core WHERE e107_name='pref_backup'");
	$row = mysql_fetch_array($result);

	$pref = unserialize(base64_decode($row['e107_value']));

	$PrefOutput = $eArrayStorage->WriteArray($pref);

	mysql_query("DELETE FROM ".$mySQLprefix."core WHERE `e107_name` = 'SitePrefs' OR `e107_name` = 'SitePrefs_Backup'");
	mysql_query("INSERT INTO ".$mySQLprefix."core VALUES ('SitePrefs', '{$PrefOutput}')");
	mysql_query("INSERT INTO ".$mySQLprefix."core VALUES ('SitePrefs_Backup', '{$PrefOutput}')");

	$message = "Основное резервное копирование успешно восстановлено. <br /><br /><a href='../../index.php'>Нажмите здесь для продолжения</a>";
	$END = TRUE;
}


if (isset($_POST['reset_core_sub']) && $_POST['mode'] == 1)
{
	if (($at = e_verify()) === FALSE) {
		exit;
	}

	$result = @mysql_query("SELECT * FROM ".$mySQLprefix."core WHERE e107_name='SitePrefs'");
	$row = @mysql_fetch_array($result);

	$pref = $eArrayStorage->ReadArray($row['e107_value']);

	echo "
		<span class='headertext2'><b>Измените отдельные элементы ядра и нажмите кнопку, чтобы сохранить - <span class='headertext'>используйте этот скрипт с осторожностью</span>.</b></span><br /><br />
		<form method='post' action='".$_SERVER['PHP_SELF']."'>
		<table style='width:95%'>\n";

	while (list($key, $prefr) = each($pref)) {
		if (is_array($prefr)) {
			foreach ($prefr as $akey => $apref) {
				echo "<tr><td class='headertext2' style='width:50%; text-align:right;'>{$key}[{$akey}]&nbsp;&nbsp;</td>
				<td style='width:50%'><input type='text' name='{$key}[{$akey}]' value='{$apref}' size='50' maxlength='100' /></td></tr>\n";

			}
		} else {
			echo "<tr><td class='headertext2' style='width:50%; text-align:right;'>{$key}&nbsp;&nbsp;</td>
			<td style='width:50%'><input type='text' name='{$key}' value='{$prefr}' size='50' maxlength='100' /></td></tr>\n";
		}
	}
	echo "
		<tr>
		<td colspan='2' style='text-align:center'><br /><input class='button' type='submit' name='coreedit_sub' value='Сохранить настройки ядра' /></td>
		</tr>
		</table>
		<input type='hidden' name='a_name' value='".$_POST['a_name']."' />
		<input type='hidden' name='a_password' value='".preg_replace("/\W/", '', $_POST['a_password'])."' />
		</form>";
	$END = TRUE;
}

if (isset($message)) {
	echo "<br /><br /><div style='text-align:center'><span class='headertext2'>{$message}</span></div><br />";
}

if (isset($END)) {
	echo "<br /></div></body></html>";
	exit;
}

echo "<span class='headertext2'>
	Утилита сброса настроек ядра. Позволит вам полностью восстановить ядро, если оно повреждено, или восстановить из резервной копии. <br/>Работа утилиты не повлияет на ваш фактический контент (Новости, сообщения форума, статьи и т.д.).<br />
	<b>Запускайте эту утилиту, только если ваш сайт не в состоянии загружаться из-за критической ошибки ядра или если вам необходимо изменить настройки и вы не можете войти в Админпанель сайта.</b></span><br /><br /><br /><br />
	 
	<span class='headertext'>Пожалуйста, введите имя Главного Администратора и пароль для продолжения...</span><br /><br />
	<form method='post' action='".$_SERVER['PHP_SELF']."'>
	<table style='width:95%'>
	<tr>
	<td style='width:50%; text-align:right;' class='mediumtext'>Имя Главного Администратора:</td>
	<td style='width:50%'>
	<input class='tbox' type='text' name='a_name' size='30' value='' maxlength='100' />
	</td>
	</tr>
	<tr>
	<td style='width:50%; text-align:right;' class='mediumtext'>Пароль Главного Администратора:</td>
	<td style='width:50%'>
	<input class='tbox' type='password' name='a_password' size='30' value='' maxlength='100' />
	</td>
	</tr>
	<tr>
	<td colspan='2' style='text-align:center'>
	<br />
	<input class='button' type='submit' name='usubmit' value='Продолжить' />
	</td>
	</tr>
	</table>
	<br />
	</div>
	</body>
	</html>";

function e_verify() {
	global $mySQLprefix;
	if (ACTIVE !== TRUE) {
		exit;
	}
	if (MAGIC_QUOTES_GPC == FALSE) {
		$a_name = addslashes($_POST['a_name']);
	}
	else
	{
		$a_name = $_POST['a_name'];
	}

	$a_name = str_replace('/*', '', $a_name);

	$result = mysql_query("SELECT * FROM ".$mySQLprefix."user WHERE user_name='".$a_name."'");
	$row = mysql_fetch_array($result);

	if (($row['user_password'] === md5($_POST['a_password'])) && ($row['user_perms'] === '0') && (ACTIVE === TRUE)) {
		clear_cache();
		return $row;
	} else {
		return FALSE;
	}
}

function clear_cache() {
	$dir = "../cache/";
	$pattern = "*.cache.php";
	$deleted = false;
	$pattern = str_replace(array("\*", "\?"), array(".*", "."), preg_quote($pattern));
	if (substr($dir, -1) != "/") {
		$dir .= "/";
	}
	if (is_dir($dir)) {
		$d = opendir($dir);
		while ($file = readdir($d)) {
			if (is_file($dir.$file) && preg_match("/^{$pattern}$/", $file)) {
				if (unlink($dir.$file)) {
					$deleted[] = $file;
				}
			}
		}
		closedir($d);
		return true;
	} else {
		return false;
	}
}

?>