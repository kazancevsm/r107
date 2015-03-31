<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     r107 website system  : http://r107.pro
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "Content Rotator"  Author: Boedy - info@boxfish.org
|     Support OSGroup.pro
|     http://r107.pro support@r107.pro
+-----------------------------------------------------------------------------------------------+
*/

require_once("../../class2.php");
require_once(e_HANDLER."ren_help_handler.php");
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");

if (!getperms("P")) {
	header("location:".e_HTTP."index.php");
	exit;
}

if (e_QUERY) {
		$tmp = explode (".", e_QUERY);
		$action     = $tmp[0];
		$sub_action = $tmp[1];
		$type       = $tmp[2];
		$id	    = $tmp[3];
	}
//-----------------
//	GENERAL
//-----------------

if((!isset($action)) || (isset($action) && $action == "general")){



$i = 0;
	$sql->db_Select("c_rotator","*", "ORDER BY cr_sequence DESC", false);
	while($row = $sql -> db_Fetch()) {
		$cr_id[$i] 		= $row[cr_id];
		$cr_title[$i] 		= $row[cr_title];
		$cr_intro[$i]		= $row[cr_intro];
		$cr_text[$i]		= $row[cr_text];
		$cr_image[$i]		= $row[cr_image];
		$cr_thumbnail[$i]	= $row[cr_thumbnail];
		$cr_captions[$i]	= $row[cr_captions];
		$link[$i]		= $row[cr_link];
		$cr_sequence[$i]      	= $row[cr_sequence];
	$i++;
	}
	
	
	
	$text .= "
		<script type='text/javascript'>
		$(document).ready(function() {";
						
	for ($i = 0; $i < count($cr_id); $i++){	
	if($cr_text[$i] != ""){			
	$text .= "	$('#cr_textbox".$i."').fancybox({
				'autoScale'		: true,
				'width'			: 950
			});";
	}
	}
	$text .= "
		});
	</script>


	<table class='fborder' style='margin-top:20px;width: 95%'>
		<tr>
			<td style='width:5%' class='fcaption'>".LAN_C_ROTATOR_ID."</td>
			<td style='width:20%' class='fcaption'>".LAN_C_ROTATOR_CAPTION."</td>
			<td style='width:20%' class='fcaption'>".LAN_C_ROTATOR_OVT."</td>
			<td style='width:30%' class='fcaption'>".LAN_C_ROTATOR_MENU_2."</td>
			<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_MENU_3."</td>
			<td style='width:30%' class='fcaption'>".LAN_C_ROTATOR_MENU_8."</td>
			<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_LINK."</td>
			<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_MENU_4."</td>
			<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_OPTION."</td>
		</tr>";
	for ($i = 0; $i < count($cr_id); $i++)
	{
	if($cr_text[$i] != ""){$type = "html";}else{$type = "pic";}
	if($cr_image[$i] != ""){$cr_image[$i] = "<img style='max-width:300px;' src='".$cr_image[$i]."' />";}
	if($cr_thumbnail[$i] != ""){$cr_thumbnail[$i] = "<img style='max-width:100px;' src='".$cr_thumbnail[$i]."' />";} 
	$text .= "<tr style='border:solid 1px #000;height:40px;'>
				<td class='forumheader3'>
			 		".$cr_sequence[$i]."
				</td>
				<td class='forumheader3'>
			 		".$cr_title[$i]."
				</td>
				<td class='forumheader3'>
			 		".$cr_intro[$i]."
				</td>
				<td class='forumheader3'>";
	if($cr_text[$i] != ""){			
	$text .= 	"<a id='cr_textbox".$i."' href='#cr_textbox_field".$i."' title='".$cr_title[$i]."'>".LAN_C_ROTATOR_ADMIN_55."</a>
                <div style='display: none;'>
					<div id='cr_textbox_field".$i."' style='width:".$cr_pref['cr_panel_width']."px;height:".$cr_pref['cr_panel_height']."px;overflow:auto;'>
						".$newtext = $tp->toHTML($cr_text[$i], true)."
                	</div>
				</div>";
	}
	$text .= 	"</td>
				<td class='forumheader3'>
					".$cr_image[$i]."
				</td>
				<td class='forumheader3'>
					".$cr_thumbnail[$i]."
				</td>
				<td class='forumheader3'>
					".$cr_captions[$i]."
				</td>
				<td class='forumheader3'>
					" .$link[$i]."
				</td>
				<td class='forumheader3'>
					<a href='admin_config.php?add.edit_$type.".$cr_id[$i]."'><img src='".e_IMAGE."admin/edit_16.png' alt='Edit' title='Edit' /></a>
					<a href='admin_config.php?add.delete.".$cr_id[$i]."'><img src='".e_IMAGE."admin/delete_16.png' alt='Delete' title='Delete' /></a>
					<br/>
					".LAN_C_ROTATOR_MENU_10.":<br/>";
	if($cr_sequence[$i] != count($id))
	$text .= "				<a href='handlers/order.php?moveup.".$cr_id[$i].".".$cr_sequence[$i]."'><img src='".e_IMAGE."admin/up.png' alt='Edit' title='Edit' /></a>";
    if($cr_sequence[$i] != 1)
	$text .= "				<a href='handlers/order.php?movedown.".$cr_id[$i].".".$cr_sequence[$i]."'><img src='".e_IMAGE."admin/down.png' alt='Delete' title='Delete' /></a>";

	$text .="		</td>
			</tr>";
	}
	$text .= "</table>";
	
   // The usual, tell e107 what to include on the page
   $ns->tablerender("Add items", $text);

   require_once(e_ADMIN."footer.php");
   
}





