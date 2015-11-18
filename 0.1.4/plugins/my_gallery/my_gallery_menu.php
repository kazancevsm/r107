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

//==== Include templates ================================
$tml_file = THEME."my_gallery_tml.php";
include((file_exists($tml_file) ? $tmp_file : e_PLUGIN."my_gallery/my_gallery_tml.php"));
      $search = array("{MG_USER_NAME}",
      		"{MG_USER_GALLERY}",
			"{MG_IMG_TITLE}",
			"{MG_IMG_DESCRIPTION}",
			"{MG_IMG_FILE}",
			"{MG_IMG_GALLERY}",
			"{MG_IMG_SIZE}",
			"{MG_IMG_DOWLOAD}",
			"{MG_IMG_THUMB}",
			"{MG_COMMENTS}",
			"{MG_COMMENT}",
			"{MG_HS_CAPTION}");

// Menu Settings
$caption = $pref['mygallery_menu_caption'];   //give you gallery title/name
$maxwidth = $pref['mygallery_menu_img_size']; //change the width of your image here
$max_foto_w = $pref['mygallery_foto_view_width']; //Image preview size
$max_foto_h = $pref['mygallery_foto_view_height'];
$gallery = $pref['mygallery_folder'];     //Image folder path
$cikle = $pref['mygallery_mine_cikle'];


if ($sql->db_Select("my_gallery", "*", "img_status = 'menu'")) {
      while($row = $sql->db_Fetch()) {
        $folder_name[$row['img_name']] = $row['img_title'];
      }
}

if ($sql->db_Select("my_gallery", "*", "img_status = 'upload'")) {
    $post_upload_list = "";
    while($row = $sql->db_Fetch()) {

            $post_upload_list .= $row['img_name'];

        }

    }

