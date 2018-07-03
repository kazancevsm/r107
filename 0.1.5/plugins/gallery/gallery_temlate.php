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

//========== SC Description ======================
/*
	{MG_USER_NAME} - upload image user name link
	{MG_USER_GALLERY} - user gallery link
	{MG_IMG_TITLE} - image title
	{MG_IMG_DESCRIPTION} - image description
	{MG_IMG_FILE} - image file name
	{MG_IMG_GALLERY} - Gallery link
	{MG_IMG_SIZE} - image size in px
	{MG_IMG_DOWLOAD} - image download link
	{MG_IMG_THUMB} - thumb image
	{MG_COMMENTS} - comments link
	{MG_COMMENT} - comment text
	{MG_HS_CAPTION} - HighSlide caption
*/

//==== HighSlide caption ======================
$MG_HIGHSLIDE_CAPTION = "".MYGAL_L067.": {MG_USER_NAME}
    <br/>".MYGAL_L036.": {MG_IMG_TITLE}
    <br/>".MYGAL_L037.": {MG_IMG_DESCRIPTION}
    <br/>".MYGAL_L046." {MG_IMG_GALLERY}
    <br/>".MYGAL_L026." {MG_IMG_SIZE} {MG_IMG_DOWLOAD}
";

$MG_LAST_HIGHSLIDE_CAPTION = "".MYGAL_L067.": {MG_USER_GALLERY}
    <br/>".MYGAL_L036.": {MG_IMG_TITLE}
    <br/>".MYGAL_L037.": {MG_IMG_DESCRIPTION}
";

$MG_COMMENTS_HIGHSLIDE_CAPTION = "".MYGAL_L067.": {MG_USER_GALLERY}
    <br/>".MYGAL_L036.": {MG_IMG_TITLE}
    <br/>".MYGAL_L037.": {MG_IMG_DESCRIPTION}
";

$MG_RND_HIGHSLIDE_CAPTION = "".MYGAL_L036.": {MG_IMG_TITLE}
    <br/>".MYGAL_L037.": {MG_IMG_DESCRIPTION}
    <br/>".MYGAL_L046." {MG_IMG_GALLERY}
";

//==== Last gallery image =======================
$MG_LAST_IMG = "{MG_IMG_THUMB}{MG_HS_CAPTION}
    <br/>{MG_IMG_TITLE}
	<br/>".MYGAL_L067." {MG_USER_GALLERY}
	<br/>{MG_COMMENTS}
";

//==== Last comments image =====================
$MG_LAST_COMMENT = "
	<div style='clear:both;'>
		<div style='float:left; margin: 0 3px; padding: 2px;'>
			{MG_IMG_THUMB}{MG_HS_CAPTION}
		</div>
			<div class='mygall_folder_a' style='margin: 0 0 0 135px; text-align:left;'>
				{MG_IMG_TITLE}
			</div>
			<div style='text-align:left; padding: 3px;'>
				{MG_COMMENT}
			</div>
			<div class='mygall_folder_b' style='text-align:right;'>
				".MYGAL_L067." {MG_USER_NAME} {MG_COMMENTS}
			</div>
	</div>
";

//==== Random image =====================
$MG_RANDOM_IMG = "{MG_IMG_THUMB}{MG_HS_CAPTION}
    <br/>{MG_IMG_TITLE}
    <br/>{MG_IMG_GALLERY}
	<br/>{MG_COMMENTS}
";

//==== Galleru image
$MG_IMAGE = "{MG_IMG_THUMB}{MG_HS_CAPTION}
    <br/>{MG_IMG_TITLE}
	<br/>{MG_COMMENTS}
";

//==== User gallery image ========
$MG_IMAGE_UG = $MG_IMAGE;

//==== Random image menu ========
$MG_IMAGE_RM = $MG_IMAGE;

?>