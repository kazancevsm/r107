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


if (e_QUERY) {
	list($action, $nr, $type) = explode(".", e_QUERY);
}
else
{
	$action = FALSE;
	$nr = FALSE;
}
	
if(isset($_POST['create_CR']))
{
		
			$cr_title = $_POST['cr_title'];
			$cr_intro = $_POST['cr_intro'];
			$cr_text  = $_POST['cr_text'];
			$cr_image = $_POST['cr_image'];
			$cr_thumbnail = $_POST['cr_thumbnail'];
			$cr_captions = $_POST['cr_captions'];
			$cr_link  = $_POST['cr_link'];
            $sql->db_Select("c_rotator", "max(cr_order)+1", "", "no-where");
            $row = $sql->db_Fetch();
			$cr_text = str_replace("'", "&#39;", "$cr_text");
			$sql->db_Insert("c_rotator", "0, '$cr_title', '$cr_intro', '$cr_text', '$cr_image', '$cr_thumbnail', '$cr_captions', '$cr_link', '$row[0]'");
			

}
	
if(isset($_POST['update_CR']))
{	
		
			$cr_title = $_POST['cr_title'];
			$cr_intro = $_POST['cr_intro'];
			$cr_text  = $_POST['cr_text'];
			$cr_image = $_POST['cr_image'];
			$cr_link  = $_POST['cr_link'];
			$cr_thumbnail  = $_POST['cr_thumbnail'];
			$cr_captions = $_POST['cr_captions'];
			$cr_id	= $_POST['cr_id'];
			
			$sql->db_Update("c_rotator", "title='$cr_title', intro='$cr_intro', text='$cr_text', image='$cr_image', thumbnail='$cr_thumbnail', captions='$cr_captions', link='$cr_link' WHERE id='$cr_id'");
				header("location: admin_view_entrees.php");	

}
	
	if($action == "edit") {
	
	$sql->db_Select("c_rotator", "*","id ='$nr'");
	while($row = $sql -> db_Fetch()) {
	$cr_title = $row[title];
	$cr_intro = $row[intro];
	$cr_text = $row[text];
	$cr_image = $row[image];
	$cr_thumbnail = $row[thumbnail];
	$cr_captions = $row[captions];
	$cr_link = $row[link];
	$cr_id = $nr;
	
	
	}
	
	$message = LAN_C_ROTATOR_ADMIN_5;
	}
	
	
	if($action == "delete") {
        $sql->db_Update("c_rotator", "cr_order=cr_order-1 WHERE cr_order > (select cr_order from (select * from ".MPREFIX."c_rotator) as c1 where c1.id =$nr)");
        $sql->db_Delete("c_rotator", "id='$nr'");
	header("location: admin_view_entrees.php");
	}
	
	
	
	$i = 0;
	$sql->db_Select("c_rotator","*", "ORDER BY id DESC", false);
	while($row = $sql -> db_Fetch()) {
	$id[$i] 		= $row[id];
	$title[$i] 		= $row[title];
	$intro[$i]		= $row[intro];
	$bericht[$i]	= $row[text];
	$image[$i]		= $row[image];
	$thumbnail[$i]	= $row[thumbnail];
	$captions[$i]	= $row[captions];
	$link[$i]		= $row[link];
	$i++;
	}
	
   

	if ($message != '')
	$error = "<tr><td colspan='2' style='text-align:center;height40px;border:dashed 1px #000;padding:5px;'>$message</td></tr>";
	
	
	$text = "<div style='text-align:center; width:100%'>
	<table>
		<tr>
			<td><a href='".e_SELF."?action=pic'><img title='Add image' alt='' src='images/image_add.png' /></a></td>
			<td><a href='".e_SELF."?action=pic'>Add a picture</a></td>
		<tr>
			<td><a href='".e_SELF."?action=html'><img title='Add html page' alt='' src='images/html_add.png' /></a></td>
			<td><a href='".e_SELF."?action=html'>Add a html entree</a></td>
		</tr>
	</table>
  
  </div>";
	
if(isset($_GET['action']) && $_GET['action'] == 'pic' || ($action == "edit" && $type == 'pic')){
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
		<input class='tbox' type='text' name='cr_captions' style='width: 100%' value='$cr_captions' maxlength='200' />
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

if(isset($_GET['action']) && $_GET['action'] == 'html' || ($action == "edit" && $type == 'html')){
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
?>
