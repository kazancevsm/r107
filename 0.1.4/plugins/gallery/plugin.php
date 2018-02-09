<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://r107.slog.su
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "gallery"
|     Author: Sunout sunout@mail.ru
|     Home page: http://r107.slog.su
+-----------------------------------------------------------------------------------------------+
*/

$lan_file = e_PLUGIN."gallery/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."gallery/languages/English.php"));

$eplug_name = LAN_GAL_NAME."";				//Name Plugin
$eplug_version = "0.1";					// Version plugin
$eplug_author = "Sunout";				// Author
$eplug_url = "http://r107.slog.su";			// Web address author and supprot
$eplug_email = "sunout@mail.ru";			// Mail author
$eplug_description = LAN_GAL_ABOUT."";			// About plugin
$eplug_compatible = "r107 v1.4+";			// Version e107
$eplug_readme = "readme.txt";				// Leave blank if no readme file
$eplug_folder = "gallery";				// Name of the plugin's folder
$eplug_logo = "button.png";				// Logo plugin
$eplug_icon = "gallery/images/gallery_32.png";		// Icon image and caption text
$eplug_icon_small = "gallery/images/gallery_16.png";	// Icon image and caption text
$eplug_menu_name = "gallery_menu";
$eplug_caption =  LAN_GAL_NAME;
$eplug_menu_name = LAN_GAL_MENU_NAME; 			// Mane of menu item for plugin
$eplug_conffile = "admin_config.php";			// Name of the admin configuration file

$eplug_link = True; 					// Create a link in main menu (yes=TRUE, no=FALSE)
$eplug_link_url = e_PLUGIN."gallery/gallery.php";	// Start file of plugin
$eplug_link_name = LAN_GAL_NAME;

$eplug_done = LAN_GAL_MES_INSTALL;
$eplug_upgrade_done = LAN_GAL_MES_UPGRADE;
$upgrade_add_prefs = LAN_GAL_MES_ADD_PREFS;
$upgrade_remove_prefs = LAN_GAL_MES_REM_PREFS;

$eplug_table_names = array("gallery_cat","gallery_img");// List of table names


$eplug_prefs = array(
    "gallery_rows" => "4",
    "gallery_columns" => "4",
    "gallery_menu_rows" => "3",
    "gallery_menu_columns" => "1",
    "gallery_img_icon_height" => "94",
    "gallery_img_icon_width" => "120",
    "gallery_img_view_height" => "480",
    "gallery_img_view_width" => "580",
    "gallery_gallery_name" => LAN_GAL_NAME,
    "gallery_menu_caption" => LAN_GAL_MENU_NAME,
    "gallery_menu_img_size" => "140",
    "gallery_nav_position" => "0",
    "gallery_slide_show" => FALSE,
    "gallery_memo_show" => "2",
    "gallery_mine_page" => "1",
    "gallery_nav_show" => FALSE,
    "gallery_comments" => FALSE,
    "gallery_raters" => FALSE,
    "gallery_hs_theme" => 0,
    "gallery_img_quality" => 90,
    "gallery_sort_type" => "NA"
    );
    
$eplug_tables = array("
CREATE TABLE ".MPREFIX."gallery_cat (
cat_id INT(9) auto_increment not null,
cat_sub_id VARCHAR(250) NULL,
cat_foldername VARCHAR(250) NULL,
cat_name VARCHAR(250) NULL,
cat_desc VARCHAR(250) NULL,
cat_userid varchar(10),
cat_img varchar(50),
cat_img varchar(50),
cat_count VARCHAR(250) NULL,
PRIMARY KEY (cat_id)
) ENGINE = MyISAM;"
,
"CREATE TABLE ".MPREFIX."gallery_img (
img_id INT(9) NOT NULL auto_increment,
img_cat_id INT(9) NOT NULL,
img_name VARCHAR (250) NULL,
img_desc TEXT NULL,
img_title VARCHAR (250) NULL,
img_status VARCHAR (50) NULL,
img_userid VARCHAR (10) NULL,
img_count VARCHAR (10) NULL,
PRIMARY KEY (img_id)
) ENGINE = MyISAM"
);


$upgrade_alter_tables = array("");
/*
$upgrade_alter_tables = array("
CREATE TABLE ".MPREFIX."gallery (
img_id INT(9) NOT NULL auto_increment ,
img_name VARCHAR( 250 ) NULL ,
img_description TEXT NULL ,
PRIMARY KEY  (img_id)
) ENGINE = MYISAM ;
", "
ALTER TABLE ".MPREFIX."gallery ADD img_title VARCHAR( 250 ) NULL ;
", "
ALTER TABLE ".MPREFIX."gallery ADD img_status VARCHAR( 50 ) NULL ;
", "
ALTER TABLE ".MPREFIX."gallery ADD img_user VARCHAR( 250 ) NULL ;
");
*/

?>