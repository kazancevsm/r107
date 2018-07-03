<?php
if(!defined("e107_INIT")){ exit; }
// [multilanguage]
include_lan(e_THEME."standart/languages/".e_LANGUAGE.".php");
@include_lan(e_THEME."standart/languages/English.php");
// [theme information]
$themename = "Standart";
$themeversion = " 0.2";
$themeauthor = "OSGroup";
$themeemail = "sunout1303@yandex.ru";
$themewebsite = "http://r107.slog.su";
$themedate = "09/2014";
$themeinfo = "";
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;
define("IMODE", "lite");
define("STANDARDS_MODE", TRUE);
define("NEXTPREV_NOSTYLE", TRUE);
define("FS_LINK_SEPARATOR","<div class='fs-linkSep'><!-- --></div>");
define("FS_START_SEPARATOR", FALSE);
define("FS_END_SEPARATOR", FALSE);
define("ADLINK_COLS",5);
define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");
define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", LAN_THEME_2);
define("COMMENTOFFSTRING", LAN_THEME_3);
define("PRE_EXTENDEDSTRING", "<div class='readmore'>");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", "</div>");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " :: ");
define("ICONMAIL", "mail.png");
define("ICONPRINT", "print.png");
define("ICONPRINTPDF", "pdf.png");
define('NEWSCAT_AMOUNT',10);
define("BULLET", "bullet.png");

function theme_head() {
	return "
		<!--[if lte IE 7]>
		<script type='text/javascript' src='".THEME_ABS."js/menu.js'></script>
		<![endif]-->
	";
}

// [layout]
$layout = "_default";
$HEADER = "
<div class='wrapper'>
	<div class='wrapper_header'>
		<div class='top_header'>
			<div class='header_logo'>
				<a href='".e_HTTP."index.php' title='{SITENAME}'>{LOGO}</a>
			</div>
			<div class='header_banner'>
				{BANNER}
			</div>
		</div>
		<div class='bottom_header'>
			<div class='header_login'>
				{LOGIN}
			</div>
			<div class='header_search'>
				{SEARCH}
			</div>
		</div>
	</div>
	<div class='wrapper_sitelinks_dropdown'>
		{SITELINKS_DROPDOWN}
	</div>
	<div class='wrapper_maincontent'>
		<div class='topcontentall clearfix'>
			  <div class='maincontent_right'>
				 {SETSTYLE=flatlinks}
				 {LINKSTYLE=flatlinks}
				 {SITELINKS=flat:2}
				 {SETSTYLE=bottmomenus}
				 {MENU=1}
				 {MENU=2}
				 {MENU=3}
			 </div>
			 <div class='maincontent_left'> 
";
$FOOTER = "
			</div>
		</div>
	</div>
	<div class='wrapper_clear'></div>
	<div class='wrapper_footerline'></div>
	<div class='wrapper_footer'>
		<div class='footer_menul'>
			<a href='http://validator.w3.org/check?uri=referer' title=''><img src='".THEME_ABS."images/bottom_xhtml.png' alt='' style='margin-top: 10px;' /></a>
		</div>
		<div class='footer_menum smalltext'>
			{SITEDISCLAIMER}
		</div>
		<div class='footer_menur'>
			<a href='http://r107.slog.su' title='r107'><img src='".THEME_ABS."images/e_logo_small.png' alt='' /></a>
			<br />{SITENAME}
		</div>
	</div>
	<div class='wrapper_footerlinks'>
	  {LINKSTYLE=bottom}
	  {SITELINKS=flat:3}
	</div>
</div>
";

$CUSTOMHEADER["HOME"] = "
<div class='wrapper'>
	<div class='wrapper_header'>
		<div class='top_header'>
			<div class='header_logo'>
				<a href='".e_HTTP."index.php' title='{SITENAME}'>{LOGO}</a>
			</div>
			<div class='header_banner'>
				{BANNER}
			</div>
		</div>
		<div class='bottom_header'>
			<div class='header_login'>
				{LOGIN}
			</div>
			<div class='header_search'>
				{SEARCH}
			</div>
		</div>
	</div>
	</div>
	<div class='wrapper_sitelinks_dropdown'>
		{SITELINKS_DROPDOWN}
	</div>
	<div class='wrapper_maincontent'>
		<div class='topcontent clearfix'>
			{SETSTYLE=wm}
			{WMESSAGE}

