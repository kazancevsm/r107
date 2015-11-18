<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/vekna_blue/theme.php $
|     $Revision: 11678 $
|     $Id: theme.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [multilanguage]
include_lan(e_THEME."vtrade_theme/languages/".e_LANGUAGE.".php");

// [theme]
$themename = "vtrade";
$themeversion = "1.0";
$themeauthor = "sunout";
$themeemail = "sunout@mail.ru";
$themewebsite = "http://e107.compolys.ru";
$themedate = "2012";
$themeinfo = "Based on, and with permission from Arach's site, http://e107.vekna.com";
define("STANDARDS_MODE", TRUE);
define("IMODE", "lite");
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;

define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");
/*
function theme_head()
{
  return "<link rel='stylesheet' href='".THEME_ABS."nav_menu.css' type='text/css' />\n";
}
*/
// [layout]

$layout = "_default";
//<div id='bg_left'><img src='".THEME_ABS."images/bg_left.jpg'></div>
//<div id='bg_right'><img src='".THEME_ABS."images/bg_right.jpg'></div>
//
//<div id='main_line'></div>
$HEADER = "
<div id='page'>
    <center>
    <div id='main_shadow'>
    <div id='main_border'>
	<div id='main'>
	      <div id='main_header'>
		  <div id='frame_logo'>
		     <a href='".SITEURL."'><img align='left' src='".THEME_ABS."images/logo.png'></a> 
		  </div>
		  <div id='frame_menu1'>
		      {SETSTYLE=menu1}
		      {MENU=1}
		  </div>
		  <div id='frame_menu2'>
		      {SETSTYLE=menu2}
		      {MENU=2}
		  </div>
	      </div>
	      <div id='main_sitelinks'>
		    {SITELINKS}
	      </div>
	      <div id='main_line'></div>
	      <div id='main_content'>
		   
		    <div id='frame_content_center'>
			{SETSTYLE=centsite}
";

$FOOTER = "
		    </div>
		    <div id='frame_content_left'>
			{SETSTYLE=menu3}
			{MENU=3}
			{SETSTYLE=menu4}
			{MENU=4}
			{SETSTYLE=menu5}
			{MENU=5}
		    </div>
	      </div>
	      <div id='main_infobar'>
		  <div id='infobar_left'>
		      {SETSTYLE=menu6}
		      {MENU=6}
		  </div>
		  <div id='infobar_right'>
		      {SITEDISCLAIMER}{THEME_DISCLAIMER}
		  </div>
	      </div>
	  </div>
      </div>
      </div>
      </center>
</div>
";

$CUSTOMHEADER = "
<div id='page'>
    <center>
    <div id='main_shadow'>
    <div id='main_border'>
	<div id='main'>
	      <div id='main_header'>
		  <div id='frame_logo'>
		     <a href='".SITEURL."'><img align='left' src='".THEME_ABS."images/logo.png'></a> 
		  </div>
		  <div id='frame_menu1'>
		      {SETSTYLE=menu1}
		      {MENU=1}
		  </div>
		  <div id='frame_menu2'>
		      {SETSTYLE=menu2}
		      {MENU=2}
		  </div>
	      </div>
	      <div id='main_sitelinks'>
		    {SITELINKS}
	      </div>
	      <div id='main_line'></div>
	      <div id='main_content'>
		    <div id='frame_content_left'>
			{SETSTYLE=menu3}
			{MENU=3}
			{SETSTYLE=menu4}
			{MENU=4}
			{SETSTYLE=menu5}
			{MENU=5}
		    </div>
		    <div id='frame_content_center'>
			{SETSTYLE=centsite}
";
$CUSTOMFOOTER = "
		    </div>
	      </div>
	      <div id='main_infobar'>
		  <div id='infobar_left'>
		      {SETSTYLE=menu6}
		      {MENU=6}
		  </div>
		  <div id='infobar_right'>
		      {SITEDISCLAIMER}{THEME_DISCLAIMER}
		  </div>
	      </div>
	  </div>
      </div>
      </div>
      </center>
