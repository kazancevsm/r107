<?php
/*
+-------------------------------------------------------------------------
|
|     Loginza plugin version 0.5.1 for e107
|
|     Author: Evlanov Alexander (Kapman)
|     alex@aleksander.org.ru
|     http://free-lance.ru/users/kapman
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+-------------------------------------------------------------------------
*/

	require_once('../../class2.php');

	if(!getperms('P')) { exit('You do not have permission'); }

	require_once(e_ADMIN.'auth.php');
	require_once(e_HANDLER.'form_handler.php');
	$rs = new form;

	@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');
	
	global $pref, $sql, $tp;
	
	$width = (e_PAGE == 'admin_loginza.php');
	
	$action = e_QUERY;
	if ($action == '')
	{
		$action = 'main';
	}
	
	require_once('loginza_class.php');
	$loginza = new loginza;
	
	if($action == 'main'){
	
		if (isset($_POST['save_settings'])) {
			$pref['loginza_providers'] = $tp->toDB($_POST['loginza_providers']);
			$pref['loginza_lang'] = $tp->toDB($_POST['loginza_lang']);
			$pref['loginza_connect'] = intval($_POST['loginza_connect']);
			$pref['loginza_menu_title'] = $tp->toDB($_POST['loginza_menu_title']);
			$pref['loginza_secure_login'] = intval($_POST['loginza_secure_login']);
			$pref['loginza_widget_id'] = intval($_POST['loginza_widget_id']);
			$pref['loginza_api_signature'] = $tp->toDB($_POST['loginza_api_signature']);
			save_prefs();
				
			$ns->tablerender('', '<div style="text-align:center;"><b>'.LOGINZA_ADMIN_SAVED.'</b></div>');
		}
	
		$text .= '
        <div style="text-align:center">
        '.$rs -> form_open('post', e_SELF, 'SettingLoginza', '', '', '').'
        <table style="'.$width.'" class="fborder" cellspacing="0" cellpadding="0">
        <tr style="vertical-align:top">
        <td colspan="3" style="text-align:center;" class="forumheader">'. LOGINZA_ADMIN_CONF .'</td></tr>
		<tr><td style="width:40%" class="forumheader3" colspan="2">' . LOGINZA_ADMIN_PROVS . '<br />'.LOGINZA_ADMIN_PROV.'</td>
    	<td style="width:50%" class="forumheader3">
		<select class = "tbox" name = "loginza_providers[]" size="8" style="width: 100px;" multiple>
			<option value="google" '.(in_array('google', $pref['loginza_providers'])?'selected':'').'>google</option>
			<option value="yandex" '.(in_array('yandex', $pref['loginza_providers'])?'selected':'').'>yandex</option>
			<option value="mailruapi" '.(in_array('mailruapi', $pref['loginza_providers'])?'selected':'').'>mailruapi</option>
			<option value="mailru" '.(in_array('mailru', $pref['loginza_providers'])?'selected':'').'>mailru</option>
			<option value="vkontakte" '.(in_array('vkontakte', $pref['loginza_providers'])?'selected':'').'>vkontakte</option>
			<option value="facebook" '.(in_array('facebook', $pref['loginza_providers'])?'selected':'').'>facebook</option>
			<option value="twitter" '.(in_array('twitter', $pref['loginza_providers'])?'selected':'').'>twitter</option>
			<option value="loginza" '.(in_array('loginza', $pref['loginza_providers'])?'selected':'').'>loginza</option>
			<option value="myopenid" '.(in_array('myopenid', $pref['loginza_providers'])?'selected':'').'>myopenid</option>
			<option value="webmoney" '.(in_array('webmoney', $pref['loginza_providers'])?'selected':'').'>webmoney</option>
			<option value="rambler" '.(in_array('rambler', $pref['loginza_providers'])?'selected':'').'>rambler</option>
			<option value="flickr" '.(in_array('flickr', $pref['loginza_providers'])?'selected':'').'>flickr</option>
			<option value="lastfm" '.(in_array('lastfm', $pref['loginza_providers'])?'selected':'').'>lastfm</option>
			<option value="verisign" '.(in_array('verisign', $pref['loginza_providers'])?'selected':'').'>verisign</option>
			<option value="aol" '.(in_array('aol', $pref['loginza_providers'])?'selected':'').'>aol</option>
			<option value="steam" '.(in_array('steam', $pref['loginza_providers'])?'selected':'').'>steam</option>
			<option value="openid" '.(in_array('openid', $pref['loginza_providers'])?'selected':'').'>openid</option>
			<option value="livejournal" '.(in_array('livejournal', $pref['loginza_providers'])?'selected':'').'>livejournal</option>
			<option value="odnoklassniki" '.(in_array('odnoklassniki', $pref['loginza_providers'])?'selected':'').'>odnoklassniki</option>
		</select>
		</td></tr>
		<tr><td style="width:40%" class="forumheader3" colspan="2">' . LOGINZA_ADMIN_LANG . '</td>
	    <td style="width:50%" class="forumheader3"><select class = "tbox" name = "loginza_lang" />
		<option value="ru" '.($pref['loginza_lang']=='ru'?'selected':'').'>'.LOGINZA_ADMIN_RU.'</option>
		<option value="uk" '.($pref['loginza_lang']=='uk'?'selected':'').'>'.LOGINZA_ADMIN_UK.'</option>
		<option value="en" '.($pref['loginza_lang']=='en'?'selected':'').'>'.LOGINZA_ADMIN_EN.'</option>
		</select></td></tr>
		<tr><td style="width:40%" class="forumheader3" colspan="2">' . LOGINZA_ADMIN_CONNECT . '</td>
	    <td style="width:50%" class="forumheader3"><select class = "tbox" name = "loginza_connect" />'
		.(@ini_get('allow_url_fopen') == 1?'<option value="0" '.($pref['loginza_connect']=='0'?'selected':'').'>file_get_contents</option>':'')
		.(function_exists('curl_init')?'<option value="1" '.($pref['loginza_connect']=='1'?'selected':'').'>curl</option>':'').'
		<option value="2" '.($pref['loginza_connect']=='2'?'selected':'').'>socket</option>
		</select></td></tr>
		<tr><td style="width:40%" class="forumheader3" colspan="2">' . LOGINZA_MENU_TITLE . '</td>
	    <td style="width:50%" class="forumheader3">
		<input type="text" name="loginza_menu_title" class="tbox" style="width:97%" value="'.$pref['loginza_menu_title'].'" />
		</td></tr>
		<tr>
			<td style="width:40%" class="forumheader3" rowspan="3">' . LOGINZA_SECURE_LOGIN . LOGINZA_SECURE_DESC . '</td>
			<td class="forumheader3"><label for="loginza_secure_login">'.LOGINZA_ENABLED.'</label></td>
			<td class="forumheader3"><input type="checkbox" name="loginza_secure_login" id="loginza_secure_login" class="tbox" value="1" '
			.($pref['loginza_secure_login']=='1'?'checked="checked"':'').' /></td>
		</tr>
		<tr>
			<td style="width:10%" class="forumheader3">ID:</td>
			<td class="forumheader3"><input type="text" name="loginza_widget_id" class="tbox" style="width:97%" value="'
			.$pref['loginza_widget_id'].'" /></p></td>
		</tr>
		<tr>
			<td class="forumheader3">'.LOGINZA_SECRET_KEY.'</td>
			<td class="forumheader3"><input type="text" name="loginza_api_signature" class="tbox" style="width:97%" value="'
			.$pref['loginza_api_signature'].'" /></td>
		</td></tr>
		<tr style="vertical-align:top">
        <td colspan="3" style="text-align:center" class="forumheader">'
        .$rs -> form_button('submit', 'save_settings', LOGINZA_ADMIN_SAVE, '', '', '')
        .'</td>
        </tr>
        </table>
        '.$rs -> form_close()
		.'</div>';
		
	}elseif($action == 'stat'){
	
		if (isset($_POST['del_acc'])) {
			if($sql->db_Query("SELECT `l`.`id` FROM `".MPREFIX."user` AS `u` LEFT JOIN `".MPREFIX.$pref['loginza_db']."` AS `l` ON `u`.`user_id` = `l`.`user_id` GROUP BY `l`.`id`")){
				while($res = $sql->db_Fetch()){
					if($res['id']!=NULL){
						$acc[] = intval($res['id']);
					}
				}
				$sql->db_Query("DELETE FROM `e107_loginza` WHERE `id` NOT REGEXP '^(".implode('|',$acc).")$'");
			}
			
			$ns->tablerender('', '<div style="text-align:center;"><b>'.LOGINZA_ADMIN_DEL_OK.'</b></div>');
		}
	
		$total = $sql->db_Count($pref['loginza_db'],'(*)');
		$sql->db_Query("SELECT COUNT(id) AS `id`,`provider` FROM ".MPREFIX.$pref['loginza_db']." GROUP BY `provider`");
		while($row = $sql->db_Fetch()){
			if($row['provider']!=NULL){
				$td[] = $row;
			}
		}
		
		$text .= '<div style="text-align:center">
        '.$rs -> form_open('post', e_SELF.'?stat', 'SettingLoginza', '', '', '').'
		<table style="'.$width.'" class="fborder" cellspacing="0" cellpadding="0">
		<tr style="vertical-align:top">
        <td colspan="2" style="text-align:center;" class="forumheader">'. LOGINZA_ADMIN_STAT .'</td></tr>';
		for($i=0;$i<count($td);$i++){
			
			$text .= '<tr><td style="width:30%" class="forumheader3">' . $loginza->getprovico($td[$i]['provider']) . '</td>
			<td style="width:30%" class="forumheader3">
			'.intval($td[$i]['id']).'
			</td></tr>';
		}
        $text .= '
		<tr><td style="width:30%" class="forumheader3">' . LOGINZA_ADMIN_TOTAL . '</td>
    	<td style="width:30%" class="forumheader3">
		'.intval($total).'
		</td></tr>
		<tr style="vertical-align:top">
        <td colspan="2" style="text-align:center" class="forumheader">'
        .$rs -> form_button('submit', 'del_acc', LOGINZA_ADMIN_DEL_ACC, '', '', '')
        .'</td>
        </tr>
        </table>';
		
	}

	$ns -> tablerender('Loginza', $text);

	function show_options($action)
	{
		global $sql;
		if ($action == "")
		{
			$action = "main";
		}
		$var['main']['text'] = LOGINZA_ADMIN_CONF;
		$var['main']['link'] = e_SELF;
		$var['stat']['text'] = LOGINZA_ADMIN_STAT;
		$var['stat']['link'] = e_SELF."?stat";

		show_admin_menu(LOGINZA_ADMIN_MENU, $action, $var);
	}	
	
	function admin_loginza_adminmenu()
	{
		global $action;
		show_options($action);
	}

	require_once(e_ADMIN.'footer.php');

?>