<?php
require_once("../../class2.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_HANDLER."np_class.php");
require_once(HEADERF) ;	
require_once("cart_cookie.php");
require_once(e_HANDLER."mail.php"); 

$cartses = CartIDfunc();
$caption = "������� �� �������";
$fname = $_POST["name"];
$lname = $_POST["famil"];
$email = $_POST["mail"];
$addr1 = $_POST["ad1"];
$tel = $_POST["phone"];
$city = $_POST["gorod"];
$zip = $_POST["kod"];
$pas='';$k=0;$n=0;$j=0;

$d= date("d.m.Y�.",time());
$t=date("G:i:s",time());


/*
mysql_connect(localhost,root,$pas) OR DIE("�� ���� ������� ���������� "); 
mysql_select_db(wwwcentre2000ru) or die(mysql_error()); 
$query = "SELECT itemId,qty FROM e107_mycart";
$res = mysql_query($query) or die(mysql_error()); 
$j = mysql_num_rows($res);

while ($row=mysql_fetch_array($res)) { 
  $iditem[] = $row['itemId'];
  $amount[] = $row['qty'];
} */

$sql = new db;
$sql -> db_Select("mycart", "itemId,qty", "uniID='$cartses'") or die (""._MYSTORE35."");
while($row = $sql -> db_Fetch()){
  $iditem[] = $row['itemId'];
  $amount[] = $row['qty'];
  $j++;
}


//$text .= "$j ";

/*for ($i = 0; $i < $j; $i++) {
	$query1 = "SELECT itemId,itemName,itemPrice FROM e107_myitems WHERE itemId = '$iditem[$i]'";
	$res1 = mysql_query($query1) or die(mysql_error());
	$itname[$i] = $row['itemName'];
	$itprice[$i] = $row['itemPrice'];
	$text .= "$itname[0]";	
}*/


for ($i = 0; $i < $j; $i++) {
	$sql2 = new db;
	$sql2 -> db_Select("myitems", "itemName,itemPrice", "itemId=$iditem[$i] ORDER BY itemId") or die (""._MYSTORE35."");
	while($row2 = $sql2 -> db_Fetch()){
		$itemname[$i] = $row2["itemName"];
		$itemprice[$i] = $row2["itemPrice"];
		$k++;
	}
}

for ($i = 0; $i < $k; $i++) {
 //   $text .= "$itemname[$i] $amount[$i] $itemprice[$i]----- <br>"; 
 $cena = $amount[$i]* $itemprice[$i]; 
   $bodyz .= "<br>������������: " . $itemname[$i] . "<br>����������: " . $amount[$i] . "<br>����: " . $itemprice[$i] . "<br>����� ���� � ������: " .$cena*29.5. " �.<br>";
}
$bodyz .= "���� �� �������� - 100 ���.";
//$text .= "$iditem[0] $amount[0] - $iditem[1] $amount[1] ";

/*$i = 0; $j = 0;
		$sql -> db_Select("mycart", "*", "");
            while($row = $sql -> db_Fetch()){
				$id[] = $row["itemId"];
				$kolvo[] = $row["qty"];
				$i = $i + 1;
			}*/
		

/*    for($j=0; $j <= $i; $j++){
       $text .="$idname[$j] -- $idprice[$j]-- $idkolvo[$j]-- /// ";
    }
	$j = 0;
	while($j<>$i){
		$text .= "---- $id[$j] $kolvo[$j]    ---";
		$j = $j +1;
    }*/


//$text .= "������, $fname $lname $email $addr1 $addr2 $city $zip | ������� $d - $t";
$hello .= "��� ���������� ����� �������� ��� ��������� ����� ����������. �� ����� �������� � ���� ��� ���������� ��������� ����� ������. ������� �� ��� �����.";

//Send Order
$subject = "����� � �������� �������� �� $d | $t";
$message = "��� ������� - $fname $lname <br> $email <br> ����� - $addr1 $city <br> ������� ��� ��������� - $tel<br>�������������� ���������� � ������: $zip <br>--------------------------------------------------------<br> $bodyz <br> ���� � ����� ������ (����������) - $d $t";
sendemail("admin@admin.ru", $subject, $message);

//Send Order
$text .= "$hello <br><br><br> $subject <br><br> $message <br>";
$text .="<table class=\"forumheader3\" style='width:95%'>";
			$text .="<td class=\"forumheader3\"><center><form action=cart.php method='post'><input type=hidden name=clearord value=clearord><input type='Submit' name='submit' value='���������� ������ � ���������'></form></td>";
$text .="</table>";

$ns->tablerender($caption, $text);
require_once(FOOTERF) ;
?>