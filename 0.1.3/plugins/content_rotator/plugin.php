<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "Content Rotator"
|     Author: Boedy - info@boxfish.org
+-----------------------------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."content_rotator/languages/".e_LANGUAGE.".php");

$eplug_name = "Content Rotator";
$eplug_version = "1.02";
$eplug_author = "boedy";
$eplug_logo = "button.png";
$eplug_url = "http://www.boedy.net/";
$eplug_email = "info@boedy.net";
$eplug_description = "Content Rotator for images and content.";
$eplug_compatible = "e107 v7.8+";
$eplug_conffile = "admin_config.php";
$eplug_icon = $eplug_folder."/images/icon.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_caption =  "Content rotator";

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "content_rotator";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";


// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/content_rotator_32.png";
$eplug_icon_small = $eplug_folder."/images/content_rotator_16.png";
$eplug_caption = "Content Rotator";

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array();

$eplug_table_names = array("c_rotator");
$eplug_tables = array(
"CREATE TABLE ".MPREFIX."c_rotator (
   id int(11) unsigned NOT NULL auto_increment,
   title varchar(200) NOT NULL default '',
   intro text NOT NULL,
   text text NOT NULL,
   image varchar(256) NOT NULL default '',
   thumbnail varchar(256) NOT NULL default '',
   captions varchar(256) NOT NULL default '',
   link varchar(256) NOT NULL default '',
   cr_order int(11) unsigned NOT NULL default '0',
   PRIMARY KEY (id)
) ENGINE=MyISAM;");

$upgrade_alter_tables  = array(
    "ALTER TABLE ".MPREFIX."c_rotator ADD cr_order int(11) unsigned NOT NULL default '0'",
    "UPDATE ".MPREFIX."c_rotator SET cr_order=id "

);


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = LAN_C_ROTATOR_INSTALL_1;
?>