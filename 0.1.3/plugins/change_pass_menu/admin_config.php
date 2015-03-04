<?php
// **************************************************************************
// *
// *  Change Password menu Configuration for e107 v7
// *
// **************************************************************************
require_once("../../class.php");
if (!getperms("P"))
{
    header("location:" . e_HTTP . "index.php");
    exit;
} 
require_once(e_ADMIN . "auth.php");
require_once(e_HANDLER . "userclass_class.php");
if (e_LANGUAGE !="English" && file_exists(e_PLUGIN . "change_pass_menu/languages/admin/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "change_pass_menu/languages/admin/" . e_LANGUAGE . ".php");
} 
else
{
    include_once(e_PLUGIN . "change_pass_menu/languages/admin/English.php");
} 

if (e_QUERY=="update")
{ 
    // Update rest
    $pref['cpass_userclass']=$_POST['cpass_userclass'];
    save_prefs();
    $cpass_msgtext="<tr><td class='r_header3' colspan='2'><strong>" . CPASS_A5 . "</strong></td></tr>";
} 

$cpass_text .="<form method='post' action='" . e_SELF . "?update' id='confcpass'>
<table style='width: 97%;' class='r_border'>
<tr><td colspan='2' class='r_caption'>" . CPASS_A1 . "</td></tr>$cpass_msgtext";
// Main admin class
$cpass_text .="
<tr>
<td style='width:30%' class='r_header3'>" . CPASS_A6 . "</td>
<td style='width:70%' class='r_header3'>" . r_userclass("cpass_userclass", $pref['cpass_userclass'], "off", 'nobody, member, admin, classes') . "
</td></tr>";
// Submit button
$cpass_text .="
<tr>
<td colspan='2' class='r_caption' style='text-align: left;'><input type='submit' name='update' value='" . CPASS_A7 . "' class='button' />\n
</td>
</tr>";

$cpass_text .="</table></form>";

$ns->tablerender(CPASS_A2, $cpass_text);

require_once(e_ADMIN . "footer.php");


?>