";
$CUSTOMFOOTER["HOME"] = "
		</div>
	</div>
	<div class='wrapper_clear'></div>
	<div class='bottmomenus'>
		<div class='bmenul'>
		  {SETSTYLE=bottmomenus}
			{MENU=2}
		</div>
		<div class='bmenur'>
			{MENU=3}
		</div>
		<div class='bmenum'>
			{MENU=4}
		</div>
	</div>
	<div class='wrapper_clear'></div>
	<div class='footerbor'></div>
	<div class='footer'>
		<div class='fmenul'>
			<div>
				<a href='http://validator.w3.org/check?uri=referer' title=''><img src='".THEME_ABS."images/bottom_xhtml.png' alt='' style='margin-top: 10px;' /></a>
			</div>
		</div>
		<div class='fmenur smalltext'>
			{SITEDISCLAIMER}
		</div>
		<div class='fmenum'>
			<a href='http://r107.slog.su' title='e107'><img src='".THEME_ABS."images/e_logo_small.png' alt='' /></a>
			<br />{SITENAME}
		</div>
	</div>
	<div class='footerlinks'>
	  {LINKSTYLE=bottom}
	  {SITELINKS=flat:3}
	</div>
</div>
";

$CUSTOMPAGES["HOME"] = SITEURL."index.php";

$CUSTOMHEADER["FULL"] = "
<div class='wrapper_full'>
	<div class='headerbg'>
		<div class='top_header'>
			<div class='header_logo'>
				<a href='".e_HTTP."index.php' title='{SITENAME}'>{LOGO}</a>
			</div>
			<div class='header_banner'>
				{BANNER}
			</div>
		</div>
		<div class='bottom_header'>
			<div class='header_login'>
				{LOGIN}
			</div>
			<div class='header_search'>
				{SEARCH}
			</div>
		</div>
	</div>
	<div class='navigation'>
		{SITELINKS_DROPDOWN}
	</div>
	<div class='wrapper_maincontent'>
		<div class='fullside'>
		  {SETSTYLE=full}
";
$CUSTOMFOOTER["FULL"] = "
		</div>
	</div>
	<div class='wrapper_clear'></div>
	<div class='footerborfull'></div>
	<div class='footer'>
		<div class='fmenul'>
			<div>
				<a href='http://validator.w3.org/check?uri=referer' title=''><img src='".THEME_ABS."images/bottom_xhtml.png' alt='' style='margin-top: 10px;' /></a>
			</div>
		</div>
		<div class='fmenur smalltext'>
			{SITEDISCLAIMER}
		</div>
		<div class='fmenum'>
			<a href='http://r107.slog.su' title='e107'><img src='".THEME_ABS."images/e_logo_small.png' alt='' /></a>
			<br />{SITENAME}
		</div>
	</div>
	<div class='footerlinks'>
	  {LINKSTYLE=bottom}
	  {SITELINKS=flat:3}
	</div>
</div>
";
$CUSTOMPAGES["FULL"] = "forum/ ";

//	[tablestyle]
function tablestyle($caption, $text, $mode=""){
	global $style;
	
	if($mode == "admin_update")
	{
		echo "
		<span class='admin_update'>
			".$caption."
		</span>
		<span class='hover' style='display:none'>
			".$text."
		</span>
		";
		return;	
	}
		
switch ($style) {

	case "wm":
	echo "
		<div class='topcontent_entry clearfix'>
			".$text."
		</div>
				";
	break;
	case "flatlinks":
	echo "
	<div class='styledmenu'>
    <div class='13'>
      ".$text."
    </div>
  </div>
        ";
	break;
	case "full":
	echo "
	<div class='fullcontent clearfix'>
		<div class='fullcontent_title'>
			".$caption."
		</div>
		<div class='fullcontent_entry'>
			".$text."
		</div>
	</div>
        ";
	break;
	case "maincontent_right":
	echo "
	<div class='rightbox'>
		<div class='rightbox_title'>
			".$caption."
		</div>
		<div class='rightbox_text'>
			".$text."
		</div>
	</div>
        ";
	break;
	case "maincontent_left":
	echo "
	<div class='leftbox'>
		<div class='leftbox_title_bg'>
			<div class='leftbox_title'>
				".$caption."
			</div>
		</div>
		<div class='leftbox_text'>
			".$text."
		</div>
	</div>
        ";
	break;
	case "bottmomenus":
	echo "
	<div class='bottmomenusbox'>
		<div class='bottmomenus_title'>
			".$caption."
		</div>
		<div class='bottmomenus_text'>
			".$text."
		</div>
	</div>
        ";
	break;
	default:
	echo "
	<div class='bottmomenusbox'>
		<div class='title_clean'>
			".$caption."
		</div>
		<div class='bottmomenus_text'>
			".$text."
		</div>
	</div>
    ";
	break;
 }
}

