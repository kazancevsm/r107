	<?php
	require_once("../../class2.php");
//if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."np_class.php");

require_once("cart_cookie.php");

$cartses = CartIDfunc();

$addorder = $_POST["addcat"];

$dqty = $_POST["mqty"];

//put in the post variables for database addition
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$address = $_POST["address1"]."<br>".$_POST["address2"];
$city = $_POST["city"];
$state = $_POST["state"];
$country = $_POST["country"];
$zip = $_POST["zip"];
$euser = USERNAME;
$uemail = USEREMAIL;


				
					


if (IsSet($addorder)) {
	
	//connect to the cart table and grab the cart contents

			$sql -> db_Select("mycart", "*", "uniID='$cartses'");
                while($row = $sql -> db_Fetch()){
					
					$itemid = $row["itemId"];
					$myqty = $row["qty"];
	//Add the order to the Order Database and then send out to payment gateway.
	$sqlc = new db;
	$countvar = $sqlc -> db_Count("myorders", "(*)", "WHERE uniID='$cartses' AND orderstatus = 'pending'");
	if ($countvar == 0){
	$sql2 = new db;
			$sql2 -> db_Insert("myorders", "0, '$fname', '$lname', '$address', '$city', '$state', '$zip', '$country', '$cartses', '$euser', '$uemail', '$itemid', '$myqty', 'not paid', 'pending'")or die (mysql_error());
			$addorder = "";
	}
}





	require_once(HEADERF) ;
			$sql -> db_Select("mystoreconf", "*", "");
                while($row = $sql -> db_Fetch()){
					$phandle = $row['ph'];
					$min = $row['min'];
					$max = $row['max'];
					$currency = $row['currency'];
		}

$text .="<table class=\"forumheader3\" style='width:95%'>";
			$sql -> db_Select("myorders", "*", "uniID='$cartses'") or die (""._MYSTORE30." <a href='myStore.php'>"._MYSTORE31." &gt;&gt;</a>");
                while($row = $sql -> db_Fetch()){
					
					$itemid = $row["itemid"];
					$myqty = $row["qty"];
					
				//Go to the other table and retrieve the product information
					$sql2 = new db;
					$sql2 -> db_Select("myitems", "*", "itemId=$itemid ORDER BY itemId") or die (""._MYSTORE35."");
						while($row2 = $sql2 -> db_Fetch()){
							$itemname = $row2["itemName"];
							$itemDesc = $row2["itemDesc"];
							$itemprice = $row2["itemPrice"];
							$carter = $row["cartId"];
							$ph = $row2["ph"];
							$sku = $row["sku"];
						

					// Increment the total cost of all items 
						$totalCost += ($myqty * $row2["itemPrice"]); 
						$postCost += ($myqty * $row2["ph"]);
					

				}
			}
					$postvar = $postCost;
					if ($postvar < $min) {
						$postvar = $min;
					}
				if ($postvar > $max){
					$postvar = $max;
				}
				
		if ($phandle == "pitem") {
			$costvar = $_POST["totalcost"];
//			$costvar = number_format($costvar, 2, ".", ",");
//			$postvar = number_format($postvar, 2, ".", ",");
		//$text .="<tr><td class=\"forumheader2\"><b>The Total Purchase amount is $costvar - $currency</td></tr>";
}
else
	{
	$costvar = $_POST["totalcost"];
//	$costvar = number_format($costvar, 2, ".", ",");
	}
				$text .="<tr><td class=\"forumheader2\" colspan=2><b>Окончательная стоимость $costvar - $currency + 100 руб. доставка</td></tr>";
		
		 //Just want to grab a couple of store preferences
								$sql4 = new db;
								$sql4 -> db_Select("mystoreconf", "*", "");
							while($row2 = $sql4 -> db_Fetch()){
								$bumail = $row2["busemail"];
							}
		//Start PayPal part
			$webaddress = SITEURL;
			
			$fname1 = $_POST["fname"];
			$lname1 = $_POST["lname"];
			$email1 = $_POST["email"];
			$addr1 = $_POST["address1"];
			$tel = $_POST["tel"];
			$city1 = $_POST["city"];
			$zip1 = $_POST["zip"];
			
			
			$text .="<tr><td class=\"forumheader3\"><center><form action='email.php' method='post'><input type='Submit' name='submit' value='Нажмите чтобы подтвердить заказ'>";
			$text .="<input type='hidden' name='name' value='$fname1'>";
			$text .="<input type='hidden' name='famil' value='$lname1'>";
			$text .="<input type='hidden' name='mail' value='$email1'>";
			$text .="<input type='hidden' name='ad1' value='$addr1'>";
			$text .="<input type='hidden' name='phone' value='$tel'>";
			$text .="<input type='hidden' name='gorod' value='$city1'>";
			$text .="<input type='hidden' name='kod' value='$zip1'>";
			
			//end pay pal */
			
//			$text .="<td class=\"forumheader3\"><center><form action=cart.php method='post'><input type='text' name=clearord value=clearord><input type='Submit' name='submit' value='Cancel Order and Keep Shopping'></form></td>";
		$text .="</table>";
		/*$text .="<table class=\"forumheader2\" style='width:95%'>";
			$text .="<td class=\"forumheader2\"><center><form action='cart.php' method='post'><input type=hidden name=clearord value=clearord><input type='Submit' name='submit' value='Cancel Order and Keep Shopping'></form></td>";
$text .="</table>";*/

}