$text = "<!-- ######## Random Image ####### -->";

    for ($j=0; $j<$cikle; $j++) {

        $dir_s = e_PLUGIN."my_gallery/$gallery";
        $a = array();
        if ($handle = opendir($dir_s))
        {
          while (false !== ($file = readdir($handle)))
          {
           if ($file != "." && $file != ".." && $file != "index.php")  $a[] = $file;
          }
        closedir($handle);
        }
        $count = sizeof($a);
        $r = rand(0,$count-1);
        $folder_a = $a[$r];

        $dir_s .= "/$folder_a";
        $a = array();
        if ($handle = opendir($dir_s))
        {
          while (false !== ($file = readdir($handle)))
          {
           if ($file != "." && $file != ".." && $file != "index.php")  $a[] = $file;
          }
        closedir($handle);
        }
        $count = sizeof($a);
        $r = rand(0,$count-1);
        $folder_b = $a[$r];

        $dir_s .= "/$folder_b";
        $a = array();
        if ($handle = opendir($dir_s))
        {
          while (false !== ($file = readdir($handle)))
          {
            $str_tn = substr_count("$file", "tn_") + substr_count("$file", "tv_");
        	$str_type = substr_count("$file", ".jpg") + substr_count("$file", ".JPG") + substr_count("$file", ".jpeg") + substr_count("$file", ".JPEG");
        	$post_upload = substr_count("$post_upload_list", "$file");
        	if ($str_type != 0 && $str_tn != 1 && $post_upload == 0)
        	   {
        	   $a[]=$file;
               }
          }
        closedir($handle);
        }
        $count = sizeof($a);
        $r = rand(0,$count-1);
        $file = $a[$r];

        if ($file != "") {	        $img_url = "".$gallery."/".$folder_a."/".$folder_b."/".$file."";

	        $info = getimagesize(e_PLUGIN."my_gallery/".$img_url);

	        $img_title = "";
	        $img_description = "";
	        $img_user_id = "";
	        $img_user = "";
	        $img_user_mail = "";
	        $comm_id = "add";
	        $c_count = 0;

	        	if ($sql->db_Select("my_gallery", "*", "img_name = '".$img_url."'")) {
	                while($row = $sql->db_Fetch()) {
	                    $comm_id = $row['img_id'];
	                    $img_title = $row['img_title'];
	                    $img_description = $row['img_description'];
	                    list($img_user_id, $img_user, $img_user_mail) = explode(".", $row['img_user']);
	                    if ($img_user_mail != "") $img_user_mail = explode("@", $img_user_mail); else $img_user_name = MYGAL_L070;
	                }

	            }

	    //============== Icon and image slide =============
	    $text .= "<div class='my_gall_rnd_img'>";

        $replace = array("".(($img_user_id != "" and $img_user_id != "0") ? "<a href='".e_HTTP."user.php?id.".$img_user_id."' title='".MYGAL_L084." ".$img_user_name."'>".$img_user_name."</a>" : "")."".(($img_user_id != "" and $img_user_id == "0") ? "<a href='javascript:window.location=\"mai\"+\"lto:\"+\"$img_user_mail[0]\"+\"@\"+\"$img_user_mail[1]\";self.close();'>".$img_user_name."</a>" : "")."",

                    "".(($img_user_id != "" and $img_user_id != "0") ? "<a href='".e_SELF."?user=".$img_user_id."' title='".MYGAL_L083." ".$img_user_name."'>".$img_user_name."</a>" : "")."".(($img_user_id != "" and $img_user_id == "0") ? "<a href='javascript:window.location=\"mai\"+\"lto:\"+\"$img_user_mail[0]\"+\"@\"+\"$img_user_mail[1]\";self.close();'>".$img_user_name."</a>" : "")."",

					"".($img_title != "" ? "".$img_title."" : MYGAL_L085 )."",

					"".($img_description !="" ? "".$img_description."" : MYGAL_L085)."",

					"".$file."",

					"<a href='".e_PLUGIN."my_gallery/my_gallery.php?gallery=".$gallery."/".$folder_a."/".$folder_b."'>".($folder_name[$gallery."/".$folder_a."/".$folder_b] !="" ? $folder_name[$gallery."/".$folder_a."/".$folder_b] : $folder_b)."</a>",

					"".$info[0]."x".$info[1]."",

					"<a href='".e_PLUGIN."my_gallery/dload.php?file=".$gallery."/".$folder_a."/".$folder_b."/".$file."'>".MYGAL_L022."</a>",

					"<a id='thumb_".$file."' alt='".($img_title != "" ? "".$img_title."" : "".MYGAL_L027." ".$file."" )."'
			        title='".($img_description !="" ? "".MYGAL_L037.": ".$img_description."" : "")."'
			        ".(file_exists("".e_PLUGIN."my_gallery/".$gallery."/".$folder_a."/".$folder_b."/tv_".$file."")
			        ? "href='".e_PLUGIN."my_gallery/image.php?file=".$gallery."/".$folder_a."/".$folder_b."/tv_".$file."'"
			        : "href='".e_PLUGIN."my_gallery/foto.php?img=".$gallery."/".$folder_a."/".$folder_b."/".$file."&h=".$max_foto_h."&w=".$max_foto_w."'")."
			        class='highslide' onclick=\"return hs.expand(this, { captionId: 'caption_".$file."' } )\">
			        	<img src='".e_PLUGIN."my_gallery/foto.php?img=".$gallery."/".$folder_a."/".$folder_b."/".$file."&h=".$maxwidth."&w=".$maxwidth."' />
			        </a>",

					"".($pref['mygallery_comments']
					? "<a href='".e_PLUGIN."my_gallery/comments.php?comm_id=".$comm_id."".($comm_id=="add" ? "&img=".$gallery."/".$folder_a."/".$folder_b."/".$file."" : "")."' onclick=\"return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 500} )\" class='highslide'>
					".MYGAL_L045."".$sql->db_Count("comments", "(*)", "WHERE comment_item_id = '".$comm_id."' AND comment_type = 'my_gallery'")."
					</a>
				    <div class='highslide-html-content' id='highslide-html' style='width: 700px'>
				    	<div class='highslide-move' style='border: 0; height: 18px; padding: 2px; cursor: default'>
				    	    <a href='#' onclick='return hs.close(this)' class='control'>".MYGAL_L057."</a>
				            <a href='#' onclick='return false' class='highslide-move control'>".MYGAL_L056."</a>
				    	</div>

				    	<div class='highslide-body'></div>

				    	<div style='text-align: center; border-top: 1px solid silver; padding: 5px 0'>
				    		<small>
				    	    	<i>".$_SERVER["HTTP_HOST"]."</i>
				            </small>
				    	</div>
				    </div>" : "")."
				    ",

					"");

        $mg_hs_caption = str_replace($search, $replace, $MG_RND_HIGHSLIDE_CAPTION);

		$replace[] = "<div class='highslide-caption' id='caption_$file'>".$mg_hs_caption."</div>";

        $text .= str_replace($search, $replace, $MG_IMAGE_RM);

        $text .= "</div>";


        }  else { $c++; if ($c < ($cikle + 20)) $j--; }
    }

$ns -> tablerender($caption, $text);

?>