$sc_style['NEWSIMAGE']['pre'] = "<div class='news_image'>";
$sc_style['NEWSIMAGE']['post'] = "</div>";
$sc_style['NEWSCOMMENTS']['pre'] = "<div class='news_comments'>";
$sc_style['NEWSCOMMENTS']['post'] = "</div>";
//[newsstlyle]
$NEWSSTYLE = "
<div class='news_box'>
	<div class='leftbox'>
		<div class='leftbox_title_bg'>
			<div class='leftbox_title'>
				{NEWSTITLE}
			</div>
		</div>
		<div class='meta'>
			<div class='author mediumtext'>
				{NEWSDATE=short}&nbsp;&nbsp;".LAN_THEME_9."&nbsp;{NEWSAUTHOR}
			</div>
		</div>
	  <div class='news_body'>
			{NEWSIMAGE}
			{NEWSBODY} {EXTENDED}
		</div>
		<div class='clear'></div>
		<div class='metabottom v-middle'>
			<div class='metaicons'>
    		{EMAILICON} {PRINTICON} {ADMINOPTIONS}
			</div>
   		{NEWSCOMMENTS}
	  </div>
	</div>
</div>
	";
$NEWSLISTSTYLE = "
<div class='news_box'>
	<div class='leftbox'>
		<div class='leftbox_title_bg'>
			<div class='leftbox_title'>
				{NEWSTITLE}
			</div>
		</div>
		<div class='meta'>
			<div class='author mediumtext'>
				{NEWSDATE=short}&nbsp;&nbsp;".LAN_THEME_9."&nbsp;{NEWSAUTHOR}
			</div>
		</div>
	  <div class='news_body'>
			{NEWSIMAGE}
			{NEWSBODY} {EXTENDED}
		</div>
		<div class='clear'></div>
		<div class='metabottom v-middle'>
			<div class='metaicons'>
    		{EMAILICON} {PRINTICON} {ADMINOPTIONS}
			</div>
			{NEWSCOMMENTS}
	  </div>
	</div>
</div>
";
$NEWSARCHIVE ="
		<div>
			<table style='width:98%;'>
				<tr>
					<td>
						<div class='mediumtext'>{ARCHIVE_BULLET}&nbsp;{ARCHIVE_LINK}&nbsp;".LAN_THEME_9."&nbsp;{ARCHIVE_AUTHOR}&nbsp;-&nbsp;{ARCHIVE_DATESTAMP}&nbsp;".LAN_THEME_8."&nbsp;{ARCHIVE_CATEGORY}</div>
					</td>
				</tr>
			</table>
		</div>
";
//Render news categories on the bottom of the page
$NEWSCAT = "
		<table cellpadding='0' cellspacing='0' style='width: 95%'>
			<tr>
				<td>
					<div class='news_title_cat'>
						{NEWSCATEGORY}
					</div>
				</td>
			</tr>
			<tr>
				<td colspan='2' style='padding-top: 10px;'>
					<table style='width: 100%' cellpadding='0' cellspacing='0'>
						<tr>
							<td class='catlink left v-middle' style='padding-bottom: 5px; padding-left: 10px;'>
								{NEWSCAT_ITEM}
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
";
//Loop for news items in category
$NEWSCAT_ITEM = "
	<div class='news_item_cat'>
		<img src='".THEME_ABS."images/bullet.png' alt='' />&nbsp;&nbsp;{NEWSTITLELINK}
	</div>
