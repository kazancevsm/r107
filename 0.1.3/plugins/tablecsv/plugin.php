<?php
/*============================= Tabletime v1.0 =========================\
|	author - Sunout, http://e107.compolys.ru, sunout@compolys.ru	\
|	coder - Sunout, Geo, license GNU GPL				\
====================================== 2011 ============================*/
if (!defined('e107_INIT')) { exit; }
// ----------------------------------------Plugin info------------------------------
$lan_file = e_PLUGIN."tablecsv/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."timetable/languages/English.php"));

$eplug_name = "tablecsv";				// Name Plugin
$eplug_version = "1.0";					// Version plugin
$eplug_author = "'Sunout/Geo";				// Author
$eplug_url = "http://e107.compolys.ru";			// Web address author and supprot
$eplug_email = "sunout@compolys.ru";			// Mail author
$eplug_description = "tablecsv";			// About plugin
$eplug_compatible = "e107v7";				// Version e107
$eplug_readme = "doc/readme.pdf";			// Leave blank if no readme file
$eplug_folder = "tablecsv"; 				// Name of the plugin's folder
$eplug_menu_name = "tablecsv"; 				// Mane of menu item for plugin
$eplug_conffile = "admin_config.php"; 			// Name of the admin configuration file
$eplug_logo = "theme/icon_32.png";			// Logo plugin
$eplug_icon = $eplug_folder."/theme/icon_32.png"; 	// Icon image and caption text
$eplug_icon_small = $eplug_folder."/theme/icon_16.png";// Logo plugin
$eplug_caption = "Редактировать";
$eplug_link = True; 					// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_name = "tablecsv";
$eplug_link_url = e_PLUGIN."tablecsv/tablecsv.php";	// Start file of plugin
$eplug_done = "Timetable успешно установлена!"; 	// Text to display after plugin successfully installed
$eplug_prefs = array();
$eplug_table_names = array("tc_vac","tc_vacinv"); 	// List of table names
$eplug_tables = array( 					// List of sql requests to create tables
//=============== table Table CSV General =====================//
"create table ".MPREFIX."tc_vac (
vac_id int auto_increment not null,
vac_name varchar(250),
vac_salary varchar(250),
primary key(vac_id)
) TYPE=MyISAM;",

"create table ".MPREFIX."tc_vacinv (
vac_id int auto_increment not null,
vac_name varchar(250),
vac_salary varchar(250),
primary key(vacinv_id)
) TYPE=MyISAM;"
);

// upgrading ...
$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done = "";
?>