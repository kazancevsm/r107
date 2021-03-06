<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "md_gallery"
|     Author: Alex ANP alex-anp@ya.ru
|     Home page: http://e107.seafoxy.ru
|				 http://e107plugins.blogspot.com
+-----------------------------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// Config -------------------------------
$gallery = $pref['mdgallery_folder'];
$folder = e_PLUGIN."md_gallery/".$gallery;
$caption = "".MYGAL_L043."";
//$gallery = $folder;

$folder_name = array();

if ($sql->db_Select("md_gallery", "*", "img_status = 'menu'")) {
      while($row = $sql->db_Fetch()) {
        $folder_name[$row['img_name']] = $row['img_title'];
//        echo $row['img_name']." - ".$folder_name[$row['img_name']]."<br>";
      }
}

//echo sizeof($folder_name);

$text = "<!-- #### TextNavMenu #### -->";
if ($_GET['gallery']) $this_gallery = $_GET['gallery'];
//if ($_GET['img']) { $img = $_GET['img']; }
//if ($_GET['page']) $page = $_GET['page'];

if ($handle = opendir($folder)){
	while (false !== ($folder_a = readdir($handle))){
		if ($folder_a != "." && $folder_a != ".." && $folder_a != "index.php"){
			$nav_a[] = $folder_a;
		}
	}
	closedir($handle);
}
sort($nav_a);
foreach ($nav_a as $folder_a){
	$text .= "".($folder_name[$gallery."/".$folder_a] != "" ? $folder_name[$gallery."/".$folder_a] : $folder_a)."";
	$nav_b = "";
	if ($handle = opendir("$folder/$folder_a")){
		while (false !== ($folder_b = readdir($handle))){
			if ($folder_b != "." && $folder_b != ".." && $folder_b != "index.php")  { $nav_b[]= $folder_b; }
		}
		closedir($handle);
	}
	sort($nav_b);
	$text .= "<ul>";
	foreach ($nav_b as $folder_b){
		$text .= "<li>".(($this_gallery != "$gallery/$folder_a/$folder_b")
                ? "<a href='".e_PLUGIN."md_gallery/md_gallery.php?gallery=$gallery/$folder_a/$folder_b'>".
                ($folder_name[$gallery."/".$folder_a."/".$folder_b] != "" ? $folder_name[$gallery."/".$folder_a."/".$folder_b] : $folder_b)
                ."</a>"
                : "<b>".
                ($folder_name[$gallery."/".$folder_a."/".$folder_b] != "" ? $folder_name[$gallery."/".$folder_a."/".$folder_b] : $folder_b)
                ."</b>")."</li>";
                }
        $text .= "</ul>";
        }


$ns -> tablerender($caption, $text);
?>