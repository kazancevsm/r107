<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

// Три статуса у товара при совершении операций
// waiting - в ожидании, при попадани товара в корзину
// send - отправлен
// processed - обработанный

//================================================================================
require_once("../../class2.php");
if (!defined('e107_INIT')) { exit; }
//require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_handler.php");
//require_once(e_HANDLER."np_class.php");
require_once("languages/".e_LANGUAGE.".php");
//require_once("cart_cookie.php");
$ns = new e107table;
require_once(HEADERF);
require_once(e_SYSTEM.'shortcode/batch/news_archives.php');
require_once(e_HANDLER.'shortcode_handler.php');
require_once('vt_class.php');
$vt_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);

//=============Navigation================
include("navigation.php");
//=============Front Page================
if(IsSet($page) && $page=='frontpage') {
    require_once("frontpage.php");
}
//=============Cat, Subcat Page==========
if(!IsSet($page) || IsSet($page) && $page=='categories' || $page==''){
    require_once("categories.php");
}

//=============Items Page================
if(IsSet($page) && $page=='det'){
    require_once("details.php");
}
//=============Items Page================
if(IsSet($page) && $page=='profile'){
    require_once("profile.php");
}
//=============Search page===============
if(IsSet($page) && $page=='search'){
    require_once("search.php");
}

//=============Basket Page===============
if(IsSet($page) && $page=='basket'){
    require_once("basket.php");
}
//=============Order Page===============
if(IsSet($page) && $page=='order'){
    require_once("order.php");
		}
		//=============Message Page===============]
if(IsSet($page) && $page=='notify'){
    require_once("notify.php");
}
//=============Navigation================
//include("navigation.php");

$caption = "<a href='".e_PLUGIN."vtrade/vtrade.php?page=frontpage'>$conf_vthead</a> $caption_section";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
function sql_allitem($from,$conf_showrowsitems){
	$result_allitems = mysql_query("SELECT * FROM ".MPREFIX."vt_nom") or die(mysql_error());
	//$result_allitem = 1;
	return $result_allitem;
}
?>