<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "my_gallery"
|     Author: Alex ANP alex-anp@ya.ru
|     Home page: http://e107.seafoxy.ru
|				 http://e107plugins.blogspot.com
+-----------------------------------------------------------------------------------------------+
*/

$file = $_GET['file'];
$date_txt = date("y-m-d_H-i-s");
$text = "Content-Disposition: attachment; filename=".$_SERVER["SERVER_NAME"]."_e107_my_gallery_".$date_txt.".jpg";
header('Content-type: image/jpeg');
header($text);
readfile($file);
?>