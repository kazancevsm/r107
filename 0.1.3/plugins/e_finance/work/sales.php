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
require_once("languages/lan_".e_LANGUAGE.".php");
require_once(e_ADMIN."auth.php");

	$actvar = $_POST["action"];
		$purchase = $_GET["who"];
			if ($actvar == "edit"){
							$sql -> db_Select("myitems", "*", "itemId = $catid");
                while($row = $sql -> db_Fetch()){
					$namval = $row['itemName'];
					$desval = $row['itemDesc'];
					$prival = $row['itemPrice'];
				}
			}

		
$text ="<table class=\"forumheader3\" style='width:95%'>";
 			$sql -> db_Select("myorders", "*", "ordstatus ='Paid' AND paystat ='Completed'");
                while($row = $sql -> db_Fetch()){
					$who = $row["uniID"];
                                $umer = $row["user"];
			$text .="<tr><td class'forumheader2' width='80%'><a href='sdetail.php?who=$who'>"._MYSTORE60." $umer</a></td></tr>";
				}
				$text .="</table>";
$caption = ""._MYSTORE61."";
$ns -> tablerender($caption, $text);

$text ="<table class=\"forumheader3\" style='width:95%'>";
 			$sql -> db_Select("myorders", "*", "ordstatus = 'Completed' AND paystat = 'Completed'");
              while($row = $sql -> db_Fetch()){
				$who = $row["uniID"];
                                $umer = $row["user"];
		$text .="<tr><td class'forumheader2' width='90%'><a href='sdetail.php?who=$who&action=hist'>"._MYSTORE60." $umer</a></td></tr><tr><TD>&nbsp;</td></tr>";
				}
				$text .="</table>";
$caption = ""._MYSTORE62."";
$ns -> tablerender($caption, $text);

$text ="<table class=\"forumheader3\" style='width:95%'>";
 			$sql -> db_Select("myorders", "*", "ordstatus = 'pending' AND paystat = 'not paid' Group By uniID");
              while($row = $sql -> db_Fetch()){
				$who = $row["uniID"];
                                $umer = $row["user"];
		$text .="<tr><td class'forumheader2' width='90%'><a href='sdetail.php?who=$who&action=hold'>"._MYSTORE60." $umer</a></td></tr><tr><TD>&nbsp;</td></tr>";
				}
				$text .="</table>";
$caption = "Orders Sitting In Car waiting for payment";
$ns -> tablerender($caption, $text);

echo "</br><div style='text-align:center'>http://www.myTipper.com</div>"; 

require_once(e_ADMIN."footer.php");

?>