<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "my_gallery"
|     Author: Alex ANP alex-anp@ya.ru
|     Home page: http://e107.seafoxy.ru
|				 http://e107plugins.blogspot.com
+-----------------------------------------------------------------------------------------------+
*/

$lan_file = e_PLUGIN."my_gallery/languages/".e_LANGUAGE.".php";
include_once((file_exists($lan_file) ? $lan_file : e_PLUGIN."my_gallery/languages/English.php"));

function GalleryName($gallery) {
	$mydb = new db();
	if ($mydb->db_Select("my_gallery", "img_title", "img_status = 'menu' and img_name='".$gallery."'")) {
	      while($row = $mydb->db_Fetch()) {
	        $folder_name = $row['img_title'];
	      }
		return $folder_name;
	}
}

function ImageInfo($img_name, $info) {
	list($folder_0, $folder_a, $folder_b, $img_file) = explode("/", $img_name);

	$img_size = getimagesize(e_PLUGIN."my_gallery/".$img_name);

	$img_info = array(
		'gallery' => $folder_0,
		'folder_a' => $folder_a,
		'folder_b' => $folder_b,
		'img_file' => $img_file,
		'img_size' => $img_size[0]."x".$img_size[1]
	);

    $text = $img_info[$info];
	return  $text;
}

function UserInfo($img_user) {	list($img_user_id, $img_user_name, $img_user_mail) = explode(".", $img_user);
	if ($img_user_mail !="") $img_user_mail = explode("@", $img_user_mail);
	if ($img_user_name == "") $img_user_name = MYGAL_L070;
	$text = "".(($img_user_id != "" and $img_user_id != "0") ? "<a href='".e_PLUGIN."my_gallery/my_gallery.php?user=".$img_user_id."' title='".MYGAL_L083."'>".$img_user_name."</a>" : "")."
        ".(($img_user_id != "" and $img_user_id == "0") ? "<a href='javascript:window.location=\"mai\"+\"lto:\"+\"$img_user_mail[0]\"+\"@\"+\"$img_user_mail[1]\";self.close();'>".$img_user_name."</a>" : "")."";

	return $text;
}

$advanced_where = "";  //img_status = 'public'

// The fields that will be returned by the SQL
$return_fields = "img_id, img_name, img_title, img_description, img_user";

// The fields that can be search for matches
$search_fields = array("img_title",
                       "img_description",
                       "img_user",
                       "img_name");

// A weighting for the importance of finding a match in each of the search fields
$weights = array("1.2", "0.8", "1.2", "1.0", "0.8");

// Message to be displayed when no matches found
$no_results = LAN_198;

// The SQL WHERE clause, if any
$where = "1 and ".$advanced_where;

// The SQL ORDER BY columns as a keyed array
$order = array('img_id' => DESC);

// The table(s) to be searched
$table = "my_gallery";

// Perform the search
$ps = $sch->parsesearch($table, $return_fields, $search_fields, $weights,
                        'search_my_gallery', $no_results, $where, $order);

// Assign the results to specific variables
$text .= $ps['text'];
$results = $ps['results'];

// A callback function (name is passed to the parsesearch() function above)
// It is passed a single row from the DB result set
function search_my_gallery($row) {
   global $pref;
   global $con;
	$gallery_path = ImageInfo($row["img_name"], 'gallery')."/".ImageInfo($row["img_name"], 'folder_a')."/".ImageInfo($row["img_name"], 'folder_b');
   // Populate as many of the $res array keys as is sensible for the plugin
   $res['link'] = e_PLUGIN."my_gallery/my_gallery.php?comm_id=".$row["img_id"];
   $res['pre_title'] = "";
   $res['title'] = $row["img_title"];
   $res['pre_summary'] = "
   		<div class='smalltext' style='padding: 2px 0px'>
   		".MYGAL_L046." <a href='".e_PLUGIN."my_gallery/my_gallery.php?gallery=".$gallery_path."'>
   		".GalleryName(ImageInfo($row["img_name"], 'gallery')."/".ImageInfo($row["img_name"], 'folder_a'))."/"
   		.GalleryName($gallery_path)."
		</a></div>
   		<table class='fborder' style='width:100%;'>
   		<tr>
   		<td class='forumheader3' style='width:130px; text-align:center;'>
			<img src='".e_PLUGIN."my_gallery/foto.php?img=".$row["img_name"]."&h=90&w=120'>
   		</td>
   		<td class='forumheader3'>".MYGAL_L037.": ".$row["img_description"]."
   			<br/>".MYGAL_L027." ".ImageInfo($row["img_name"], 'img_file')."
   			<br/>".MYGAL_L026." ".ImageInfo($row["img_name"], 'img_size')."
   			<br/>".MYGAL_L067.": ".UserInfo($row["img_user"])."
   		</td>
   		</tr>
   		</table>
   ";
   $res['summary'] = "".MYGAL_L036.": ".$row["img_title"].", ".MYGAL_L037.": ".$row["img_description"].", ".MYGAL_L067." ".UserInfo($row["img_user"])."";
   $res['detail'] = "<a href='".e_PLUGIN."my_gallery/my_gallery.php?comm_id=".$row["img_id"]."'>http://".$_SERVER["HTTP_HOST"].e_HTTP.$PLUGINS_DIRECTORY."my_gallery/my_gallery.php?comm_id=".$row["img_id"]."</a>";
   return $res;
}
?>