<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================

if (!defined('e107_INIT')) { exit; }
// ----------------------------------------Plugin info------------------------------
$lan_file = e_PLUGIN."catalog/languages/".e_LANGUAGE.".php";
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."catalog/languages/English.php");

$eplug_name = PLUG_INFO_CAP;				// Caption of the plugin
$eplug_version = "1.0";					// Version of the plugin
$eplug_author = "MagicDreamWebStudio";			// Author
$eplug_url = "http://md.osgroup.pro";			// Site of author and support
$eplug_email = "sunout@osgroup.pro";			// E-mail of author
$eplug_description = PLUG_INFO_ABOUT;			// Information about the plugin
$eplug_compatible = "e107v7+";				// Version of e107 for plugin working
$eplug_readme = "doc/readme.doc";			// Leave blank if no readme file
$eplug_folder = "catalog";				// Name of the plugin's folder
$eplug_menu_name = PLUG_INFO_NAME;			// Mane of menu item for plugin
$eplug_conffile = "admin_config.php";			// Name of the admin configuration file
$eplug_logo = "theme/logo_32.png";
$eplug_icon = $eplug_folder."/theme/logo_32.png";	// Icon image and caption text
$eplug_icon_small = $eplug_folder."/theme/logo_16.png";
$eplug_caption =  PLUG_CONF_CAP;			// Caption adminconfig page
$eplug_link = True;					// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_name = PLUG_INFO_NAME;
$eplug_link_url = e_PLUGIN."catalog/catalog.php";
$site = SITEURL;
$eplug_done = PLUG_INFO_INST;				// Text to display after plugin successfully installed
$eplug_prefs = array( 					// List of preferences
"conf_cathead" => PLUG_INFO_NAME,			// plugin name
"conf_catadmail" => 'yourmail@yourserver.domen',	// mail of admin trade or manager
"conf_catsizepicbig" => '600',				// big size of pictures
"conf_catsizepicsmall" => '150',			// small size of pictures
"conf_catshowcolscat" => '2',				// show column categories
"conf_catshowrowscat" => '10',				// show row categories
"conf_catshowcolsitems" => '2',				// show column items
"conf_catshowrowsitems" => '10',			// show rows items
"conf_catnewshow" => PLUG_YES,				// show new arrivals
"conf_catnewhead" => PLUG_CONF_NEW_CAP,			
"conf_catnewitems" => '4',
"conf_catsaleshow" => PLUG_YES,
"conf_catsalehead" => PLUG_CONF_SALE_CAP,
"conf_catsaleitems" => '4',
"conf_cathitshow" => PLUG_YES,
"conf_cathithead" => PLUG_CONF_HIT_CAP,
"conf_cathititems" => '4'
);

// Tables
$eplug_table_names = array("catalog_cat","catalog_nom");
$eplug_tables = array(
"CREATE TABLE ".MPREFIX."catalog_cat (
cat_id int NOT NULL auto_increment,
cat_sub int,
cat_name varchar(255),
cat_pic varchar(255),
cat_desc longtext,
primary key (cat_id)
) ENGINE=MyISAM;",
"CREATE TABLE ".MPREFIX."catalog_nom (
nom_id int NOT NULL auto_increment,
nom_cat int,
nom_art varchar(250),
nom_name varchar(250),
nom_type varchar(250),
nom_unit varchar(250),
nom_desc longtext,
nom_pic varchar(250),
nom_price varchar(250),
primary key (nom_id)
) ENGINE=MyISAM;"
);

/*
// upgrading ... 
$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = array("ALTER TABLE `".MPREFIX."myitems` ADD `stock` VARCHAR(250);", "ALTER TABLE `".MPREFIX."mystorecat` ADD `parid` VARCHAR(255);", "ALTER TABLE `".MPREFIX."mystorecat` ADD `catimg` VARCHAR(255);", "ALTER TABLE `".MPREFIX."mycart` ADD `cartdate` VARCHAR(255);", "ALTER TABLE `".MPREFIX."mycart` ADD `uniID` VARCHAR(255);", "ALTER TABLE `".MPREFIX."myitems` CHANGE `details` `details` LONGTEXT DEFAULT NULL", "CREATE TABLE ".MPREFIX."myprofile (
ID` int(5) NOT NULL auto_increment,
fname` varchar(255),
lname` varchar(255),
address` longtext NOT NULL,
city` varchar(255),
state` varchar(255),
zip` varchar(255),
country` varchar(255),
uniID` varchar(255),
user` varchar(255),
email` varchar(255),
itemid` varchar(255),
qty` varchar(255),
paystat` varchar(255),
ordstatus` varchar(255),
  PRIMARY KEY  (`ID`),
  FULLTEXT KEY `ordstat` (`ordstatus`)
) ENGINE=MyISAM AUTO_INCREMENT=6 ;");

$upgrade_alter_tables = array("CREATE TABLE ".MPREFIX."vt_order (
order_id int NOT NULL auto_increment,
order_date varchar(255),
primary key (order_id)
) ENGINE=MyISAM;");

$eplug_upgrade_done ="Обновление успешно завершено!";
*/
?>