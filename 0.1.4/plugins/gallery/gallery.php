<?php
/*============================= Notice-Board v5.0 ==============================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru		|
|	coder - Sunout, sunout@compolys.ru					|
|	license GNU GPL								|
=================================== 2012-2013 =================================*/

	require_once("../../class2.php");
	require_once(e_HANDLER."form_handler.php");
//	require_once(e_HANDLER."userclass_class.php");
	require_once(e_PLUGIN."gallery/gallery_handler.php");
	@include_once(e_PLUGIN."gallery/languages/".e_LANGUAGE.".php");
//	$ns = new e107table;
	require_once(HEADERF);
//	require_once(e_PLUGIN."gallery/navigation.php");
	
	//===== Include templates
$tml_file = THEME."gallery_temlate.php";
include((file_exists($tml_file) ? $tmp_file : e_PLUGIN."gallery/gallery_temlate.php"));
	$search = array(
		"{MG_USER_NAME}",
		"{MG_USER_GALLERY}",
		"{MG_IMG_TITLE}",
		"{MG_IMG_DESCRIPTION}",
		"{MG_IMG_FILE}",
		"{MG_IMG_GALLERY}",
		"{MG_IMG_SIZE}",
		"{MG_IMG_DOWLOAD}",
		"{MG_IMG_THUMB}",
		"{MG_COMMENTS}",
		"{MG_COMMENT}",
		"{MG_HS_CAPTION}");

//====== GALLERY FRONTPAGE
if(!IsSet($_GET['page'])){
	require_once("frontpage.php");
}
if(IsSet($_GET['page'])){
//====== GALLERY ALBUMS
	if($page == 'albums'){
	      require_once("albums.php");
	}
//===== GALLERY ADD
	if($page == 'add'){
		require_once("add.php");
	}
//====================GALLERY SEARCH======================//
	if($page == 'search'){
	      require_once("search.php");
	}
}
$caption = "<a href='".e_PLUGIN."gallery/gallery.php#gallery'><h1>$gallery_name</h1></a>";
$ns -> tablerender($caption,$text);
require_once(FOOTERF);
?>