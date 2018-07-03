<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     $Date: 2007/03/22 $
|     $Author: Alex ANP alex-anp@ya.ru $
+-----------------------------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

$mydb = new db();

if ($mydb->db_Count("plugin", "(*)", "WHERE plugin_path='eHighSlide' AND plugin_installflag=1")) {
	echo "<!-- =========== Used eHighSlide Meta =========== -->\n";
} else {
	include_once(e_PLUGIN."gallery/style_tml.php");

	echo "<script type='text/javascript' src='".e_PLUGIN."gallery/highslide/highslide.js'></script>\n";
	echo "<script type='text/javascript' src='".e_PLUGIN."gallery/highslide/highslide-html.js'></script>\n";

	echo "<script type='text/javascript'>
	    hs.graphicsDir = 'highslide/graphics/';
	    hs.outlineType = 'rounded-white';
	    hs.outlineWhileAnimating = true;
	    hs.objectLoadTime = 'after';
	    window.onload = function() {
	        hs.preloadImages();
	    }
	</script>
	";
	echo "
	<style type='text/css'>

	.highslide-html {
	    background-color: white;
	}
	.highslide-html-content {
		position: absolute;
	    display: none;
	}
	.highslide-loading {
	    display: block;
		color: black;
		font-size: 8pt;
		font-family: sans-serif;
		font-weight: bold;
	    text-decoration: none;
		padding: 2px;
		border: 1px solid black;
	    background-color: white;

	    padding-left: 22px;
	    background-image: url(".e_PLUGIN."gallery/highslide/graphics/loader.white.gif);
	    background-repeat: no-repeat;
	    background-position: 3px 1px;
	}

	.control {
		float: right;
	    display: block;
	    /*position: relative;*/
		margin: 0 5px;
		font-size: 9pt;
	    font-weight: bold;
		text-decoration: none;
		text-transform: uppercase;
		color: #999;
	}
	.control:hover {
		color: black !important;
	}
	.highslide-move {
	    cursor: move;
	}

	.highslide-display-block {
	    display: block;
	}
	.highslide-display-none {
	    display: none;
	}
	</style>
	";

	echo $text[$pref['gallery_hs_theme']];
}

	if (file_exists(THEME."gallery.css")) {
		echo "<link href='".THEME."gallery.css' rel='stylesheet' type='text/css'>\n";
		} else {
			echo "<link href='".e_PLUGIN."gallery/gallery.css' rel='stylesheet' type='text/css'>\n";
			}

?>