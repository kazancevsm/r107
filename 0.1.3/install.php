<?php
/*
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. Все права защищены.
	Сайт: http://r107.pro
	Почта: support@r107.pro
	Файл: install.php
	Версия: 0.1
	Кодировка: utf8
	Дата: 04.11.2014 05:05:05
	Автор: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. All Rights Reserved.
	Site: http://r107.pro
	Email: support@r107.pro
	File: install.php
	Version: 0.1
	Charset: utf8
	Date: 04.11.2014 05:05:05
	Author: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+
*/

define('MIN_MYSQL_UTF8_VERSION', '5.0');
define('MAKE_INSTALL_LOG', FALSE);

// Параметры и пути по умолчанию для программы установки
$MySQLPrefix	     = 'pref_';

$ADMIN_DIRECTORY     = "admin/";
$CUSTOM_DIRECTORY    = "custom/";
$FILES_DIRECTORY     = "files/";
$IMAGES_DIRECTORY    = "images/";
$THEMES_DIRECTORY    = "themes/";
$PLUGINS_DIRECTORY   = "plugins/";
$HANDLERS_DIRECTORY  = "handlers/";
$LANGUAGES_DIRECTORY = "languages/";
$HELP_DIRECTORY      = "docs/help/";
$DOWNLOADS_DIRECTORY = "files/downloads/";

// Конец конфигурируемых переменных

if(isset($_GET['object']))
{
	get_object($_GET['object']);
	die();
}

define("e107_INIT", TRUE);
define("e_UC_ADMIN", 254);

error_reporting(E_ALL);

function e107_ini_set($var, $value)
{
	if (function_exists('ini_set'))
	{
		ini_set($var, $value);
	}
}

// Установка некоторых PHP опций
e107_ini_set('magic_quotes_runtime',     0);
e107_ini_set('magic_quotes_sybase',      0);
e107_ini_set('arg_separator.output',     '&amp;');
e107_ini_set('session.use_only_cookies', 1);
e107_ini_set('session.use_trans_sid',    0);


if(!function_exists("file_get_contents")) {
	die("Системе r107 для правильной работы требуется PHP 5.0 или выше.");
}

//  Убедитесь, что '.' это первая часть подключаемого пути
$inc_path = explode(PATH_SEPARATOR, ini_get('include_path'));
if($inc_path[0] != ".")
{
	array_unshift($inc_path, ".");
	$inc_path = implode(PATH_SEPARATOR, $inc_path);
	e107_ini_set("include_path", $inc_path);
}
unset($inc_path);

if(!function_exists("mysql_connect"))
{
	die("Системе r107 для правильной работы требуется, чтобы PHP был установлен или скомпилирован с MySQL, пожалуйста, см. руководство по MySQL для получения дополнительной информации.");
}

// Проверка подключения функции realpath () на хостинге
$functions_ok = true;
$disabled_functions = ini_get('disable_functions');
if (trim($disabled_functions) != '')
{
	$disabled_functions = explode( ',', $disabled_functions );
	foreach ($disabled_functions as $function)
	{
		if(trim($function) == "realpath")
		{
			$functions_ok = false;
		}
	}
}
if($functions_ok == true && function_exists("realpath") == false)
{
	$functions_ok = false;
}
if($functions_ok == false)
{
	die("Системе r107 требуется функция realpath(), которая должна быть включена на вашем хостинге. Эта функция требуется для некоторых <b>важных</b> проверок безопасности. Пожалуйста, свяжитесь со своим хостинг-провайдером для получения дополнительной информации.");
}

if(!function_exists("print_a"))
{
	function print_a($var)
	{
		return '<pre>'.htmlentities(print_r($var, true), null, "utf8").'</pre>';
	}
}

header("Content-type: text/html; charset=utf8");

$installer_folder_name = 'install';

include_once("./{$HANDLERS_DIRECTORY}e107_class.php");

$e107_paths = compact('ADMIN_DIRECTORY', 'CUSTOM_DIRECTORY', 'FILES_DIRECTORY', 'IMAGES_DIRECTORY', 'THEMES_DIRECTORY', 'PLUGINS_DIRECTORY',
                      'HANDLERS_DIRECTORY', 'LANGUAGES_DIRECTORY', 'HELP_DIRECTORY', 'DOWNLOADS_DIRECTORY');
$e107 = new e107($e107_paths, realpath(dirname(__FILE__)));
unset($e107_paths);

$e107->e107_dirs['INSTALLER'] = "{$installer_folder_name}/";

$e_install = new e_install();
$e_forms = new e_forms();

$e_install->template->SetTag("installer_css_http", $_SERVER['PHP_SELF']."?object=stylesheet");
$e_install->template->SetTag("installer_folder_http", e_HTTP.$installer_folder_name."/");
$e_install->template->SetTag("files_dir_http", e_FILE_ABS);

if(!isset($_POST['stage'])) {
	$_POST['stage'] = 1;
}
$_POST['stage'] = intval($_POST['stage']);

switch ($_POST['stage']) {
	case 1:
		$e_install->stage_1();
		break;
	case 2:
		$e_install->stage_2();
		break;
	case 3:
		$e_install->stage_3();
		break;
	case 4:
		$e_install->stage_4();
		break;
	case 5:
		$e_install->stage_5();
		break;
	case 6:
		$e_install->stage_6();
		break;
	case 7:
		$e_install->stage_7();
		break;
	default:
		$e_install->raise_error("Информация о шаге установки от клиента не имеет никакого смысла.");
}

if($_SERVER['QUERY_STRING'] == "debug"){
	$e_install->template->SetTag("debug_info", print_a($e_install));
}
else
{
	$e_install->template->SetTag("debug_info", (count($e_install->debug_info) ? print_a($e_install->debug_info)."Трассировка:<br />".print_a($e_install) : ""));
}

echo $e_install->template->ParseTemplate(template_data(), TEMPLATE_TYPE_DATA);



class e_install
{
	var $required_php = "5.0";
	var $paths;
	var $template;
	var $debug_info;
	var $e107;
	var $previous_steps;
	var $stage;
	var $post_data;
	var $logFile;

	function e_install()
	{
		$this->logFile = '';
		if (MAKE_INSTALL_LOG)
		{
			$this->logFile = dirname(__FILE__).'/InstallLog.log';
		}
//		$this->logLine('Query string: ');
		$this->template = new SimpleTemplate();
		while (@ob_end_clean());
		global $e107;
		$this->e107 = $e107;
		if(isset($_POST['previous_steps']))
		{
			$this->previous_steps = unserialize(base64_decode($_POST['previous_steps']));
			unset($_POST['previous_steps']);
		}
		else
		{
			$this->previous_steps = array();
		}
		$this->post_data = $_POST;
	}

	function logLine($logLine)
	{
		if (!MAKE_INSTALL_LOG || ($this->logFile == '')) return;
		$logfp = fopen($this->logFile, 'a+');
		fwrite($logfp, ($now = time()).', '.gmstrftime('%d.%m.%y %H:%M:%S',$now).'  '.$logLine."\n"); 
		fclose($logfp);
	}

