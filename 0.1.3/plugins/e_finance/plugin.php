<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

if (!defined('e107_INIT')) { exit; }
// ----------------------------------------Plugin info------------------------------
$lan_file = e_PLUGIN."e_finance/languages/".e_LANGUAGE.".php";
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."e_finance/languages/English.php");

$eplug_name = LAN_EF_PLUG_NAME;
$eplug_version = "1.0";
$eplug_author = "Sunout";
$eplug_url = "http://md.osgroup.pro";
$eplug_email = "support@r107.pro";
$eplug_description = LAN_EF_PLUG_ABOUT;
$eplug_compatible = "e107v7";
$eplug_readme = "doc/readme.doc";			// leave blank if no readme file
$eplug_folder = "e_finance";				// Name of the plugin's folder
$eplug_menu_name = LAN_EF_PLUG_NAME;			// Mane of menu item for plugin
$eplug_conffile = "admin_config.php";			// Name of the admin configuration file
$eplug_logo = "theme/logo_32.png";
$eplug_icon = $eplug_folder."/theme/logo_32.png";	// Icon image and caption text
$eplug_icon_small = $eplug_folder."/theme/logo_16.png";
$eplug_caption =  "Configure The E-Finance";

$eplug_link = True;					// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_name = LAN_EF_INFO_01;
$eplug_link_url = "";
$site = SITEURL;
$eplug_done = LAN_EF_PLUG_INST;// Text to display after plugin successfully installed

$eplug_prefs = array( // List of preferences
"conf_vthead" => LAN_EF_INFO_01,			// plugin name
"conf_admail" => 'yourmail@yourserver.domen',	// mail of admin trade or manager
"conf_sizepicbig" => '600',			// big size of pictures
"conf_sizepicsmall" => '150',			// small size of pictures
"conf_showcolscat" => '2',			// show column categories
"conf_showrowscat" => '10',			// show row categories
"conf_showcolsitems" => '2',			// show column items
"conf_showrowsitems" => '10',			// show rows items
"conf_newshow" => LAN_EF_YES,			// show new arrivals
"conf_newhead" => LAN_EF_CONF_NEW_CAP,		// 
"conf_newitems" => '4',
"conf_saleshow" => LAN_EF_YES,
"conf_salehead" => LAN_EF_CONF_SALE_CAP,
"conf_saleitems" => '4',
"conf_hitshow" => LAN_EF_YES,
"conf_hithead" => LAN_EF_CONF_HIT_CAP,
"conf_hititems" => '4'
);

	
//$eplug_table_names = array("");// List of table names
//
$eplug_table_names = array("ef_basket","ef_order","ef_profile");	// List of table names
//$eplug_table_names = array("ef_nom","ef_cat","ef_basket","ef_profile");	// List of table names
$eplug_tables = array(					// List of sql requests to create tables
"CREATE TABLE ".MPREFIX."ef_profile (
profile_id int(5),
profile_fname varchar(255),
profile_lname varchar(255),
profile_org varchar(255),
profile_address longtext,
profile_city varchar(255),
profile_state varchar(255),
profile_country varchar(255),
profile_index varchar(255),
profile_username varchar(255),
profile_email varchar(255),
profile_phone varchar(255),
profile_icq varchar(255),
profile_desc longtext,
profile_bonus varchar(255),
primary key (profile_id)
) ENGINE=MyISAM;"

, "CREATE TABLE ".MPREFIX."ef_basket (
basket_id int(5) auto_increment,
basket_nom_name varchar(250),
basket_nom_art varchar(250),
basket_ordnumber int(5),
basket_amount int(5),
basket_price int(5) default NULL,
primary key (basket_id)
) ENGINE=MyISAM;",

"CREATE TABLE ".MPREFIX."ef_order (
order_id int(11) auto_increment,
order_date varchar(255),
order_userid int(11),
order_status varchar(255),
order_user varchar(255),
order_org varchar(255),
order_address varchar(255),
order_email varchar(255),
order_icq varchar(255),
order_phone varchar(255),
order_delivery varchar(255),
order_payment varchar(255),
order_bonus varchar(255),
primary key (order_id)
) ENGINE=MyISAM;");

/*
// upgrading ... 
$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = array("ALTER TABLE `".MPREFIX."myitems` ADD `stock` VARCHAR(250);", "ALTER TABLE `".MPREFIX."mystorecat` ADD `parid` VARCHAR(255);", "ALTER TABLE `".MPREFIX."mystorecat` ADD `catimg` VARCHAR(255);", "ALTER TABLE `".MPREFIX."mycart` ADD `cartdate` VARCHAR(255);", "ALTER TABLE `".MPREFIX."mycart` ADD `uniID` VARCHAR(255);", "ALTER TABLE `".MPREFIX."myitems` CHANGE `details` `details` LONGTEXT DEFAULT NULL", "CREATE TABLE ".MPREFIX."myprofile (
ID` int(5) NOT NULL auto_increment,
fname` varchar(255) NOT NULL default '',
lname` varchar(255) NOT NULL default '',
address` longtext NOT NULL,
city` varchar(255) NOT NULL default '',
state` varchar(255) NOT NULL default '',
zip` varchar(255) NOT NULL default '',
country` varchar(255) NOT NULL default '',
uniID` varchar(255) NOT NULL default '',
user` varchar(255) NOT NULL default '',
email` varchar(255) NOT NULL default '',
itemid` varchar(255) NOT NULL default '',
qty` varchar(255) NOT NULL default '',
paystat` varchar(255) NOT NULL default '',
ordstatus` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  FULLTEXT KEY `ordstat` (`ordstatus`)
) ENGINE=MyISAM AUTO_INCREMENT=6 ;");
$upgrade_alter_tables = array("CREATE TABLE ".MPREFIX."ef_order (			
order_id int(11) NOT NULL auto_increment,
order_date varchar(255) NOT NULL default '',
primary key (order_id)
) ENGINE=MyISAM;");
/*
$eplug_upgrade_done ="Обновление успешно завершено!";
*/
?>