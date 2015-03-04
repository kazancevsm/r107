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

global $sql, $e107cache;

@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');

$lcount = $e107cache->retrieve('nomd5_loginza', 60);

if(!$lcount){
	$lcount = $sql->db_Count('loginza');
	$e107cache->retrieve('nomd5_loginza', $lcount);
}

$text .= '<div style="padding-bottom: 2px;">
<img src="'.e_PLUGIN.'loginza/images/loginza.png" alt="" style="border:0px; vertical-align: bottom; width: 16px; height: 16px"/>
'.LOGINZA_ADMIN_TOTAL.' <a href="'.e_PLUGIN.'loginza/admin_loginza.php?stat">'.$lcount.'</a></div>';

?>