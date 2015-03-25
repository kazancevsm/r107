<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/

require_once("../../class2.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_PLUGIN."md_nboard/nboard_class.php");
@include_once(e_PLUGIN."md_nboard/languages/".e_LANGUAGE.".php");
$ns = new e107table;
require_once(HEADERF);
require_once(e_PLUGIN."md_nboard/navigation.php");
//require_once(e_PLUGIN."md_nboard//nboard/_banners_menu.php");
//====================NOTICE-BOARD CATEGORY=====================//
if(!IsSet($_GET['page'])){
	require_once("list.php");
}
if(IsSet($_GET['page'])){
//====================NOTICE-BOARD VIEWADS======================//
if($page == 'detail'){
	require_once("detailed.php");
}
//====================NOTICE-BOARD ADD =========================//
if($page == 'add'){
	require_once("add.php");
}
//====================NOTICE-BOARD PRIVATE OFFICE==============//
if($page == 'po'){
	require_once("private_office.php");
}	
//====================NOTICE-BOARD SEARCH======================//
if($page == 'search'){
	require_once("search.php");
}
}
$caption = "<a href='".e_PLUGIN."md_nboard/nboard.php'>".NB_INFO."</a> $catlink $sublink";
$ns -> tablerender($caption,$text);
require_once(FOOTERF);
?>