";
// linkstyle
// http://wiki.e107.org/?title=Styling_Individual_Sitelink_Menus
function linkstyle($np_linkstyle) {
// Common to all styles (for this theme)
// Common sublink settings
// NOTE: *any* settings can be customized for sublinks by using
//       "sub" as a prefix for the setting name. Plus, there"s "subindent"
//  $linkstyleset["sublinkclass"] = "mysublink2;
//  $linkstyleset["subindent"]    = " ";
// Now for some per-style setup
switch ($np_linkstyle)
{
	case "toplinks":
		$linkstyleset["linkdisplay"] = 1;
		$linkstyleset["prelink"] = '<ul id="menu">';
		$linkstyleset["postlink"] = '</ul>';
		$linkstyleset["linkstart"] = '<li>';
		$linkstyleset["linkend"] = '</li>';
		$linkstyleset["linkstart_hilite"] = '<li>';
		$linkstyleset["linkclass_hilite"] = '';
		$linkstyleset["linkseparator"] = '';
	break;
	case "bottom":
		$linkstyleset["linkdisplay"] = 1;
		$linkstyleset["prelink"] = '';
		$linkstyleset["postlink"] = '';
		$linkstyleset["linkstart"] = '';
		$linkstyleset["linkend"] = '';
		$linkstyleset["linkstart_hilite"] = '';
		$linkstyleset["linkclass_hilite"] = '';
		$linkstyleset["linkseparator"] = '&nbsp;&nbsp;';
	break;
	case "flatlinks":
		$linkstyleset["linkdisplay"] = 2;
		$linkstyleset["prelink"] = '';
		$linkstyleset["postlink"] = '';
		$linkstyleset["linkstart"] = '<div style="padding-left:0px">';
		$linkstyleset["linkend"] = '</div>';
		$linkstyleset["linkstart_hilite"] = "";
		$linkstyleset["linkclass_hilite"] = "curren";
		$linkstyleset["linkalign"] = "left";
	break;
	default: // if no LINKSTYLE defined
		$linkstyleset["linkdisplay"] = 1;
		define("PRELINK", "");
		define("POSTLINK", "");
		define("LINKSTART", "<span> ");
		define("LINKSTART_HILITE", "<span> ");
		define("LINKEND", "</span><div style='padding-top: 1px;'></div>");
		define("LINKALIGN", "left");
}
return $linkstyleset;
}
// Chatbox post style
$CHATBOXSTYLE = '<br /><b>{USERNAME}</b>&nbsp;{TIMEDATE}<br />{MESSAGE}<br />';
// Comment post style
$sc_style['REPLY']['pre'] = "<tr><td class='smallblacktext' style='padding: 10px 20px;'>";
$sc_style['REPLY']['post'] = "</td></tr>";
$sc_style['COMMENTEDIT']['pre'] = "<tr><td class='forumheader' colspan='2' style='text-align: right'>";
$sc_style['COMMENTEDIT']['post'] = "</td></tr>";
$sc_style['JOINED']['post'] = "<br />";
$sc_style['LOCATION']['post'] = "<br />";
$sc_style['RATING']['post'] = "<br /><br />";
$sc_style['COMMENT']['post'] = '<br />';
$COMMENTSTYLE = "
<div class='spacer' style='text-align:left; width: 100%; padding: 3px 0; margin: 5px 10px;'>
<table class='fborder' style='width: 98%; border-bottom: 1px solid #EEEEEE; background: transparent;'>
  <tr>
    <td class=' r_header mediumtext' style='padding: 10px 10px;' colspan='2'>
    	".LAN_THEME_9." {USERNAME} ".LAN_THEME_8." {TIMEDATE}
    </td>
  </tr>
  {REPLY}
  <tr>
    <td class='forumheader3' style='width: 25%; vertical-align: top; border: 0 none'>
	    <div style='text-align: center;'>
	    	{AVATAR}
	    </div>
    	<span class='smalltext'>
				{JOINED}{COMMENTS}{LOCATION}{IPADDRESS}
			</span>
    </td>
    <td class='forumheader3' style='width: 70%; vertical-align: top; border: 0 none;'>
    	{COMMENT}
    </td>
  </tr>
{COMMENTEDIT}
</table>
</div>
";
// Chatbox post style
$CHATBOXSTYLE = '<br /><b>{USERNAME}</b>&nbsp;{TIMEDATE}<br />{MESSAGE}<br />';
$SEARCH_SHORTCODE = "
      <div>
          <input class='search-form' type='text' name='q' size='25' maxlength='50' value='".LAN_SEARCH."' onfocus='if (this.value == \"".LAN_SEARCH."\") this.value = \"\";' onblur='if (this.value == \"\") this.value = \"".LAN_SEARCH."\";'  />
          <input type='submit' value='' class='search-submit' />
      </div>
";
?>