//-----------------------
// 	ADD
//-----------------------


if((isset($action) && $action == "add")){


if(isset($_POST['create_CR']))
{
		
	$cr_title = $_POST['cr_title'];
	$cr_intro = $_POST['cr_intro'];
	$cr_text  = $_POST['cr_text'];
	$cr_image = $_POST['cr_image'];
	$cr_thumbnail = $_POST['cr_thumbnail'];
	$cfcaptions = $_POST['cfcaptions'];
	$cr_link  = $_POST['cr_link'];
		$sql->db_Select("c_rotator", "max(cr_sequence)+1", "", "no-where");
		$row = $sql->db_Fetch();
			$cr_text = str_replace("'", "&#39;", "$cr_text");
			$sql->db_Insert("c_rotator", "0, ''$row[0]', $cr_title', '$cr_intro', '$cr_text', '$cr_image', '$cr_thumbnail', '$cfcaptions', '$cr_link'");
			

}
	
if(isset($_POST['update_CR']))
{	
		
			$cr_title = $_POST['cr_title'];
			$cr_intro = $_POST['cr_intro'];
			$cr_text  = $_POST['cr_text'];
			$cr_image = $_POST['cr_image'];
			$cr_link  = $_POST['cr_link'];
			$cr_thumbnail  = $_POST['cr_thumbnail'];
			$cfcaptions = $_POST['cfcaptions'];
			$cr_id	= $_POST['cr_id'];
			
			$sql->db_Update("c_rotator", "cr_title='$cr_title', cr_intro='$cr_intro', cr_text='$cr_text', cr_image='$cr_image', cr_thumbnail='$cr_thumbnail', cr_captions='$cfcaptions', cr_link='$cr_link' WHERE cr_id='$cr_id'");
				header("location: admin_view_entrees.php");	

}
	
	if($action == "edit") {
	
	$sql->db_Select("c_rotator", "*","id ='$nr'");
	while($row = $sql -> db_Fetch()) {
	$cr_title = $row[cr_title];
	$cr_intro = $row[cr_intro];
	$cr_text = $row[cr_text];
	$cr_image = $row[cr_image];
	$cr_thumbnail = $row[cr_thumbnail];
	$cfcaptions = $row[cr_captions];
	$cr_link = $row[cr_link];
	$cr_id = $nr;
	
	
	}
	
	$message = LAN_C_ROTATOR_ADMIN_5;
	}
	
	
	if($action == "delete") {
        $sql->db_Update("c_rotator", "cr_sequence=cr_sequence-1 WHERE cr_sequence > (select cr_sequence from (select * from ".MPREFIX."c_rotator) as c1 where c1.cr_id =$nr)");
        $sql->db_Delete("c_rotator", "cr_id='$nr'");
	header("location: admin_view_entrees.php");
	}
	
	
	
	$i = 0;
	$sql->db_Select("c_rotator","*", "ORDER BY id DESC", false);
	while($row = $sql -> db_Fetch()) {
	$cr_id[$i] 	= $row[cr_id];
	$cr_title[$i] 	= $row[cr_title];
	$cr_intro[$i]	= $row[cr_intro];
	$cr_text[$i]	= $row[cr_text];
	$cr_image[$i]	= $row[cr_image];
	$cr_thumbnail[$i]	= $row[cr_thumbnail];
	$cr_captions[$i]	= $row[cr_captions];
	$link[$i]	= $row[cr_link];
	$i++;
	}
	
   

	if ($message != '')
	$error = "<tr><td colspan='2' style='text-align:center;height40px;border:dashed 1px #000;padding:5px;'>$message</td></tr>";
	
	
	$text = "<div style='text-align:center; width:100%'>
	<table>
		<tr>
			<td><a href='".e_SELF."?add.edit_pic'><img title='Add image' alt='' src='images/image_add.png' /></a></td>
			<td><a href='".e_SELF."?add.edit_pic'>Add a picture</a></td>
		<tr>
			<td><a href='".e_SELF."?add.edit_html'><img title='Add html page' alt='' src='images/html_add.png' /></a></td>
			<td><a href='".e_SELF."?add.edit_html'>Add a html entree</a></td>
		</tr>
	</table>
  
  </div>";
	
if(isset($_GET['sub_action']) && $_GET['sub_action'] == 'pic' || ($sub_action == "edit" && $type == 'pic')){
   // Our informative text
   $text = "
<form method='post' action='".e_SELF."'>\n
   <table style='width:800px;'>
		".$error."
   	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_1."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cr_title' style='width: 100%' value='$cr_title' maxlength='200' />
		</td>
	</tr>
   	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_7."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<textarea  name='cr_intro' style='width: 100%'  rows='4' onselect=\"storeCaret(this);\" onclick=\"storeCaret(this);\" onkeyup=\"storeCaret(this);\">$cr_intro</textarea><br />";
		$text .= display_help('helpb')."
		</td>
	</tr>
	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_3."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cr_image' style='width: 100%' value='$cr_image' maxlength='200' />
		</td>
	</tr>
	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_8."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cr_thumbnail' style='width: 100%' value='$cr_thumbnail' maxlength='200' />
		</td>
	</tr>
	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_9."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cfcaptions' style='width: 100%' value='$cfcaptions' maxlength='200' />
		</td>
	</tr>
	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_4."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cr_link' style='width: 100%' value='$cr_link' maxlength='200' />
		</td>
	</tr>
	<tr style='vertical-align:top'>
		<td colspan='2' style='text-align:center' class='forumheader'>
			".($action == "edit" ? "<input type='hidden' name='cr_id' value='$cr_id' />" : "")."

		<input class='button' type='submit' name='".($action == "edit" ? "update_CR" : "create_CR")."'  value='".($action == "edit" ? LAN_C_ROTATOR_ADMIN_3 : LAN_C_ROTATOR_ADMIN_1)."' />
		</td>
	</tr>
	</table>
</form>";
};

if(isset($_GET['sub_action']) && $_GET['sub_action'] == 'html' || $sub_action == 'edit_html' ){
   // Our informative text
   $text = "
<form method='post' action='".e_SELF."'>\n
   <table style='width:800px;'>
		".$error."
   	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_1."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cr_title' style='width: 100%' value='$cr_title' maxlength='200' />
		</td>
	</tr>
   	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_2."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<textarea  name='cr_text' style='width: 100%'  rows='6' onselect=\"storeCaret(this);\" onclick=\"storeCaret(this);\" onkeyup=\"storeCaret(this);\">$cr_text</textarea><br />";
		$text .= display_help('helpb')."
		</td>
	</tr>
	<tr>
		<td style='width:30%' class='forumheader3'>".LAN_C_ROTATOR_MENU_8."</td>
		<td style='width:70%; text-align: left;' class='forumheader3'>
		<input class='tbox' type='text' name='cr_thumbnail' style='width: 100%' value='$cr_thumbnail' maxlength='200' />
		</td>
	</tr>
	<tr style='vertical-align:top'>
		<td colspan='2' style='text-align:center' class='forumheader'>
			".($action == "edit" ? "<input type='hidden' name='cr_id' value='$cr_id' />" : "")."

		<input class='button' type='submit' name='".($action == "edit" ? "update_CR" : "create_CR")."'  value='".($action == "edit" ? LAN_C_ROTATOR_ADMIN_3 : LAN_C_ROTATOR_ADMIN_1)."' />
		</td>
	</tr>
	</table>
</form>";
};

// The usual, tell e107 what to include on the page
   $ns->tablerender("Add items", $text);

   require_once(e_ADMIN."footer.php");

}   
   

