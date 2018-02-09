<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "gallery"
|     Author: Alex ANP alex-anp@ya.ru
+-----------------------------------------------------------------------------------------------+
*/

$lan_file = e_PLUGIN."gallery/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."gallery/languages/English.php"));

$search_info[] = array(
   'sfile'     => e_PLUGIN.'gallery/search.php',
   'qtype'     => MYGAL_L003,
   'refpage'   => 'gallery.php',
   'id'        => 'gallery',
);
?>