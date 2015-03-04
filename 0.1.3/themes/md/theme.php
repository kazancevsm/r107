<?php
/*
+ ----------------------------------------------------------------------------+
|     r107 website system
|
|     ©Sunout 2014
|     http://r107.pro
|     sunout@osgroup.pro
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

// [multilanguage]
@include_once(e_THEME."r107/languages/".e_LANGUAGE.".php");
@include_once(e_THEME."r107/languages/English.php");

// [theme]
$themename = "md_new";
$themeversion = "1.0";
$themeauthor = "MagicDreamWebStudio";
$themeemail = "sunout@osgroup.pro";
$themewebsite = "http://md.osgroup.pro";
$themedate = "2014";
$themeinfo = "Main Theme MDStudio site";
define("STANDARDS_MODE", TRUE);
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;
define("IMODE", "lite");
define("SITE_DESC", "the group developer integrated advanced of a web systems ");
define("SITE_ADMIN_NUMBER", "8 (902) 87 09 176");

define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");
$register_sc[]='NAVI';

// [layout]       <div class='header_banner'>{BANNER}</div>
$layout = "_default";

/*

*/
$HEADER = "
<link rel='stylesheet' href='".THEME."css/navi.css' type='text/css' />
<div class='bg_top'>
	<div class='site_desc_bg'></div>
	<div class='header_bg'></div>
</div>
<div class='wrapper'>
	<div class='site_desc'>
		".SITE_DESC."
	</div>
	<div class='wrapper_header'>
		<div class='header_logo'>
			<a href='".SITEURL."' alt='".SITENAME."'>
				{LOGO}
			</a>
		</div>
		<div class='header_admin_number'>
			<div class='admin_number'>
				".SITE_ADMIN_NUMBER."
			</div>
		</div>
	</div>
	<div class='header_sitelinks'>
		{SITELINKS}
	</div>
	<div class='wrapper_middle'>
		
		
		<div class='middle_content'>
			{SETSTYLE=content}
";

$FOOTER = "
		</div>
		<div class='middle_menu'>
			{LINKSTYLE=alt2}
			{SITELINKS=flat:2}
			{SETSTYLE=leftmenu}
			{MENU=1}
		</div>
	</div>
</div>
	<div class='wrapper_footer'>
		<div class='footer'>
			<div class='footer_menu'>
				{SETSTYLE=footer_menu}
				{MENU=8}<img class='footer_logo_img' src='".e_THEME."md/images/e_logo.png' />
			</div>
			<div class='footer_menu'>
				{SETSTYLE=footer_menu}
				{MENU=9}
			</div>
			<div class='footer_menu'>
				{SETSTYLE=footer_menu}
				{MENU=10}
			</div>
		</div>
	</div>
 ";
 /*

 */
$CUSTOMHEADER = "
<link rel='stylesheet' href='".THEME."css/navi.css' type='text/css' />
<div class='bg_top'>
	<div class='site_desc_bg'></div>
	<div class='header_bg'></div>
</div>
<div class='wrapper'>
	<div class='site_desc'>
		".SITE_DESC."
	</div>
	<div class='wrapper_header'>
		<div class='header_logo'>
			<a href='".SITEURL."' alt='".SITENAME."'>
				{LOGO}
			</a>
		</div>
		<div class='header_admin_number'>
			<div class='admin_number'>
				".SITE_ADMIN_NUMBER."
			</div>
		</div>
	</div>
	<div class='header_sitelinks'>
		{SITELINKS}
	</div>
	<div class='wrapper_middle'>
		<div class='middle_content_rotator'>
			{SETSTYLE=menu2}
			{MENU=2}
		</div>
		<div class='middle_menus'>
			<div class='middle_menu_top'>
				{SETSTYLE=menu3}
				{MENU=3}
			</div>
			<div class='middle_menu_top'>
				{SETSTYLE=menu4}
				{MENU=4}
			</div>
			<div class='middle_menu_top'>
				{SETSTYLE=menu5}
				{MENU=5}
			</div>
			<div class='middle_menu_top'>
				{SETSTYLE=menu6}
				{MENU=6}
			</div>
		</div>
		<div class='middle_content_custom'>
		{SETSTYLE=content_custom}
";
$CUSTOMFOOTER = "
		</div>
		<div class='middle_menu_bottom'>
				{SETSTYLE=menu7}
				{MENU=7}
			</div>
	</div>
</div>
	<div class='wrapper_footer'>
		<div class='footer'>
			<div class='footer_menu'>
				{SETSTYLE=footer_menu}
				{MENU=8}<img class='footer_logo_img' src='".e_THEME."md/images/e_logo.png' />
			</div>
			<div class='footer_menu'>
				{SETSTYLE=footer_menu}
				{MENU=9}
			</div>
			<div class='footer_menu'>
				{SETSTYLE=footer_menu}
				{MENU=10}
			</div>
		</div>
	
	</div>
 ";
$CUSTOMPAGES = "plugins/catalog/catalog.php?page=frontpage";
 
