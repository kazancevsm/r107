include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_login.php");
global $pref;

if(!USER){
	$loginsc = "
		<div class='login_sign'>
			<div class='login_button'>
				<div class='login_button_text'>
					<a href='".e_HTTP."login.php'>".LAN_LOGIN_SING."</a>
				</div>
			</div>
		</div>
		";
		
	if ($pref['user_reg']==1) {
		$loginsc .= "
			<div class='login_reg'>
				<div class='login_button'>
					<div class='login_button_text'>
						<a href='".e_HTTP."signup.php'>".LAN_LOGIN_REG."</a>
					</div>
				</div>
			</div>
		";
	}
		return $loginsc;
}

if (USER == TRUE || ADMIN == TRUE) {
	$loginsc = '
			<div class="c_login2">
				<span class="welcome">
					'.LAN_LOGIN_WELCOME.'&nbsp;&nbsp;'.USERNAME.'
				</span>
  ';
	$loginsc .= '
	';
					if (ADMIN == TRUE) {
						$loginsc .= '
				<span class="login_links_b">
					<a href="'.e_ADMIN_ABS.'admin.php">'.LAN_LOGIN_ADMINPANEL.'</a>&nbsp;&nbsp;
							';
					}
					$loginsc .= '
						<a href="'.e_HTTP.'user.php?id.'.USERID.'">'.LAN_LOGIN_PROFILE.'</a>&nbsp;&nbsp;
						<a href="'.e_HTTP.'usersettings.php">'.LAN_LOGIN_SETTINGS.'</a>&nbsp;&nbsp;
						'.(isset($pref['plug_installed']['list_new']) ? '<a href="'.e_PLUGIN_ABS.'list_new/list.php?new">'.LAN_LOGIN_LISTNEW.'</a>' : '').'
				</span>
				<span class="logout">
					<span class="logm">
						<span class="register_text">
							<a href="'.e_HTTP.'news.php?logout">'.LAN_LOGIN_LOGOUT.'</a>
						</span>
					</span>
				</span>
			</div>
	';
	$loginsc .= '
  ';
	return $loginsc;
}