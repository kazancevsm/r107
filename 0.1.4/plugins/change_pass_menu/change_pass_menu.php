<?php 
// **************************************************************************
// *  Change Password Menu
// *
// **************************************************************************
if (!check_class($pref['cpass_userclass']))
{
    exit;
} 
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "change_pass_menu/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "change_pass_menu/languages/" . e_LANGUAGE . ".php");
} 
else
{
    include_once(e_PLUGIN . "change_pass_menu/languages/English.php");
} 

$cpass_text="<table class='fborder' width='100%'>
	<tr style='vertical-align:top'>
	<td style='text-align:left' class='forumheader3'>
	<img src='".e_PLUGIN."change_pass_menu/images/cpass_16.png' style='border:0' alt='logo' />
	<a href='".e_PLUGIN."change_pass_menu/cpass.php'> " . CPASS_1 . "</a>
	</td></tr>
</table>";


$ns->tablerender(CPASS_1, $cpass_text);

?>