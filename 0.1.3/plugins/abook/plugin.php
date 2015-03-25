<?php
/*==================================Address Book 1.0=============================
|  author - Sunout; Geo, http://e107.compolys.ru, support@compolys.ru		|
|  http://e107.ru, http://e107.ru, http://e107.org                            	|
|  GNU General Public License (http://gnu.org)					|
====================================19.11.2011=================================*/
// ----------------------------------------Plugin info------------------------------
$lan_file = e_PLUGIN."abook/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."abook/languages/English.php"));

$eplug_name = AB_INFO;					// Name Plugin
$eplug_version = "1.0";					// Version plugin
$eplug_author = "'ComPolyS'";				// Author
$eplug_url = "http://e107.compolys.ru";			// Web address author and supprot
$eplug_email = "sunout@compolys.ru";			// Mail author
$eplug_description = AB_ABOUT;				// About plugin
$eplug_compatible = "e107v7";				// Version e107
$eplug_readme = "doc/readme.txt";			// Leave blank if no readme file
$eplug_folder = "abook"; 				// Name of the plugin's folder
$eplug_menu_name = AB_INFO; 				// Mane of menu item for plugin
$eplug_conffile = "admin_config.php"; 			// Name of the admin configuration file
$eplug_logo = "images/icon_32.png";			// Logo plugin
$eplug_icon = $eplug_folder."/images/icon_32.png"; 	// Icon image and caption text
$eplug_icon_small = $eplug_folder."/images/icon_16.png";// Logo plugin
$eplug_caption = AB_EDIT_1;
$eplug_link = True; 					// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_name = AB_INFO;
$eplug_link_url = e_PLUGIN."abook/abook.php";		// Start file of plugin
$eplug_done = "Address Book успешно установлена!"; 				// Text to display after plugin successfully installed
$eplug_prefs = array(); // List of preferences
$eplug_table_names = array("ab_cat", "ab_gnl", "ab_ban"); // List of table names
$eplug_prefs = array(
    "ab_folder" => "abook",
    "ab_admail" => "user@e-mail",
    "ab_days" => "30",
    "ab_prolong" => "15",
    "ab_dateformat" => "%d.%m.%Y",
    "ab_sizepicbig" => "600",
    "ab_sizepicsmall" => "200",
    "ab_showcols" => "2",
    "ab_showrows" => "40"
    );

$eplug_tables = array( // List of sql requests to create tables
//=============== table Addresss Book Config ======================// 
"create table ".MPREFIX."ab_cat (
cat_id int auto_increment not null,
cat_name varchar(200),
cat_desc varchar(250),
cat_icon varchar(200),
primary key(cat_id)
) TYPE=MyISAM;",
//=============== table Address Book Config ======================//
"create table ".MPREFIX."ab_gnl (
gnl_id int auto_increment not null,
gnl_cat varchar(200),
gnl_name varchar(200),
gnl_mag varchar(200),
gnl_city varchar(100),
gnl_address varchar(100),
gnl_site varchar(250),
gnl_mail varchar(200),
gnl_icq varchar(200),
gnl_user varchar(250),
gnl_conname varchar(50),
gnl_conphone varchar(50),
gnl_logo varchar(100),
gnl_img varchar(100),
gnl_devision blob,
gnl_desc blob,
gnl_check_admin varchar(10),
primary key(gnl_id)
) TYPE=MyISAM;",

//=============== table Addresss Book Banners ======================//
"create table ".MPREFIX."ab_ban (
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
//array("ALTER TABLE `".MPREFIX."mycconf` ADD `adlength` VARCHAR(250);", "ALTER TABLE `".MPREFIX."mycads` ADD `pdate` VARCHAR(250);");
$eplug_upgrade_done = "������� ��������.";
?>