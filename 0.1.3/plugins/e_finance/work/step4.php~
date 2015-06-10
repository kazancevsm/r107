<?
session_start();
require_once("../../class2.php");
//if (!defined('e107_INIT')) { exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."np_class.php");
require_once("languages/".e_LANGUAGE.".php");
require_once("cart_cookie.php");
$ns = new e107table;
require_once(HEADERF);
//require_once(e_FILE.'shortcode/batch/news_archives.php');
//require_once(e_HANDLER.'shortcode_handler.php');
//require_once('vt_class.php');

	// STEP 4
	$text .="<div id='vt_block'><table width=90%>";
	$text .="<tr><td><img src='".e_PLUGIN."vtrade/theme/step_4.png'></td></tr>";
	$text .="<tr><td></td><td><input class='tbox' type='hidden' name='order_userid' value='$order_userid' maxlength='200'/></td>";
	//$message .="<tr><td></td><td><input class='tbox' type='' name='profile_username' value='$profile_username' maxlength='200'/></td>";
	$text .="<tr><td></td><td></td><td>";	
	$text .="<tr><td>  ваше имя *</td><td>".$_SESSION['order_user']."<span id='check_name'></span></td>";
//	$message .="<tr><td>  *</td><td><input class='tbox' type='text' name='profile_lname' size='50' value='$profile_lname' maxlength='200'/></td>";
	$text .="<tr><td> название организации </td><td>$order_org<span id='check_name'></span></td>";
	//$message .="<tr><td></td><td><input class='tbox' type='text' name='profile_index' size='50' value='$profile_index' maxlength='200'/></td>";
	//$message .="<tr><td></td><td><input class='tbox' type='text' name='profile_country' onblur='checkcity()' size='50' value='$profile_country' maxlength='200'/><span id='check_city'></span></td>";
	//$text .="<tr><td></td><td><input class='tbox' type='text' name='order_status' onblur='checkcity()' size='50' value='$order_status' maxlength='200'/><span id='check_city'></span></td>";
	//$message .="<tr><td> *</td><td><input class='tbox' type='text' name='order_city' onblur='checkcity()' size='50' value='$order_city' maxlength='200'/><span id='check_city'></span></td>";
	$text .="<tr><td> адрес*</td><td><input type='text' value='$order_address'><span id='check_address'></span></td>";
	$text .="<tr><td> почта*</td><td>$order_email</td>";
	$text .="<tr><td>ICQ</td> <td>$order_icq></td>";
	$text .="<tr><td>Телефон</td><td>$order_phone</td><span id='check_phone'></span></td>";
	//$message .="<tr><td> </td><td><textarea cols=48 rows=10 class='tbox' type='text' name='profile_desc' maxlength='500'/>$profile_desc</textarea></td>";
	//$text .= "<tr><td colspan=2 align=center><br>
	//<input type='submit' class='button'  name='submit_insert' value=''  onClick='f_submit_add()'>";
	$text .= "<tr><td colspan=2 align=center><br>
	<input type='submit' class='button'  name='submit_insert' value='ok'>";
	$text .="</td></tr></table></div>";
	$ns -> tablerender($caption, $text);
	require_once(FOOTERF);
	?>
