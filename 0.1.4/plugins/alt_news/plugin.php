<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/alt_news/plugin.php $
|     $Revision: 12178 $
|     $Id: plugin.php 12178 2011-05-02 20:45:40Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// Plugin info -------------------------------------------------------------------------------------------------------
include_lan(e_PLUGIN."alt_news/languages/".e_LANGUAGE.".php");

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = LAN_ALTNEWS_NAME;
$eplug_version = "1.0";
$eplug_author = "e107 & OSGroup";
$eplug_url = "http://vk.com/r107_sl";
$eplug_email = "sunout@mail.ru";
$eplug_description = LAN_ALTNEWS_ABOUT;
$eplug_compatible = "e107v0.7+";
$eplug_readme = "";
$eplug_status = FALSE;

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "alt_news";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "alt_news";


// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/chatbox_32.png";
$eplug_icon_small = $eplug_folder."/images/chatbox_16.png";

$eplug_caption = LAN_CONFIGURE; // e107 generic term.
?>
