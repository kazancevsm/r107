<?php
// ***************************************************************
// *
// *		Title:			Change Password Menu
// *
// *		Author:			Barry Keal
// *
// *		Localization:	Alexander Kadnikov [Predator]
// *
// *		Date:			02 September 2011
// *
// *		Version:		1.1
// *
// *		Description:	Simple User Change password
// *
// *		Site:			www.e107club.ru
// *
// ***************************************************************
if (e_LANGUAGE !="English" && file_exists(e_PLUGIN . "change_pass_menu/languages/admin/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "change_pass_menu/languages/admin/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "change_pass_menu/languages/admin/English.php");
}
// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = CPASS_A2;
$eplug_version = "1.1";
$eplug_author = "Barry";
$eplug_url = "http://keal.me.uk";
$eplug_email = "cpass@keal.me.uk";
$eplug_description = CPASS_A3;
$eplug_compatible = "e107 v0.7++<br /><b>Перевод:</b> Александр Кадников [Predator]";
$eplug_readme = "readme.pdf";	// leave blank if no readme file
$eplug_compliant=TRUE;
$eplug_status = FALSE;
$eplug_latest = FALSE;

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "change_pass_menu";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "Изменение пароля";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/cpass_32.png";
$eplug_icon_small = $eplug_folder."/images/cpass_16.png";
$eplug_caption =  CPASS_A2;

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs =array("cpass_userclass"=>"0");

// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = "";

// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = "";

// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = TRUE;
$eplug_link_name = CPASS_A2;
$eplug_link_url = e_PLUGIN."change_pass_menu/cpass.php";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = CPASS_A4;

// upgrading ... //

$upgrade_add_prefs = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done = "";
?>