<?php


if (!defined('e107_INIT')) { exit; }

// [multilanguage]
include_lan(e_THEME."single_page_gallery_theme/languages/".e_LANGUAGE.".php");

// [theme]
$themename = "Single Page (Gallery)";
$themeversion = "1.0";
$themeauthor = "Sunout";
$themeemail = "sunout@mail.ru";
$themewebsite = "http://r107.smt-sl.ru";
$themedate = "september 2017";
$themeinfo = "Based on, and with permission from Arach's site, http://e107.vekna.com";
define("STANDARDS_MODE", TRUE);
define("IMODE", "lite");
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;

define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");
function theme_head()
{
  return "<script type='text/javascript' src='".THEME_ABS."scroll.js'></script>\n";
}
/*
function theme_head()
{
  return "<link rel='stylesheet' href='".THEME_ABS."nav_menu.css' type='text/css' />\n";
}
*/
// [layout]

$layout = "_default";

/*
to use an icon image next to links, add the following line ...
{SITELINKS_ALT=".e_IMAGE."blah.png}
instead of
{SITELINKS_ALT=no_icons}
then make change to nav_menu.css (documented in that file)

<div class='wrapper_sitelinks'>{SITELINKS}</div>
*/

$HEADER = "
<div class='wrapper_sitelinks'>
	<div class='sitelinks_box'>
		<span class='sitelinks_item'>
			<a href='#main'>Главная</a>
		</span>
		<span class='sitelinks_item'>
			<a href='#gallery'>Галерея</a>
		</span>
		<span class='sitelinks_item'>
			<a href='#service'>Наши услуги</a>
		</span>
		<span class='sitelinks_item'>
			<a href='#about'>О нас</a>
		</span>
		<span class='sitelinks_item'>
			<a href='#contact'>Контакты</a>
		</span>
	</div>
</div>
<table class='wrapper'>
	<tr>
	<td class='wrapper_box_spacer'></td>
	<tr>
	<td class='wrapper_box_header'>
		<a id='main'></a>
		<div class='wrapper_box_spacer'></div>
		<div class='box_header'> 
			<div class='header_logo'>
				<img src='".THEME_ABS."images/logo.png'>
				<h3 style='color:#fff;text-shadow: #000 0 0 2px;'>Студия ручной ковки</h3>
				<h1 style='color:#ff6600;text-shadow: #000 0 0 2px;'>Уральские традиции</h1>
			</div>
		</div>
	</td>
	<tr>
	<td class='wrapper_box_middle'>
		<a id='gallery'></a>
		<div class='wrapper_box_spacer'></div>
		{SETSTYLE=main}
";

$FOOTER = "
	</td>
	<tr>
	<td class='wrapper_box_service'>
		<a id='service'></a>
		<div class='wrapper_box_spacer'></div>
		<div class='box_service'>
			{SETSTYLE=menu2}
			{MENU=2}
		</div>
	</td>
	<tr>
	<td class='wrapper_box_about'>
		<a id='about'></a>
		<div class='wrapper_box_spacer'></div>
		<div class='box_about'>
			{SETSTYLE=menu1}
			{MENU=1}
		</div>
	</td>
	<tr>
	<td class='wrapper_box_contact'>
	<a id='contact'></a>
	<div class='wrapper_box_spacer'></div>
		<div class='box_contact'>
			{SETSTYLE=menu3}
			{MENU=3}
		</div>
	</td>
	
	<tr>
	<td class='wrapper_footer'>
		{SITEDISCLAIMER}<br />
		{THEME_DISCLAIMER}
	</td>
</table>
";

$CUSTOMHEADER = "

";

$CUSTOMFOOTER = "

";

$CUSTOMPAGES = "";

$NEWSSTYLE = "
<div class='spacer'>
<div class='borderx'><div class='line2'>{NEWSTITLE}</div>
<div class='incontent'>{NEWSBODY}{EXTENDED}</div>
<div class='infobar'>{NEWSAUTHOR} on {NEWSDATE} | {NEWSCOMMENTS}{TRACKBACK}</div>
</div>
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
define('LINKDISPLAY', 1);
define('PRELINK', "<div class='sitelinks_box'>");
define('POSTLINK', "</div>");
define('LINKSTART', "<span class='sitelinks_item'>");
define("LINKSTART_HILITE", "");
define('LINKEND', "</span>");
define('LINKALIGN', "left");


//	[tablestyle]

function tablestyle($caption, $text, $mode)
{
	global $style;
	if ($style == "menu1")
	{
		echo "
		<div class='about_caption'>
			<h1 style='color:#eee'>{$caption}</h1>
		</div>
		<div class='about_body'>
			{$text}
		</div>
		<div class='menubottom'>
		</div>";
	}
	elseif ($style == "menu2")
	{
		echo "
		<div class='service_caption'>
				<h1 style='color:#333'>{$caption}</h1>
		</div>
		<div class='service_body'>
			{$text}
		</div>
		<div class='menubottom'>
		</div>";
	}
	elseif ($style == "menu3")
	{
		echo "
		<div class='contact_caption'>
				<h1 style='color:#333'>{$caption}</h1>
		</div>
		<div class='contact_body'>
			{$text}
		</div>
		<div class='menubottom'>
		</div>";
	}
	else
	{
		if($caption)
		{
			echo "	<div class='box_middle'>
					<div class='middle_caption'>
						{$caption}
					</div>
					<div class='middle_text'>
						{$text}
					</div>
				</div>";
		}
		else
		{
//			echo "<div class='spacer'>\n<div class='borderx'>\n<div class='incontent'>{$text}</div>\n</div>\n</div>\n";
			echo "	<div class='box_middle'>
					<div class='middle_caption'>
						{$caption}
					</div>
					<div class='middle_text'>
						{$text}
					</div>
				</div>";
		}
	}
};

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