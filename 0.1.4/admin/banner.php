<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/banner.php $
|     $Id: banner.php 12086 2011-02-27 14:50:07Z e107steved $
+----------------------------------------------------------------------------+
*/
if(!empty($_POST) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = ''; 
}
require_once("../class2.php");
if (!getperms("D")) 
{
	header("location:".e_BASE."index.php");
	exit();
}


require_once(e_HANDLER."calendar/calendar_class.php");

$cal = new DHTML_Calendar(true);
function headerjs()
{
  	global $cal;
    $js = $cal->load_files();
	return $js;
}
$e_sub_cat = 'banner';
$e_wysiwyg = 'data,banner_extended';
if(e_QUERY) // must be before auth.php
{
	list($action, $sub_action, $id) = explode(".", e_QUERY);
	$id = intval($id);
}

require_once("auth.php");
require_once(e_HANDLER."form_handler.php");
$rs = new form;
require_once(e_HANDLER."userclass_handler.php");
require_once(e_HANDLER."file_handler.php");
$fl = new e_file;

//FIXME mix up in banner language files
include_lan(e_LANGUAGEDIR.e_LANGUAGE."/admin/lan_menus.php");
include_lan(e_PLUGIN."banner_menu/languages/".e_LANGUAGE.".php");




//$reject = array('$.','$..','/','CVS','thumbs.db','*._$',"thumb_", 'index', '.DS_Store');
//$images = $fl->get_files(e_IMAGE."banners/","",$reject);
$images = $fl->get_files(e_FILE."banners/","","standard");

if (isset($_POST['update_menu'])) {

	$menu_pref['bannefcaption']	= $tp->toDB($_POST['bannefcaption']);
	$menu_pref['banner_amount']	= intval($_POST['banner_amount']);
	$menu_pref['banner_rendertype']	= intval($_POST['banner_rendertype']);

	if (isset($_POST['catid'])) {
		$array_cat = explode("-", $_POST['catid']);
		$cat='';
		for($i = 0; $i < count($array_cat); $i++) {
			$cat .= $tp->toDB($array_cat[$i])."|";
		}
		$cat = substr($cat, 0, -1);
		$menu_pref['banner_place'] = $cat;
	}

	$sysprefs->setArray('menu_pref');
	$message = BANNER_MENU_L2;
}



