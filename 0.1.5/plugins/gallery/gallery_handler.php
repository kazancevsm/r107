<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://r107.slog.su
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "gallery"
|     Author: Sunout sunout@mail.ru
|     Home page: http://r107.slog.su
+-----------------------------------------------------------------------------------------------+
*/

$page = $_GET['page'];
$cat = (int)$_GET['cat'];
$id = $_GET['id'];

	$month = date("m");
	$day = date("d");
	$year = date("y");
	$today = mktime(0,0,0,$month,$day,$year);
	$i=0;

	

$mydb = new db();
$mydb1 = new db();
$mydb2 = new db();

//===== Config
$folder = 'albums';
$img_in_page = $pref['gallery_img_in_page'];
$img_rows = $pref['gallery_rows'];
$img_columns = $pref['gallery_columns'];
$img_icon_height = $pref['gallery_img_icon_height'];
$img_icon_width = $pref['gallery_img_icon_widt'];
$img_view_height = $pref['gallery_img_view_height'];
$img_view_width = $pref['gallery_img_view_width'];
$gallery_name = $pref['gallery_gallery_name'];
$title_image = $pref['gallery_title_image'];
$n_position = $pref['gallery_nav_position'];
$tn_scr = "foto.php";

if ($pref['gallery_slide_show']) $tn_scr = "tn_foto.php";
//$caption_nav = MYGAL_L021;
$m_position = $pref['gallery_memo_show'];
$n_show = $pref['gallery_nav_show'];
$sort_type = $pref['gallery_sort_type'];
// --------------------------------------

$gallery = $folder;


//==================== Delete folder function ==================
function deltree($path) {
	if (is_dir($path)) {
		if (version_compare(PHP_VERSION, '5.0.0') < 0) {
			$entries = array();
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) $entries[] = $file;
			closedir($handle);
			}
		} else {
			$entries = scandir($path);
			if ($entries === false) $entries = array(); // just in case scandir fail...
		}
		foreach ($entries as $entry) {
			if ($entry != '.' && $entry != '..') {
				deltree($path.'/'.$entry);
			}
		}
		return rmdir($path);
		} else {
	return unlink($path);
	}
}