</div>
";

$CUSTOMPAGES = "news.php vtrade.php?frontpage";

$NEWSSTYLE = "
    <div id='block_news'>
	<div id='news_title'>{NEWSTITLE}</div>
	<div id='news_body'>{NEWSBODY}{EXTENDED}</div>
	<div id='news_infobar'>{NEWSAUTHOR} on {NEWSDATE} | {NEWSCOMMENTS}{TRACKBACK}</div>
    </div>
";

define("ICONSTYLE", "");
define("COMMENTLINK", LAN_THEME_2);
define("COMMENTOFFSTRING", LAN_THEME_3);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " | ");


// [linkstyle]
define('PRELINK', "<div id='block_sitelinks_space'></div><div id='block_sitelinks_pg'></div>");
define('POSTLINK', "</div>");
define('LINKSTART', "<div id='block_sitelinks'>");
//define("LINKSTART_HILITE", "");
define('LINKEND', " </div><div id='block_sitelinks_pg'></div>");
define('LINKDISPLAY', 1);
define('LINKALIGN', " ");
define("BULLET", " ");



//	[tablestyle]
//<tr><td id='menu1_caption'>$caption</td></tr>
function tablestyle($caption, $text, $mode){
	global $style;
	if ($style == 'menu1'){
	echo "<div id='block_menu1'>
	<div id='menu1_body'>$text</div>
	</div>
	";
	} else if ($style == 'menu2'){
	echo "<div id='block_menu2'>
	<div id='menu2_body'>$text</div>
	</div>
	";
	} else if ($style == 'menu3'){
	echo "<div id='block_menu3'>
	<div id='menu3_caption'>$caption</div>
	<div id='menu3_body'>$text</div>
	</div>";
	} else if ($style == 'menu4'){
	echo "<div id='block_menu4'>
	<div id='menu4_caption'>$caption</div>
	<div id='menu4_body'>$text</div>
	</div>";
	} else if ($style == 'menu5'){
	echo "<div id='block_menu5'>
	<div id='menu5_caption'>$caption</div>
	<div id='menu5_body'>$text</div>
	<div id='menu5_bottom'></div>
	</div>";
	} else if ($style == 'menu6'){
	echo "<div id='block_menu6'>
	<div id='menu6_caption'>$caption</div>
	<div id='menu6_body'>$text</div>
	</div>";
	} else if ($style == 'menu_ban'){
	echo "<div id='block_menu7'>
	<div id='menu7_body'>$text</div>
	</div>";
	} else if($style == 'centsite'){
	echo "<div id='block_center'>
	<div id='center_caption'>$caption</div>
	<div id='center_body'>$text</div>
	</div>
	";
	} else if($style == 'centsite_custom'){
	echo "<div id='block_center_custom'>
	<div id='center_caption'>$caption</div>
	<div id='center_body'>$text</div>
	</div>
	";
	} else if($style == ""){
	echo "<div id='block_center'>
	<div id='center_caption'>$caption</div>
	<div id='center_body'>$text</div>
	</div>
	";
	}
}

$COMMENTSTYLE = "
<table style='width: 100%;' cellspacing='10'>
<tr>
<td style='width: 30%; text-align: right; vertical-align: top;'><span class='mediumtext'><b>{USERNAME}</b></span><br /><span class='smalltext'>{TIMEDATE}</span><br />{AVATAR}<span class='smalltext'>{REPLY}</span></td>
<td style='width: 70%;'>
{COMMENT} {COMMENTEDIT}
</td>
</tr>
</table>
";

$CHATBOXSTYLE = "
<img src='".THEME_ABS."images/bullet2.gif' alt='' style='vertical-align: middle;' />
<b>{USERNAME}</b>
<div class='smalltext'>
{MESSAGE}
</div>
<br />";

?>