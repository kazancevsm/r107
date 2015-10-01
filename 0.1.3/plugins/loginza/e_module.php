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

global $e_event, $sql;
$e_event->register('userdel', 'ondeluser_loginza');

function ondeluser_loginza($data){
	if(!is_object($sql)) $sql = new db;
	$sql->db_Delete('loginza',"`user_id`=".$data);
} 

?>