//	$sql3 = new db;
//			$sql3 -> db_Select("myorders", "*", "uniID='$cartses'")or die(mysql_error());
//                while($row2 = $sql3 -> db_Fetch()){
//					
//					$itemid = $row2["itemid"];
//					$myqty = $row2["qty"];
//					
//				//Go to the other table and retrieve the product information
//					$sql7 = new db;
//					$sql7 -> db_Select("myitems", "*", "itemId=$itemid ORDER BY itemId")or die(mysql_error());
//						while($row7 = $sql7 -> db_Fetch()){
//							$itemname = $row7["itemName"];
//							$itemDesc = $row7["itemDesc"];
//							$itemprice = $row7["itemPrice"];
//							$carter = $row["cartId"];
//							$ph = $row2["ph"];
//							$sku = $row["sku"];
//						
//
//					// Increment the total cost of all items 
//						$totalCost += ($row["qty"] * $row7["itemPrice"]); 
//						$postCost += ($row["qty"] * $row7["ph"]);
//					
//			
//				
//				}
//			}
//					$postvar = $postCost;
//					if ($postvar < $min) {
//						$postvar = $min;
//					}
//				if ($postvar > $max){
//					$postvar = $max;
//				}
//				
//		if ($phandle == "pitem") {
//			$costvar = $totalCost + $postvar;
//			$costvar = number_format($costvar, 2, ".", ",");
//			$postvar = number_format($postvar, 2, ".", ",");
//		
//		}
//		if ($phandle != "pitem")
//		{
//		$costvar = $totalCost;
//		}
//				$text .="<tr><td class=\"forumheader2\"><b>Total Cost of Purchase. " . $costvar - $currency."</td></tr>";
//		
////info built
//
//
//		//Start PayPal part
//								$sql4 = new db;
//								$sql4 -> db_Select("mystoreconf", "*", "")or die(mysql_error());
//							while($row2 = $sql4 -> db_Fetch()){
//								$bumail = $row2["busemail"];
//							}
//			$storename = SITENAME;
//			$webaddress = SITEURL;
//			$text .="<tr><td class=\"forumheader3\"><center><form action='https://www.paypal.com/cgi-bin/webscr' method='post'><input type='Submit' name='submit' value='Click Here To Pay Now'>";
//			$text .="<input type='hidden' name='cmd' value='_xclick'>";
//			$text .="<input type='hidden' name='business' value='$bumail'>";
//			$text .="<input type='hidden' name='item_name' value='$cartses'>";
//			$text .="<input type='hidden' name='item_number' value='Purchase from $storename'>";
//			$text .="<input type='hidden' name='amount' value='$costvar'>";
//			$text .="<input type='hidden' name='no_note' value='1'>";
//			$text .="<input type='hidden' name='currency_code' value='$currency'>";
//			$text .="<input type='hidden' name='notify_url' value='$webaddress";
//			$text .="e107_plugins/myStore/notify.php'>";
//			$text .="<input type='hidden' name='return' value='$webaddress'>";
//			$text .="<input type='hidden' name='tax' value='0'></form></td></tr>";
//
//			//end pay pal


//end payment form
$caption = "Ваш заказ принят!";
		$ns->tablerender($caption, $text);
require_once(FOOTERF) ;
?>