<?php
//================================ Catalog =======================================
//	author: MagicDreamWebStudio, http://md.osgroup.pro
//	coders: Sunout, StAlKeR_PeOpLe
//	sunout@osgroup.pro, stalker@osgroup.pro
//	license GNU GPL
//==================== the project started in May 2014 ===========================

//-----stylesheet------//
//$text ="<link rel='stylesheet' href='".e_PLUGIN."catalog/theme/menu_type1.css' type='text/css'/>";

(int)$cat = $_GET['cat'];
(int)$sub = $_GET['sub'];
(int)$id = $_GET['id'];

//=====================Output All Category======================
$text ="<center>
<form enctype='multipart/form-data' name='form_search' method='post' action='catalog.php?page=search'>
<tr><td><input type='text' class='tbox' style='margin:5px; width:140px;' placeholder='Наименование товара...' name='search' size='40'><input type='submit' value='Найти' class='button' name='submit_search'>
</form>
</center>";

$caption = "Поиск товара";
$ns -> tablerender($caption, $text);
?>