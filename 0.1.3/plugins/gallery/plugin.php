<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     r107 website system  : http://r107.pro
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "magic_gallery"
|     Author: Sunout sunout@osgroup.pro
|     Home page: 	http://md.osgroup.pro
|			http://r107.pro
|			http://osgroup.pro
+-----------------------------------------------------------------------------------------------+
*/

$lan_file = e_PLUGIN."gallery/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."gallery/languages/English.php"));

$eplug_name = MG_PLUGIN_NAME;
$eplug_version = "0.1";
$eplug_author = MG_PLUGIN_AUTHOR1."<br>".MG_PLUGIN_AUTHOR2;
$eplug_folder = "gallery";
$eplug_logo = $eplug_folder."/images/logo.png";
$eplug_icon = $eplug_folder."/images/icon_32.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_url = "http://osgroup.pro";
$eplug_email = "support@osgroup.pro";
$eplug_description = MG_PLUGIN_DESC;
$eplug_compatible = "e107 v0.7+";
$eplug_readme = "doc/".e_LANGUAGE.".pdf";
$eplug_menu_name = "magic_gallery_menu";
$eplug_conffile = "admin_config.php";
$eplug_caption =  MG_PLUGIN_NAME;
$eplug_link = TRUE;
$eplug_link_url = e_PLUGIN."gallery/gallery.php";
$eplug_link_name = PLUGIN_LINK;
$eplug_done = MG_PLUGIN_INST;
$eplug_upgrade_done = MG_PLUGIN_UPGRADE;

$eplug_prefs = array(
    "md_gallery_folder" => "gallery",
    "md_gallery_foto_in_page" => "16",
    "md_gallery_rows" => "4",
    "md_gallery_columns" => "4",
    "md_gallery_foto_icon_height" => "94",
    "md_gallery_foto_icon_width" => "120",
    "md_gallery_foto_view_height" => "600",
    "md_gallery_foto_view_width" => "800",
    "md_gallery_gallery_name" => MG_PLUGIN_NAME,
    "md_gallery_title_image" => "theme/images/title_image.jpg",
    "md_gallery_menu_caption" => MG_MENU_CAPTION,
    "md_gallery_slide_show" => FALSE,
    "md_gallery_memo_show" => "2",
    "md_gallery_mine_page" => "1",
    "md_gallery_mine_cikle" => 3,
    "md_gallery_nav_show" => FALSE,
    "md_gallery_comments" => FALSE,
    "md_gallery_raters" => FALSE,
    "md_gallery_theme" => 0,
    "md_gallery_img_quality" => 70,
    "md_gallery_sort_type" => "NA",
    "md_gallery_user_album" => FALSE
    );

$eplug_table_names = array(
        "gal_album"
    );

$eplug_tables = array(
"CREATE TABLE ".MPREFIX."gal_album (
album_id INT(9) NOT NULL auto_increment,
album_user_id int(9) NULL,
album_name_dir VARCHAR (250) NULL,
album_name VARCHAR (250) NULL,
album_desc TEXT NULL,
album_icon VARCHAR (250) NULL,
album_rate VARCHAR (250) NULL,
PRIMARY KEY (album_id)
) ENGINE = MYISAM;
");

//-----UPGRADE
$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
/*
$upgrade_alter_tables = array("
", "
ALTER TABLE ".MPREFIX."my_gallery ADD img_title VARCHAR( 250 ) NULL ;
", "
ALTER TABLE ".MPREFIX."my_gallery ADD img_status VARCHAR( 50 ) NULL ;
", "
ALTER TABLE ".MPREFIX."my_gallery ADD img_user VARCHAR( 250 ) NULL ;
");
*/

?>