<?php

require_once("../../class2.php");
//if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."np_class.php");
$tpcost = $_POST["totalcost"];
$dqty = $_POST["mqty"];


//Now we create the forms if you are a returning/currently logged in customer

require_once(HEADERF);


				$text ="<form name=\"config\" method=\"post\" action=\"checkoutp.php\"><table class=\"forumheader3\" style='width:100%'>";

				$text .= "<tr><td>Имя: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='fname'></td></tr>";

$text .= "<tr><td>Фамилия: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='lname'></td></tr>";

$text .= "<tr><td>Email: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='email'></td></tr>";

$text .="<tr><td>Адрес; индекс: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='address1'></td></tr>";

$text .="<tr><td>Город: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='city'></td></tr>";
$text .="<tr><td>Телефон: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='tel'></td></tr>";
				

/*$text .="<tr><td>State: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='state'></td></tr>";*/

$text .="<tr><td>Дополинительная информация к заказу: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='zip'></td></tr>";

/*$text .="<tr><td>Country: </td><td class=\"forumheader2\" width='70%'><input class='tbox' type='text' name='country'></td></tr>";*/

$text .= "<tr><td>&nbsp;</td><td><input type=hidden name=totalcost value='$tpcost'><input type=hidden name=mqty value='$dqty'><input class='button' type='submit' value='Подтвердить' name='addcat'>";
$text .= "</td></tr></table></form>";


	
$caption = "Уважаемый покупатель, заполните все данные, для корректного оформления заказа в нашем магазине.";
		$ns->tablerender($caption, $text);
require_once(FOOTERF) ;
exit;
?>