	function raise_error($details)
	{
		$this->debug_info[] = array (
		'info' => array (
			'details' => $details,
			'backtrace' => debug_backtrace()
			)
		);
	}

	function stage_1()
	{
		global $e_forms;
		$this->stage = 1;
		$this->get_lan_file();
		$this->template->SetTag("installation_heading", LANINS_001);
		$this->template->SetTag("stage_pre", LANINS_002);
		$this->template->SetTag("stage_num", LANINS_003);
		$this->template->SetTag("stage_title", LANINS_004);
		$this->template->SetTag("copyright_localization", LANINS_201);
		$this->template->SetTag("copyright_newyear", date('Y'));
		$this->template->SetTag("copyright_reserved", LANINS_RES);
		$this->template->SetTag("system_version", LANINS_VER);
		$e_forms->start_form("language_select", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
		$e_forms->add_select_item("language", $this->get_languages(), "Russian");
		$this->finish_form();
		$e_forms->add_button("submit", LANINS_006);
		$this->template->SetTag("stage_content", "<div style='text-align: center;'><label for='language'>".LANINS_005."</label>\n<br /><br /><br />\n".$e_forms->return_form()."</div>");
	}

	function stage_2()
	{
		global $e_forms;
		$this->stage = 2;
		$this->previous_steps['language'] = $_POST['language'];
		$this->get_lan_file();
		$this->template->SetTag("installation_heading", LANINS_001);
		$this->template->SetTag("stage_pre", LANINS_002);
		$this->template->SetTag("stage_num", LANINS_021);
		$this->template->SetTag("stage_title", LANINS_022);
		$this->template->SetTag("copyright_localization", LANINS_201);
		$this->template->SetTag("copyright_newyear", date('Y'));
		$this->template->SetTag("copyright_reserved", LANINS_RES);
		$this->template->SetTag("system_version", LANINS_VER);
		$page_info = nl2br(LANINS_023);
		$e_forms->start_form("versions", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
		$output = "
			<br /><br />
			<div style='width: 100%; padding-left: auto; padding-right: auto;'>
			  <table cellspacing='0'>
			    <tr>
			      <td style='border-top: 1px solid #999;' class='row-border'><label for='server'>".LANINS_024."</label></td>
			      <td style='border-top: 1px solid #999;' class='row-border'><input class='tbox' type='text' id='server' name='server' size='40' value='localhost' maxlength='100' /></td>
				  <td style='width: 40%; border-top: 1px solid #999;' class='row-border'>".LANINS_030."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='name'>".LANINS_025."</label></td>
			      <td class='row-border'><input class='tbox' type='text' name='name' id='name' size='40' value='' maxlength='100' /></td>
				  <td class='row-border'>".LANINS_031."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='password'>".LANINS_026."</label></td>
			      <td class='row-border'><input class='tbox' type='password' name='password' size='40' id='password' value='' maxlength='100' /></td>
				  <td class='row-border'>".LANINS_032."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='db'>".LANINS_027."</label></td>
			      <td class='row-border'><input class='tbox' type='text' name='db' size='20' id='db' value='' maxlength='100' />
					<br />
					<label class='defaulttext'><input class='checkbox' type='checkbox' name='createdb' value='1' />".LANINS_028."</label>
				  </td>
				  <td class='row-border'>".LANINS_033."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='prefix'>".LANINS_029."</label></td>
			      <td class='row-border'><input class='tbox' type='text' name='prefix' size='20' id='prefix' value='pref_'  maxlength='100' /></td>
				  <td class='row-border'>".LANINS_034."</td>
			    </tr>
			  </table>
			</div>
			<br /><br />\n";
		$e_forms->add_plain_html($output);
		$this->finish_form();
		$e_forms->add_button("submit", LANINS_035);
		$this->template->SetTag("stage_content", $page_info.$e_forms->return_form());
	}


	function stage_3()
	{
		global $e_forms;
		$success = TRUE;
		$this->stage = 3;
		$this->get_lan_file();
		$this->template->SetTag("installation_heading", LANINS_001);
		$this->template->SetTag("stage_pre", LANINS_002);
		$this->template->SetTag("stage_num", LANINS_036);
		$this->template->SetTag("copyright_localization", LANINS_201);
		$this->template->SetTag("copyright_newyear", date('Y'));
		$this->template->SetTag("copyright_reserved", LANINS_RES);
		$this->template->SetTag("system_version", LANINS_VER);
		$this->previous_steps['mysql']['server'] = trim($_POST['server']);
		$this->previous_steps['mysql']['user'] = trim($_POST['name']);
		$this->previous_steps['mysql']['password'] = $_POST['password'];
		$this->previous_steps['mysql']['db'] = trim($_POST['db']);
		$this->previous_steps['mysql']['createdb'] = (isset($_POST['createdb']) && $_POST['createdb'] == TRUE ? TRUE : FALSE);
		$this->previous_steps['mysql']['db_utf8'] = TRUE;
		$this->previous_steps['mysql']['prefix'] = trim($_POST['prefix']);
		$success = $this->check_name($this->previous_steps['mysql']['db'], FALSE) && $this->check_name($this->previous_steps['mysql']['prefix'], FALSE);
		if(!$success || $this->previous_steps['mysql']['server'] == "" || $this->previous_steps['mysql']['user'] == "") 
		{
			$this->stage = 3;
			$this->template->SetTag("stage_num", LANINS_021);
			$e_forms->start_form("versions", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
			$head = LANINS_039."<br /><br />\n";
			$output = "
			<br /><br />
			<div style='width: 100%; padding-left: auto; padding-right: auto;'>
			  <table cellspacing='0'>
			    <tr>
			      <td style='border-top: 1px solid #999;' class='row-border'><label for='server'>".LANINS_024."</label></td>
			      <td style='border-top: 1px solid #999;' class='row-border'><input class='tbox' type='text' id='server' name='server' size='40' value='{$this->previous_steps['mysql']['server']}' maxlength='100' /></td>
				  <td style='width: 40%; border-top: 1px solid #999;' class='row-border'>".LANINS_030."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='name'>".LANINS_025."</label></td>
			      <td class='row-border'><input class='tbox' type='text' name='name' id='name' size='40' value='{$this->previous_steps['mysql']['user']}' maxlength='100' /></td>
				  <td class='row-border'>".LANINS_031."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='password'>".LANINS_026."</label></td>
			      <td class='row-border'><input class='tbox' type='password' name='password' id='password' size='40' value='{$this->previous_steps['mysql']['password']}' maxlength='100' /></td>
				  <td class='row-border'>".LANINS_032."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='db'>".LANINS_027."</label></td>
			      <td class='row-border'><input type='text' name='db' id='db' size='20' value='{$this->previous_steps['mysql']['db']}' maxlength='100' />
				    <br />
					<label class='defaulttext'><input type='checkbox' name='createdb'".($this->previous_steps['mysql']['createdb'] == 1 ? " checked='checked'" : "")." value='1' />".LANINS_028."</label>
				  </td>
				  <td class='row-border'>".LANINS_033."</td>
			    </tr>

			    <tr>
			      <td class='row-border'><label for='db_utf8'>".LANINS_DB_UTF8_CAPTION."</label></td>
			      <td class='row-border'>
					<label class='defaulttext'><input type='checkbox' id='db_utf8' name='db_utf8'".($this->previous_steps['mysql']['db_utf8'] == 1 ? " checked='checked'" : "")." value='1' />".LANINS_DB_UTF8_LABEL."</label>
				  </td>
				  <td class='row-border'>".LANINS_DB_UTF8_TOOLTIP."</td>
			    </tr>

			    <tr>
			      <td class='row-border'><label for='prefix'>".LANINS_029."</label></td>
			      <td class='row-border'><input type='text' name='prefix' id='prefix' size='20' value='{$this->previous_steps['mysql']['prefix']}'  maxlength='100' /></td>
				  <td class='row-border'>".LANINS_034."</td>
			    </tr>";
			if ( ! $success)
			{
				$output .= "<tr><td class='row-border' colspan='3'>".LANINS_105."</td></tr>";
			}
			$output .= "
			  </table>
			</div>
			<br /><br />\n";
			$e_forms->add_plain_html($output);
			$e_forms->add_button("submit", LANINS_035);
			$this->template->SetTag("stage_title", LANINS_040);
		} 
		else 
		{
			$this->template->SetTag("stage_title", LANINS_037.($this->previous_steps['mysql']['createdb'] == 1 ? LANINS_038 : ""));
			if ( ! @mysql_connect($this->previous_steps['mysql']['server'], $this->previous_steps['mysql']['user'], $this->previous_steps['mysql']['password']))
			{
				$success = FALSE;
				$page_content = LANINS_041.nl2br("\n\n<b>".LANINS_083."\n</b><i>".mysql_error()."</i>");
			} 
			else 
			{
				$page_content = LANINS_042;
				// Соединение установлено.
				// Проверка версии MySQL
				$query = '';
				preg_match('/^(.*?)($|-)/', mysql_get_server_info(), $mysql_version);
				if (version_compare($mysql_version[1], MIN_MYSQL_UTF8_VERSION, '>='))
				{
					// Создание базы данных если требуется
					$db_utf8 = '';
					if($this->previous_steps['mysql']['db_utf8'])
					{
						$db_utf8 = ' CHARACTER SET `utf8` ';
						@mysql_query('SET NAMES `utf8`');
					}
					if($this->previous_steps['mysql']['createdb'] == 1)
					{
						$query = 'CREATE DATABASE '.$this->previous_steps['mysql']['db'].$db_utf8;
					}
					elseif($db_utf8)
					{
						$query = 'ALTER DATABASE '.$this->previous_steps['mysql']['db'].$db_utf8;
					}
				}
				else
				{
					// MySQL не совместима с utf8
					// Сброс db_utf8
					$this->previous_steps['mysql']['db_utf8'] = 0;

					if($this->previous_steps['mysql']['createdb'] == 1)
					{
						$query = 'CREATE DATABASE '.$this->previous_steps['mysql']['db'];
					}
				}

				if($query)
				{
					if ( ! mysql_query($query))
					{
						$success = FALSE;
						$page_content .= "<br /><br />".LANINS_043.nl2br("\n\n<b>".LANINS_083."\n</b><i>".mysql_error()."</i>");
					} 
					else 
					{
						$page_content .= "<br /><br />".LANINS_044;
					}
				}
			}
			if($success)
			{
				$e_forms->start_form("versions", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
				$page_content .= "<br /><br />".LANINS_045."<br /><br />";
				$e_forms->add_button("submit", LANINS_035);
			}
			$head = $page_content;
		}
		if ($success)
			$this->finish_form();
		else
			$this->finish_form(3);
		$this->template->SetTag("stage_content", $head.$e_forms->return_form());
	}

	function stage_4()
	{
		global $e_forms;
		$this->stage = 4;
		$this->get_lan_file();
		$this->template->SetTag("installation_heading", LANINS_001);
		$this->template->SetTag("stage_pre", LANINS_002);
		$this->template->SetTag("stage_num", LANINS_007);
		$this->template->SetTag("stage_title", LANINS_008);
		$this->template->SetTag("copyright_localization", LANINS_201);
		$this->template->SetTag("copyright_newyear", date('Y'));
		$this->template->SetTag("copyright_reserved", LANINS_RES);
		$this->template->SetTag("system_version", LANINS_VER);
		$not_writable = $this->check_writable_perms('must_write');		// Некоторые директории ДОЛЖНЫ быть перезаписываемыми
		$opt_writable = $this->check_writable_perms('can_write');		// Некоторые дополнительные каталоги должны быть перезаписываемыми
		$version_fail = FALSE;
		$perms_errors = "";
		if(count($not_writable)) 
		{
			$perms_pass = FALSE;
			foreach ($not_writable as $file) 
			{
				$perms_errors .= (substr($file, -1) == "/" ? LANINS_010a : LANINS_010)."<br /><b>{$file}</b><br />\n";
			}
			$perms_notes = LANINS_018;
		} 
		elseif (count($opt_writable))
		{
			$perms_pass = TRUE;
			foreach ($opt_writable as $file) 
			{
				$perms_errors .= (substr($file, -1) == "/" ? LANINS_010a : LANINS_010)."<br /><b>{$file}</b><br />\n";
			}
			$perms_notes = LANINS_106;
		}
		else
		{
			$perms_pass = TRUE;
			$perms_errors = "&nbsp;";
			$perms_notes = LANINS_017;
		}

		if(!function_exists("mysql_connect")) 
		{
			$version_fail = TRUE;
			$mysql_note = LANINS_011;
			$mysql_help = LANINS_012;
		}
		elseif (!@mysql_connect($this->previous_steps['mysql']['server'], $this->previous_steps['mysql']['user'], $this->previous_steps['mysql']['password'])) 
		{
			$mysql_note = LANINS_011;
			$mysql_help = LANINS_013;
		} 
		else 
		{
			$mysql_note = mysql_get_server_info();
			$mysql_help = LANINS_017;
		}
		if(!function_exists("utf8_encode")) 
		{
			$xml_installed = FALSE;
		} 
		else 
		{
			$xml_installed = TRUE;
		}

		$php_version = phpversion();
		if(version_compare($php_version, $this->required_php, ">="))
		{
			$php_help = LANINS_017;
		}
		else
		{
			$php_help = LANINS_019;
		}
		$e_forms->start_form("versions", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
		if(!$perms_pass)
		{
			$e_forms->add_button("retest_perms", LANINS_009);
			$this->stage = 3; // Заставить установщик вернуться на шаг назад
		}
		elseif ($perms_pass && !$version_fail && $xml_installed)
		{
			$e_forms->add_button("continue_install", LANINS_020);
		}
		$output = "
			<table style='width: 100%; margin-left: auto; margin-right: auto;'>
			  <tr>
			    <td style='width: 20%;'>".LANINS_014."</td>
			    <td style='width: 40%;'>{$perms_errors}</td>
			    <td style='width: 40%;'>{$perms_notes}</td>
			  </tr>
			  <tr>
			    <td>".LANINS_015."</td>
			    <td>{$php_version}</td>
			    <td>{$php_help}</td>
			  </tr>
			  <tr>
			    <td>".LANINS_016."</td>
			    <td>{$mysql_note}</td>
			    <td>{$mysql_help}</td>
			  </tr>
			  <tr>
			    <td>".LANINS_050."</td>
			    <td>".($xml_installed ? LANINS_051 : LANINS_052)."</td>
			    <td>".($xml_installed ? LANINS_017 : LANINS_053)."</td>
			  </tr>
			</table>\n<br /><br />\n\n";
		$this->finish_form();
		$this->template->SetTag("stage_content", $output.$e_forms->return_form());
	}



	function stage_5()
	{
		global $e_forms;
		$this->stage = 5;
		$this->logLine('Stage 5 started');
		$this->get_lan_file();
		$this->template->SetTag("installation_heading", LANINS_001);
		$this->template->SetTag("stage_pre", LANINS_002);
		$this->template->SetTag("stage_num", LANINS_046);
		$this->template->SetTag("stage_title", LANINS_047);
		$this->template->SetTag("copyright_localization", LANINS_201);
		$this->template->SetTag("copyright_newyear", date('Y'));
		$this->template->SetTag("copyright_reserved", LANINS_RES);
		$this->template->SetTag("system_version", LANINS_VER);
		$e_forms->start_form("admin_info", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
		$output = "
			<div style='width: 100%; padding-left: auto; padding-right: auto;'>
			  <table cellspacing='0'>
			    <tr>
			      <td class='row-border'><label for='u_name'>".LANINS_072."</label></td>
			      <td class='row-border'><input class='tbox' type='text' name='u_name' id='u_name' size='30' value='".(isset($this->previous_steps['admin']['user']) ? $this->previous_steps['admin']['user'] : "")."' maxlength='60' /></td>
				  <td class='row-border'>".LANINS_073."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='d_name'>".LANINS_074."</label></td>
			      <td class='row-border'><input class='tbox' type='text' name='d_name' id='d_name' size='30' value='".(isset($this->previous_steps['admin']['display']) ? $this->previous_steps['admin']['display'] : "")."' maxlength='60' /></td>
				  <td class='row-border'>".LANINS_075."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='pass1'>".LANINS_076."</label></td>
			      <td class='row-border'><input type='password' name='pass1' size='30' id='pass1' value='' maxlength='60' /></td>
				  <td class='row-border'>".LANINS_077."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='pass2'>".LANINS_078."</label></td>
			      <td class='row-border'><input type='password' name='pass2' size='30' id='pass2' value='' maxlength='60' /></td>
				  <td class='row-border'>".LANINS_079."</td>
			    </tr>
			    <tr>
			      <td class='row-border'><label for='email'>".LANINS_080."</label></td>
			      <td class='row-border'><input type='text' name='email' size='30' id='email' value='".(isset($this->previous_steps['admin']['email']) ? $this->previous_steps['admin']['email'] : LANINS_082)."' maxlength='100' /></td>
				  <td class='row-border'>".LANINS_081."</td>
			    </tr>
			  </table>
			</div>
			<br /><br />\n";
		$e_forms->add_plain_html($output);
		$this->finish_form();
		$e_forms->add_button("submit", LANINS_035);
		$this->template->SetTag("stage_content", $e_forms->return_form());
	}

	function stage_6()
	{
		global $e_forms;
		$this->logLine('Stage 6 started');
		$this->get_lan_file();
		$this->stage = 6;

		$_POST['u_name'] = str_replace(array("'", '"'), "", $_POST['u_name']);
		$_POST['d_name'] = str_replace(array("'", '"'), "", $_POST['d_name']);

		$this->previous_steps['admin']['user'] = $_POST['u_name'];
		if ($_POST['d_name'] == "")
		{
			$this->previous_steps['admin']['display'] = $_POST['u_name'];
		}
		else
		{
			$this->previous_steps['admin']['display'] = $_POST['d_name'];
		}
		$this->previous_steps['admin']['email'] = $_POST['email'];
		$this->previous_steps['admin']['password'] = $_POST['pass1'];

		if(trim($_POST['u_name']) == "" || trim($_POST['email']) == "" || trim($_POST['pass1']) == "")
		{
			$this->template->SetTag("installation_heading", LANINS_001);
			$this->template->SetTag("stage_num", LANINS_046);
			$this->template->SetTag("stage_pre", LANINS_002);
			$this->template->SetTag("stage_title", LANINS_047);
			$this->template->SetTag("copyright_localization", LANINS_201);
			$this->template->SetTag("copyright_newyear", date('Y'));
			$this->template->SetTag("copyright_reserved", LANINS_RES);
			$this->template->SetTag("system_version", LANINS_VER);
			$e_forms->start_form("admin_info", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
			$page = LANINS_086."<br />".($_SERVER['QUERY_STRING'] == "debug" ? print_a($_POST, TRUE) : "")."<br />";

			$this->finish_form(5);
			$e_forms->add_button("submit", LANINS_048);
		}
		elseif($_POST['pass1'] != $_POST['pass2'])
		{
			$this->template->SetTag("installation_heading", LANINS_001);
			$this->template->SetTag("stage_num", LANINS_046);
			$this->template->SetTag("stage_pre", LANINS_002);
			$this->template->SetTag("stage_title", LANINS_047);
			$this->template->SetTag("copyright_localization", LANINS_201);
			$this->template->SetTag("copyright_newyear", date('Y'));
			$this->template->SetTag("copyright_reserved", LANINS_RES);
			$this->template->SetTag("system_version", LANINS_VER);
			$e_forms->start_form("admin_info", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
			$page = LANINS_049."<br />".($_SERVER['QUERY_STRING'] == "debug" ? print_a($_POST, TRUE) : "")."<br />";

			$this->finish_form(5);
			$e_forms->add_button("submit", LANINS_048);
		}
		else
		{

			$this->template->SetTag("installation_heading", LANINS_001);
			$this->template->SetTag("stage_pre", LANINS_002);
			$this->template->SetTag("stage_num", LANINS_056);
			$this->template->SetTag("stage_title", LANINS_055);
			$this->template->SetTag("copyright_localization", LANINS_201);
			$this->template->SetTag("copyright_newyear", date('Y'));
			$this->template->SetTag("copyright_reserved", LANINS_RES);
			$this->template->SetTag("system_version", LANINS_VER);

			$e_forms->start_form("confirmation", $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == "debug" ? "?debug" : ""));
			$page = nl2br(LANINS_057);
			$this->finish_form();
			$e_forms->add_button("submit", LANINS_035);
		}

		$this->template->SetTag("stage_content", $page.$e_forms->return_form());
		$this->logLine('Stage 6 completed');
	}

	function stage_7()
	{
		global $e_forms;
		$this->logLine('Stage 7 started');
		$this->get_lan_file();

		$this->stage = 7;

		$this->template->SetTag("installation_heading", LANINS_001);
		$this->template->SetTag("stage_pre", LANINS_002);
		$this->template->SetTag("stage_num", LANINS_058);
		$this->template->SetTag("stage_title", LANINS_071);
		$this->template->SetTag("copyright_localization", LANINS_201);
		$this->template->SetTag("copyright_newyear", date('Y'));
		$this->template->SetTag("copyright_reserved", LANINS_RES);
		$this->template->SetTag("system_version", LANINS_VER);
		$db_utf8 = ($this->previous_steps['mysql']['db_utf8'] ? 'utf8' : '');
		$config_file = "<?php
/*
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. Все права защищены.
	Сайт: http://r107.pro
	Почта: support@r107.pro
	Файл: install.php
	Версия: 0.1
	Кодировка: utf8
	Дата: 04.11.2014 05:05:05
	Автор: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. All Rights Reserved.
	Site: http://r107.pro
	Email: support@r107.pro
	File: install.php
	Version: 0.1
	Charset: utf8
	Date: 04.11.2014 05:05:05
	Author: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+
*/

# Файл конфигурации создан автоматически программой установки системы е107


\$mySQLserver    = '{$this->previous_steps['mysql']['server']}';
\$mySQLuser      = '{$this->previous_steps['mysql']['user']}';
\$mySQLpassword  = '{$this->previous_steps['mysql']['password']}';
\$mySQLdefaultdb = '{$this->previous_steps['mysql']['db']}';
\$mySQLprefix    = '{$this->previous_steps['mysql']['prefix']}';
//\$mySQLcharset может содержать, только 'utf8' или ''
\$mySQLcharset   = '{$db_utf8}';

\$ADMIN_DIRECTORY     = '{$this->e107->e107_dirs['ADMIN_DIRECTORY']}';
\$CUSTOM_DIRECTORY    = '{$this->e107->e107_dirs['CUSTOM_DIRECTORY']}';
\$FILES_DIRECTORY     = '{$this->e107->e107_dirs['FILES_DIRECTORY']}';
\$IMAGES_DIRECTORY    = '{$this->e107->e107_dirs['IMAGES_DIRECTORY']}';
\$THEMES_DIRECTORY    = '{$this->e107->e107_dirs['THEMES_DIRECTORY']}';
\$PLUGINS_DIRECTORY   = '{$this->e107->e107_dirs['PLUGINS_DIRECTORY']}';
\$HANDLERS_DIRECTORY  = '{$this->e107->e107_dirs['HANDLERS_DIRECTORY']}';
\$LANGUAGES_DIRECTORY = '{$this->e107->e107_dirs['LANGUAGES_DIRECTORY']}';
\$HELP_DIRECTORY      = '{$this->e107->e107_dirs['HELP_DIRECTORY']}';
\$DOWNLOADS_DIRECTORY = '{$this->e107->e107_dirs['DOWNLOADS_DIRECTORY']}';


?".">";

		$config_result = $this->write_config($config_file);
		$e_forms->start_form("confirmation", "index.php");
		if ($config_result) 
		{
			$page = $config_result."<br />";
			$this->logLine('Error writing config: '.$config_result);
		} 
		else 
		{
			$this->logLine('config written successfully');
			$errors = $this->create_tables();
			if ($errors == true) 
			{
				$page = $errors."<br />";
				$this->logLine('Error writing database content: '.$errors);
			}
			else 
			{
				$this->logLine('Database content complete');
				$page = nl2br(LANINS_069)."<br />";
				$e_forms->add_button('submit', LANINS_035);
			}
		}
		$this->finish_form();
		$this->template->SetTag("stage_content", $page.$e_forms->return_form());
		$this->logLine('Stage 7 complete');
	}


	// Проверка имени БД или префиксов таблиц - все начинающиеся с 'е' вызывают проблемы.
	// Возвращает TRUE, если приемлемо и FALSE, если неприемлемо
	// Пустая строка возвращает значение $blank_ok (вызывающая сторона должна установить значение TRUE для префикса и FALSE для имени БД)
	function check_name($str, $blank_ok = FALSE)
	{
		if ($str == '') return $blank_ok;
		if (preg_match("#^\d+[e|E]#",$str)) return FALSE;
		return TRUE;
	}


	// Выбор языка установки
	function get_lan_file()
	{
		if(!isset($this->previous_steps['language']))
		{
			$this->previous_steps['language'] = "Russian";
		}
		$this->lan_file = "{$this->e107->e107_dirs['LANGUAGES_DIRECTORY']}{$this->previous_steps['language']}/lan_installer.php";
		if(is_readable($this->lan_file))
		{
			include($this->lan_file);
		}
		elseif(is_readable("{$this->e107->e107_dirs['LANGUAGES_DIRECTORY']}English/lan_installer.php"))
		{
			include("{$this->e107->e107_dirs['LANGUAGES_DIRECTORY']}English/lan_installer.php");
		}
		else
		{
			$this->raise_error("Фатальная ошибка: Не удалось получить правильный файл языка для установки.");
		}
	}

	function get_languages()
	{
		$handle = opendir("{$this->e107->e107_dirs['LANGUAGES_DIRECTORY']}");
		while ($file = readdir($handle))
		{
			if ($file != "." && $file != ".." && $file != "/" && $file != "CVS")
			{
				if(file_exists("./{$this->e107->e107_dirs['LANGUAGES_DIRECTORY']}{$file}/lan_installer.php"))
				{
					$lanlist[] = $file;
				}
			}
		}
		closedir($handle);
		return $lanlist;
	}

	function finish_form($force_stage = false)
	{
		global $e_forms;
		if($this->previous_steps)
		{
			$e_forms->add_hidden_data("previous_steps", base64_encode(serialize($this->previous_steps)));
		}
		$e_forms->add_hidden_data("stage", ($force_stage ? $force_stage : ($this->stage + 1)));
	}

	function check_writable_perms($list = 'must_write')
	{
		$bad_files = array();
		$data['must_write'] = 'config.php';
		$data['can_write'] = '{$FILES_DIRECTORY}cache/|{$FILES_DIRECTORY}public/|{$FILES_DIRECTORY}public/avatars/|{$PLUGINS_DIRECTORY}|{$THEMES_DIRECTORY}';
		if (!isset($data[$list])) 
			return $bad_files;
			foreach ($this->e107->e107_dirs as $dir_name => $value) 
			{
				$find[] = "{\${$dir_name}}";
				$replace[] = "./$value";
			}
			$data[$list] = str_replace($find, $replace, $data[$list]);
			$files = explode("|", trim($data[$list]));
			foreach ($files as $file) 
			{
				if(!is_writable($file)) 
				{
					$bad_files[] = str_replace("./", "", $file);
				}
			}
		return $bad_files;
	}

	function create_tables()
	{

		$link = mysql_connect($this->previous_steps['mysql']['server'], $this->previous_steps['mysql']['user'], $this->previous_steps['mysql']['password']);
		if(!$link)
		{
			return nl2br(LANINS_084."\n\n<b>".LANINS_083."\n</b><i>".mysql_error($link)."</i>");
		}

		$db_selected = mysql_select_db($this->previous_steps['mysql']['db'], $link);
		if(!$db_selected)
		{
			return nl2br(LANINS_085." '{$this->previous_steps['mysql']['db']}'\n\n<b>".LANINS_083."\n</b><i>".mysql_error($link)."</i>");
		}

		$filename = "{$this->e107->e107_dirs['ADMIN_DIRECTORY']}sql/core_sql.php";
		$fd = fopen ($filename, "r");
		$sql_data = fread($fd, filesize($filename));
		fclose ($fd);

		if (!$sql_data)
		{
			return nl2br(LANINS_060)."<br /><br />";
		}

		preg_match_all("/create(.*?)(?:myisam|innodb);/si", $sql_data, $result );

		// Попытка вызова utf8
		if($this->previous_steps['mysql']['db_utf8'])
		{
			@mysql_query('SET NAMES `utf8`');
		}

		foreach ($result[0] as $sql_table)
		{
//			preg_match("/CREATE TABLE\s(.*?)\s\(/si", $sql_table, $match);
//			$tablename = $match[1];

//			preg_match_all("/create(.*?)myisam;/si", $sql_data, $result );
			$sql_table = preg_replace("/create table\s/si", "CREATE TABLE {$this->previous_steps['mysql']['prefix']}", $sql_table);
			if (!mysql_query($sql_table, $link))
			{
				return nl2br(LANINS_061."\n\n<b>".LANINS_083."\n</b><i>".mysql_error($link)."</i>");
			}
		}
		$this->logLine('All tables created');
		$datestamp = time();

		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}news VALUES (0, '".LANINS_063."', '".LANINS_062."', '', '{$datestamp}', '0', '1', 1, 0, 0, 0, 0, '0', '', 'r107_box.png', 0) ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}news_category VALUES (0, '".LANINS_087."', 'icon_news_32.png') ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}links VALUES (0, '".LANINS_088."', 'index.php', '', '', 1, 1, 0, 0, 0) ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}links VALUES (0, '".LANINS_089."', 'download.php', '', '', 1, 2, 0, 0, 0) ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}links VALUES (0, '".LANINS_090."', 'user.php', '', '', 1, 3, 0, 0, 0) ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}links VALUES (0, '".LANINS_091."', 'submitnews.php', '', '', 1, 4, 0, 0, 0) ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}links VALUES (0, '".LANINS_092."', 'contact.php', '', '', 1, 5, 0, 0, 0) ");

		$udirs = "admin/|plugins/|temp";
		$e_SELF = $_SERVER['PHP_SELF'];
		$e_HTTP = preg_replace("#".$udirs."#i", "", substr($e_SELF, 0, strrpos($e_SELF, "/"))."/");

		$pref_language = isset($this->previous_steps['language']) ? $this->previous_steps['language'] : "Russian";

		if (file_exists($this->e107->e107_dirs['LANGUAGES_DIRECTORY'].$pref_language."/lan_prefs.php"))
		{
			include_once($this->e107->e107_dirs['LANGUAGES_DIRECTORY'].$pref_language."/lan_prefs.php");
		}
		else
		{
			include_once($this->e107->e107_dirs['LANGUAGES_DIRECTORY']."English/lan_prefs.php");
		}

		$site_admin_user = $this->previous_steps['admin']['display'];
		$site_admin_email = $this->previous_steps['admin']['email'];

		require_once("{$this->e107->e107_dirs['FILES_DIRECTORY']}prefs.php");

		include_once("{$this->e107->e107_dirs['HANDLERS_DIRECTORY']}arraystorage_class.php");

		$tmp = ArrayData::WriteArray($pref);

		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}core VALUES ('SitePrefs', '{$tmp}')");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}core VALUES ('SitePrefs_Backup', '{$tmp}')");

		$emote = '';
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}core VALUES ('emote', '{$emote}') ");

		// Настройка меню
		$new_block = Array ( 
				'comment_caption' 	=> LANINS_096,			// 'Latest Comments'
				'comment_display' 	=> '10',
				'comment_characters' 	=> '50',
				'comment_postfix' 	=> LANINS_097,			// '[more ...]'
				'comment_title' 	=> 0,
				'newforumposts_caption' => LANINS_100,			// 'Latest Forum Posts'
				'newforumposts_display' => '10',
				'forum_no_characters' 	=> '20',
				'forum_postfix' 	=> LANINS_097,			// '[more ...]'
				'update_menu' 		=> LANINS_101,			// 'Update menu Settings'
				'forum_show_topics' 	=> '1',
				'newforumposts_characters' => '50',
				'newforumposts_postfix' => LANINS_097,			// '[more ...]'
				'newforumposts_title' 	=> 0,
				'clock_caption' 	=> LANINS_102			// 'Date / Time'
				);

		$menu_conf = serialize($new_block);
