<?php

if (!defined('e107_INIT')) { exit; }

global $sc_style, $catalog_shortcodes;

// ##### NEXT PREV --------------------------------------------------
if(!isset($CATALOG_NP_TABLE)){
	$CATALOG_NP_TABLE = "<div class='nextprev'>{LINK_NEXTPREV}</div>";
} 
// ##### ----------------------------------------------------------------------

$sc_style['CATALOG_MANAGE_NEWLINK']['pre'] = "<div style='text-align:right;'>";
$sc_style['CATALOG_MANAGE_NEWLINK']['post'] = " >></div>";

$CATALOG_TABLE_MANAGE_START = "
	<form method='post' action='".e_SELF."?".e_QUERY."' id='linkmanagerform' enctype='multipart/form-data'>
	<table class='fborder' style='width:100%;' cellspacing='0' cellpadding='0'>
	<tr>
	<td style='width:15%' class='fcaption'>".LAN_LINKS_MANAGER_5."</td>
	<td style='width:75%' class='fcaption'>".LAN_LINKS_MANAGER_1."</td>
	<td style='width:10%' class='fcaption'>".LAN_LINKS_MANAGER_2."</td>
	</tr>";

$CATALOG_TABLE_MANAGE = "
	<tr>
	<td style='width:15%; padding-bottom:5px;' class='forumheader3'>{CATALOG_MANAGE_CAT}</td>
	<td style='width:75%; padding-bottom:5px;' class='forumheader3'>{CATALOG_MANAGE_ICON} {CATALOG_MANAGE_NAME}</td>
	<td style='width:10%; padding-bottom:5px; text-align:center; vertical-align:top;' class='forumheader3'>{CATALOG_MANAGE_OPTIONS}</td>
	</tr>";

$CATALOG_TABLE_MANAGE_END = "</table></form><br />{CATALOG_MANAGE_NEWLINK}";


?>
