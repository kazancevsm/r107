<?php
/*============================= Tabletime v1.0 =========================\
|	author - Sunout, http://e107.compolys.ru, sunout@compolys.ru	\
|	coder - Sunout, Geo, license GNU GPL				\
====================================== 2011 ============================*/
if (!defined('e107_INIT')) { exit; }
// ----------------------------------------Plugin info------------------------------
$lan_file = e_PLUGIN."timetable/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."timetable/languages/English.php"));

$eplug_name = TT_INFO;					// Name Plugin
$eplug_version = "1.0";					// Version plugin
$eplug_author = "'Sunout/Geo";		// Author
$eplug_url = "http://e107.compolys.ru";			// Web address author and supprot
$eplug_email = "sunout@compolys.ru";			// Mail author
$eplug_description = TT_ABOUT;				// About plugin
$eplug_compatible = "e107v7";				// Version e107
$eplug_readme = "doc/readme.pdf";			// Leave blank if no readme file
$eplug_folder = "timetable"; 				// Name of the plugin's folder
$eplug_menu_name = TT_INFO; 				// Mane of menu item for plugin
$eplug_conffile = "admin_config.php"; 			// Name of the admin configuration file
$eplug_logo = "theme/icon_32.png";			// Logo plugin
$eplug_icon = $eplug_folder."/theme/icon_32.png"; 	// Icon image and caption text
$eplug_icon_small = $eplug_folder."/theme/icon_16.png";// Logo plugin
$eplug_caption = TT_EDIT_1;
$eplug_link = True; 					// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_name = TT_INFO;
$eplug_link_url = e_PLUGIN."timetable/timetable.php";		// Start file of plugin
$eplug_done = "Timetable успешно установлена!"; // Text to display after plugin successfully installed
$eplug_prefs = array();
$eplug_table_names = array("tt_gnl","tt_ban"); // List of table names
$eplug_tables = array(
"create table ".MPREFIX."tt_gnl (
gnl_id int auto_increment not null,
gnl_name varchar(250),
gnl_desc blob,
gnl_icon varchar(250),
primary key(gnl_id)
) TYPE=MyISAM;",
//=============== table Notice-Board Banners ======================//
"create table ".MPREFIX."tt_ban (
ban_id int auto_increment not null,
ban_catid varchar(10),
ban_org varchar(100),
ban_url varchar(100),
ban_datebegin varchar(50),
ban_dateend varchar(50),
ban_images varchar(100),
primary key(ban_id)
) TYPE=MyISAM;"

);

// upgrading ...
$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done = "";
?>