if ($_POST['createbanner'] || $_POST['updatebanner'])
{

	//$banner_start = (int) (!$_POST['banner_start'] ? 0 : mktime (0, 0, 0, $_POST['startmonth'], $_POST['startday'], $_POST['startyear']));
	$banner_start = (int) (!$_POST['banner_start'] ? 0 : strtotime ($_POST['banner_start']));
	//$banner_end = (int) (!$_POST['endmonth'] || !$_POST['endday'] || !$_POST['endyear'] ? 0 : mktime (0, 0, 0, $_POST['endmonth'], $_POST['endday'], $_POST['endyear']));
	$banner_end = (int) (!$_POST['banner_end'] ? 0 : strtotime ($_POST['banner_end']));
	$cli = $tp->toDB($_POST['client_name'] ? $_POST['client_name'] : $_POST['banner_client_sel']);

	if ($_POST['banner_pages']) {
		$postcampaign = ($_POST['banner_place'] ? $_POST['banner_place'] : $_POST['banner_place_sel']);
		$pagelist = explode("\r\n", $_POST['banner_pages']);
		for($i = 0 ; $i < count($pagelist) ; $i++) {
			$pagelist[$i] = trim($pagelist[$i]);
		}
		$plist = implode("|", $pagelist);
		$pageparms = $postcampaign."^".$_POST['banner_listtype']."-".$plist;
		$pageparms = preg_replace("#\|$#", "", $pageparms);
		$pageparms = (trim($_POST['banner_pages']) == '') ? '' :
		 $pageparms;
		$cam = $pageparms;
	} else {
		$cam = ($_POST['banner_place'] ? $_POST['banner_place'] : $_POST['banner_place_sel']);
	}

	$clickURL = $tp->toDB($_POST['click_url']);
	unset($_POST['click_url']);
	if ($_POST['createbanner']) 
	{
		admin_update($sql->db_Insert("banner", "0, '".$cli."', '".$tp->toDB($_POST['client_login'])."', '".$tp->toDB($_POST['client_password'])."', '".$tp->toDB($cam)."', '".rawurlencode($_POST['banner_image'])."', '$banner_imageheight', '$banner_imagewidth', '".$clickURL."', '".intval($_POST['impressions_purchased'])."', '$banner_start', '$banner_end', '".intval($_POST['banner_class'])."', 0, 0, '' "), 'insert', BNRLAN_63);
	} 
	else 
	{
		admin_update($sql->db_Update("banner", "banner_clientname='".$cli."', banner_clientlogin='".$tp->toDB($_POST['client_login'])."', banner_clientpassword='".$tp->toDB($_POST['client_password'])."', banner_place='".$tp->toDB($cam)."', banner_image='".rawurlencode($_POST['banner_image'])."', banner_imageheight='".$_POST['banner_imageheight']."', banner_imagewidth='".$_POST['banner_imagewidth']."', banner_clickurl='".$clickURL."', banner_impurchased='".intval($_POST['impressions_purchased'])."', banner_startdate='$banner_start', banner_enddate='$banner_end', banner_active='".intval($_POST['banner_class'])."'  WHERE banner_id='".intval($_POST['eid'])."'"), 'update', BNRLAN_64);
	}
	unset($_POST['client_name'], $_POST['client_login'], $_POST['client_password'], $_POST['banner_image'], $_POST['impressions_purchased'], $banner_start, $banner_end, $_POST['banner_enabled'], $_POST['startday'], $_POST['startmonth'], $_POST['startyear'], $_POST['endday'], $_POST['endmonth'], $_POST['endyear'], $_POST['banner_class'], $_POST['banner_pages'], $_POST['banner_listtype']);
}

if (isset($_POST['confirm'])) {
	admin_update($sql->db_Delete("banner", "banner_id='".intval($_POST['id'])."' "), 'delete', BNRLAN_1);
}

if ($action == "delete" && $sub_action) {
	$text = "<div style='text-align:center'>
		<b>".BNRLAN_2."</b>
		<br /><br />
		<form method='post' action='".e_SELF."'>
		<input type='hidden' name='e-token' value='".e_TOKEN."' />
		<input class='button' type='submit' name='cancel' value='".LAN_CANCEL."' />
		<input class='button' type='submit' name='confirm' value='".LAN_CONFDELETE."' />
		<input type='hidden' name='id' value='".intval($sub_action)."' />
		</form>
		</div>";
	$ns->tablerender(BNRLAN_5, $text);

	require_once("footer.php");
	exit;
}
if (isset($_POST['cancel'])) {
	$message = BNRLAN_6;
}

