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

   require_once("../../class.php");
   require_once(e_HANDLER.'ren_help.php');
   if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
   }

   require_once(e_ADMIN."auth.php");

	
	$i = 0;
	$sql->db_Select("c_rotator","*", "ORDER BY cr_order DESC", false);
	while($row = $sql -> db_Fetch()) {
	$id[$i] 		= $row[id];
	$title[$i] 		= $row[title];
	$intro[$i]		= $row[intro];
	$bericht[$i]	= $row[text];
	$image[$i]		= $row[image];
	$thumbnail[$i]	= $row[thumbnail];
	$captions[$i]	= $row[captions];
	$link[$i]		= $row[link];
    $order[$i]      = $row[cr_order];
	$i++;
	}
	
	
	
	$text .= "
		<script type='text/javascript'>
		$(document).ready(function() {";
						
	for ($i = 0; $i < count($id); $i++){								 		
	if($bericht[$i] != ""){			
	$text .= "	$('#cr_textbox".$i."').fancybox({
				'autoScale'			: true,
				'width'				: 950
			});";
	}
	}
	$text .= "
		});
	</script>


	<table class='fborder' style='margin-top:20px;width: 95%'>
					<tr>
						<td style='width:5%' class='fcaption'>".LAN_C_ROTATOR_MENU_5."</td>
						<td style='width:20%' class='fcaption'>".LAN_C_ROTATOR_MENU_1."</td>
						<td style='width:20%' class='fcaption'>".LAN_C_ROTATOR_MENU_7."</td>
						<td style='width:30%' class='fcaption'>".LAN_C_ROTATOR_MENU_2."</td>
						<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_MENU_3."</td>
						<td style='width:30%' class='fcaption'>".LAN_C_ROTATOR_MENU_8."</td>
						<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_MENU_9."</td>
						<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_MENU_4."</td>
						<td style='width:15%' class='fcaption'>".LAN_C_ROTATOR_MENU_6."</td>
					</tr>";
	for ($i = 0; $i < count($id); $i++)
	{
	if($bericht[$i] != ""){$type = "html";}else{$type = "pic";}
	if($image[$i] != ""){$image[$i] = "<img style='max-width:300px;' src='".$image[$i]."' />";}
	if($thumbnail[$i] != ""){$thumbnail[$i] = "<img style='max-width:100px;' src='".$thumbnail[$i]."' />";} 
	$text .= "<tr style='border:solid 1px #000;height:40px;'>
				<td class='forumheader3'>
			 		".$order[$i]."
				</td>
				<td class='forumheader3'>
			 		".$title[$i]."
				</td>
				<td class='forumheader3'>
			 		".$intro[$i]."
				</td>
				<td class='forumheader3'>";
	if($bericht[$i] != ""){			
	$text .= 	"<a id='cr_textbox".$i."' href='#cr_textbox_field".$i."' title='".$title[$i]."'>".LAN_C_ROTATOR_ADMIN_55."</a>
                <div style='display: none;'>
					<div id='cr_textbox_field".$i."' style='width:".$cr_pref['cr_panel_width']."px;height:".$cr_pref['cr_panel_height']."px;overflow:auto;'>
						".$newtext = $tp->toHTML($bericht[$i], true)."
                	</div>
				</div>";
	}
	$text .= 	"</td>
				<td class='forumheader3'>
					".$image[$i]."
				</td>
				<td class='forumheader3'>
					".$thumbnail[$i]."
				</td>
				<td class='forumheader3'>
					".$captions[$i]."
				</td>
				<td class='forumheader3'>
					" .$link[$i]."
				</td>
				<td class='forumheader3'>
					<a href='admin_config.php?edit.".$id[$i].".$type'><img src='".e_IMAGE."admin/edit_16.png' alt='Edit' title='Edit' /></a>
					<a href='admin_config.php?delete.".$id[$i]."'><img src='".e_IMAGE."admin/delete_16.png' alt='Delete' title='Delete' /></a>
					<br/>
					".LAN_C_ROTATOR_MENU_10.":<br/>";
	if($order[$i] != count($id))
	$text .= "				<a href='handlers/order.php?moveup.".$id[$i].".".$order[$i]."'><img src='".e_IMAGE."admin/up.png' alt='Edit' title='Edit' /></a>";
    if($order[$i] != 1)
	$text .= "				<a href='handlers/order.php?movedown.".$id[$i].".".$order[$i]."'><img src='".e_IMAGE."admin/down.png' alt='Delete' title='Delete' /></a>";

	$text .="		</td>
			</tr>";
	}
	$text .= "</table>";
	
   // The usual, tell e107 what to include on the page
   $ns->tablerender("Add items", $text);

   require_once(e_ADMIN."footer.php");
?>