//		$menu_conf = 'a:23:{s:15:"comment_caption";s:15:"Latest Comments";s:15:"comment_display";s:2:"10";s:18:"comment_characters";s:2:"50";s:15:"comment_postfix";s:12:"[ more ... ]";s:13:"comment_title";i:0;s:15:"article_caption";s:8:"Articles";s:16:"articles_display";s:2:"10";s:17:"articles_mainlink";s:23:"Articles Front Page ...";s:21:"newforumposts_caption";s:18:"Latest Forum Posts";s:21:"newforumposts_display";s:2:"10";s:19:"forum_no_characters";s:2:"20";s:13:"forum_postfix";s:10:"[more ...]";s:11:"update_menu";s:20:"Update menu Settings";s:17:"forum_show_topics";s:1:"1";s:24:"newforumposts_characters";s:2:"50";s:21:"newforumposts_postfix";s:10:"[more ...]";s:19:"newforumposts_title";i:0;s:13:"clock_caption";s:11:"Date / Time";s:15:"reviews_caption";s:7:"Reviews";s:15:"reviews_display";s:2:"10";s:15:"reviews_parents";s:1:"1";s:16:"reviews_mainlink";s:21:"Review Front Page ...";s:16:"articles_parents";s:1:"1";}';
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}core VALUES ('menu_pref', '{$menu_conf}') ");

		preg_match("/^(.*?)($|-)/", mysql_get_server_info(), $mysql_version);
		if (version_compare($mysql_version[1], '5.0.0', '<')) {
			$search_prefs = 'a:12:{s:11:\"user_select\";s:1:\"1\";s:9:\"time_secs\";s:2:\"60\";s:13:\"time_restrict\";s:1:\"0\";s:8:\"selector\";s:1:\"2\";s:9:\"relevance\";s:1:\"0\";s:13:\"plug_handlers\";N;s:10:\"mysql_sort\";b:0;s:11:\"multisearch\";s:1:\"1\";s:6:\"google\";s:1:\"0\";s:13:\"core_handlers\";a:5:{s:4:\"news\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"0\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\";s:1:\"1\";}s:8:\"comments\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"1\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\";s:1:\"2\";}s:5:\"users\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"1\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\";s:1:\"3\";}s:9:\"downloads\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"1\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\
";s:1:\"4\";}s:5:\"pages\";a:6:{s:5:\"class\";s:1:\"0\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:9:\"pre_title\";s:1:\"0\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"order\";s:1:\"5\";}}s:17:\"comments_handlers\";a:2:{s:4:\"news\";a:3:{s:2:\"id\";i:0;s:3:\"dir\";s:4:\"core\";s:5:\"class\";s:1:\"0\";}s:8:\"download\";a:3:{s:2:\"id\";i:2;s:3:\"dir\";s:4:\"core\";s:5:\"class\";s:1:\"0\";}}s:9:\"php_limit\";s:0:\"\";}';
		} else {
			$search_prefs = 'a:12:{s:11:\"user_select\";s:1:\"1\";s:9:\"time_secs\";s:2:\"60\";s:13:\"time_restrict\";s:1:\"0\";s:8:\"selector\";s:1:\"2\";s:9:\"relevance\";s:1:\"0\";s:13:\"plug_handlers\";N;s:10:\"mysql_sort\";b:1;s:11:\"multisearch\";s:1:\"1\";s:6:\"google\";s:1:\"0\";s:13:\"core_handlers\";a:5:{s:4:\"news\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"0\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\";s:1:\"1\";}s:8:\"comments\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"1\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\";s:1:\"2\";}s:5:\"users\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"1\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\";s:1:\"3\";}s:9:\"downloads\";a:6:{s:5:\"class\";s:1:\"0\";s:9:\"pre_title\";s:1:\"1\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:5:\"order\
";s:1:\"4\";}s:5:\"pages\";a:6:{s:5:\"class\";s:1:\"0\";s:5:\"chars\";s:3:\"150\";s:7:\"results\";s:2:\"10\";s:9:\"pre_title\";s:1:\"0\";s:13:\"pre_title_alt\";s:0:\"\";s:5:\"order\";s:1:\"5\";}}s:17:\"comments_handlers\";a:2:{s:4:\"news\";a:3:{s:2:\"id\";i:0;s:3:\"dir\";s:4:\"core\";s:5:\"class\";s:1:\"0\";}s:8:\"download\";a:3:{s:2:\"id\";i:2;s:3:\"dir\";s:4:\"core\";s:5:\"class\";s:1:\"0\";}}s:9:\"php_limit\";s:0:\"\";}';
		}
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}core` VALUES ('search_prefs', '{$search_prefs}') ");
		$notify_prefs = mysql_real_escape_string("array ('event' => array ('usersup' => array ('type' => 'off', 'class' => '254', 'email' => '',),'userveri' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'login' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'logout' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'flood' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'subnews' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'newspost' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'newsupd' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), 'newsdel' => array ( 'type' => 'off', 'class' => '254', 'email' => '', ), ), )");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}core` VALUES ('notify_prefs', '{$notify_prefs}') ");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}banner` VALUES (0, 'r107', 'login', 'password', 'place_one', 'banner_r107.png', '', '', 'http://r107.pro', 0, 0, 0, 0, 0, 0, '') ");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (1, 'login_menu', 1, 1, '0', '', 'login_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (3, 'online_menu', 0, 0, '0', '', 'online_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (4, 'blogcalendar_menu', 0, 0, '0', '', 'blogcalendar_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (5, 'tree_menu', 0, 0, '0', '', 'tree_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (6, 'search_menu', 0, 0, '0', '', 'search_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (7, 'compliance_menu', 0, 0, '0', '', 'compliance_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (8, 'userlanguage_menu', 0, 0, '0', '', 'userlanguage_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (9, 'powered_by_menu', 2, 2, '0', '', 'powered_by_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (10, 'counter_menu', 0, 0, '0', '', 'counter_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (11, 'usertheme_menu', 0, 0, '0', '', 'usertheme_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (12, 'banner_menu', 0, 0, '0', '', 'banner_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (13, 'online_extended_menu', 2, 1, '0', '', 'online_extended_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (14, 'clock_menu', 0, 0, '0', '', 'clock_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (15, 'sitebutton_menu', 0, 0, '0', '', 'sitebutton_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (16, 'comment_menu', 0, 0, '0', '', 'comment_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (17, 'lastseen_menu', 0, 0, '0', '', 'lastseen/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (18, 'other_news_menu', 0, 0, '0', '', 'other_news_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (19, 'other_news2_menu', 0, 0, '0', '', 'other_news_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (20, 'admin_menu', 0, 0, '0', '', 'admin_menu/')");
//		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (21, 'rss_menu', 5, 1, '0', '', 'rss_menu/')");
		mysql_query("INSERT INTO `{$this->previous_steps['mysql']['prefix']}menus` VALUES (22, 'PCMag', 3, 1, '0', '', '1')");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}userclass_classes VALUES (1, 'PRIVATEMENU', '".LANINS_093."',".e_UC_ADMIN.")");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}userclass_classes VALUES (2, 'PRIVATEFORUM1', '".LANINS_094."',".e_UC_ADMIN.")");
//		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}plugin VALUES (0, '".LANINS_095."', '0.03', 'Integrity Check', 1, '') ");
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}generic VALUES (0, 'wmessage', 1145848343, 1, '', 0, '[center]<img src=&#039;{e_IMAGE}first_step.png&#039; style=&#039;width: 450px; height: 338px&#039; alt=&#039;&#039; />[/center]')");
//		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}page VALUES (1, '', '[img]{e_IMAGE}pcmag.png[/img] ', 0, 1145843485, 0, 0, '', '', '', 'PCMag')");
		$this->logLine('Sample custom page added');

		// Создание Администратора
		$ip = $_SERVER['REMOTE_ADDR'];
		$userp = "1, '{$this->previous_steps['admin']['display']}', '{$this->previous_steps['admin']['user']}', '', '".md5($this->previous_steps['admin']['password'])."', '', '{$this->previous_steps['admin']['email']}', '', '', '', 0, ".time().", 0, 0, 0, 0, 0, 0, '{$ip}', 0, '', '', '', 0, 1, '', '', '0', '', ".time().", ''";
		mysql_query("INSERT INTO {$this->previous_steps['mysql']['prefix']}user VALUES ({$userp})" );

		$this->logLine('User record added');

		if (mysql_close($link))				// Вам нужно указать $link в связи с ошибкой в ​​PHP 5.3 : http://bugs.php.net/bug.php?id=48754&edit=1
		{
			$this->logLine('Database manipulation complete');
		}
		else
		{
			$this->logLine('Error closing database: '.mysql_error());
			return 'Error closing database: '.mysql_error();
		}

		return false;
	}

	function write_config($data)
	{
		$fp = @fopen("config.php", "w");
		if (!@fwrite($fp, $data))
		{
			@fclose ($fp);
			return nl2br(LANINS_070);
		}
		@fclose ($fp);
		return false;
	}
}

class e_forms {

	var $form;
	var $opened;

	function start_form($id, $action, $method = "post" )
	{
		$this->form = "\n<form method='{$method}' id='{$id}' action='{$action}'>\n";
		$this->opened = true;
	}

	function add_select_item($id, $labels, $selected)
	{
		$this->form .= "
		<select name='{$id}' id='{$id}'>\n";
		foreach ($labels as $label)
		{
			$this->form .= "<option".($label == $selected ? " selected='selected'" : "").">{$label}</option>\n";
		}
		$this->form .= "</select>\n";
	}

	function add_button($id, $title, $align = "right", $type = "submit")
	{
		$this->form .= "<div style='text-align: {$align}; z-index: 10;'><input class='button' type='{$type}' id='{$id}' value='{$title}' /></div>\n";
	}

	function add_hidden_data($id, $data)
	{
		$this->form .= "<input type='hidden' name='{$id}' value='{$data}' />\n";
	}

	function add_plain_html($html_data)
	{
		$this->form .= $html_data;
	}

	function return_form()
	{
		if($this->opened == true)
		{
			$this->form .= "</form>\n";
		}
		$this->opened = false;
		return $this->form;
	}
}

class SimpleTemplate
{

	var $Tags = array();
	var $open_tag = "{";
	var $close_tag = "}";

	function SimpleTemplate()
	{
		define("TEMPLATE_TYPE_FILE", 0);
		define("TEMPLATE_TYPE_DATA", 1);
	}

	function SetTag($TagName, $Data)
	{
		$this->Tags[$TagName] = array(	'Tag'  => $TagName,
		'Data' => $Data
		);
	}

	function RemoveTag($TagName)
	{
		unset($this->Tags[$TagName]);
	}

	function ClearTags()
	{
		$this->Tags = array();
	}

	function ParseTemplate($Template, $template_type = TEMPLATE_TYPE_FILE)
	{
		if($template_type == TEMPLATE_TYPE_DATA)
		{
			$TemplateData = $Template;
		}
		else
		{
			$TemplateData = file_get_contents($Template);
		}
		foreach ($this->Tags as $Tag)
		{
			$TemplateData = str_replace($this->open_tag.$Tag['Tag'].$this->close_tag, $Tag['Data'], $TemplateData);
		}
		return $TemplateData;
	}
}

function template_data()
{
	$data = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<!--
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. Все права защищены.
	Сайт: http://r107.pro
	Почта: support@r107.pro
	Файл: install.php
	Версия: 0.1
	Кодировка: utf8
	Дата: 04.11.2014 05:05:05
	Автор: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+
	© r107.pro, 2014. All Rights Reserved.
	Site: http://r107.pro
	Email: support@r107.pro
	File: install.php
	Version: 0.1
	Charset: utf8
	Date: 04.11.2014 05:05:05
	Author: © Казанцев Сергей	[Sunout]
+-------------------------------------------------------------------------------+
-->
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
	<title>{installation_heading}</title>
	<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf8\" />
	<meta http-equiv=\"content-style-type\" content=\"text/css\" />
	<style>
body{
	background-color : #000;
	font-family : Trebuchet MS, \"Lucida Sans Unicode\", Arial, Lucida Sans, Tahoma, Sans-Serif;
	font-size : 13px;
	padding : 25px 0 25px 0;
	text-align : center;
}
h1 {
	margin : 5px;
	font-size : 16px;
	color : #444;
}
h3 {
	color : #222;
	font-size : 16px;
	margin : 0 0 8px 0;
}
img {
	border : none;
}
a:hover, a:active {
	color : black;
}
a:link, a:visited {
	color : #444;
	text-decoration : none;
}
td {
	vertical-align : top;
}
.wrapper {
	background : #fff;
	color : #444;
	margin : auto;
	text-align:left;
	width : 800px;
	border-radius:5px;
		-webkit-border-radius : 5px;
		-moz-border-radius : 5px;
		-khtml-border-radius : 5px;
}
.wrapper_header {
	position : relative;
	background : transparent;
	margin : 0px;
	width : 800px;
	height : 30px;
	padding : 10px;
}
.wrapper_logo {
	position : relative;
	background : #000;
	margin : 0px;
	padding : 10px;
	width : 780px;
}
.wrapper_content {
	width : 780px;
	padding : 10px;
	margin: 0px;
}
.wrapper_clearing {
	clear : both;
	height : 0;
}
.wrapper_footer {
	background : transparent;
	margin : auto;
	padding : 10px;
	width : 780px;
	height : 50px;
	font-size: 8pt;
	line-height : 1.2;
	color : #999;
}
.content_body {
	margin :  0px;
}
.tbox {
	padding : 5px;
	background : transparent;
	color : #444;
	border : 1px solid #999;
	border-radius:5px;
		-webkit-border-radius : 5px;
		-moz-border-radius : 5px;
		-khtml-border-radius : 5px;
}
.checkbox {
	cursor: pointer;
	position: relative;
	width: 15px;
	height: 15px;
	top: 0;
	border-radius: 4px;
	background: #fcfff4;
	background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
}
.button {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9));
	background:-moz-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
	background:-webkit-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
	background:-o-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
	background:-ms-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
	background:linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9',GradientType=0);
	background-color:#f9f9f9;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #dcdcdc;
	display:inline-block;
	cursor:pointer;
	color:#666666;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffffff;
}
.button:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #e9e9e9), color-stop(1, #f9f9f9));
	background:-moz-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
	background:-webkit-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
	background:-o-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
	background:-ms-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
	background:linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e9e9e9', endColorstr='#f9f9f9',GradientType=0);
	background-color:#e9e9e9;
}
.button:active {
	position:relative;
	top:1px;
}
select {
	padding : 5px;
	background : #eee;
	color : #444;
	border : 1px solid #999;
	border-radius:5px;
		-webkit-border-radius : 5px;
		-moz-border-radius : 5px;
		-khtml-border-radius : 5px;
	cursor-type : hending;
}
.row-border {
	border-bottom: 1px solid #eee;
	padding: 10px;
}
	</style>
</head>
<body>
	<div class=\"wrapper\">
		<div class=\"wrapper_header\">
			<h1>{installation_heading} {system_version}</h1>
		</div>
		<div class=\"wrapper_logo\">
			<img src=\"images/adminlogo.png\">
		</div>
		<div class=\"wrapper_content\">
			<div class=\"content_body\">
				<h3>{stage_pre}&nbsp;{stage_num} - {stage_title}</h3>
				<br />
				{stage_content}
				{debug_info}
			</div>
			
		</div>
		<div class=\"wrapper_clearing\">
			&nbsp;
		</div>
		<div class=\"wrapper_footer\">
			{copyright_localization}{copyright_newyear}{copyright_reserved}
		</div>
	</div>
</body>
</html>";
	return $data;
}
?>