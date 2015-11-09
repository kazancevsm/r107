<?php

require_once("../../class2.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
@include_once(e_PLUGIN."abook/languages/".e_LANGUAGE.".php");

$ns = new e107table;
require_once(HEADERF);
require_once("classmen.php");
$uspage = e_BASE;
	$cat = $_GET['cat'];
	$act = $_GET["act"];
//==================================Caption Table==============================
	$text .= "<table class='fcaption' style='width:100%'>";
	$text .="<tr><td class='fcaption'>".AB_NAME_5."</td>
		<td class='fcaption'>".AB_CONF_7."</td>
		<td class='fcaption'>".AB_MAIL_1."</td>
		</tr>";
//==================================Items======================================
	$sql ->db_Select ("ab_gnl", "*", "gnl_cat='$cat'");
                while($row = $sql -> db_Fetch()){
			$gnl_division = $row['gnl_division'];
			$gnl_phone = $row['gnl_phone'];
			$gnl_mail = $row['gnl_mail'];
			
	
	$text .="<tr><td class='forumheader2'>$gnl_division</td>
		<td class='forumheader2'>$gnl_phone</td>
		<td class='forumheader2'>$gnl_mail</td></tr>";
	}
//	if ($act == "det"){
		


$text .="</table>";
$caption = '����������';
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>