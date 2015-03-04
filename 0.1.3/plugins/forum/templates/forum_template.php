<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/templates/forum_template.php $
|     $Revision: 11678 $
|     $Id: forum_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }
if(!defined("USER_WIDTH")){ define("USER_WIDTH","width:95%"); }

if (!isset($FORUM_MAIN_START))
{
	$FORUM_MAIN_START = "<div style='text-align:center'>\n<div class='spacer'>\n<table style='".USER_WIDTH."' class='r_border'>\n<tr>\n<td colspan='2' style='width:60%; text-align:center' class='r_caption'>{FORUMTITLE}</td>\n<td style='width:10%; text-align:center' class='r_caption'>{THREADTITLE}</td>\n<td style='width:10%; text-align:center' class='r_caption'>{REPLYTITLE}</td>\n<td style='width:20%; text-align:center' class='r_caption'>{LASTPOSTITLE}</td>\n</tr>";
}
if (!isset($FORUM_MAIN_PARENT))
{
	$FORUM_MAIN_PARENT = " <tr>\n<td colspan='5' class='r_header1'>{PARENTNAME} {PARENTSTATUS}</td>\n</tr>";
}
if (!isset($FORUM_MAIN_FORUM))
{
	$FORUM_MAIN_FORUM = "<tr>\n<td style='width:5%; text-align:center' class='r_header2'>{NEWFLAG}</td>\n<td style='width:55%' class='r_header2'>{FORUMNAME}<br /><span class='smallblacktext'>{FORUMDESCRIPTION}</span>{FORUMSUBFORUMS}</td>\n<td style='width:10%; text-align:center' class='r_header3'>{THREADS}</td>\n<td style='width:10%; text-align:center' class='r_header3'>{REPLIES}</td>\n<td style='width:20%; text-align:center' class='r_header3'><span class='smallblacktext'>{LASTPOST}</span></td>\n</tr>";
}
if (!isset($FORUM_MAIN_END))
{
	$FORUM_MAIN_END = "</table></div>\n<div class='spacer'>\n<table style='".USER_WIDTH."' class='r_border'>\n<tr>\n<td colspan='2' style='width:60%' class='r_caption'>{INFOTITLE}</td>\n</tr>\n<tr>\n<td rowspan='4' style='width:5%; text-align:center' class='r_header3'>{LOGO}</td>\n<td style='width:auto' class='r_header3'>{USERINFO}</td>\n</tr>\n<tr>\n<td style='width:95%' class='r_header3'>{INFO}</td>\n</tr><tr>\n<td style='width:95%' class='r_header3'>{FORUMINFO}</td>\n</tr>\n<tr>\n<td style='width:95%' class='r_header3'>{USERLIST}<br />{STATLINK}</td>\n</tr>\n</table>\n</div>\n<div class='spacer'>\n<table class='r_border' style='".USER_WIDTH."'>\n<tr>\n<td class='r_header3' style='text-align:center; width:33%'>{ICONKEY}</td>\n<td style='text-align:center; width:33%' class='r_header3'>{SEARCH}</td>\n<td style='width:33%; text-align:center; vertical-align:middle' class='r_header3'><span class='smallblacktext'>{PERMS}</span>\n</td>\n</tr>\n</table>\n</div>\n</div>";
}

if (!isset($FORUM_NEWPOSTS_START))
{
	$FORUM_NEWPOSTS_START = "<div style='text-align:center'>\n<div class='spacer'>\n<table style='".USER_WIDTH."' class='r_border'>\n<tr>\n<td style='width:3%' class='r_caption'>&nbsp;</td>\n<td style='width:60%' class='r_caption'>{NEWTHREADTITLE}</td>\n<td style='width:27%; text-align:center' class='r_caption'>{POSTEDTITLE}</td>\n</tr>";
}

if (!isset($FORUM_NEWPOSTS_MAIN))
{
	$FORUM_NEWPOSTS_MAIN = "<tr>\n<td style='width:3%' class='r_header3'>{NEWIMAGE}</td>\n<td style='width:60%' class='r_header3'>{NEWSPOSTNAME}</td>\n<td style='width:27%; text-align:center' class='r_header3'>{STARTERTITLE}</td>\n</tr>";
}

if (!isset($FORUM_NEWPOSTS_END))
{
	$FORUM_NEWPOSTS_END = "</table></div></div>";
}

if (!isset($FORUM_TRACK_START))
{
	$FORUM_TRACK_START = "<div style='text-align:center'>\n<div class='spacer'>\n<table style='".USER_WIDTH."' class='r_border'>\n<tr>\n<td colspan='3' style='width:60%' class='r_caption'>{TRACKTITLE}</td>\n</tr>\n";

	if (!isset($FORUM_TRACK_MAIN))
	{
		$FORUM_TRACK_MAIN = "<tr>
			<td style='text-align:center; vertical-align:middle; width:6%'  class='r_header3'>{NEWIMAGE}</td>
			<td style='vertical-align:middle; text-align:left; width:70%'  class='r_header3'><span class='mediumtext'>{TRACKPOSTNAME}</span></td>
			<td style='vertical-align:middle; text-align:center; width:24%'  class='r_header3'><span class='mediumtext'>{UNTRACK}</span></td>
			</tr>";
	}
}

if (!isset($FORUM_TRACK_END))
{
	$FORUM_TRACK_END = "</table>\n</div>\n</div>";
}

?>