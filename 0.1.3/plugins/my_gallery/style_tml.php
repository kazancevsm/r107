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

$text = array("
<!-- ======== #0 white-10px ============ -->
<script type='text/javascript'>
    hs.graphicsDir = '".e_PLUGIN."my_gallery/highslide/graphics/';
    window.onload = function() {
        hs.preloadImages(5);
    }
</script>

<style type='text/css'>
.highslide {
	cursor: url(".e_PLUGIN."my_gallery/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide img {
	border: 2px solid white;
}
.highslide:hover img {
	border: 2px solid gray;
}

.highslide-image {
	border: 10px solid white;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;
    border: 5px solid white;
    border-top: none;
    padding: 5px;
    background-color: white;
}
.highslide-loading {
    display: block;
	color: white;
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
    text-decoration: none;
	padding: 3px;
	border-top: 1px solid white;
	border-bottom: 1px solid white;
    background-color: black;

    padding-left: 22px;
    background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/loader.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;

}
a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}

.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}
</style>
", "
<!-- ======== #1 no-border ========== -->
<script type='text/javascript'>
    hs.graphicsDir = '".e_PLUGIN."my_gallery/highslide/graphics/';
    window.onload = function() {
        hs.preloadImages(5);
    }
</script>

<style type='text/css'>
.highslide {
	cursor: url(".e_PLUGIN."my_gallery/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide img {
	border: 2px solid silver;
}
.highslide:hover img {
	border: 2px solid gray;
}

.highslide-image {
    border-bottom: 1px solid white;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;

    border-bottom: 1px solid white;
    padding: 5px;
    background-color: silver;
}
.highslide-loading {
    display: block;
	color: white;
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
    text-decoration: none;
	padding: 3px;
	border-top: 1px solid white;
	border-bottom: 1px solid white;
    background-color: black;

    padding-left: 22px;
    background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/loader.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;

}

a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}
.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}
</style>
", "
<!-- =========== #2 outer-glow =========== -->
<script type='text/javascript'>
    hs.graphicsDir = '".e_PLUGIN."my_gallery/highslide/graphics/';
    hs.outlineType = 'outer-glow';
    window.onload = function() {
        hs.preloadImages(5);
    }
</script>

<style type='text/css'>
.highslide {
	cursor: url(".e_PLUGIN."my_gallery/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide img {
	border: 2px solid gray;
}
.highslide:hover img {
	border: 2px solid white;
}

.highslide-image {
	border: 5px solid #444444;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;
    border: 5px solid #444444;
    border-top: none;
    padding: 5px;
    background-color: gray;
}
.highslide-loading {
    display: block;
	color: white;
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
    text-decoration: none;
	padding: 3px;
	border-top: 1px solid white;
	border-bottom: 1px solid white;
    background-color: black;

    padding-left: 22px;
    background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/loader.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;
}
a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}
.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}
</style>
", "
<!-- ========== #3 white-rounded-outline ========= -->
<script type='text/javascript'>
    hs.graphicsDir = '".e_PLUGIN."my_gallery/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    window.onload = function() {
        hs.preloadImages(5);
    }
</script>

<style type='text/css'>
.highslide {
	cursor: url(".e_PLUGIN."my_gallery/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide img {
	border: 2px solid white;
}
.highslide:hover img {
	border: 2px solid gray;
}

.highslide-image {
    border: 2px solid white;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;
    border: 2px solid white;
    border-top: none;
    padding: 5px;
    background-color: white;
}
.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}
.highslide-loading {
    display: block;
	color: white;
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
    text-decoration: none;
	padding: 3px;
	border-top: 1px solid white;
	border-bottom: 1px solid white;
    background-color: black;

    padding-left: 22px;
    background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/loader.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;

}
a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}
</style>
", "
<!-- ======== #4 no-outline ========= -->
<script type='text/javascript'>
    hs.graphicsDir = '".e_PLUGIN."my_gallery/highslide/graphics/';
    hs.outlineType = null;
    window.onload = function() {
        hs.preloadImages();
    }
</script>

<style type='text/css'>
.highslide {
    cursor: url(".e_PLUGIN."my_gallery/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide img {
	border: 2px solid white;
}
.highslide:hover img {
	border: 2px solid gray;
}

.highslide-image {
	border: 2px solid white;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;
    border: 2px solid white;
    border-top: none;
    padding: 5px;
    background-color: white;
}
.highslide-loading {
    display: block;
	color: white;
	font-style: 'MS Sans Serif';
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
    text-decoration: none;
	padding: 3px;
	border-top: 1px solid white;
	border-bottom: 1px solid white;
    background-color: black;

    padding-left: 22px;
    background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/loader.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;

}

a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}
.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}

</style>

", "
<!-- ============= #5 slideshow-controlbar ========== -->
<script type='text/javascript'>
	hs.registerOverlay(
    	{
    		thumbnailId: null,
    		overlayId: 'controlbar',
    		position: 'top right',
    		hideOnMouseOut: true
		}
	);

    hs.graphicsDir = '".e_PLUGIN."my_gallery/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    window.onload = function() {
        hs.preloadImages(5);
    }
</script>

<style type='text/css'>
.highslide {
	cursor: url(".e_PLUGIN."my_gallery/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide img {
	border: 2px solid white;
}
.highslide:hover img {
	border: 2px solid gray;
}

.highslide-image {
    border: 2px solid white;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;
    border: 2px solid white;
    border-top: none;
    padding: 5px;
    background-color: white;
}
.highslide-loading {
    display: block;
	color: white;
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
    text-decoration: none;
	padding: 3px;
	border-top: 1px solid white;
	border-bottom: 1px solid white;
    background-color: black;

    padding-left: 22px;
    background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/loader.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;

}
a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}

.highslide-move {
    cursor: move;
}

.highslide-overlay {
	display: none;
}

/* Controlbar example */
.controlbar {
	background: url(".e_PLUGIN."my_gallery/highslide/graphics/controlbar4.gif);
	width: 167px;
	height: 34px;
}
.controlbar a {
	display: block;
	float: left;
	/*margin: 0px 0 0 4px;*/
	height: 27px;
}
.controlbar a:hover {
	background-image: url(".e_PLUGIN."my_gallery/highslide/graphics/controlbar4-hover.gif);
}
.controlbar .previous {
	width: 50px;
}
.controlbar .next {
	width: 40px;
	background-position: -50px 0;
}
.controlbar .highslide-move {
	width: 40px;
	background-position: -90px 0;
}
.controlbar .close {
	width: 36px;
	background-position: -130px 0;
}


/* Necessary for functionality */
.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}
</style>
");

?>