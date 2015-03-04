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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/clock_menu/config.php $
|     $Revision: 11678 $
|     $Id: config.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
$eplug_admin = TRUE;
require_once("../../class.php");
if (!getperms("1")) {
	header("location:".e_BASE."index.php");
	 exit ;
}
require_once(e_ADMIN."auth.php");
include_lan(e_PLUGIN."clock_menu/languages/admin/".e_LANGUAGE.".php");

require_once(e_HANDLER."form_handler.php");
$rs = new form;
	
if (isset($_POST['update_menu'])) {
	while (list($key, $value) = each($_POST)) {
		if ($key != "update_menu") {
			$menu_pref[$key] = $value;
		}
	}
	if ($_POST['clock_format'] != 1) {
		$menu_pref['clock_format'] = 0;
	}
	$tmp = addslashes(serialize($menu_pref));
	$sql->db_Update("core", "e107_value='$tmp' WHERE e107_name='menu_pref' ");
	$ns->tablerender("", "<div style=\"text-align:center\"><b>".CLOCK_AD_L1."</b></div>");
}
	
$text = "<div style='text-align:center'>
	<form method=\"post\" action=\"".e_SELF."?".e_QUERY."\" name=\"menu_conf_form\">
	<table style=\"width:85%\" class=\"r_border\">";
	
//  Title
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L2.": </td>
	<td style=\"width:60%\" class='r_header3'>
	<input class=\"tbox\" type=\"text\" name=\"clock_caption\" size=\"20\" value=\"".$menu_pref['clock_caption']."\" maxlength=\"100\" />
	</td>
	</tr>";
	
// Format Time
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L5.": </td>
	<td style=\"width:60%\" class='r_header3'>".($menu_pref['clock_format'] == 1 ? $rs->form_checkbox("clock_format", 1, 1) : $rs->form_checkbox("clock_format", 1, 0) )."
	<br /><b class='smalltext'>".CLOCK_AD_L6."</b></td>
	</tr>";
	
//  Date Prefix
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L7.": </td>
	<td style=\"width:60%\" class='r_header3'>
	<input class=\"tbox\" type=\"text\" name=\"clock_dateprefix\" size=\"10\" value=\"".$menu_pref['clock_dateprefix']."\" maxlength=\"50\" />
	<br /><b class='smalltext'>".CLOCK_AD_L8."</b></td>
	</tr>";
	
//  Date Suffix
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L9.": </td>
	<td style=\"width:60%\" class='r_header3'>
	1<input class=\"tbox\" type=\"text\" name=\"clock_datesuffix1\" size=\"10\" value=\"".$menu_pref['clock_datesuffix1']."\" maxlength=\"50\" />
	<br /><b class='smalltext'>".CLOCK_AD_L13."</b></td>
	</tr>";
	
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L10.": </td>
	<td style=\"width:60%\" class='r_header3'>
	2<input class=\"tbox\" type=\"text\" name=\"clock_datesuffix2\" size=\"10\" value=\"".$menu_pref['clock_datesuffix2']."\" maxlength=\"50\" />
	<br /><b class='smalltext'>".CLOCK_AD_L13."</b></td>
	</tr>";
	
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L11.": </td>
	<td style=\"width:60%\" class='r_header3'>
	3<input class=\"tbox\" type=\"text\" name=\"clock_datesuffix3\" size=\"10\" value=\"".$menu_pref['clock_datesuffix3']."\" maxlength=\"50\" />
	<br /><b class='smalltext'>".CLOCK_AD_L13."</b></td>
	</tr>";
	
$text .= "<tr>
	<td style=\"width:40%\" class='r_header3'>".CLOCK_AD_L12.": </td>
	<td style=\"width:60%\" class='r_header3'>
	4<input class=\"tbox\" type=\"text\" name=\"clock_datesuffix4\" size=\"10\" value=\"".$menu_pref['clock_datesuffix4']."\" maxlength=\"50\" />
	<br /><b class='smalltext'>".CLOCK_AD_L13."</b></td>
	</tr>";
	
$text .= "<tr style=\"vertical-align:top\">
	<td colspan=\"2\"  style=\"text-align:center\" class='r_header1'>
	<input class=\"button\" type=\"submit\" name=\"update_menu\" value=\"".CLOCK_AD_L3."\" />
	</td>
	</tr>
	</table>
	</form>
	</div>";
$ns->tablerender(CLOCK_AD_L4, $text);
require_once(e_ADMIN."footer.php");
?>