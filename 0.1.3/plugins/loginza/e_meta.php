<?php
/*
+-------------------------------------------------------------------------
|
|     Loginza plugin version 0.5 for e107
|
|     Author: Evlanov Alexander (Kapman)
|     alex@aleksander.org.ru
|     http://free-lance.ru/users/kapman
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+-------------------------------------------------------------------------
*/

	if (!defined('e107_INIT')) { exit; }
	
	global $sql, $pref, $_uid;

	@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');

	if (e_PAGE == 'user.php') {
		
		$que = explode('.', e_QUERY);
		
		if($que[0]=='id' && is_numeric($que[1])){
			
			$loginza_profile = $sql->db_Count($pref['loginza_db'],'(*)'," WHERE `user_id`='".intval($que[1])."'");
			if($loginza_profile>0){
				$detect1 = strpos($USER_FULL_TEMPLATE, "{USER_VISITS}");
				$detect2 = strpos($USER_FULL_TEMPLATE, "{USER_UPDATE_LINK}") - 1;
				$detect = $detect2 - $detect1;
				$profile_old = substr($USER_FULL_TEMPLATE, $detect1, $detect);
				$profile_new = "<tr>
				<td style='width:30%' class='r_header3'>".LOGINZA_PROFILE."</td>
				<td style='width:70%' class='r_header3'>{LOGINZA_PROFILE}</td>
				</tr>";
				$USER_FULL_TEMPLATE = str_replace($profile_old, $profile_old.$profile_new, $USER_FULL_TEMPLATE);
			}
		}
	}
	
	if (e_PAGE == 'usersettings.php') {
		
			$loginza_profile = $sql->db_Count($pref['loginza_db'],'(*)'," WHERE `user_id`='".intval($_uid)."'");
				$detect1 = strpos($USERSETTINGS_EDIT, "{USERCLASSES}");
				$detect2 = strpos($USERSETTINGS_EDIT, "{USEREXTENDED_ALL}") - 1;
				$detect = $detect2 - $detect1;
				$profile_old = substr($USERSETTINGS_EDIT, $detect1, $detect);
				$profile_new = "<tr>
					<td colspan='2' class='r_header1'>OpenID</td>
				</tr>
				<tr>
					<td style='width:40%' class='r_header3'>".LOGINZA_PROFILE."<br /><span class='smalltext'>".LOGINZA_EDIT_DESC."</span></td>
					<td style='width:60%' class='r_header2'><span class='defaulttext'>
					{LOGINZA_EDIT}
					</span>
					</td>
				</tr>";
				$USERSETTINGS_EDIT = str_replace($profile_old, $profile_old.$profile_new, $USERSETTINGS_EDIT);
	}
	
?>