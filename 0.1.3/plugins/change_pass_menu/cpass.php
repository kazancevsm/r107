<?php
require_once("../../class.php");
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "change_pass_menu/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "change_pass_menu/languages/" . e_LANGUAGE . ".php");
} 
else
{
    include_once(e_PLUGIN . "change_pass_menu/languages/English.php");
} 
require_once(HEADERF);
if (USERID > 0)
{
    require_once(e_HANDLER . "form_handler.php");
    $rs = new form;
    if (isset($_POST['updatesettings']))
    {
        $uuid = USERID;
        $sql->db_Select("user", "user_password", "user_id='{$uuid}'");
        $curVal = $sql->db_Fetch();
        if ($uuid == 1)
        {
            $error .= CPASS_21 . "<br />";
        } 
        if (md5($_POST['password0']) != $curVal['user_password'])
        {
            $error .= CPASS_15 . "<br />";
        } 
        if ($_POST['password1'] != $_POST['password2'])
        {
            $error .= CPASS_11 . "<br />";
        } 
        if ($_POST['password1'] == $_POST['password0'])
        {
            $error .= CPASS_16 . "<br />";
        } 
        if (strlen($_POST['password1']) < $pref['signup_pass_len'])
        {
            $error .= CPASS_12 . " " . $pref['signup_pass_len'] . " " . CPASS_13 . "<br />";
        } 
        if (empty($_POST['password1']))
        {
            $error .= CPASS_14 . "<br />";
        } 
        // #	make it greater than 1 so that main admin can't change it
        if (empty($error) && $uuid > 1)
        {
            $password = md5($_POST['password1']);
            if ($sql->db_Update("user", "user_password='$password' where user_id='$uuid'"))
            {
                $error .= CPASS_17 . "<br />";
            } 
            else
            {
                $error .= CPASS_18 . "<br />";
            } 
        } 
    } 
    unset($_POST['password0']);
    unset($_POST['password1']);
    unset($_POST['password2']);
    $cpass_text .= "<form id='cpass' action='" . e_SELF . "' method='post'>
	<table class='r_border' width='97%'>
	<tr style='vertical-align:top'>
	<td colspan='2' style='text-align:left' class='r_caption'>" . CPASS_10 . "
	</td></tr>";
    if (file_exists("./images/change64.png"))
    {
        $cpass_text .= "<tr style='vertical-align:top;'>
		<td colspan='2' style='text-align:center' class='r_header3'><img src='./images/change64.png' alt='' /><br />" . CPASS_20 . "
		</td>
	</tr>";
    } 
    if (!empty($error))
    {
        $cpass_text .= "<tr style='vertical-align:top'>
		<td colspan='2' style='text-align:left' class='r_header2'>" . $error . "
		</td>
	</tr>";
    } 
    $cpass_text .= "<tr>
	<td style='width:30%' class='r_header3'>" . CPASS_3 . "</td>
	<td style='width:70%' class='r_header3'>
	" . $rs->form_password("password0", 40, "", 20) . "
	</td>
	</tr>
	<tr>
	<td style='width:30%' class='r_header3'>" . CPASS_4 . "</td>
	<td style='width:70%' class='r_header3'>
	" . $rs->form_password("password1", 40, "", 20);
    if ($pref['signup_pass_len'] > 0)
    {
        $cpass_text .= "<br /><span class='smalltext'>  (" . CPASS_7 . " {$pref['signup_pass_len']} " . CPASS_8 . ")</span>";
    } 
    $cpass_text .= "
	</td>
	</tr>

	<tr>
	<td style='width:30%' class='r_header3'>" . CPASS_5 . "</td>
	<td style='width:70%' class='r_header3'>
	" . $rs->form_password("password2", 40, "", 20) . "<br /><span class='smalltext'>  (" . CPASS_6 . ")</span>
	</td>
	</tr>
	<tr style='vertical-align:top'>
	<td colspan='2' style='text-align:left' class='r_caption'>
	<input class='button' type='submit' name='updatesettings' value='" . CPASS_9 . "' /></td>
	</tr>
	</table></form>";
} 
else
{
    $cpass_text .= "
	<table class='r_border' width='97%'>
	<tr style='vertical-align:top'>
	<td colspan='2' style='text-align:left' class='r_caption'>" . CPASS_10 . "
	</td></tr>
	<tr style='vertical-align:top'>
	<td style='text-align:left' class='r_header3'>" . CPASS_19 . "
	</td></tr>
	<tr style='vertical-align:top'>
	<td colspan='2' style='text-align:left' class='r_caption'>
	&nbsp;</td>
	</tr></table>";
} 
$ns->tablerender(CPASS_1, $cpass_text);
require_once(FOOTERF);
?>