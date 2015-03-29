<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     r107 website system  : http://r107.pro
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "Content Rotator"  Author: Boedy - info@boxfish.org
|     Support OSGroup.pro
|     http://r107.pro support@r107.pro
+-----------------------------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."content_rotator/languages/".e_LANGUAGE.".php");

$eplug_name = LAN_C_ROT_NAME;
$eplug_version = "1.0 RC1";
$eplug_author = "boedy & OSGroup";
$eplug_logo = "button.png";
$eplug_url = "http://r107.pro/";
$eplug_email = "support@r107.pro";
$eplug_description = LAN_C_ROT_DESC;
$eplug_compatible = "e107 v0.7 ++";
$eplug_done = LAN_C_ROT_INSTALL;
$eplug_conffile = "admin_config.php";
$eplug_icon = $eplug_folder."/images/icon.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_caption =  LAN_C_ROT_NAME;
$eplug_folder = "content_rotator";				// Name of the plugin's folder
$eplug_menu_name = "";						// Name of menu item for plugin
$eplug_conffile = "admin_config.php"; 				// Name of the admin configuration file
$eplug_icon = $eplug_folder."/images/c_rotator_32.png";		// Icon image and caption text
$eplug_icon_small = $eplug_folder."/images/c_rotator_16.png";	// Icon image and caption text
$eplug_link = FALSE;						// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_name = "";
$eplug_link_url = "";
$eplug_prefs = array(); 					// List of preferences
$eplug_table_names = array("c_rotator");

$eplug_table_names = array("c_rotator");
$eplug_tables = array(
"CREATE TABLE ".MPREFIX."c_rotator (
	rot_id int(11) unsigned NOT NULL auto_increment,
	rot_sequence int(11) unsigned NOT NULL default '0',
	rot_title varchar(200) NOT NULL default '',
	rot_intro text NOT NULL,
	rot_text text NOT NULL,
	rot_image varchar(256) NOT NULL default '',
	rot_thumbnail varchar(256) NOT NULL default '',
	rot_captions varchar(256) NOT NULL default '',
	rot_link varchar(256) NOT NULL default '',
	PRIMARY KEY (rot_id)
	) ENGINE=MyISAM;");

	/*
$upgrade_alter_tables  = array(
    "ALTER TABLE ".MPREFIX."c_rotator ADD cr_order int(11) unsigned NOT NULL default '0'",
    "UPDATE ".MPREFIX."c_rotator SET cr_order=id "

);

*/
?>