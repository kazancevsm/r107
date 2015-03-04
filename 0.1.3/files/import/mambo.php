<?
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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_files/import/mambo.php $
|     $Revision: 11678 $
|     $Id: mambo.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
require_once("../../class.php");
require_once(e_ADMIN."auth.php");

if(!isset($_POST['do_conversion']))
{

	$text = "
	<table style='width: 100%;' class='r_border'>
	<tr>
	<td class='r_header3' style='text-align: center; margin-left: auto; margin-right: auto;'>
	This script will import your Mambo database to e107. It will copy over users only.<br /><br /></b>

	<br /><br />\n


	<form method='post' action='".e_SELF."'>
	Please enter the details for your Mambo database ...<br /><br />

	<table style='width: 50%;' class='r_border'>
	<tr>
	<td style='width: 50%; text-align: right;'>Host&nbsp;&nbsp;</td>
	<td style='width: 50%; text-align: left;'><input class='tbox' type='text' name='mamboHost' size='30' value='localhost' maxlength='100' />
	</tr>
	<tr>
	<td style='width: 50%; text-align: right;'>Username&nbsp;&nbsp;</td>
	<td style='width: 50%; text-align: left;'><input class='tbox' type='text' name='mamboUsername' size='30' value='' maxlength='100' />
	</tr>
	<tr>
	<td style='width: 50%; text-align: right;'>Password&nbsp;&nbsp;</td>
	<td style='width: 50%; text-align: left;'><input class='tbox' type='text' name='mamboPassword' size='30' value='' maxlength='100' />
	</tr>
	<tr>
	<td style='width: 50%; text-align: right;'>Database&nbsp;&nbsp;</td>
	<td style='width: 50%; text-align: left;'><input class='tbox' type='text' name='mamboDatabase' size='30' value='mambo' maxlength='100' />
	</tr>
	<tr>
	<td style='width: 50%; text-align: right;'>Table Prefix&nbsp;&nbsp;</td>
	<td style='width: 50%; text-align: left;'><input class='tbox' type='text' name='mamboPrefix' size='30' value='mos_' maxlength='100' />
	</tr>
	</table>
	<br /><br />
	<input class='button' type='submit' name='do_conversion' value='Continue' />
	</td>
	</tr>
	</table>";

	$ns -> tablerender("mambo to e107 Conversion Script", $text);
	require_once(e_ADMIN."footer.php");
	exit;
}

if(!isset($_POST['mamboHost']) || !isset($_POST['mamboUsername']) || !isset($_POST['mamboPassword']) || !isset($_POST['mamboDatabase'])){
	echo "Field(s) left blank, please go back and re-enter values.";
	require_once(e_ADMIN."footer.php");
	exit;
}

extract($_POST);

$text .= "<table style='width: 100%;' class='r_border'>
<tr>
<td class='r_header3' style='text-align: center; margin-left: auto; margin-right: auto;'>
Attempting to connect to Mambo database [ {$mamboDatabase} @ {$mamboHost} ] ...<br />\n";
flush();

$phpbbConnection = mysql_connect($mamboHost, $mamboUsername, $mamboPassword, TRUE);
if(!mysql_select_db($mamboDatabase, $phpbbConnection)){
	goError("Error! Cound not connect to Mambo database. Please go back to the previous page and check your settings");
}

$e107Connection = mysql_connect($mySQLserver, $mySQLuser, $mySQLpassword, TRUE);
if(!mysql_select_db($mySQLdefaultdb, $e107Connection)){
	goError("Error! Cound not connect to e107 database.");
}

echo "Successfully connected to Mambo and e107 databases ...<br /><br />";


$phpbb_res = mysql_query("SELECT * FROM {$mamboPrefix}users", $phpbbConnection);
if(!$phpbb_res){
	goError("Error! Unable to access ".$mamboPrefix."users table.");
}



$text = "<div><table class='r_border'>";
$text .= "<tr>";
$text .= "<td class='r_caption'>name</td>";
$text .= "<td class='r_caption'>username</td>";
$text .= "<td class='r_caption'>email</td>";
$text .= "<td class='r_caption'>password</td>";
$text .= "<td class='r_caption'>usertype</td>";
$text .= "<td class='r_caption'>block</td>";
$text .= "<td class='r_caption'>sendEmail</td>";
$text .= "<td class='r_caption'>gid</td>";
$text .= "<td class='r_caption'>regDate</td>";
$text .= "<td class='r_caption'>lvDate</td>";
$text .= "</tr>";

$result = mysql_query("SELECT name,username,email,block,sendEmail,gid,password,usertype,UNIX_TIMESTAMP(registerDate) AS regDate,UNIX_TIMESTAMP(lastvisitDate) AS lvDate FROM {$mamboPrefix}users", $phpbbConnection);
while ($mos = mysql_fetch_array($result, MYSQL_ASSOC)) {
$text .= "<tr>";
$text .= "<td class='r_header3'>".$mos['name']."</td>";
$text .= "<td class='r_header3'>".$mos['username']."</td>";
$text .= "<td class='r_header3'>".$mos['email']."</td>";
$text .= "<td class='r_header3'>".$mos['password']."</td>";
$text .= "<td class='r_header3'>".$mos['usertype']."</td>";
$text .= "<td class='r_header3'>".$mos['block']."</td>";
$text .= "<td class='r_header3'>".$mos['sendEmail']."</td>";
$text .= "<td class='r_header3'>".$mos['gid']."</td>";
$text .= "<td class='r_header3'>".$mos['regDate']."</td>";
$text .= "<td class='r_header3'>".$mos['lvDate']."</td>";
$text .= "</tr>";

$block = ($mos['block']) ? 2 : 0;
$admin = ($mos['usertype'] == "superadministrator") ? 1 : 0;
$class = '';			// Potential class allocation - can edit to list class numbers here
$query = "INSERT INTO ".$mySQLprefix."user VALUES (";
$query .= "0, '".$mos['name']."', '".$mos['username']."', '', '".$mos['password']."', '', '".$mos['email']."', '', '', '', '1', '".$mos['regDate']."', '".$mos['lvDate']."', 0, 0, 0, 0, 0, '', '{$block}', '', '', '', 0, '{$admin}', '".$mos['name']."', '{$class}', '', '', 0, '' ";
$query .= ")";
$message = mysql_query($query, $e107Connection) ? LAN_CREATED: LAN_CREATED_FAILED;

}
$text .= "</table></div>";

echo $text."<br /><br /></div>";
echo "<div style='text-align:center'>$message</div>";



function goError($error){
	echo "<b>{$error}</b></td></tr></table>";
	require_once(e_ADMIN."footer.php");
	exit;
}


require_once(e_ADMIN."footer.php");
?>