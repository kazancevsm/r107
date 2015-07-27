<?php

/*
**
**	Content Rotator - e107 Plugin
**	Author: 		Boudewijn Geiger
**	Version:		1.0
**  Date:			juli-2010
**  copyright: 		20010 by - boedy.net
**  website: 		http://www.boedy.net
**
**  License:		You may not transfer or sub-license,
**					any of my templates or plugins to anyone
**					else without prior written consent
**					from boedy, or when stated otherwise.
**
*/

if (!defined('e107_INIT')) { exit; }

	global $sql, $eArrayStorage;

	if(!is_object($sql)){ $sql = new db; }
	$sql -> db_Select("core", "*", "e107_name='content_rotator' ");
	$row = $sql -> db_Fetch();
	$cr_pref = $eArrayStorage->ReadArray($row['e107_value']);



echo '<link rel="stylesheet" type="text/css" href="'.e_PLUGIN_ABS.'content_rotator/css/galleryview.css" />';
echo '<link rel="stylesheet" type="text/css" href="'.e_PLUGIN_ABS.'content_rotator/fancybox/jquery.fancybox-1.3.1.css" />';

//include javascripts. You can Delete the line that includes jquery, if you already have jquery included in you site
if($cr_pref['cr_jquery'] == true){
echo '
<script>!window.jQuery && document.write(\'<script src="'.e_PLUGIN_ABS.'content_rotator/js/jquery-1.4.2.min.js"><\/script>\')</script>
';
}
echo '<script type="text/javascript" src="'.e_PLUGIN_ABS.'content_rotator/js/jquery.galleryview-2.1.1-pack.js" ></script>';
echo '<script type="text/javascript" src="'.e_PLUGIN_ABS.'content_rotator/js/jquery.timers-1.2.js" ></script>';
echo '<script type="text/javascript" src="'.e_PLUGIN_ABS.'content_rotator/js/jquery.easing.1.3.js" ></script>';
echo '<script type="text/javascript" src="'.e_PLUGIN_ABS.'content_rotator/fancybox/jquery.fancybox-1.3.1.pack.js" ></script>';
echo '<script type="text/javascript" src="'.e_PLUGIN_ABS.'content_rotator/fancybox/jquery.mousewheel-3.0.2.pack.js" ></script>';


// case 0 = default, case 1 = filmstrip only, case 3 = panels only
	switch ($cr_pref['cr_layout']) {
    	case 0:
        	$show_panels = true;
			$show_filmstrip = true;
			$cr_pref['cr_filmstrip_margin'] = '5px';
        	break;
    	case 1:
        	$show_panels = false;
			$show_filmstrip = true;
			$cr_pref['cr_filmstrip_margin'] = '5px';
        	break;
    	case 3:
        	$show_panels = true;
			$show_filmstrip = false;
			$cr_pref['cr_filmstrip_margin'] = '0px';
			$left_panel = 0;
        	break;
	}

//set various styles
echo "<style type='text/css'>
 .gallery{background-color:".$cr_pref['cr_frame_background_color'].";border:".$cr_pref['cr_border'].";padding:".$cr_pref['cr_padding']."px;}
 .panel-content{background-color:".$cr_pref['cr_panel_background_color'].";}
 .panel-content {left:".$left_panel."px;}
 .panel .overlay-background { background:".$cr_pref['cr_overlay_color']."; }
 .panel-overlay h2{ color:".$cr_pref['cr_titel_color']."; }
 .panel-overlay{color:".$cr_pref['cr_overlay_text_color'].";}
 .frame .caption { font-size: 11px; text-align: center; color:".$cr_pref['cr_caption_text_color']."; }
 .frame.current .caption { color:".$cr_pref['cr_caption_text_color_active']."; }
 .panel .panel-overlay { height:".$cr_pref['cr_overlay_height']."px; padding: 0; padding-left:10px; }
 .panel .overlay-background { height:".$cr_pref['cr_overlay_height']."px; padding: 0; }
 .filmstrip { margin:".$cr_pref['cr_filmstrip_margin']."; }";

if($cr_pref['cr_item_buttons_align'] == "Horizontal"){
	echo ".cr_rotator_buttons li{display:inline;}";
	echo ".cr_rotator_buttons{top:".(12+$cr_pref['cr_padding'])."px;right:".(4+$cr_pref['cr_padding'])."px;}";
	
}
else
{
	echo ".cr_rotator_buttons li{display:block;}";
	echo ".cr_rotator_buttons{top:".(4+$cr_pref['cr_padding'])."px;right:".(4+$cr_pref['cr_padding'])."px;}";

}
echo "</style>";
//set the variables for the javascript
echo "<script type='text/javascript'>
	jQuery(document).ready(function(){jQuery('#photos').galleryView({panel_width: $cr_pref[cr_panel_width],panel_height: $cr_pref[cr_panel_height],frame_width: $cr_pref[cr_frame_width],frame_height: $cr_pref[cr_frame_height],overlay_position: '$cr_pref[cr_overlay_position]',	filmstrip_position: '$cr_pref[cr_filmstrip_position]',filmstrip_size: '$cr_pref[cr_filmstrip_size]',transition_speed: $cr_pref[cr_transition_speed],transition_interval: $cr_pref[cr_transition_interval],overlay_opacity: $cr_pref[cr_overlay_opacity],overlay_text_color: '$cr_pref[cr_overlay_text_color]',nav_theme: '$cr_pref[cr_nav_theme]',easing: '$cr_pref[cr_easing]',overlay_easing: '$cr_pref[cr_overlay_easing]',show_captions: '$cr_pref[cr_show_captions]',fade_panels: '$cr_pref[cr_fade_panels]',show_panels: '$show_panels',show_filmstrip: '$show_filmstrip',start_frame: $cr_pref[cr_start_frame],pointer_size: $cr_pref[cr_pointer_size],panel_scale: '$cr_pref[cr_panel_scale]',frame_scale: '$cr_pref[cr_frame_scale]',	frame_gap: $cr_pref[cr_frame_gap],pause_on_hover: '$cr_pref[cr_pause_on_hover]',overlay_easing: '$cr_pref[cr_overlay_easing]',overlay_transition_speed: $cr_pref[cr_overlay_speed],overlay_height: $cr_pref[cr_overlay_height],overlay_speed: $cr_pref[cr_overlay_speed]
});
	});
</script>";

?>