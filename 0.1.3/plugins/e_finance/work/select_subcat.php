<?php
/*============================= Notice-Board v2.0 ======================================|
|	author - ComPolyS, http://e107.compolys.ru, e107@compolys.ru			|
|	coder - Sunout, sunout@compolys.ru						|
|	license GNU GPL									|
=================================== december 2010 =====================================*/
header('Content-Type: text/xml');
require_once("../../class2.php");
//if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");

$cat_id = $_GET['id'];
	mysql_query('SET NAMES cp1251');
	mysql_query ("set character_set_results='utf8'");
	$dom = new DOMDocument();
	$response = $dom -> createElement('response');
	$dom -> appendChild($response);
	$books = $dom -> createElement('books');
	$response -> appendChild($books);
$sql -> db_Select("vt_cat", "*", "cat_sub=$cat_id");
	while($row = $sql -> db_Fetch()){
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
		$book = $dom -> createElement('book');
		$title = $dom -> createElement('title');
        	$titleText = $dom -> createTextNode($cat_id);
        	$title -> appendChild($titleText);
        	$isbn = $dom -> createElement('isbn');
        	$isbnText = $dom -> createTextNode($cat_name);
        	$isbn -> appendChild($isbnText);
        	$book -> appendChild($title);
		$book -> appendChild($isbn);
		$books -> appendChild($book);
	}
    $xmlString = $dom -> saveXML();
    echo $xmlString;
?>