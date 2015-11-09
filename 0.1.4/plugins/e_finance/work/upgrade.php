	<?php

require_once("../../class2.php");
if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_ADMIN."auth.php");


	//connect to the cart table and grab the cart contents

			$sql -> db_Select("mycart", "*", "");
                while($row = $sql -> db_Fetch()){
					
					$itemid = $row["itemId"];
					$myqty = $row["qty"];
					$who = $row["cookieId"];
					$email = $row["e107_user"];
					$ord = $row["ordstatus"];
					$qty = $row["qty"];
					$pay = $row["paystat"];

	$sql2 = new db;
			$sql2 -> db_Insert("myorders", "0, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '$who', '$who', '$email', '$itemid', '$qty', '$pay', '$ord'");

	}


	$sql -> db_Delete("mycart", "");






$text .="<table class=\"forumheader3\" style='width:95%'>";
			
$text .="<tr><td class=\"forumheader2\" colspan=2><b>Your Store Has now been Upgraded completely and all orders moved to the orders table. From now on the orders will be grouped into their correct user etc. <br><BR> Please delete this upgrade file for security reasons.</td></tr></table>";

$site = SITEURL;
mail("myStore@mytipper.com", "myStore 2.0 Just installed on $site", "$site just installed myStore\n\nAdd them to your site database.");


$caption = "Ваш заказ принят!";
		$ns->tablerender($caption, $text);
require_once(e_ADMIN."footer.php");
?>