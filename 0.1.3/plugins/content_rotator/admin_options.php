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

require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
$rs = new form;
e107_require_once(e_HANDLER.'arraystorage_class.php');
$eArrayStorage = new ArrayData();
unset($text);

$lan_file = e_PLUGIN."content_rotator/languages/".e_LANGUAGE.".php";
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."content_rotator/languages/English.php");

if(isset($_POST['update_content_rotator'])){
	$message = updatecr_prefs();
}

function updatecr_prefs(){
	global $sql, $eArrayStorage, $tp;
	while(list($key, $value) = each($_POST)){
		foreach($_POST as $k => $v){
			if(strpos($k, "cr_") === 0){
				$cr_pref[$k] = $tp->toDB($v);
			}
		}
	}
	$tmp = $eArrayStorage->WriteArray($cr_pref);
	$sql -> db_Update("core", "e107_value='$tmp' WHERE e107_name='content_rotator' ");

	$message = LAN_C_ROTATOR_GENERAL_2;
	return $message;
}

function getDefaultcr_prefs(){
		$cr_pref['cr_jquery']					= 'true';
		$cr_pref['cr_layout']					= '0';
		$cr_pref['cr_panel_width']				= '800';
		$cr_pref['cr_panel_height']				= '300';
		$cr_pref['cr_panel_background_color']	= 'white';
		$cr_pref['cr_frame_width']				= '80';
		$cr_pref['cr_frame_height']				= '80';
		$cr_pref['cr_overlay_height']			= '70';
		$cr_pref['cr_overlay_font_size'] 		= '1em';
		$cr_pref['cr_overlay_position']			= 'bottom';
		$cr_pref['cr_filmstrip_position'] 		= 'bottom';
		$cr_pref['cr_filmstrip_size'] 			= '';
		$cr_pref['cr_transition_speed']			= '1000';
		$cr_pref['cr_transition_interval']		= '6000';
		$cr_pref['cr_overlay_opacity']			= '0.6';
		$cr_pref['cr_titel_color']				= 'white';
		$cr_pref['cr_overlay_color']			= 'black';
		$cr_pref['cr_background_color']			= 'black';
		$cr_pref['cr_overlay_text_color']		= 'white';
		$cr_pref['cr_caption_text_color']		= 'yellow';
		$cr_pref['cr_caption_text_color_active']= 'white';
		$cr_pref['cr_border']					= '1px solid black';
		$cr_pref['cr_nav_theme']				= 'light';
		$cr_pref['cr_easing']					= 'swing';
		$cr_pref['cr_show_captions']			= 'false';
		$cr_pref['cr_fade_panels']				= 'true';
		$cr_pref['cr_show_panels']				= 'true';
		$cr_pref['cr_show_filmstrip']			= 'true';
		$cr_pref['cr_start_frame']				= '1';
		$cr_pref['cr_pointer_size']				= '5';
		$cr_pref['cr_panel_scale']				= 'crop';
		$cr_pref['cr_frame_scale']				= 'crop';
		$cr_pref['cr_frame_gap']				= '5';
		$cr_pref['cr_padding']					= '0';
		$cr_pref['cr_frame_background_color']	= '#ccc';
		$cr_pref['cr_pause_on_hover']			= 'false';
		$cr_pref['cr_d_javascript_image']		= '';
		$cr_pref['cr_item_buttons']				= 'true';
		$cr_pref['cr_item_count']				= '';
		$cr_pref['cr_item_count_align']			= 'Horizontal';
		$cr_pref['cr_display_order']			= 'desc';
		$cr_pref['cr_default_thumbnail']		= '';
		$cr_pref['cr_overlay_easing']			= 'easeOutBounce';
		$cr_pref['cr_overlay_speed']			= '1000';
		$cr_pref['cr_item_buttons_align']		= 'Horizontal';
		
		


		
		return $cr_pref;
}



function getcr_prefs(){
	global $sql, $eArrayStorage;

	if(!is_object($sql)){ $sql = new db; }
	$num_rows = $sql -> db_Select("core", "*", "e107_name='content_rotator' ");
	if($num_rows == 0){
		$tmp = getDefaultcr_prefs();
		$tmp2 = $eArrayStorage->WriteArray($tmp);
		$sql -> db_Insert("core", "'content_rotator', '".$tmp2."' ");
		$sql -> db_Select("core", "*", "e107_name='content_rotator' ");
	}
	$row = $sql -> db_Fetch();
	$cr_pref = $eArrayStorage->ReadArray($row['e107_value']);
	return $cr_pref;
}

