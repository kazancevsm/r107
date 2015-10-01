<?php
/*
<----------------------------------------------->
| myStore v0.1                         
| for e107 v6. http://www.myTipper.com                        
| 
This is a BETA PLEASE REPORT BUGS IMMEDIATELY
<----------------------------------------------->
*/

require_once("../../class2.php");
if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_ADMIN."auth.php");
require_once("languages/lan_".e_LANGUAGE.".php");


$purchase = $_GET["who"];
	$actvar = $_GET["action"];
	if ($actvar == "sent"){
			$sql -> db_Update("myorders", "uniID='$purchase'")or die (mysql_error());
			$actvar= "hist";
	}
		if ($actvar == "remo"){
			$sqld = new db;
			$sqld -> db_Delete("myorders", "uniID='$cartses'");
			$actvar= "hist";
	}
		if ($actvar == ""){
		$text .="<table class=\"forumheader3\" style='width:95%'><tr><td>"._MYSTORE63."</td></tr>";

		$text .= "<tr><td class=\"forumheader2\"><b>"._MYSTORE65."</b></td><td class=\"forumheader2\"><b>"._MYSTORE64."</b></td><td class=\"forumheader2\"><b>Qty</td><td class=\"forumheader2\"><b>"._MYSTORE66."</td><td class=\"forumheader2\"><b>"._MYSTORE67."</b></td></tr>";

			$sql -> db_Select("myorders", "*", "uniID='$purchase' ORDER BY itemId") or die(mysql_error());
                while($row = $sql -> db_Fetch()){
					
					$itemid = $row["itemid"];
					$myqty = $row["qty"];
					
				//Go to the other table and retrieve the product information
					$sql2 = new db;
					$sql2 -> db_Select("myitems", "*", "itemId=$itemid") or die ("test");
						while($row2 = $sql2 -> db_Fetch()){
							$itemname = $row2["itemName"];
							$itemDesc = $row2["itemDesc"];
							$itemprice = $row2["itemPrice"];
							$carter = $row["cartId"];
							$status = $row["ordstatus"];
					
						

					// Increment the total cost of all items 
						$totalCost += ($row["qty"] * $row2["itemPrice"]); 
					}
			$text .= "<tr><td class=\"forumheader2\">$itemname</td><td class=\"forumheader2\">$itemDesc</td><td class=\"forumheader2\"><b>$myqty</td><td class=\"forumheader2\">$itemprice</td><td class=\"forumheader2\">$status</td></tr>";
				
				}
						$costvar = number_format($totalCost, 2, ".", ",");
		$text .="<tr><td class=\"forumheader2\"><b>"._MYSTORE37." \$$costvar</td><td class=\"forumheader2\"><a href='sdetail.php?action=sent&who=$purchase'>Mark Sale as Completed</a></td></tr></table>";
		$caption = ""._MYSTORE68." $purchase";
$ns -> tablerender($caption, $text);
		}
		If ($actvar == "hist"){
					$text .="<table class=\"forumheader3\" style='width:95%'><tr><td>"._MYSTORE63."</td></tr>";

		$text .= "<tr><td class=\"forumheader2\"><b>"._MYSTORE65."</b></td><td class=\"forumheader2\"><b>"._MYSTORE64."</b></td><td class=\"forumheader2\"><b>Qty</td><td class=\"forumheader2\"><b>"._MYSTORE66."</td><td class=\"forumheader2\"><b>"._MYSTORE67."</b></td></tr>";

			$sql -> db_Select("myorders", "*", "uniID='$purchase'") or die(mysql_error());
			
                while($row = $sql -> db_Fetch()){
					
					$itemid = $row["itemid"];
					$myqty = $row["qty"];
					
					echo "itemid ".$itemid;
				//Go to the other table and retrieve the product information
					$sql2 = new db;
					$sql2 -> db_Select("myitems", "*", "itemId=$itemid");
						while($row2 = $sql2 -> db_Fetch()){
							$itemname = $row2["itemName"];
							$itemDesc = $row2["itemDesc"];
							$itemprice = $row2["itemPrice"];
							$carter = $row["cartId"];
							$status = $row["ordstatus"];
						
					
						

					// Increment the total cost of all items 
						$totalCost += ($row["qty"] * $row2["itemPrice"]); 
					}
			$text .= "<tr><td class=\"forumheader2\">$itemname</td><td class=\"forumheader2\">$itemDesc</td><td class=\"forumheader2\">$myqty</td><td class=\"forumheader2\">$itemprice</td><td class=\"forumheader2\">$status</td></tr>";
				
				}
						$costvar = number_format($totalCost, 2, ".", ",");
		$text .="<tr><td class=\"forumheader2\"><b>"._MYSTORE37." $costvar - $currency</td></tr></table>";
		$caption = ""._MYSTORE68." $purchase";
$ns -> tablerender($caption, $text);
		}
		If ($actvar == "hold"){
					$text .="<table class=\"forumheader3\" style='width:95%'><tr><td>"._MYSTORE63."</td></tr>";

		$text .= "<tr><td class=\"forumheader2\"><b>"._MYSTORE65."</b></td><td class=\"forumheader2\"><b>"._MYSTORE64."</b></td><td class=\"forumheader2\"><b>Qty</td><td class=\"forumheader2\"><b>"._MYSTORE66."</td><td class=\"forumheader2\"><b>"._MYSTORE67."</b></td></tr>";

			$sql -> db_Select("myorders", "*", "uniID='$purchase'") or die(mysql_error());
			
                while($row = $sql -> db_Fetch()){
					
					$itemid = $row["itemid"];
					$myqty = $row["qty"];
					
					
				//Go to the other table and retrieve the product information
					$sql2 = new db;
					$sql2 -> db_Select("myitems", "*", "itemId=$itemid");
						while($row2 = $sql2 -> db_Fetch()){
							$itemname = $row2["itemName"];
							$itemDesc = $row2["itemDesc"];
							$itemprice = $row2["itemPrice"];
							$carter = $row["cartId"];
							$status = $row["ordstatus"];
						
					
						

					// Increment the total cost of all items 
						$totalCost += ($row["qty"] * $row2["itemPrice"]); 
					}
			$text .= "<tr><td class=\"forumheader2\">$itemname</td><td class=\"forumheader2\">$itemDesc</td><td class=\"forumheader2\">$myqty</td><td class=\"forumheader2\">$itemprice</td><td class=\"forumheader2\">$status</td></tr>";
				
				}
						$costvar = number_format($totalCost, 2, ".", ",");
		$text .="<tr><td class=\"forumheader2\"><b>"._MYSTORE37." $costvar - $currency</td></tr>";
		$text .="<tr><td class=\"forumheader2\"><b>"._MYSTORE37." \$$costvar</td><td class=\"forumheader2\"><a href='sdetail.php?action=remo&who=$purchase'>Delete the Order</a></td></tr></table>";
		$caption = ""._MYSTORE68." $purchase";
$ns -> tablerender($caption, $text);
		}