if (isset($message)) {
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

if ($sql->db_Select("banner")) {
	while ($row = $sql->db_Fetch()) {
		extract($row);

		if (strpos($banner_place, "^") !== FALSE) {
			$campaignsplit = explode("^", $banner_place);
			$banner_place = $campaignsplit[0];
		}

		if ($banner_place) {
			$campaigns[] = $banner_place;
		}
		if ($banner_clientname) {
			$clients[] = $banner_clientname;
		}
		if ($banner_clientlogin) {
			$logins[] = $banner_clientlogin;
		}
		if ($banner_clientpassword) {
			$passwords[] = $banner_clientpassword;
		}
	}
}


if (!$action) {
	$text = "
		<table class='fborder'>
		<tr><td colspan='7' style='text-align:center' class='fcaption'>".BNRLAN_7."</td></tr>
		<tr>
		<td class='forumheader' style='text-align:center'>".BNRLAN_8."</td>
		<td class='forumheader' style='text-align:center'>".BNRLAN_9."</td>
		<td class='forumheader' style='text-align:center'>".BNRLAN_10."</td>
		<td class='forumheader' style='text-align:center'>".BNRLAN_11."</td>
		<td class='forumheader' style='text-align:center'>".BNRLAN_12."</td>
		<td class='forumheader' style='text-align:center'>".BNRLAN_13."</td>
		<td class='forumheader' style='text-align:center'>".LAN_OPTIONS."</td>
		</tr>";

	if (!$banner_total = $sql->db_Select("banner")) {
		$text .= "<tr><td colspan='7' class='forumheader3' style='text-align:center'>".BNRLAN_15."</td></tr>";
	} else {
		while ($row = $sql->db_Fetch()) {
			extract($row);

			$clickpercentage = ($banner_clicks && $banner_impressions ? round(($banner_clicks / $banner_impressions) * 100)."%" : "-");
			$impressions_left = ($banner_impurchased ? $banner_impurchased - $banner_impressions : BNRLAN_16);
			$impressions_purchased = ($banner_impurchased ? $banner_impurchased : BNRLAN_16);

			$banner_start = ($banner_startdate ? strftime("%d %B %Y", $banner_startdate) : BNRLAN_17);
			$banner_end = ($banner_enddate ? strftime("%d %B %Y", $banner_enddate) : BNRLAN_17);

			if (strpos($banner_place, "^") !== FALSE) {
				$campaignsplit = explode("^", $banner_place);
				$banner_place = $campaignsplit[0];
				$textvisivilitychanged = "(*)";
			} else {
				$textvisivilitychanged = "";
			}

			$text .= "<tr>
				<td class='forumheader3' style='text-align:center'>".$banner_id."</td>
				<td class='forumheader3' style='text-align:center'>".$banner_clientname."</td>
				<td class='forumheader3' style='text-align:center'>".$banner_clicks."</td>
				<td class='forumheader3' style='text-align:center'>".$clickpercentage."</td>
				<td class='forumheader3' style='text-align:center'>".$impressions_purchased."</td>
				<td class='forumheader3' style='text-align:center'>".$impressions_left."</td>
				<td class='forumheader3' style='text-align:center'><a href='".e_SELF."?create.edit.".$banner_id."'>".ADMIN_EDIT_ICON."</a> <a href='".e_SELF."?delete.".$banner_id."'>".ADMIN_DELETE_ICON."</a></td>
				</tr>
				<tr>
				<td class='forumheader3' style='text-align:center'>&nbsp;</td>
				<td class='forumheader3' style='text-align:center'>".$banner_place."</td>
				<td colspan='2' class='forumheader3' style='text-align:center'>".r_userclass_name($banner_active)." ".$textvisivilitychanged."</td>
				<td colspan='3' class='forumheader3' style='text-align:center'>".BNRLAN_45.": ".$banner_start." &lt;&gt; ".BNRLAN_21.": ".$banner_end."</td>
				</tr>
				<tr><td colspan='8'>&nbsp;</td></tr>";
		}
	}
	$text .= "</table>";

	$ns->tablerender(BNRLAN_42, $text);
}

if ($action == "create") {
	if(isset($pref['install_date'])) { 
		$_startYear = date('Y', $pref['install_date']);
	} else {
		$_startYear = date('Y') - 5;
	}
	$_endYear = date('Y') + 5;

	if ($sub_action == "edit" && $id) {
		if (!$sql->db_Select("banner", "*", "banner_id = '".$id."' " )) {
			$text .= "<div style='text-align:center;'>".BNRLAN_15."</div>";
		} else {
			while ($row = $sql->db_Fetch()) {
				extract($row);

				$_POST['client_name'] = $banner_clientname;
				$_POST['client_login'] = $banner_clientlogin;
				$_POST['client_password'] = $banner_clientpassword;
				$_POST['banner_image'] = rawurldecode($banner_image);
				$_POST['banner_imageheight'] = $banner_imageheight;
				$_POST['banner_imagewidth'] = $banner_imagewidth;
				$_POST['click_url'] = rawurldecode($banner_clickurl);
				$_POST['impressions_purchased'] = $banner_impurchased;
				$_POST['banner_place'] = $banner_place;
				$_POST['banner_active'] = $banner_active;
				$_POST['banner_start'] = $banner_startdate;
				$_POST['banner_end'] = $banner_enddate;

				if (strpos($_POST['banner_place'], "^") !== FALSE) {
					$campaignsplit = explode("^", $_POST['banner_place']);
					$listtypearray = explode("-", $campaignsplit[1]);
					$listtype = $listtypearray[0];
					$campaign_pages = str_replace("|", "\n", $listtypearray[1]);
					$_POST['banner_place'] = $campaignsplit[0];
				} else {
					$_POST['banner_place'] = $banner_place;
				}

			}
		}
	}

	$text = "
		<div style='text-align: center;'>
		<form method='post' action='".e_SELF."'>
		<table class='fborder'>
		<tr><td colspan='2' style='text-align:center' class='fcaption'>".($sub_action == "edit" ? BNRLAN_22 : BNRLAN_23)."</td></tr>
		<tr>
		<td class='forumheader3'>".BNRLAN_24."</td>
		<td class='forumheader3'>";
	if (count($campaigns)) {
		$text .= "<select name='banner_place_sel' class='tbox'><option></option>";
		$c = 0;
		while ($campaigns[$c]) {
			if (!isset($for_var[$campaigns[$c]])) {
				$text .= ($_POST['banner_place'] == $campaigns[$c] ? "<option selected='selected'>".$campaigns[$c]."</option>" : "<option>".$campaigns[$c]."</option>");
				$for_var[$campaigns[$c]] = $campaigns[$c];
			}
			$c++;
		}
		unset($for_var);

		$text .= "</select> ".BNRLAN_25."&nbsp;&nbsp;";
	}
	$text .= " <input class='tbox' type='text' size='30' maxlength='100' name='banner_place' value='' />
		".BNRLAN_26."
		</td>
		</tr>

		<tr>
		<td class='forumheader3'>".BNRLAN_27."</td>
		<td class='forumheader3'>";

	if (count($clients)) {
		$text .= "<select name='banner_client_sel' class='tbox' onchange=\"Change_Details(this.form)\"><option></option>";
		$c = 0;
		while ($clients[$c]) {
			if (!isset($for_var[$clients[$c]])) {
				$text .= ($_POST['client_name'] == $clients[$c] ? "<option selected='selected'>".$clients[$c]."</option>" : "<option>".$clients[$c]."</option>");
				$for_var[$clients[$c]] = $clients[$c];
			}
			$c++;
		}
		unset($for_var);

		$text .= "</select> ".BNRLAN_28."&nbsp;&nbsp;";
		$text .= "<script type='text/javascript'>
			function Change_Details(form){
			var login_field = (document.all) ? document.all(\"clientlogin\") : document.getElementById(\"clientlogin\");
			var password_field = (document.all) ? document.all(\"clientpassword\") : document.getElementById(\"clientpassword\");
			switch(form.banner_client_sel.selectedIndex-1){";

		$c = 0;
		$i = 0;
		while ($logins[$c]) {
			if (!isset($for_var[$logins[$c]])) {
				$text .= "
					case ".$i.":
					login_field.value = \"".$logins[$c]."\";
					password_field.value = \"".$passwords[$c]."\";
					break;";
				$for_var[$logins[$c]] = $logins[$c];
				$i++;
			}
			$c++;
		}
		unset($for_var);

		$text .= "
			default:
			login_field.value = \"\";
			password_field.value = \"\";
			break;
			}
			}
			</script>";
	}

	$text .= "<input class='tbox' type='text' size='30' maxlength='100' name='client_name' value='' />
		".BNRLAN_29."
		</td></tr>

		<tr>
		<td class='forumheader3'>".BNRLAN_30."</td>
		<td class='forumheader3'>
		<input class='tbox' type='text' size='30' maxlength='20' id='clientlogin' name='client_login' value='".$_POST['client_login']."' />
		</td></tr>

		<tr>
		<td class='forumheader3'>".BNRLAN_31."</td>
		<td class='forumheader3'>
		<input class='tbox' type='text' size='30' maxlength='50' id='clientpassword' name='client_password' value='".$_POST['client_password']."' />
		</td></tr>

		<tr>
		<td class='forumheader3'>".BNRLAN_32."</td>
		<td class='forumheader3'>
		<input class='button' type ='button' value='".BNRLAN_43."' onclick='expandit(this)' />
		<div style='display:none'><br />";
	$c = 0;
	while ($images[$c])
	{

		$image = $images[$c]['path'].$images[$c]['fname'];

		$fileext1 = substr(strrchr($image, "."), 1);
		$fileext2 = substr(strrchr($image, "."), 0);

		$text .= "<input type='radio' name='banner_image' value='".$images[$c]['fname']."'";

		if (basename($image) == $_POST['banner_image']) {
			$text .= "checked='checked'";
		}

		if ($fileext1 == swf) {
			$text .= " /> <br /><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='468' height='60'>
				<param name='movie' value='".e_FILE."banners/".$images[$c]['fname']."'>
				<param name='quality' value='high'><param name='SCALE' value='noborder'>
				<embed src='".e_FILE."banners/".$images[$c]['fname']."' width='468' height='60' scale='noborder' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed></object>
				<br />";
		}
		else if($fileext1 == "php" || $fileext1 == "html" || $fileext1 == "js") {
			$text .= " /> ".BNRLAN_46.": ".$images[$c]['fname']."<br />";
		} else {
			$text .= " /> <img src='$image' alt='' /><br />";
		}
		$c++;
	}
	$text .= "</div></td></tr>
		
		<tr>
		<td class='forumheader3'>".BNRLAN_14."</td>
		<td class='forumheader3'>
			".BNRLAN_17." <input class='tbox' type='text' size='10' maxlength='10' name='banner_imageheight' value='".$_POST['banner_imageheight']."' />
			".BNRLAN_18." <input class='tbox' type='text' size='10' maxlength='10' name='banner_imagewidth' value='".$_POST['banner_imagewidth']."' />
		</td></tr>
		
		<tr>
		<td class='forumheader3'>".BNRLAN_33."</td>
		<td class='forumheader3'>
		<input class='tbox' type='text' size='70' maxlength='150' name='click_url' value='".$_POST['click_url']."' />
		</td></tr>

		<tr>
		<td class='forumheader3'>".BNRLAN_34."</td>
		<td class='forumheader3'>
		<input class='tbox' type='text' size='10' maxlength='10' name='impressions_purchased' value='".$_POST['impressions_purchased']."' /> 0 = ".BNRLAN_35."
		</td></tr>

		<tr>
		<td class='forumheader3'>".BNRLAN_36." / ".BNRLAN_37."</td>
		
		<td class='forumheader3'>";
		$banner_start = ($_POST['banner_start'] > 0) ? date('d-m-Y', $_POST['banner_start']) : '';

		$cal_options['showsTime'] = false;
		$cal_options['showOthers'] = false;
		$cal_options['weekNumbers'] = false;
		$cal_options['ifFormat'] = '%d-%m-%Y';
		$cal_attrib['class'] = 'tbox';
		$cal_attrib['size'] = '10';
		$cal_attrib['name'] = 'banner_start';
		$cal_attrib['value'] = $banner_start;
		
		//onfocus=\"this.select();lcs(this)\" onclick=\"event.cancelBubble=true;this.select();lcs(this)\"
		$text .= $cal->make_input_field($cal_options, $cal_attrib);
		
		$text .= ' / ';
		
		$banner_end = ($_POST['banner_end'] > 0) ? date('d-m-Y', $_POST['banner_end']) : '';

		unset($cal_options);
		unset($cal_attrib);
		$cal_options['showsTime'] = false;
		$cal_options['showOthers'] = false;
		$cal_options['weekNumbers'] = false;
		$cal_options['ifFormat'] = '%d-%m-%Y';
		$cal_attrib['class'] = 'tbox';
		$cal_attrib['size'] = '10';
		$cal_attrib['name'] = 'banner_end';
		$cal_attrib['value'] = $banner_end;
		$text .= $cal->make_input_field($cal_options, $cal_attrib);
		
		
		$text .= " (".BNRLAN_38.")";
		$text .= " <tr>
		<td class='forumheader3'>".BNRLAN_39."</td>
		<td class='forumheader3'>
		".MENLAN_4."
		".r_userclass("banner_class", $_POST['banner_active'], "off", "public,member,guest,admin,classes,nobody,classes")."
		</td></tr>



		<tr><td colspan='2' style='text-align:center' class='forumheader'>
		<input type='hidden' name='e-token' value='".e_TOKEN."' />";
	$text .= ($sub_action == "edit" && $id ? "<input class='button' type='submit' name='updatebanner' value='".BNRLAN_40."' /><input type='hidden' name='eid' value='".$id."' />" : "<input class='button' type='submit' name='createbanner' value='".BNRLAN_41."' />");

	$text .= "</td></tr></table>
		</form></div>";

	$ns->tablerender(BNRLAN_42, $text);

}



if ($action == "menu")
{
  $in_catname = array();		// Notice removal
  $out_catname = array();

	$array_cat_in = explode("|", $menu_pref['banner_place']);
	if (!$menu_pref['bannefcaption'])
	{
		$menu_pref['bannefcaption'] = BANNER_MENU_L1;
	}

	$category_total = $sql -> db_Select("banner", "DISTINCT(banner_place) as banner_place", "ORDER BY banner_place", "mode=no_where");
	while ($row = $sql -> db_Fetch())
	{
		extract($row);
		if (in_array($banner_place, $array_cat_in))
		{
			$in_catname[] = $banner_place;
		} else {
			$out_catname[] = $banner_place;
		}
	}


	$text = "<div style='text-align:center'>
	<form method='post' action='".e_SELF."?menu' name='menu_conf_form'>
	<table class='fborder' >

	<tr>
	<td style='width:40%' class='forumheader3'>".BANNER_MENU_L3.": </td>
	<td style='width:60%' class='forumheader3'>
	<input class='tbox' type='text' name='bannefcaption' size='20' value='".$menu_pref['bannefcaption']."' maxlength='100' />
	</td>
	</tr>

	<tr>
	<td style='width:40%' class='forumheader3'>".BANNER_MENU_L6."</td>
	<td style='width:60%' class='forumheader3'>

	<table style='width:90%'>
	<tr>
	<td style='width:45%; vertical-align:top'>".BANNER_MENU_L7."<br />
	<select class='tbox' id='catout' name='catout' size='10' style='width:180px' multiple='multiple' onchange='moveOver();'>\n";

	foreach($out_catname as $name)
	{
		$text .= "<option value='{$name}'>{$name}</option>\n";
	}

	$text .= "</select>
	</td>
	<td style='width:45%; vertical-align:top'>".BANNER_MENU_L8."<br />
	<select class='tbox' id='catin' name='catin' size='10' style='width:180px' multiple='multiple'>\n";

	$catidvalues = "";
	foreach($in_catname as $name)
	{
		$text .= "<option value='{$name}'>{$name}</option>\n";
		$catidvalues .= $name."-";
	}

	$text .= "</select><br /><br />
	<input class='button' type='button' value='".BANNER_MENU_L9."' onclick='removeMe();' />
	<input type='hidden' name='catid' id='catid' value='".$catidvalues."' />
	</td>
	</tr>
	</table>

	</td>
	</tr>

	<tr>
	<td style='width:40%' class='forumheader3'>".BANNER_MENU_L19."</td>
	<td style='width:60%' class='forumheader3'>
	<input class='tbox' type='text' name='banner_amount' size='10' value='".$menu_pref['banner_amount']."' maxlength='2' />
	</td>
	</tr>

	<tr>
	<td style='width:40%' class='forumheader3'>".BANNER_MENU_L10."</td>
	<td style='width:60%' class='forumheader3'>
	<select class='tbox' id='banner_rendertype' name='banner_rendertype' size='1'  >
	".$rs->form_option(BANNER_MENU_L11, (!$menu_pref['banner_rendertype'] || $menu_pref['banner_rendertype'] == "0" ? "1" : "0"), 0)."
	".$rs->form_option("1 - ".BANNER_MENU_L12."", ($menu_pref['banner_rendertype'] == "1" ? "1" : "0"), 1)."
	".$rs->form_option("2 - ".BANNER_MENU_L13."", ($menu_pref['banner_rendertype'] == "2" ? "1" : "0"), 2)."
	".$rs->form_option("3 - ".BANNER_MENU_L14."", ($menu_pref['banner_rendertype'] == "3" ? "1" : "0"), 3)."
	".$rs->form_select_close()."
	</td>
	</tr>

	<tr>
	<td colspan='2' class='forumheader' style='text-align:center'>
	<input type='hidden' name='e-token' value='".e_TOKEN."' />
	<input class='button' type='submit' name='update_menu' value='".BANNER_MENU_L18."' />
	</td>
	</tr>

	</table>
	</form>
	</div>";
	$ns->tablerender(BANNER_MENU_L5, $text);
	
	echo "<script type=\"text/javascript\">
		//<!--
		//<!-- Adapted from original:  Kathi O'Shea (Kathi.O'Shea@internet.com) -->

		function moveOver(){
		var boxLength = document.getElementById('catin').length;
		var selectedItem = document.getElementById('catout').selectedIndex;
		var selectedText = document.getElementById('catout').options[selectedItem].text;
		var selectedValue = document.getElementById('catout').options[selectedItem].value;

		var i;
		var isNew = true;
		if (boxLength != 0) {
		for (i = 0; i < boxLength; i++) {
		thisitem = document.getElementById('catin').options[i].text;
		if (thisitem == selectedText) {
		isNew = false;
		break;
		}
		}
		}
		if (isNew) {
		newoption = new Option(selectedText, selectedValue, false, false);
		document.getElementById('catin').options[boxLength] = newoption;
		document.getElementById('catout').options[selectedItem].text = '';
		}
		document.getElementById('catout').selectedIndex=-1;

		saveMe();
		}

		function removeMe() {
		var boxLength = document.getElementById('catin').length;
		var boxLength2 = document.getElementById('catout').length;
		arrSelected = new Array();
		var count = 0;
		for (i = 0; i < boxLength; i++) {
		if (document.getElementById('catin').options[i].selected) {
		arrSelected[count] = document.getElementById('catin').options[i].value;
		var valname = document.getElementById('catin').options[i].text;
		for (j = 0; j < boxLength2; j++) {
		if (document.getElementById('catout').options[j].value == arrSelected[count]){
		document.getElementById('catout').options[j].text = valname;
		}
		}
		}
		count++;
		}
		var x;
		for (i = 0; i < boxLength; i++) {
		for (x = 0; x < arrSelected.length; x++) {
		if (document.getElementById('catin').options[i].value == arrSelected[x]) {
		document.getElementById('catin').options[i] = null;
		}
		}
		boxLength = document.getElementById('catin').length;
		}

		saveMe();
		}

		//function clearMe(clid){
		// location.href = document.location + \"?clear.\" + clid;
		//}

		function saveMe(clid) {
		var strValues = \"\";
		var boxLength = document.getElementById('catin').length;
		var count = 0;
		if (boxLength != 0) {
		for (i = 0; i < boxLength; i++) {
		if (count == 0) {
		strValues = document.getElementById('catin').options[i].value;
		}
		else {
		strValues = strValues + \"-\" + document.getElementById('catin').options[i].value;
		}
		count++;
		}
		}
		if (strValues.length == 0) {
		//alert(\"You have not made any selections\");
		document.getElementById('catid').value = \"\";
		}
		else {
		document.getElementById('catid').value = strValues;
		}
		}

		// -->
		</script>\n";
}


function banner_adminmenu() {

	global $action, $sql, $sub_action, $id;
	$act = $action;
	if ($act == "") {
		$act = "main";
	}
	$var['main']['text'] = BNRLAN_58;
	$var['main']['link'] = e_SELF;

	$var['create']['text'] = BNRLAN_59;
	$var['create']['link'] = e_SELF."?create";

	$var['menu']['text'] = BNRLAN_61;
	$var['menu']['link'] = e_SELF."?menu";

	show_admin_menu(BNRLAN_62, $act, $var);
}

require_once("footer.php");

?>