//============ Add image script ==================
if (isset($_POST['submit_add_img1'])) {

  if ($_POST['file_name'] && $_POST['file_description'] && $_POST['gallery_sections']) {

    $message = "";

	if (isset($_FILES['file_userfile']['error']))
	{
    	if ($_POST['gallery_sections']) $image_url = $_POST['gallery_sections'];

		require_once(e_HANDLER."upload_handler.php");
		if ($uploaded = file_upload(e_PLUGIN."gallery/".$image_url, "unique"))
		{
			foreach($uploaded as $upload)
			{
			  if ($upload['error'] == 0)
			  {
				if(strstr($upload['type'], "image"))
				{

                  $message .= "".$upload['name']." - img add";

			   		//------------- Create icon -----------------------
				     If ($_POST['mg_icon_create']) {

				        $sourse_file = $image_url.$upload['name'];
				        $dist_file = $image_url."tn_".$upload['name'];

				        $height = $pref['gallery_foto_icon_height'];
				        $width= $pref['gallery_foto_icon_width'];

				   //------------- Create icon in Slide --------------------
				      if ($pref['gallery_slide_show']) {

				        $blank_tn = "images/tn_blank.jpg";

				        list($width_blank, $height_blank) = getimagesize($blank_tn);
				        list($width_orig, $height_orig) = getimagesize($sourse_file);

				        if ($width>$width_orig) { $width=$width_orig; }
				        if ($height>$height_orig) { $height=$height_orig; }
				        if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
				        if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }

				        // Resample
				        $dist_x = ($width_blank - $width)/2;
				        $dist_y = ($height_blank*0.9 - $height)/2;

				        $image_p = imagecreatefromjpeg($blank_tn);

				        // Print Image size
				        $color = imagecolorallocate($image_p, 90, 90, 90);
				        $string = "".$width_orig."x".$height_orig."";
				        imagestring($image_p, 1, 11, $height_blank - 14, $string, $color);

				        $image = imagecreatefromjpeg($sourse_file);
				        imagecopyresampled($image_p, $image, $dist_x, $dist_y, 0, 0, $width, $height, $width_orig, $height_orig);

				        $message .= ", tn_".$upload['name']." (In Slide)";

				      } else {

				        //-------------- Create normal icon ---------------------------
				        list($width_orig, $height_orig) = getimagesize($sourse_file);
				        if ($width>$width_orig) { $width=$width_orig; }
				        if ($height>$height_orig) { $height=$height_orig; }
				        if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
				        if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
				        // Resample

				        $image_p = imagecreatetruecolor($width, $height);
				        $image = imagecreatefromjpeg($sourse_file);
				        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

				        $message .= ", tn_".$upload['name']."";

				      }

				      //----------- Output ----------------
				      imagejpeg($image_p, $dist_file, $pref['gallery_img_quality']);
				      imagedestroy($image_p);
				      imagedestroy($image);

				      $message .= " created";

				     }


                  if ($pref['mg_view_create']) {

					$sourse_file = $image_url.$upload['name'];
					$dist_file = $image_url."tv_".$upload['name'];

					$height = $pref['gallery_foto_view_height'];
					$width= $pref['gallery_foto_view_width'];

					list($width_orig, $height_orig) = getimagesize($sourse_file);
					if ($width>$width_orig) { $width=$width_orig; }
					if ($height>$height_orig) { $height=$height_orig; }
					if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
					if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
					// Resample

					$image_p = imagecreatetruecolor($width, $height);
					$image = imagecreatefromjpeg($sourse_file);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

					// Output
					imagejpeg($image_p, $dist_file, $pref['gallery_img_quality']);
					imagedestroy($image_p);
					imagedestroy($image);

					$message .= ", tv_".$upload['name']." created";

                  }

				    if ($_POST['mg_original_change']) {

				        $sourse_file = $image_url.$upload['name'];
				        $dist_file = $image_url.$upload['name'];

				        $height = $pref['mg_original_size'];
				        $width = $pref['mg_original_size'];

				        list($width_orig, $height_orig) = getimagesize($sourse_file);

				        if ($width_orig > $width or $height_orig > $height) {

				          if ($width>$width_orig) { $width=$width_orig; }
				          if ($height>$height_orig) { $height=$height_orig; }
				          if (($height_orig/$width_orig)<=($height/$width)) { $height=$width*$height_orig/$width_orig; }
				          if (($height_orig/$width_orig)>($height/$width)) { $width=$height*$width_orig/$height_orig; }
				          //------------- Resample -----------

				          $image_p = imagecreatetruecolor($width, $height);
				          $image = imagecreatefromjpeg($sourse_file);
				          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

				          //-------- Output -------------
				          imagejpeg($image_p, $dist_file, $pref['gallery_img_quality']);
				          imagedestroy($image_p);
				          imagedestroy($image);

				          $message .= ", original recreated";

				        }
				    }

				   	$sql_text = array(
	                "img_name" =>           $tp -> toDB($image_url.$upload['name']),
	                "img_title" =>          $tp -> toDB($_POST['file_name']),
	                "img_description" =>    $tp -> toDB($_POST['file_description']),
	                "img_user" =>           $tp -> toDB(USERID.".".USERNAME),
	                "img_status" =>         'public'
	                );

	                if ($sql->db_Insert("gallery", $sql_text)) $message .= ", public in DB";
                    $message .= "<br />";
				}
			  }
			  else
			  {  // Error in uploaded file
			    echo "Error in uploaded file: ".(isset($upload['rawname']) ? $upload['rawname'] : $upload['name'])."<br />";
			  }
			}
		}
	}

    if ($message == "")    $message = "No any line!!!";
    $ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");

  } else {
  		require_once(e_HANDLER."message_handler.php");
		message_handler("ALERT", 5);
   		}
}

?>