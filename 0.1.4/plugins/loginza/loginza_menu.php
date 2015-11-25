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
	
	if(!USER){
		
		global $ns, $tp, $pref;
	
		$loginza_text = $tp->parseTemplate('{LOGINZA}');
		$ns->tablerender($pref['loginza_menu_title'], $loginza_text);
	
	}

?>