//-----------------------
// 	OPTIONS
//-----------------------

if((isset($action) && $action == "config")){

$rs = new form;
e107_require_once(e_HANDLER.'array_storage_handler.php');
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
		$cr_pref['cr_jquery']			= 'true';
		$cr_pref['cr_layout']			= '0';
		$cr_pref['cr_panel_width']		= '800';
		$cr_pref['cr_panel_height']		= '300';
		$cr_pref['cr_panel_background_color']	= 'white';
		$cr_pref['cr_frame_width']		= '80';
		$cr_pref['cr_frame_height']		= '80';
		$cr_pref['cr_overlay_height']		= '70';
		$cr_pref['cr_overlay_font_size'] 	= '1em';
		$cr_pref['cr_overlay_position']		= 'bottom';
		$cr_pref['cr_filmstrip_position'] 	= 'bottom';
		$cr_pref['cr_filmstrip_size'] 		= '';
		$cr_pref['cr_transition_speed']		= '1000';
		$cr_pref['cr_transition_interval']	= '6000';
		$cr_pref['cr_overlay_opacity']		= '0.6';
		$cr_pref['cr_titel_color']		= 'white';
		$cr_pref['cr_overlay_color']		= 'black';
		$cr_pref['cr_background_color']		= 'black';
		$cr_pref['cr_overlay_text_color']	= 'white';
		$cr_pref['cfcaption_text_color']	= 'yellow';
		$cr_pref['cfcaption_text_color_active']	= 'white';
		$cr_pref['cfborder']			= '1px solid black';
		$cr_pref['cr_nav_theme']		= 'light';
		$cr_pref['cr_easing']			= 'swing';
		$cr_pref['cr_show_captions']		= 'false';
		$cr_pref['cr_fade_panels']		= 'true';
		$cr_pref['cr_show_panels']		= 'true';
		$cr_pref['cr_show_filmstrip']		= 'true';
		$cr_pref['cr_start_frame']		= '1';
		$cr_pref['cr_pointer_size']		= '5';
		$cr_pref['cr_panel_scale']		= 'crop';
		$cr_pref['cr_frame_scale']		= 'crop';
		$cr_pref['cr_frame_gap']		= '5';
		$cr_pref['cr_padding']			= '0';
		$cr_pref['cr_frame_background_color']	= '#ccc';
		$cr_pref['cr_pause_on_hover']		= 'false';
		$cr_pref['cr_d_javascript_image']	= '';
		$cr_pref['cr_item_buttons']		= 'true';
		$cr_pref['cr_item_count']		= '';
		$cr_pref['cr_item_count_align']		= 'Horizontal';
		$cr_pref['cr_display_order']		= 'desc';
		$cr_pref['cr_default_thumbnail']	= '';
		$cr_pref['cr_overlay_easing']		= 'easeOutBounce';
		$cr_pref['cr_overlay_speed']		= '1000';
		$cr_pref['cr_item_buttons_align']	= 'Horizontal';
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
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cfcaption_text_color", 10, $cr_pref['cfcaption_text_color'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_46."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cfcaption_text_color_active", 10, $cr_pref['cfcaption_text_color_active'], 50)."</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_44."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cr_padding", 10, $cr_pref['cr_padding'], 50)." ".LAN_C_ROTATOR_ADMIN_59."
		</td>
	</tr>
	<tr>
		<td class='forumheader3'>".LAN_C_ROTATOR_ADMIN_26."</td>
		<td class='forumheader3' style='width:70%;'>".$rs -> form_text("cfborder", 10, $cr_pref['cfborder'], 50)."
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
   
} 




function admin_config_adminmenu()
{
	if (e_QUERY) {
		$tmp = explode (".", e_QUERY);
		$action     = $tmp[0];
		$sub_action = $tmp[1];
		$type       = $tmp[2];
	}
	if (!isset($action) || ($action == "")){
		$action = "general";
	}
   
	$var['general']['text'] = LAN_C_ROTATOR_GENERAL;
	$var['general']['link'] = e_SELF;
	
	$var['add']['text'] = LAN_C_ROTATOR_ADD;
	$var['add']['link'] = e_SELF."?add";
   
	$var['config']['text'] = LAN_C_ROTATOR_CONFIG;
	$var['config']['link'] = e_SELF."?config";
	
	show_admin_menu(LAN_C_ROTATOR_MENU_CAPTION, $action, $var);
} 
?>
