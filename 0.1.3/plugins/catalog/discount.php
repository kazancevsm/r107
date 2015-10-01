<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

if ($profile_bonus == 'Накопительная') {
	      $vtsql2 = new db;
	      $vtsql2 -> db_Select("vt_basket", "*", "basket_userid='".USERID."' AND basket_ordstat='ready' AND basket_bonus='Накопительная'");
		while($row = $vtsql2 -> db_Fetch()){
			$basket_price = $row['basket_price'];
			$basket_amount = $row['basket_amount'];
			$sum1 = $basket_amount * $basket_price;
			$total1 = $total1 + $sum1;
		}
		if ($total1 >= 1000 AND $total1 < 3000) {
		    $sd = 0.03;
		}
		if ($total1 >= 3000 AND $total1 < 7000) {
		    $sd = 0.05;
		}
		if ($total1 >= 7000 AND $total1 < 15000) {
		    $sd = 0.08;
		}
		if ($total1 >= 15000 AND $total1 < 30000) {
		    $sd = 0.1;
		}
		if ($total1 >= 30000) {
		    $sd = 0.15;
		}
//	$discount = $total - ($total*$ad);
	}
	
	if ($profile_bonus == 'Разовая' || USER==FALSE) {
		if ($total < 5000){
			 $skd = 5000 - $total;
			 $sd = 0.0;
			 $sd_text = '';
			 $sd1='5%';
		}
		if ($total >= 5000 AND $total < 10000){
			 $skd = 10000 - $total;
			 $sd = 0.05;
			 $sd_text = '(5%)';
			 $sd1='10%';
		}
		if ($total >= 10000 AND $total < 15000) {
			 $skd = 15000 - $total;
			 $sd = 0.1;
			 $sd_text = '(10%)';
			 $sd1='15%';
		}
		if ($total >= 15000) {
//			$skd = 15000 - $total;
			$sd = 0.15;
			$sd_text = '(15%)';
			$sd1='15%';
	      }
//	$discount = $total - ($total*$sd);
	} 
	
	$discount_total = $total - ($total*$sd);
	$discount = $total*$sd;
?>