//Include the Shipping Details
			$text ="<table class=\"forumheader3\" style='width:95%'>";
				$sql -> db_Select("myorders", "*", "uniID='$purchase'") or die(mysql_error());
			
                while($row = $sql -> db_Fetch()){
					$fname = $row["fname"];
					$lname = $row["lname"];
					$address = $row["address"];
					$city = $row["city"];
					$state = $row["state"];
					$zip = $row["zip"];
					$country = $row["country"];
				}

		$text .= "<tr><td class=\"forumheader2\" width=30%>Name: </td><td class=\"forumheader2\">$fname  $lname</td></tr><tr><td class=\"forumheader2\">Address: </td><td class=\"forumheader2\">$address</td></tr><tr><td class=\"forumheader2\">City: </td><td class=\"forumheader2\">$city</td></tr><tr><td class=\"forumheader2\">State: </td><td class=\"forumheader2\">$state</td></TR><tr><td class=\"forumheader2\">Zip: </td><td class=\"forumheader2\">$zip</td></tr><tr><td class=\"forumheader2\">Country</td><td class=\"forumheader2\">$country</td></tr></table>";
				$caption = "Customer Shipping Details";
$ns -> tablerender($caption, $text);

echo "</br><div style='text-align:center'>http://www.myTipper.com</div>"; 

require_once(e_ADMIN."footer.php");

?>