<?php
function CartIDfunc(){
//This is the Functiont that will create a cookie for hte store that will be
//used to identify the cart contents for a user.

if(isset($_COOKIE["FireStore"])){
	return $_COOKIE["FireStore"];
}else{
// If there is no cookie set. We will set the cookie
// and return the value of the users session ID
		$time = time();
		$expired_cart = $time - ((3600 * 24) * 1);
session_start();
setcookie("FireStore", session_id(), time() + ((3600 * 24) * 1));
$sql = new db;
$sql -> db_Delete("vt_cart", "date<='$expired_cart'");
	return session_id();
	}
}
?>