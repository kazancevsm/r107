<?php
require_once("../../class2.php");
//if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."np_class.php");
@include_lan(e_PLUGIN."abook/languages/".e_LANGUAGE.".php");
require_once("abook_class.php");
//require_once("1.php");

$ns = new e107table;
require_once(HEADERF);
require_once("navigation.php");

//====================Address Book CATEGORY=====================//
if(!IsSet($_GET['page']) || ($page=='list')){
	require_once("list.php");
}
if(IsSet($_GET['page'])) {

//====================Address Book VIEWADS======================//
    if($page=='detailed'){
	require_once("detailed.php");
    }

//====================Address Book ADD =========================//
    if($page=='add'){
	require_once("add.php");
    }

//====================Address Book SEARCH======================//
    if(IsSet($_GET['search'])){
	require_once("search.php");
    }
}
$caption = AB_INFO;
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
function theme_head() {
 	return "<script type='text/javascript' src='".e_PLUGIN."abook/js/add_check.js'></script>";
}
?>