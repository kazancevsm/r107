<?php

/*
**
**	Content Rotator - e107 Plugin
**	Author: 		Boudewijn Geiger
**	Version:		1.0
**  Date:			juli-2010
**  copyright: 		20010 by - boedy.net
**  website: 		http://www.boedy.net
**
**  License:		You may not transfer or sub-license,
**					any of my templates or plugins to anyone
**					else without prior written consent
**					from boedy, or when stated otherwise.
**
*/

require_once("../../../class.php");
require_once(e_HANDLER.'ren_help.php');
if (!getperms("P")) {
    header("location:".e_HTTP."index.php");
    exit;
}

require_once(e_ADMIN."auth.php");

if (e_QUERY) {
    list($action, $id, $order) = explode(".", e_QUERY);
}
else
    $action = FALSE;

if($action=="moveup"){
    $sql->db_Update("c_rotator", "cr_order=cr_order-1 WHERE cr_order=".($order+1));
    $sql->db_Update("c_rotator", "cr_order=cr_order+1 WHERE id=".$id);
    header("location: ../admin_view_entrees.php");
}

if($action=="movedown"){
    $sql->db_Update("c_rotator", "cr_order=cr_order+1 WHERE cr_order=".($order-1));
    $sql->db_Update("c_rotator", "cr_order=cr_order-1 WHERE id=".$id);
    header("location: ../admin_view_entrees.php");
}



