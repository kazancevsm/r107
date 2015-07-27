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

	$cr_pref = getcr_prefs();

	$i = 0;
	$sql->db_Select("c_rotator","*", "ORDER BY cr_order ".$cr_pref['cr_display_order']."", false);
	while($row = $sql -> db_Fetch()) {
	$id[$i] 		= $row[id];
	$title[$i] 		= $row[title];
	$intro[$i]		= $row[intro];
	$bericht[$i]	= $row[text];
	$image[$i]		= $row[image];
	$thumbnail[$i] 	= $row[thumbnail];
	$captions[$i]	= $row[captions];
	$link[$i]		= $row[link];
	$i++;
	}

	$text = panel($id, $title, $intro, $captions, $bericht,$thumbnail, $image, $link, $cr_pref);


	function panel($id, $title, $intro, $captions, $bericht,$thumbnail, $image, $link, $cr_pref)
	{
		global $tp;
		
		if($cr_pref['cr_item_count'] == ""){$cr_pref['cr_item_count'] = count($id);}elseif(count($id) < $cr_pref['cr_item_count']){$cr_pref['cr_item_count'] = count($id);}
		
		if($cr_pref['cr_layout'] == 3 && $cr_pref['cr_item_buttons'] == true )
		{
		$margin = "style=\"margin:0px;\"";	
		$buttons = "			
			<ul class='cr_rotator_buttons'>";
			for ($j = 0; $j < $cr_pref['cr_item_count']; $j++)
			{
			$buttons .= "<li class='cr_nav_button'><span>".($j+1)."</span></li>";
			}
			$buttons .=	"</ul>";
		}
		$text = "<div style='position:relative;width:". ($cr_pref['cr_panel_width']+($cr_pref['cr_padding']*2)) ."px'>".$buttons."<ul $margin id='photos'>";
		for ($i = 0; $i < $cr_pref['cr_item_count']; $i++){
			
			//set link
			if($link[$i] != "")
			{	
				$pre_url ="<a href='".$link[$i]."'>";
				$post_url ="</a>";
				if($cr_pref['cr_layout'] == 1)
					{
						$pre_thumbnail_url = $pre_url;
						$post_thumbnail_url = $post_url;
					}
			}
			else
			{	
				$pre_url ="";
				$post_url ="";
				$pre_thumbnail_url ="";
				$post_thumbnail_url ="";
			}
			
			
			
			if($thumbnail[$i] != "" || $bericht[$i] != ""){
				//set Default thumbnail for text/html pages
				if($thumbnail[$i] == ""){$thumbnail[$i] = $cr_pref['cr_default_thumbnail'];}
				//Thumbnail
				$text .= "<li class='e107_cr_rotator_1337'>
						  ".$pre_thumbnail_url."<img src='".$thumbnail[$i]."' title='".$captions[$i]."' alt='image' />".$post_thumbnail_url."";
						  $text .= "<div class='panel-content'>";
						  if($bericht[$i] != ""){
							  	if($title[$i] != ""){
							  	$text .= "<h2>".$title[$i]."</h2>";}
							  	$text .= $newtext = $tp->toHTML($bericht[$i], true);

						  }else{
							  	//if the the title or the overlay text is set, it wil display it in the frame.
								if($title[$i] != '' || $intro[$i] != '')
								{
									$text .= "<div id='panel-overlay$i' class='panel-overlay'>";
									if($title[$i] != '')
									{		
										$text .= "<h2>".$title[$i]."</h2>";
									}
									if($intro[$i] != '')
									{		
										$text .= "<p>".$newtext = $tp->toHTML($intro[$i], true);"</p>";
									}
									$text .= "</div>";
								}
								//main image
						  	 	$text .= "".$pre_url."<img src='".$image[$i]."' title='".$captions[$i]."' alt='".$title[$i]."' />".$post_url."";
						  }
						  $text .= "</div>";

				 $text .= "</li>";
			}
			else
			{
			//If no seperate thumbnail is given:	
			$text .= "<li class='e107_cr_rotator_1337'>";
			if($link[$i] != ""){
					$text .="<div style='display:none' id='link' name='$link[$i]'></div>";
			}
			$text .= "<img src='".$image[$i]."' title='".$captions[$i]."' alt='".$title[$i]."' />";
						if($title[$i] != '' || $intro[$i] != '')
						{
							$text .= "<div id='panel-overlay$i' class='panel-overlay'>";
							if($title[$i] != '')
							{		
								$text .= "<h2>".$title[$i]."</h2>";
							}
							if($intro[$i] != '')
							{		
								$text .= "<p>".$newtext = $tp->toHTML($intro[$i], true);"</p>";
							}
					$text .= "</div>";
					}
					
				$text .= "</li>";
			}
		}
		$text .= "</ul></div>";
		return $text;
	}
	//Display image when javascript is disabled
	if($cr_pref['cr_d_javascript_image'] != ""){
		$text .= "<noscript><img id='rc_javascript_disabled' src='".$cr_pref['cr_d_javascript_image']."' title='javascript disabled' alt='javascript disabled' /></noscript>";
	}
	
//Get some need variables from the database	
function getcr_prefs(){
	global $sql, $eArrayStorage;

	if(!is_object($sql)){ $sql = new db; }
	$sql -> db_Select("core", "*", "e107_name='content_rotator' ");
	$row = $sql -> db_Fetch();
	$cr_pref = $eArrayStorage->ReadArray($row['e107_value']);
	return $cr_pref;
}
	
   
   $ns->tablerender('', $text);
?>