define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", LAN_THEME_3);
define("COMMENTOFFSTRING", LAN_THEME_2);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " :: ");


// [linkstyle]
function linkstyle($linkstyle) {
        switch($linkstyle) {
		case "alt2":
			$style['prelink'] = "<div class='sitelinks_alt2'>";
			$style['postlink'] = "</div>";
			$style['linkstart'] = "<div class='sitelinks_alt2_box'><div class='sitelinks_alt2_item'>";
			$style['linkend'] = "</div></div>";
			$style['linkdisplay'] = "1";
			$style['linkalign'] = "";
			$style['linkclass'] = "";
			$style['linkstart_hilite'] = "";
			$style['linkseparator'] = "";
		break;
		default:
			$style['prelink'] = "<center><div class='sitelinks_default'>";
			$style['postlink'] = "</div></center>";
			$style['linkstart'] = "<div class='sitelinks_default_item'>";
			$style['linkend'] = "</div>";
			$style['linkdisplay'] = "1";
			$style['linkalign'] = "";
			$style['linkclass'] = "";
			$style['linkstart_hilite'] = "";
			$style['linkseparator'] = "";
                      //  $style['linkmainonly'] = true;
		break;
        }
        return $style;
}

// [tablestyle]
function tablestyle($caption, $text, $mode=''){
	global $style;
	switch($style) {
		case 'leftmenu':
			echo "<div class='leftmenu'>";
			if($caption !== '') {
				echo "<div class='leftmenu_caption'>$caption</div>";
			}
			echo "<div class='leftmenu_body'>$text</div></div>";
		break;
		case 'menu2':
			echo "<div class='content_rotator'>$text</div>";
		break;
		case 'menu3':
			echo "<div class='menu3'>";
			echo "<div class='menu3_body'>$text</div></div><br><br>";
		break;
		case 'menu5':
			echo "$text";
		break;
		case 'custom_menu':
			echo "<div class='cmenu'><div class='cmenu_body'>$text</div></div>";
		break;
		case 'menu_content':
			echo "<div class='menu_content'><div class='menu_content_body'>$text</div></div>";
		break;
		case 'content':
			echo "<div class='content'>";
			if($caption !== '') {
				echo "<div class='content_caption'>$caption</div>";
			}
			echo "<div class='content_body'>$text</div></div>";
		break;
		case 'content_custom':
			echo "<div class='content_custom'>";
			if($caption !== '') {
				echo "<div class='content_custom_caption'>$caption</div>";
			}
			echo "<div class='content_custom_body'>$text</div></div>";
		break;
		case 'footer_menu':
			echo "<div class='footer_menu'>";
			if($caption !== '') {
				echo "<div class='footer_menu_caption'>$caption</div>";
			}
			echo "<div class='footer_menu_body'>$text</div></div>";
		break;
		default:
			echo "<div class='content'>";
			echo "<div class='content_caption'>$caption</div>";
			echo "<div class='content_body'>$text</div></div><br><br>";
		break;
	}
}

// [newsstyle]
$NEWSSTYLE = "
	<div class='news'>
		<div class='hmain'><div class='hleft'><div class='hright'><h3>{NEWSTITLE}</h3></div></div></div>
			<div class='menutable'>
	<div class='menutable2'>
	<div class='bodytable'>
	<div class='story'>
	<div class='newsleft'>
	<div class='newsimage'>
	{NEWSIMAGE}
	</div>
	<div class='newsdate'>
	{EMAILICON}
    {PRINTICON}
    {ADMINOPTIONS}
	<br />
	{NEWSDATE}
	<br />
	<br />
	Posted by 
      {NEWSAUTHOR}
      &nbsp;::&nbsp;
      {NEWSCOMMENTS}
	</div>
	</div>
	<div class='newstext'>
    {NEWSBODY}
    {EXTENDED}
	 <br />
	</div>
	<div class='clear'>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class='bottomt'>
	<div class='hbleft'>
	<div class='hbright'>
	  </div>
	  </div>
	  </div>
	  </div>
    
    ";
// [commentstyle]
$COMMENTSTYLE = "
<div class='r_header'>
	{USERNAME} @ <span class='smalltext'>{TIMEDATE}</span>
</div><br />
<table>
	<tr>
		<td style='width:20%; text-align:center'>
			<div class='r_header2'>{AVATAR}</div>
			<div class='r_header2'><span class='smalltext'>{IPADDRESS}<br />{REPLY}</span></div>
		</td>
		<td style='width:80%; text-align:left'>
			<div class='r_header2'>{COMMENT}</div>
		</td>
	</tr>
</table>
"; 

// [chatboxstyle]
$CHATBOXSTYLE = "
<div class='spacer'>
	<div class='indentchat'>
		<b>{USERNAME}</b>
		<div style='text-align:center; padding:0px;'>
			<span class='small' >
				{TIMEDATE}
			</span>
		</div>
		<span class='smalltext'><br />
			{MESSAGE}
		</span><br><br />
	</div>
</div>";
?>