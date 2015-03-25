<?php

$nav = new alphaPages(); 
$navBar = $nav->makeAlphaNavBar(); 
	if(!empty($letter)) $nav->setLetter();  
		$total_items = $nav->makePageNavBar(); 
	if(!empty($id)) $out = $nav->profile();  
	else{ 
		$nav->setPage();  
		$out = $nav->getList();     
 	}
//======Вывод буквенной навигации======//
$text .= "<div class='nextprev'>$navBar</div>";

//======Вывод постраничной навигации======//
$text .= "<div class='nextprev'>";
$parms = $total_items.",40,".$num_page.",".e_SELF."?letter=$letter&num_page=[FROM]";
$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
$text .= "</div>";

//======Вывод записей из таблицы======//
$text .="<table width=100%>";
$text .="<tr><td>$out</td></tr></table>";
$text .="<tr><td class='fcaption'>$navBar <a href=".e_PLUGIN."abook/abook.php><b>показать все</b></a></td></tr>";
$text .="</table>";

//======Вывод постраничной навигации======//
$text .= "<div class='nextprev'>";
$parms = $total_items.",40,".$num_page.",".e_SELF."?letter=$letter&num_page=[FROM]";
$text .= $tp->parseTemplate("{NEXTPREV={$parms}}");
$text .= "</div>";

?>