if(isset($message)){
	$caption = LAN_C_ROTATOR_GENERAL_1;
	$ns -> tablerender($caption, $message);
}

$cr_pref = getcr_prefs();

if(!is_object($sql)){ $sql = new db; }
   //<input type='radio' value='".$form_value."'".$name.$checked.$tooltip.$form_js." />
   $text = "
   <table style='width:800px' class='forumheader'>
   ".$rs -> form_open("post", e_SELF, "content_rotator_form", "", "enctype='multipart/form-data'")."
   	<tr>
		<td class='forumheader3'>
			".LAN_C_ROTATOR_ADMIN_64."
		</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_checkbox("cr_jquery", "true",($cr_pref['cr_jquery'] == "true" ? "1" : "0") )."</td>

	</tr>
	<tr>
		<td class='forumheader3'>
			".LAN_C_ROTATOR_ADMIN_6."
		</td>
		<td class='forumheader3'>
			".$rs -> form_radio("cr_layout", "0", ($cr_pref['cr_layout'] == 0 ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_7."
			".$rs -> form_radio("cr_layout", "1", ($cr_pref['cr_layout'] == 1 ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_8."
			".$rs -> form_radio("cr_layout", "3", ($cr_pref['cr_layout'] == 3 ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_35."
		</td>
	</tr>
   	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_49."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_item_count", 10, $cr_pref['cr_item_count'], 50)."</td>
	</tr>
   	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_10."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_panel_width", 10, $cr_pref['cr_panel_width'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
   	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_11."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_panel_height", 10, $cr_pref['cr_panel_height'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
   	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_12."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_frame_width", 10, $cr_pref['cr_frame_width'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
   	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_13."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_frame_height", 10, $cr_pref['cr_frame_height'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
	 <tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_9."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_overlay_height", 10, $cr_pref['cr_overlay_height'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
   	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_14."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_panel_scale", "crop", ($cr_pref['cr_panel_scale'] == "crop" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_42."
			".$rs -> form_radio("cr_panel_scale", "nocrop", ($cr_pref['cr_panel_scale'] == "nocrop" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_43."
		</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_15."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_frame_scale", "crop", ($cr_pref['cr_frame_scale'] == "crop" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_42."
			".$rs -> form_radio("cr_frame_scale", "nocrop", ($cr_pref['cr_frame_scale'] == "nocrop" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_43."
		</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_56."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_display_order", "desc", ($cr_pref['cr_display_order'] == "desc" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_57."
			".$rs -> form_radio("cr_display_order", "asc", ($cr_pref['cr_display_order'] == "asc" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_58."
	</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_40."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_start_frame", 10, $cr_pref['cr_start_frame'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_16."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_overlay_position", "top", ($cr_pref['cr_overlay_position'] == "top" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_17."
			".$rs -> form_radio("cr_overlay_position", "bottom", ($cr_pref['cr_overlay_position'] == "bottom" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_18."
	</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_34."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_filmstrip_position", "top", ($cr_pref['cr_filmstrip_position'] == "top" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_17."
			".$rs -> form_radio("cr_filmstrip_position", "bottom", ($cr_pref['cr_filmstrip_position'] == "bottom" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_18."
			".$rs -> form_radio("cr_filmstrip_position", "left", ($cr_pref['cr_filmstrip_position'] == "left" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_53."
			".$rs -> form_radio("cr_filmstrip_position", "right", ($cr_pref['cr_filmstrip_position'] == "right" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_54."
	</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_36."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_filmstrip_size", 10, $cr_pref['cr_filmstrip_size'], 50)." ".LAN_C_ROTATOR_ADMIN_60."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_19."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_transition_speed", 10, $cr_pref['cr_transition_speed'], 50)." ".LAN_C_ROTATOR_ADMIN_61."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_20."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_transition_interval", 10, $cr_pref['cr_transition_interval'], 50)." ".LAN_C_ROTATOR_ADMIN_61."</td>
	</tr>";

	$easinglist=array("swing","easeOutQuad","easeInQuad","easeInOutQuad","easeInCubic","easeOutCubic","easeInOutCubic","easeInQuart","easeOutQuart","easeInOutQuart","easeInQuint","easeOutQuint","easeInOutQuint","easeInSine","easeOutSine","easeInOutSine","easeInExpo","easeOutExpo","easeInOutExpo","easeInCirc","easeOutCirc","easeInOutCirc","easeInElastic","easeOutElastic","easeInOutElastic","easeInBack","easeOutBack","easeInOutBack","easeInBounce","easeOutBounce","easeInOutBounce");
	$text .= "
	<tr>
		<td class='forumheader3' style='width:30%; white-space:nowrap;'>".LAN_C_ROTATOR_ADMIN_30."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_select_open("cr_easing");
			foreach($easinglist as $easing){
				$text .= $rs -> form_option($easing, ($cr_pref['cr_easing'] == $easing ? "1" : "0"), $easing);
			}
			$text .= $rs -> form_select_close()."
		</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:30%; white-space:nowrap;'>".LAN_C_ROTATOR_ADMIN_63."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_select_open("cr_overlay_easing");
			foreach($easinglist as $easing){
				$text .= $rs -> form_option($easing, ($cr_pref['cr_overlay_easing'] == $easing ? "1" : "0"), $easing);
			}
			$text .= $rs -> form_select_close()."
		</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_65."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_overlay_speed", 10, $cr_pref['cr_overlay_speed'], 50)." ".LAN_C_ROTATOR_ADMIN_61."</td>
	</tr>

	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_47."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_d_javascript_image", 70, $cr_pref['cr_d_javascript_image'], 150)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_62."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_default_thumbnail", 70, $cr_pref['cr_default_thumbnail'], 150)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_48."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_checkbox("cr_item_buttons", "true",($cr_pref['cr_item_buttons'] == "true" ? "1" : "0") ).LAN_C_ROTATOR_ADMIN_66."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_50."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_item_buttons_align", "Horizontal", ($cr_pref['cr_item_buttons_align'] == "Horizontal" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_51."
			".$rs -> form_radio("cr_item_buttons_align", "Vertical", ($cr_pref['cr_item_buttons_align'] == "Vertical" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_52."
		</td>
	</tr>

	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_31."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_checkbox("cr_show_captions", "true",($cr_pref['cr_show_captions'] == "true" ? "1" : "0") )."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_32."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_checkbox("cr_fade_panels", "true",($cr_pref['cr_fade_panels'] == "true" ? "1" : "0") )."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_33."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_checkbox("cr_pause_on_hover", "true",($cr_pref['cr_pause_on_hover'] == "true" ? "1" : "0") )."</td>
	</tr>
	<tr>
		<td colspan='2' style='text-align:center' class='forumheader1'><strong>Styling</strong></td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_38."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_panel_background_color", 10, $cr_pref['cr_panel_background_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_21."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_overlay_opacity", 10, $cr_pref['cr_overlay_opacity'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_22."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_overlay_color", 10, $cr_pref['cr_overlay_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_23."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_frame_background_color", 10, $cr_pref['cr_frame_background_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_39."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_frame_gap", 10, $cr_pref['cr_frame_gap'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_41."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_pointer_size", 10, $cr_pref['cr_pointer_size'], 50)." ".LAN_C_ROTATOR_ADMIN_59."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_45."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_titel_color", 10, $cr_pref['cr_titel_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_24."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_overlay_text_color", 10, $cr_pref['cr_overlay_text_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_25."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_caption_text_color", 10, $cr_pref['cr_caption_text_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_46."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_caption_text_color_active", 10, $cr_pref['cr_caption_text_color_active'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_44."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_padding", 10, $cr_pref['cr_padding'], 50)." ".LAN_C_ROTATOR_ADMIN_59."
		</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_26."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_border", 10, $cr_pref['cr_border'], 50)."
		</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_27."</td>
		<td class='forumheader3' style='width:70%;'>
			".$rs -> form_radio("cr_nav_theme", "light", ($cr_pref['cr_nav_theme'] == "light" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_28."
			".$rs -> form_radio("cr_nav_theme", "dark", ($cr_pref['cr_nav_theme'] == "dark" ? "1" : "0"), "", "").LAN_C_ROTATOR_ADMIN_29."
		</td>
	</tr>

		
	
	<tr>
		<td style='text-align:center' class='forumheader' colspan='2'>".$rs -> form_button("submit", "update_content_rotator", LAN_C_ROTATOR_ADMIN_67)."</td>
	</tr>
	</table>
	".$rs -> form_close()."

	";
	

   
   
      // The usual, tell e107 what to include on the page
   $ns->tablerender("Options", $text);

   require_once(e_ADMIN."footer.php");

?>