<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     r107 website system  : http://r107.pro
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "Content Rotator"  Author: Boedy - info@boxfish.org
|     Support OSGroup.pro
|     http://r107.pro support@r107.pro
+-----------------------------------------------------------------------------------------------+
*/

require_once("../../../class2.php");
require_once(e_HANDLER."ren_help_handler.php");
if (!getperms("P")) {
    header("location:".e_HTTP."index.php");
    exit;
}

require_once(e_ADMIN."auth.php");

if (e_QUERY) {
    list($sub_action, $id, $order) = explode(".", e_QUERY);
}
else
    $action = FALSE;

if($action=="moveup"){
    $sql->db_Update("c_rotator", "cr_sequence=cr_sequence-1 WHERE cr_sequence=".($order+1));
    $sql->db_Update("c_rotator", "cr_sequence=cr_sequence+1 WHERE cr_id=".$id);
    header("location: ../admin_config.php");
}

if($action=="movedown"){
    $sql->db_Update("c_rotator", "cr_sequence=cr_sequence+1 WHERE cr_sequence=".($order-1));
    $sql->db_Update("c_rotator", "cr_sequence=cr_sequence-1 WHERE cr_id=".$id);
    header("location: ../admin_config.php");
}



