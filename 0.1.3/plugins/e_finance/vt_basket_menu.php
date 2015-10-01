<script language="javascript" type="text/javascript" >
<!--
function confirmRefresh() {
var okToRefresh = confirm("вы хотите удалить этот товар?");
if (okToRefresh)
	{
			setTimeout("location.reload(true);",1500);
	}
}
</script>
<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

require_once('vt_class.php');
//-----stylesheet------//
$text ="<link rel='stylesheet' href='".e_PLUGIN."vtrade/theme/menu_basket.css' type='text/css'/>";

$cat = $_GET['cat'];
$sub = $_GET['sub'];
$id = $_GET['id'];
//$sum = 0;
$text .= "<div id='vt_basket_menu'>";
$text .= "<form enctype='multipart/form-data' action='".e_PLUGIN."vtrade/vtrade.php?page=order' method='post'>";
//if (USER==FALSE){
//     $text .= "<font color=#eee size=2>".VT_MES_SALE."</font>";
//}

if (USER==TRUE){
$text .= "<a href='".e_HTTP."usersettings.php'>[ Сменить пароль ]</a><br>";
$text .= "<a href='".e_PLUGIN."vtrade/vtrade.php?page=profile'>[ Профиль ]</a>";
$text .= "<br><a href='".e_PLUGIN."vtrade/vtrade.php?page=basket'>[ Предыдущие заказы ]</a>";
$vtsql = new db;
$vtsql -> db_Select("vt_profile", "*", "profile_id='".USERID."'");
	while($row = $vtsql -> db_Fetch()){
	$profile_bonus = $row['profile_bonus'];
	}
	$text .="<br><br><center>Ваш тип скидки для текущего заказа:<font size=2 color=#fff><b> $profile_bonus</b></font></center>";
}
$text .="<br><center><a href='".e_PLUGIN."vtrade/vtrade.php?page=order' onclick=\"document.getElementById('vt_discount_change').style.display='block'; return false;\">[Сменить тип скидки?]</a></center>";
$text .= "<br><br><table id='vt_basket_menu_items'>";

// -----SESSION_select-----------------------------------------------------------------

	if ($_SESSION['basket'] !='0'){
	foreach($_SESSION['basket'] as $nom_id => $basket_amount):
	    $product = get_product($nom_id);
	    $basket_id =$product['nom_id'];
	    $basket_nom_name = $product['nom_name'];
	    $basket_nom_pic = $product['nom_pic'];
	    $basket_price = $product['nom_price1'];
	    $basket_bonus = $product['basket_bonus'];
	    
	    $text .= "<tr><td><div style='width:28px;height:28px;background:#fff;'><a href='".e_PLUGIN."vtrade/vtrade.php?page=det&id=$basket_id'><img src='".e_PLUGIN."vtrade/vt_pictures/product_icons/$basket_nom_pic' height=28px></a></div></td>"; 
	    $text .= "<td style='padding-left:3px;font-size:11px;' valign='top'><a href='".e_PLUGIN."vtrade/vtrade.php?page=det&id=$basket_id'>$basket_amount x $basket_nom_name</a>";
//	    $text .= "<a href='".e_PLUGIN."vtrade/vtrade.php?page=order&del=$nom_id' onclick='javascript:confirmRefresh();' target='del' >удалить</a></td>";
//	    $text .="<iframe name='del' style='display:none' scr='".e_PLUGIN."vtrade/vtrade.php?page=order&del=$nom_id'  onload='fresh()' ></iframe>";
	    $sum = $basket_amount * $basket_price;
	    $total = $total + $sum;
	endforeach;
	
	include('discount.php');
	
	
	if (!$total==0){
	$text .="<tr><td colspan=2><font size=2 color=#eee>Всего:</font><div style='float:right; text-align:right'><font size=2 color=#eee><b> ".number_format($total,2)." руб.</b></font></div></td></tr>";
	$text .="<tr><td colspan=2><br><font size=2 color=#eee>Cкидка:</font><div style='float:right; text-align:right'><font size=2 color=#eee><b>".number_format($discount,2)." руб.</b></font></div></td></tr>";
	$text .="<tr><td colspan=2><font size=2 color=#eee>$sd_text</font></td></tr>";
	$text .="<tr><td colspan=2><br><font size=2 color=#eee>Чтобы скидка составила ".$sd1." нужно заказать еще на: <font size=2 color=#eee><b> ".number_format($skd,2)." руб.</b></td></tr>";
	$text .="<input class='tbox' type='hidden' name='total' value='$total' />";
	$text .="<input class='tbox' type='hidden' name='discount' value='$discount' />";
	}
	}
	$text .= "</table>";   
	$text .= "<br><br><center>статус корзины:<br><b><font size=3 color=#000>".number_format($discount_total,2)." руб.</b></font></br>";
	//}
$text .= "<br><a href='".e_PLUGIN."vtrade/vtrade.php?page=order'>[ В корзину ]</a> ";
//$text .= " <a href='".e_PLUGIN."vtrade/vtrade.php?page=order'><img src='".e_PLUGIN_ABS."vtrade/theme/but_order.png' alt='Оформить заказ'></a>";
$text .= "<input style='cursor:pointer' type='submit' value='Оформить заказ' name='to_step2'>";
$text .= "</center></form></div>";
//$caption = "Корзина";
//$ns -> tablerender($caption, $text);
$ns -> tablerender($caption,$text);   

?>